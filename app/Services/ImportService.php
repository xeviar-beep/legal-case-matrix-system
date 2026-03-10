<?php

namespace App\Services;

use App\Models\CaseModel;
use App\Models\ImportLog;
use App\Models\ImportError;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Intelligent Data Import Service
 * 
 * This service handles the import of Excel/CSV files with advanced features:
 * - Automatic categorization and classification
 * - Strict validation and duplicate detection
 * - Data cleaning and normalization
 * - Conflict/ambiguity detection and flagging
 * - Batch processing for performance
 * - Comprehensive logging
 * 
 * @package App\Services
 */
class ImportService
{
    protected $config;
    protected $importLog;
    protected $errors = [];
    protected $warnings = [];
    protected $flagged = [];
    protected $successCount = 0;
    protected $failedCount = 0;
    protected $skippedCount = 0;
    protected $userId;

    public function __construct()
    {
        $this->config = config('import');
    }

    /**
     * Import cases from uploaded file
     * 
     * @param \Illuminate\Http\UploadedFile $file The uploaded file
     * @param int $userId The ID of the user performing the import
     * @return ImportLog The import log record
     */
    public function importFile($file, $userId)
    {
        $this->userId = $userId;
        
        // Create import log entry
        $this->importLog = ImportLog::create([
            'filename' => $file->getClientOriginalName(),
            'file_hash' => hash_file('sha256', $file->getRealPath()),
            'status' => 'processing',
            'user_id' => $userId,
            'started_at' => now(),
        ]);

        try {
            // Check for duplicate file imports
            if ($this->isDuplicateFile($this->importLog->file_hash)) {
                $this->addWarning('This file has been imported before. Proceeding with import but watch for duplicates.');
            }

            // Parse the file based on type
            $data = $this->parseFile($file);

            if (empty($data)) {
                throw new \Exception('No data found in file or file is empty.');
            }

            // Validate file size
            if (count($data) > $this->config['limits']['max_rows_per_file']) {
                throw new \Exception("File contains too many rows. Maximum allowed: {$this->config['limits']['max_rows_per_file']}");
            }

            $this->importLog->update(['total_rows' => count($data)]);

            // Process data in batches for better performance
            $batchSize = $this->config['limits']['max_batch_size'];
            $batches = array_chunk($data, $batchSize, true);

            foreach ($batches as $batch) {
                $this->processBatch($batch);
            }

            // Update final status
            $this->importLog->update([
                'status' => 'completed',
                'successful_imports' => $this->successCount,
                'failed_imports' => $this->failedCount,
                'skipped_rows' => $this->skippedCount,
                'flagged_records' => count($this->flagged),
                'errors' => $this->errors,
                'warnings' => $this->warnings,
                'flagged_data' => $this->flagged,
                'completed_at' => now(),
            ]);

        } catch (\Exception $e) {
            Log::error('Import failed', [
                'file' => $file->getClientOriginalName(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->importLog->update([
                'status' => 'failed',
                'errors' => array_merge($this->errors, ['Fatal Error: ' . $e->getMessage()]),
                'completed_at' => now(),
            ]);
        }

        return $this->importLog;
    }

    /**
     * Parse file based on its type
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @return array Parsed data with headers mapped
     */
    protected function parseFile($file)
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $path = $file->getRealPath();

        try {
            if ($extension === 'csv' || $extension === 'txt') {
                return $this->parseCsv($path);
            } elseif ($extension === 'xlsx' || $extension === 'xls') {
                return $this->parseExcel($path);
            } else {
                throw new \Exception('Unsupported file type: ' . $extension);
            }
        } catch (\Exception $e) {
            throw new \Exception('Failed to parse file: ' . $e->getMessage());
        }
    }

    /**
     * Parse CSV file
     * 
     * @param string $path File path
     * @return array Parsed data
     */
    protected function parseCsv($path)
    {
        $csvData = array_map('str_getcsv', file($path));
        
        // Remove BOM if present
        if (!empty($csvData[0][0])) {
            $csvData[0][0] = preg_replace('/^\x{FEFF}/u', '', $csvData[0][0]);
        }

        return $this->processRawData($csvData);
    }

    /**
     * Parse Excel file (XLSX/XLS)
     * 
     * @param string $path File path
     * @return array Parsed data
     */
    protected function parseExcel($path)
    {
        $spreadsheet = IOFactory::load($path);
        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray();

        return $this->processRawData($data);
    }

    /**
     * Process raw data: extract headers and map columns
     * 
     * @param array $rawData Raw data from file
     * @return array Processed data with mapped column names
     */
    protected function processRawData($rawData)
    {
        if (empty($rawData)) {
            return [];
        }

        // Extract header row
        $headerRow = array_shift($rawData);
        
        // Skip comment rows (starting with #)
        while (!empty($rawData) && isset($rawData[0][0]) && strpos($rawData[0][0], '#') === 0) {
            array_shift($rawData);
            $this->skippedCount++;
        }

        // Map columns
        $columnMap = $this->mapColumns($headerRow);

        // Convert rows to associative arrays with proper field names
        $processedData = [];
        foreach ($rawData as $index => $row) {
            // Skip empty rows
            if (empty(array_filter($row))) {
                $this->skippedCount++;
                continue;
            }

            $mappedRow = [];
            foreach ($columnMap as $fieldName => $columnIndex) {
                $mappedRow[$fieldName] = isset($row[$columnIndex]) ? $row[$columnIndex] : null;
            }
            
            $mappedRow['_row_number'] = $index + 2; // Track original row number (accounting for header)
            $processedData[] = $mappedRow;
        }

        return $processedData;
    }

    /**
     * Map CSV/Excel columns to database field names
     * Uses flexible matching to handle various column naming conventions
     * 
     * @param array $headers Column headers from file
     * @return array Map of field names to column indices
     */
    protected function mapColumns($headers)
    {
        $columnMap = [];
        $mapping = $this->config['column_mapping'];

        foreach ($headers as $index => $header) {
            $normalizedHeader = strtolower(trim($header));
            
            foreach ($mapping as $fieldName => $possibleNames) {
                foreach ($possibleNames as $possibleName) {
                    if ($normalizedHeader === strtolower($possibleName)) {
                        $columnMap[$fieldName] = $index;
                        break 2; // Found match, move to next header
                    }
                }
            }
        }

        return $columnMap;
    }

    /**
     * Process a batch of records
     * 
     * @param array $batch Batch of records to process
     */
    protected function processBatch($batch)
    {
        foreach ($batch as $rowData) {
            try {
                $this->processRecord($rowData);
            } catch (\Exception $e) {
                $this->failedCount++;
                $rowNumber = $rowData['_row_number'];
                $errorMessage = "Row {$rowNumber}: {$e->getMessage()}";
                $this->addError($errorMessage);
                
                // Log to import_errors table
                $this->logImportError(
                    $rowNumber,
                    'invalid_data',
                    $e->getMessage(),
                    $rowData,
                    $rowData['case_number'] ?? null,
                    $rowData['case_title'] ?? null
                );
            }
        }
    }

    /**
     * Process a single record with intelligent categorization and validation
     * 
     * @param array $rowData Raw row data
     */
    protected function processRecord($rowData)
    {
        $rowNumber = $rowData['_row_number'];
        unset($rowData['_row_number']);

        // Step 1: Clean the data
        $cleanedData = $this->cleanData($rowData);

        // Step 2: Validate required fields
        if (!$this->validateRequiredFields($cleanedData, $rowNumber)) {
            $this->failedCount++;
            return;
        }

        // Step 3: Intelligent categorization
        $categorizedData = $this->categorizeRecord($cleanedData, $rowNumber);

        // Step 4: Check for duplicates
        $duplicate = $this->checkDuplicate($categorizedData);
        if ($duplicate) {
            $this->handleDuplicate($categorizedData, $duplicate, $rowNumber);
            return;
        }

        // Step 5: Validate data integrity
        if (!$this->validateDataIntegrity($categorizedData, $rowNumber)) {
            $this->failedCount++;
            return;
        }

        // Step 6: Check for ambiguous data
        if ($this->isAmbiguous($categorizedData, $rowNumber)) {
            $this->flagRecord($categorizedData, $rowNumber, 'Ambiguous categorization - requires manual review');
            return;
        }

        // Step 7: Save to database
        try {
            $caseData = $this->prepareCaseData($categorizedData);
            CaseModel::create($caseData);
            $this->successCount++;
        } catch (\Exception $e) {
            $this->failedCount++;
            $errorMessage = "Row {$rowNumber}: Failed to save - {$e->getMessage()}";
            $this->addError($errorMessage);
            
            // Log to import_errors table
            $this->logImportError(
                $rowNumber,
                'invalid_data',
                "Failed to save to database: {$e->getMessage()}",
                $categorizedData,
                $categorizedData['case_number'] ?? null,
                $categorizedData['case_title'] ?? null
            );
        }
    }

    /**
     * Clean and normalize data
     * 
     * @param array $data Raw data
     * @return array Cleaned data
     */
    protected function cleanData($data)
    {
        $cleaned = [];
        $rules = $this->config['data_cleaning'];

        foreach ($data as $field => $value) {
            if ($value === null || $value === '') {
                $cleaned[$field] = null;
                continue;
            }

            $value = (string)$value;

            // Trim whitespace
            if ($rules['trim_whitespace']) {
                $value = trim($value);
            }

            // Remove multiple spaces
            if ($rules['remove_multiple_spaces']) {
                $value = preg_replace('/\s+/', ' ', $value);
            }

            // Field-specific cleaning
            if (in_array($field, ['date_filed', 'deadline_date', 'hearing_date']) && $rules['normalize_dates']) {
                $value = $this->normalizeDate($value);
            }

            if ($field === 'case_number' && $rules['normalize_case_numbers']) {
                $value = $this->normalizeCaseNumber($value);
            }

            $cleaned[$field] = $value;
        }

        return $cleaned;
    }

    /**
     * Normalize date formats
     * 
     * @param string $date Date string in various formats
     * @return string|null Normalized date in Y-m-d format or null
     */
    protected function normalizeDate($date)
    {
        if (empty($date)) {
            return null;
        }

        try {
            // Handle Excel serial dates
            if (is_numeric($date)) {
                $unixDate = ($date - 25569) * 86400;
                return Carbon::createFromTimestamp($unixDate)->format('Y-m-d');
            }

            // Try to parse various date formats
            $carbon = Carbon::parse($date);
            return $carbon->format('Y-m-d');
        } catch (\Exception $e) {
            $this->addWarning("Invalid date format: {$date}");
            return null;
        }
    }

    /**
     * Normalize case number
     * 
     * @param string $caseNumber Case number
     * @return string Normalized case number
     */
    protected function normalizeCaseNumber($caseNumber)
    {
        // Remove extra spaces and special characters
        $caseNumber = trim($caseNumber);
        $caseNumber = preg_replace('/\s+/', ' ', $caseNumber);
        
        return $caseNumber;
    }

    /**
     * Validate required fields and auto-generate missing ones
     * 
     * @param array $data Record data (passed by reference to allow modification)
     * @param int $rowNumber Row number for error reporting
     * @return bool Always returns true after ensuring all required fields exist
     */
    protected function validateRequiredFields(&$data, $rowNumber)
    {
        $autoGenerated = [];

        // Auto-generate case_number if missing
        if (empty($data['case_number'])) {
            // Try to extract from docket number or other fields
            if (!empty($data['docket_no'])) {
                $data['case_number'] = 'CN-' . preg_replace('/[^A-Z0-9]/i', '', $data['docket_no']);
            } else {
                // Generate unique case number using timestamp and row number
                $data['case_number'] = 'AUTO-' . date('Ymd') . '-' . str_pad($rowNumber, 4, '0', STR_PAD_LEFT);
            }
            $autoGenerated[] = 'case_number';
        }

        // Auto-generate case_title if missing
        if (empty($data['case_title'])) {
            // Try to build from available data
            if (!empty($data['client_name'])) {
                $data['case_title'] = 'Case for ' . $data['client_name'];
            } elseif (!empty($data['docket_no'])) {
                $data['case_title'] = 'Case ' . $data['docket_no'];
            } else {
                $data['case_title'] = 'Case #' . $data['case_number'];
            }
            $autoGenerated[] = 'case_title';
        }

        // Auto-generate client_name if missing
        if (empty($data['client_name'])) {
            // Check if we can extract from case_title
            if (!empty($data['case_title'])) {
                // Try to find "vs" or "v." pattern to extract party names
                if (preg_match('/(.+?)\s+(?:vs?\.?|versus)\s+(.+)/i', $data['case_title'], $matches)) {
                    $data['client_name'] = trim($matches[1]);
                    $autoGenerated[] = 'client_name (extracted from title)';
                } else {
                    $data['client_name'] = 'Unknown Client';
                    $autoGenerated[] = 'client_name';
                }
            } else {
                $data['client_name'] = 'Unknown Client';
                $autoGenerated[] = 'client_name';
            }
        }

        // Add warning if any fields were auto-generated
        if (!empty($autoGenerated)) {
            $this->addWarning("Row {$rowNumber}: Auto-generated missing fields: " . implode(', ', $autoGenerated));
        }

        // Always return true - we now handle missing fields gracefully
        return true;
    }

    /**
     * Intelligently categorize record based on content
     * 
     * @param array $data Record data
     * @param int $rowNumber Row number
     * @return array Categorized data
     */
    protected function categorizeRecord($data, $rowNumber)
    {
        // Auto-detect case type
        if (empty($data['case_type']) || !$this->isValidCategory($data['case_type'], 'case_types')) {
            $data['case_type'] = $this->detectCaseType($data, $rowNumber);
        } else {
            $data['case_type'] = $this->standardizeCategory($data['case_type'], 'case_types');
        }

        // Auto-detect court/agency
        if (empty($data['court_agency']) || !$this->isValidCategory($data['court_agency'], 'court_agencies')) {
            $data['court_agency'] = $this->detectCourtAgency($data, $rowNumber);
        } else {
            $data['court_agency'] = $this->standardizeCategory($data['court_agency'], 'court_agencies');
        }

        // Auto-map section based on case_type if section is empty
        if (empty($data['section'])) {
            $data['section'] = $this->mapSectionFromCaseType($data['case_type'], $rowNumber);
        } elseif ($data['court_agency'] === 'Supreme Court') {
            // For Supreme Court, use the SC division sections
            if (!$this->isValidCategory($data['section'], 'sections')) {
                $data['section'] = $this->detectSection($data, $rowNumber);
            } else {
                $data['section'] = $this->standardizeCategory($data['section'], 'sections');
            }
        }

        // If still no section, use case_type mapping
        if (empty($data['section']) && !empty($data['case_type'])) {
            $data['section'] = $this->mapSectionFromCaseType($data['case_type'], $rowNumber);
        }

        // Auto-detect region (for NCIP)
        if ($data['court_agency'] === 'NCIP') {
            if (empty($data['region']) || !$this->isValidCategory($data['region'], 'regions')) {
                $data['region'] = $this->detectRegion($data, $rowNumber);
            } else {
                $data['region'] = $this->standardizeCategory($data['region'], 'regions');
            }
        }

        return $data;
    }

    /**
     * Detect case type from various fields using keywords
     * 
     * @param array $data Record data
     * @param int $rowNumber Row number
     * @return string|null Detected case type
     */
    protected function detectCaseType($data, $rowNumber)
    {
        $caseTypes = $this->config['case_types'];
        $searchFields = ['case_title', 'case_type', 'docket_no', 'notes'];
        
        foreach ($caseTypes as $type => $config) {
            foreach ($searchFields as $field) {
                if (empty($data[$field])) {
                    continue;
                }
                
                $text = strtolower($data[$field]);
                foreach ($config['keywords'] as $keyword) {
                    if (strpos($text, strtolower($keyword)) !== false) {
                        return $type;
                    }
                }
            }
        }

        $this->addWarning("Row {$rowNumber}: Could not auto-detect case type");
        return null;
    }

    /**
     * Detect court/agency from various fields using keywords
     * 
     * @param array $data Record data
     * @param int $rowNumber Row number
     * @return string|null Detected court/agency
     */
    protected function detectCourtAgency($data, $rowNumber)
    {
        $agencies = $this->config['court_agencies'];
        $searchFields = ['court_agency', 'docket_no', 'case_title', 'notes'];
        
        foreach ($agencies as $agency => $config) {
            foreach ($searchFields as $field) {
                if (empty($data[$field])) {
                    continue;
                }
                
                $text = strtolower($data[$field]);
                foreach ($config['keywords'] as $keyword) {
                    if (strpos($text, strtolower($keyword)) !== false) {
                        return $agency;
                    }
                }
            }
        }

        $this->addWarning("Row {$rowNumber}: Could not auto-detect court/agency");
        return null;
    }

    /**
     * Detect section from various fields
     * 
     * @param array $data Record data
     * @param int $rowNumber Row number
     * @return string|null Detected section
     */
    protected function detectSection($data, $rowNumber)
    {
        $sections = $this->config['sections'];
        $searchFields = ['section', 'docket_no', 'notes'];
        
        foreach ($sections as $section => $keywords) {
            foreach ($searchFields as $field) {
                if (empty($data[$field])) {
                    continue;
                }
                
                $text = strtolower($data[$field]);
                foreach ($keywords as $keyword) {
                    if (strpos($text, strtolower($keyword)) !== false) {
                        return $section;
                    }
                }
            }
        }

        return null; // Section is optional for Supreme Court
    }

    /**
     * Detect region from various fields
     * 
     * @param array $data Record data
     * @param int $rowNumber Row number
     * @return string|null Detected region
     */
    protected function detectRegion($data, $rowNumber)
    {
        $regions = $this->config['regions'];
        $searchFields = ['region', 'docket_no', 'notes', 'case_title'];
        
        foreach ($regions as $region => $keywords) {
            foreach ($searchFields as $field) {
                if (empty($data[$field])) {
                    continue;
                }
                
                $text = strtolower($data[$field]);
                foreach ($keywords as $keyword) {
                    if (strpos($text, strtolower($keyword)) !== false) {
                        return $region;
                    }
                }
            }
        }

        return null; // Region is optional for NCIP
    }

    /**
     * Check if a value is a valid category
     * 
     * @param string $value Value to check
     * @param string $categoryType Category type (case_types, court_agencies, etc.)
     * @return bool True if valid
     */
    protected function isValidCategory($value, $categoryType)
    {
        $categories = $this->config[$categoryType];
        return isset($categories[$value]);
    }

    /**
     * Standardize category name (handle aliases and case variations)
     * 
     * @param string $value Value to standardize
     * @param string $categoryType Category type
     * @return string Standardized category name
     */
    protected function standardizeCategory($value, $categoryType)
    {
        $categories = $this->config[$categoryType];
        $normalized = strtolower(trim($value));

        // Check direct match
        foreach ($categories as $standardName => $config) {
            if (strtolower($standardName) === $normalized) {
                return $standardName;
            }

            // Check aliases
            if (isset($config['aliases'])) {
                foreach ($config['aliases'] as $alias) {
                    if (strtolower($alias) === $normalized) {
                        return $standardName;
                    }
                }
            }

            // Check keywords
            if (isset($config['keywords'])) {
                foreach ($config['keywords'] as $keyword) {
                    if (strtolower($keyword) === $normalized) {
                        return $standardName;
                    }
                }
            }
        }

        return $value; // Return original if no match
    }

    /**
     * Check for duplicate records (prioritizing case_number)
     * 
     * @param array $data Record data
     * @return CaseModel|null Existing case if duplicate found
     */
    protected function checkDuplicate($data)
    {
        // Priority 1: Check case_number (primary unique identifier)
        if (!empty($data['case_number'])) {
            $existing = CaseModel::where('case_number', $data['case_number'])->first();
            if ($existing) {
                return $existing;
            }
        }

        // Priority 2: Check docket_no (secondary identifier)
        if (!empty($data['docket_no'])) {
            $existing = CaseModel::where('docket_no', $data['docket_no'])->first();
            if ($existing) {
                return $existing;
            }
        }

        // Priority 3: Check exact case_title match (for fuzzy matching)
        if (!empty($data['case_title']) && !empty($data['client_name'])) {
            $existing = CaseModel::where('case_title', $data['case_title'])
                                 ->where('client_name', $data['client_name'])
                                 ->first();
            if ($existing) {
                return $existing;
            }
        }

        return null;
    }

    /**
     * Handle duplicate record based on conflict resolution strategy
     * 
     * @param array $data New record data
     * @param CaseModel $duplicate Existing duplicate record
     * @param int $rowNumber Row number
     */
    protected function handleDuplicate($data, $duplicate, $rowNumber)
    {
        $strategy = $this->config['conflict_resolution'];

        switch ($strategy) {
            case 'skip':
                $this->skippedCount++;
                $this->addWarning("Row {$rowNumber}: Skipped duplicate record (Case #{$duplicate->case_number})");
                
                // Log to import_errors table
                $this->logImportError(
                    $rowNumber,
                    'duplicate',
                    "Duplicate case number detected. Existing case: {$duplicate->case_number}",
                    $data,
                    $data['case_number'] ?? null,
                    $data['case_title'] ?? null
                );
                break;

            case 'update':
                // Update existing record with new data
                $duplicate->update($this->prepareCaseData($data));
                $this->successCount++;
                $this->addWarning("Row {$rowNumber}: Updated existing record (Case #{$duplicate->case_number})");
                break;

            case 'flag':
            default:
                // Flag for manual review
                $this->flagRecord(
                    $data, 
                    $rowNumber, 
                    "Duplicate detected - existing Case #{$duplicate->case_number}"
                );
                
                // Log to import_errors table
                $this->logImportError(
                    $rowNumber,
                    'duplicate',
                    "Duplicate case number detected. Existing case: {$duplicate->case_number}. Flagged for manual review.",
                    $data,
                    $data['case_number'] ?? null,
                    $data['case_title'] ?? null
                );
                break;
        }
    }

    /**
     * Validate data integrity (cross-field validation)
     * 
     * @param array $data Record data
     * @param int $rowNumber Row number
     * @return bool True if valid
     */
    protected function validateDataIntegrity($data, $rowNumber)
    {
        $validationRules = $this->config['validation_rules'];
        
        $validator = Validator::make($data, $validationRules);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->addError("Row {$rowNumber}: {$error}");
            }
            return false;
        }

        // Additional custom validations
        
        // Validate date logic
        if (!empty($data['date_filed']) && !empty($data['hearing_date'])) {
            $dateFiled = Carbon::parse($data['date_filed']);
            $hearingDate = Carbon::parse($data['hearing_date']);
            
            if ($hearingDate->lt($dateFiled)) {
                $this->addError("Row {$rowNumber}: Hearing date cannot be before filing date");
                return false;
            }
        }

        // Validate deadline logic
        if (!empty($data['date_filed']) && !empty($data['deadline_days'])) {
            if ($data['deadline_days'] < 0) {
                $this->addError("Row {$rowNumber}: Deadline days cannot be negative");
                return false;
            }
        }

        return true;
    }

    /**
     * Check if record has ambiguous categorization
     * 
     * @param array $data Record data
     * @param int $rowNumber Row number
     * @return bool True if ambiguous
     */
    protected function isAmbiguous($data, $rowNumber)
    {
        $ambiguous = false;

        // Check if critical fields are missing after categorization
        if (empty($data['case_type'])) {
            $this->addWarning("Row {$rowNumber}: Case type could not be determined - will be marked as Unclassified");
            $ambiguous = true;
        }

        // Court/Agency is optional - don't flag if missing
        // Section is now auto-mapped from case_type, so it's okay if empty in input

        // Check for conflicting information only for NCIP region
        if (!empty($data['court_agency']) && !empty($data['region'])) {
            if ($data['court_agency'] !== 'NCIP' && !empty($data['region'])) {
                $this->addWarning("Row {$rowNumber}: Region specified but court is not NCIP");
                $ambiguous = true;
            }
        }

        return $ambiguous;
    }

    /**
     * Flag a record for manual review
     * 
     * @param array $data Record data
     * @param int $rowNumber Row number
     * @param string $reason Reason for flagging
     */
    protected function flagRecord($data, $rowNumber, $reason)
    {
        $this->flagged[] = [
            'row_number' => $rowNumber,
            'reason' => $reason,
            'data' => $data,
        ];

        $this->addWarning("Row {$rowNumber}: Flagged - {$reason}");
    }

    /**
     * Prepare case data for database insertion
     * 
     * @param array $data Processed record data
     * @return array Case data ready for CaseModel::create()
     */
    protected function prepareCaseData($data)
    {
        $caseData = [
            'user_id' => $this->userId,
            'case_number' => $data['case_number'],
            'case_title' => $data['case_title'] ?? 'Untitled Case',
            'client_name' => $data['client_name'] ?? 'Unknown Client',
            'case_type' => $data['case_type'] ?? null,
            'court_agency' => $data['court_agency'] ?? null,
            'section' => $data['section'] ?? null,
            'region' => $data['region'] ?? null,
            'docket_no' => $data['docket_no'] ?? null,
            'old_folder_no' => $data['old_folder_no'] ?? null,
            'date_filed' => $data['date_filed'] ?? null,
            'deadline_days' => $data['deadline_days'] ?? null,
            'hearing_date' => $data['hearing_date'] ?? null,
            'assigned_lawyer' => $data['assigned_lawyer'] ?? null,
            'handling_counsel_ncip' => $data['handling_counsel_ncip'] ?? null,
            'notes' => $data['notes'] ?? null,
            'actions_taken' => $data['actions_taken'] ?? null,
            'action' => $data['action'] ?? null,
            'issues_grounds' => $data['issues_grounds'] ?? null,
            'prayers_relief' => $data['prayers_relief'] ?? null,
            'new_sc_no' => $data['new_sc_no'] ?? null,
            'remarks' => $data['remarks'] ?? null,
        ];

        // Calculate deadline_date if we have date_filed and deadline_days
        if (!empty($caseData['date_filed']) && !empty($caseData['deadline_days'])) {
            $caseData['deadline_date'] = Carbon::parse($caseData['date_filed'])
                ->addDays($caseData['deadline_days'])
                ->format('Y-m-d');
        }

        // Set default status
        $caseData['status'] = 'active';

        return $caseData;
    }

    /**
     * Check if file has been imported before
     * 
     * @param string $fileHash File hash
     * @return bool True if duplicate
     */
    protected function isDuplicateFile($fileHash)
    {
        return ImportLog::where('file_hash', $fileHash)
            ->where('status', 'completed')
            ->exists();
    }

    /**
     * Add an error message
     * 
     * @param string $message Error message
     */
    protected function addError($message)
    {
        $this->errors[] = $message;
        Log::warning("Import Error: {$message}");
    }

    /**
     * Add a warning message
     * 
     * @param string $message Warning message
     */
    protected function addWarning($message)
    {
        $this->warnings[] = $message;
        Log::info("Import Warning: {$message}");
    }

    /**
     * Get import summary
     * 
     * @return array Summary data
     */
    public function getSummary()
    {
        return [
            'success_count' => $this->successCount,
            'failed_count' => $this->failedCount,
            'skipped_count' => $this->skippedCount,
            'flagged_count' => count($this->flagged),
            'errors' => $this->errors,
            'warnings' => $this->warnings,
            'flagged_records' => $this->flagged,
        ];
    }

    /**
     * Map section based on case type
     * Uses the case_type_section_mapping from config
     * 
     * @param string|null $caseType Case type
     * @param int $rowNumber Row number for logging
     * @return string|null Mapped section or null
     */
    protected function mapSectionFromCaseType($caseType, $rowNumber)
    {
        if (empty($caseType)) {
            return 'Unclassified Section';
        }

        $mapping = $this->config['case_type_section_mapping'] ?? [];

        // Direct match
        if (isset($mapping[$caseType])) {
            return $mapping[$caseType];
        }

        // Normalize and try again
        $normalizedType = ucfirst(strtolower($caseType));
        if (isset($mapping[$normalizedType])) {
            return $mapping[$normalizedType];
        }

        // Default fallback
        $this->addWarning("Row {$rowNumber}: Could not map case type '{$caseType}' to section, using default");
        return 'Unclassified Section';
    }

    /**
     * Log error to import_errors table
     * 
     * @param int $rowNumber Row number
     * @param string $errorType Type of error (missing_required, duplicate, invalid_data, conflict)
     * @param string $errorMessage Error message
     * @param array $rowData Original row data
     * @param string|null $caseNumber Case number if available
     * @param string|null $caseTitle Case title if available
     */
    protected function logImportError($rowNumber, $errorType, $errorMessage, $rowData = [], $caseNumber = null, $caseTitle = null)
    {
        try {
            ImportError::create([
                'import_log_id' => $this->importLog->id,
                'row_number' => $rowNumber,
                'case_number' => $caseNumber,
                'case_title' => $caseTitle,
                'error_type' => $errorType,
                'error_message' => $errorMessage,
                'row_data' => !empty($rowData) ? $rowData : null,
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to log import error: " . $e->getMessage());
        }
    }
}
