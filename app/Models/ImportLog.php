<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'file_hash',
        'total_rows',
        'successful_imports',
        'failed_imports',
        'skipped_rows',
        'flagged_records',
        'errors',
        'warnings',
        'flagged_data',
        'status',
        'notes',
        'user_id',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'errors' => 'array',
        'warnings' => 'array',
        'flagged_data' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the user who performed the import
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if import has errors
     */
    public function hasErrors(): bool
    {
        return $this->failed_imports > 0 || !empty($this->errors);
    }

    /**
     * Check if import has warnings
     */
    public function hasWarnings(): bool
    {
        return !empty($this->warnings);
    }

    /**
     * Check if import has flagged records
     */
    public function hasFlaggedRecords(): bool
    {
        return $this->flagged_records > 0;
    }

    /**
     * Get import summary
     */
    public function getSummary(): string
    {
        $summary = "Import completed: {$this->successful_imports}/{$this->total_rows} records imported successfully.";
        
        if ($this->skipped_rows > 0) {
            $summary .= " {$this->skipped_rows} rows skipped.";
        }
        
        if ($this->failed_imports > 0) {
            $summary .= " {$this->failed_imports} records failed.";
        }
        
        if ($this->flagged_records > 0) {
            $summary .= " {$this->flagged_records} records flagged for review.";
        }
        
        return $summary;
    }
}
