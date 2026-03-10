<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Import Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration for the intelligent data import system.
    | It defines categorization rules, validation rules, and matching criteria.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Case Type Categories
    |--------------------------------------------------------------------------
    |
    | Define the valid case types and their aliases/keywords for auto-detection.
    |
    */
    'case_types' => [
        'Civil' => [
            'keywords' => ['civil', 'civilian', 'civ'],
            'aliases' => ['CIVIL', 'Civil Case', 'Civil Action'],
        ],
        'Criminal' => [
            'keywords' => ['criminal', 'crim', 'crime'],
            'aliases' => ['CRIMINAL', 'Criminal Case', 'Criminal Action'],
        ],
        'Labor' => [
            'keywords' => ['labor', 'labour', 'employment', 'work'],
            'aliases' => ['LABOR', 'Labor Case', 'Employment Case'],
        ],
        'Administrative' => [
            'keywords' => ['administrative', 'admin', 'admininstrative'],
            'aliases' => ['ADMIN', 'Administrative Case', 'Administrative Action'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Court/Agency Categories
    |--------------------------------------------------------------------------
    |
    | Define valid courts/agencies and their detection keywords.
    |
    */
    'court_agencies' => [
        'SC' => [  // Supreme Court
            'keywords' => ['supreme', 'sc', 'supreme court', 's.c.'],
            'aliases' => ['Supreme Court', 'Supreme Court of the Philippines'],
        ],
        'CA' => [  // Court of Appeals
            'keywords' => ['appeals', 'ca', 'court of appeals', 'c.a.'],
            'aliases' => ['Court of Appeals'],
        ],
        'RTC' => [  // Regional Trial Court
            'keywords' => ['rtc', 'regional', 'trial court', 'regional trial', 'r.t.c.'],
            'aliases' => ['Regional Trial Court'],
        ],
        'OMB' => [  // Ombudsman
            'keywords' => ['ombudsman', 'omb', 'o.m.b.'],
            'aliases' => ['Ombudsman', 'Office of the Ombudsman'],
        ],
        'NCIP' => [  // National Commission on Indigenous Peoples
            'keywords' => ['ncip', 'national commission on indigenous peoples', 'indigenous', 'n.c.i.p.'],
            'aliases' => ['NCIP', 'National Commission on Indigenous Peoples'],
        ],
        'Other' => [  // Other courts/agencies
            'keywords' => ['nlrc', 'labor relations', 'national labor', 'mtc', 'metropolitan', 'mctc', 'municipal', 'other'],
            'aliases' => ['NLRC', 'MTC', 'MCTC', 'Other Courts'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Section Categories
    |--------------------------------------------------------------------------
    |
    | Define sections for Supreme Court and their detection rules.
    |
    */
    'sections' => [
        'First Division' => ['1st', 'first', 'first division', '1st division'],
        'Second Division' => ['2nd', 'second', 'second division', '2nd division'],
        'Third Division' => ['3rd', 'third', 'third division', '3rd division'],
        'En Banc' => ['en banc', 'enbanc', 'en-banc', 'full court'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Case Type to Section Mapping
    |--------------------------------------------------------------------------
    |
    | Automatically map case types to sections when section is not specified.
    | This ensures proper categorization of cases into existing sections.
    |
    */
    'case_type_section_mapping' => [
        'Civil' => 'Civil Section',
        'Criminal' => 'Criminal Section',
        'Labor' => 'Labor Section',
        'Administrative' => 'Administrative Section',
        // Add fallback for unclear cases
        'Unclassified' => 'Unclassified Section',
    ],

    /*
    |--------------------------------------------------------------------------
    | Region Categories (for NCIP)
    |--------------------------------------------------------------------------
    |
    | Define Philippine regions for NCIP cases.
    |
    */
    'regions' => [
        'CAR' => ['car', 'cordillera', 'cordillera administrative region'],
        'Region I' => ['region i', 'region 1', 'ilocos', 'r1', 'ri'],
        'Region II' => ['region ii', 'region 2', 'cagayan valley', 'r2', 'rii'],
        'Region III' => ['region iii', 'region 3', 'central luzon', 'r3', 'riii'],
        'Region IV-A' => ['region iv-a', 'region 4-a', 'calabarzon', 'r4a'],
        'Region IV-B' => ['region iv-b', 'region 4-b', 'mimaropa', 'r4b'],
        'Region V' => ['region v', 'region 5', 'bicol', 'r5', 'rv'],
        'Region VI' => ['region vi', 'region 6', 'western visayas', 'r6', 'rvi'],
        'Region VII' => ['region vii', 'region 7', 'central visayas', 'r7', 'rvii'],
        'Region VIII' => ['region viii', 'region 8', 'eastern visayas', 'r8', 'rviii'],
        'Region IX' => ['region ix', 'region 9', 'zamboanga', 'r9', 'rix'],
        'Region X' => ['region x', 'region 10', 'northern mindanao', 'r10', 'rx'],
        'Region XI' => ['region xi', 'region 11', 'davao', 'r11', 'rxi'],
        'Region XII' => ['region xii', 'region 12', 'soccsksargen', 'r12', 'rxii'],
        'Region XIII' => ['region xiii', 'region 13', 'caraga', 'r13', 'rxiii'],
        'NCR' => ['ncr', 'metro manila', 'national capital region'],
        'BARMM' => ['barmm', 'armm', 'bangsamoro', 'autonomous region muslim mindanao'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Column Mapping
    |--------------------------------------------------------------------------
    |
    | Map various possible column header names to database field names.
    | This allows flexibility in Excel/CSV file formats.
    |
    */
    'column_mapping' => [
        'case_number' => [
            'case number', 'case no', 'casenumber', 'case_number', 'number', 
            'case #', 'case no.', 'no', 'case num'
        ],
        'docket_no' => [
            'docket no', 'docket number', 'docketno', 'docket_no', 'docket',
            'docket #', 'docket no.', 'docket num'
        ],
        'old_folder_no' => [
            'old folder no', 'old folder number', 'old_folder_no', 'folder no', 
            'folder number', 'old folder', 'folder'
        ],
        'case_title' => [
            'case title', 'title', 'case_title', 'casetitle', 'case name'
        ],
        'client_name' => [
            'client name', 'client', 'client_name', 'clientname', 'party', 'petitioner'
        ],
        'case_type' => [
            'case type', 'type', 'case_type', 'casetype', 'kind', 'category'
        ],
        'section' => [
            'section', 'division', 'sec'
        ],
        'court_agency' => [
            'court/agency', 'court agency', 'court', 'agency', 'court_agency',
            'court or agency', 'court-agency'
        ],
        'region' => [
            'region', 'area', 'location'
        ],
        'assigned_lawyer' => [
            'assigned lawyer', 'lawyer', 'assigned_lawyer', 'assignedlawyer',
            'attorney', 'counsel', 'legal counsel'
        ],
        'handling_counsel_ncip' => [
            'handling counsel (ncip)', 'handling counsel', 'ncip counsel', 
            'handling_counsel_ncip', 'ncip lawyer'
        ],
        'date_filed' => [
            'date filed', 'filed date', 'date_filed', 'datefiled', 
            'filing date', 'date of filing'
        ],
        'deadline_days' => [
            'deadline days', 'days', 'deadline_days', 'deadlinedays',
            'period', 'reglementary period', 'days to comply'
        ],
        'deadline_date' => [
            'deadline date', 'deadline', 'deadline_date', 'due date', 'expiry date'
        ],
        'hearing_date' => [
            'hearing date', 'hearing', 'hearing_date', 'hearingdate',
            'trial date', 'court date'
        ],
        'status' => [
            'status', 'state', 'condition'
        ],
        'notes' => [
            'notes', 'note', 'remarks', 'comments', 'memo'
        ],
        'actions_taken' => [
            'actions taken', 'actions', 'actions_taken', 'actionstaken',
            'proceedings', 'activity'
        ],
        'action' => [
            'action', 'current action', 'latest action'
        ],
        'issues_grounds' => [
            'issues/grounds', 'issues', 'grounds', 'issues_grounds',
            'legal issues', 'basis'
        ],
        'prayers_relief' => [
            'prayers (relief)', 'prayers', 'relief', 'prayers_relief',
            'relief sought', 'prayer for relief'
        ],
        'new_sc_no' => [
            'new sc no', 'new sc number', 'new_sc_no', 'sc number',
            'supreme court number'
        ],
        'remarks' => [
            'remarks', 'remark', 'additional notes', 'comment'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Validation Rules
    |--------------------------------------------------------------------------
    |
    | Define strict validation rules for each field.
    |
    */
    'validation_rules' => [
        'case_number' => 'nullable|string|max:255',
        'docket_no' => 'nullable|string|max:255',
        'case_title' => 'nullable|string|max:500',
        'client_name' => 'nullable|string|max:255',
        'case_type' => 'nullable|string|max:255',
        'court_agency' => 'nullable|string|max:255',
        'date_filed' => 'nullable|date',
        'deadline_days' => 'nullable|integer|min:1|max:3650',
        'hearing_date' => 'nullable|date',
    ],

    /*
    |--------------------------------------------------------------------------
    | Duplicate Detection Rules
    |--------------------------------------------------------------------------
    |
    | Define fields used to detect duplicate records.
    |
    */
    'duplicate_check_fields' => [
        'case_number',      // Primary unique identifier
        'docket_no',        // Secondary identifier
        'case_title',       // For fuzzy matching
    ],

    /*
    |--------------------------------------------------------------------------
    | Data Cleaning Rules
    |--------------------------------------------------------------------------
    |
    | Define data cleaning and normalization rules.
    |
    */
    'data_cleaning' => [
        'trim_whitespace' => true,
        'remove_multiple_spaces' => true,
        'normalize_case_numbers' => true,
        'normalize_dates' => true,
        'remove_special_chars_from_numbers' => true,
        'standardize_court_names' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Import Limits
    |--------------------------------------------------------------------------
    |
    | Set limits for import operations.
    |
    */
    'limits' => [
        'max_file_size_mb' => 50,
        'max_rows_per_file' => 10000,
        'max_batch_size' => 100, // Process records in batches for performance
        'timeout_seconds' => 300, // 5 minutes
    ],

    /*
    |--------------------------------------------------------------------------
    | File Type Support
    |--------------------------------------------------------------------------
    |
    | Define supported file types and their MIME types.
    |
    */
    'supported_file_types' => [
        'csv' => ['text/csv', 'text/plain', 'application/csv'],
        'xlsx' => ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
        'xls' => ['application/vnd.ms-excel'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Conflict Resolution Strategy
    |--------------------------------------------------------------------------
    |
    | Define how to handle conflicts when duplicate records are found.
    | Options: 'skip', 'update', 'flag', 'ask'
    |
    */
    'conflict_resolution' => 'flag', // Flag for manual review by default

    /*
    |--------------------------------------------------------------------------
    | Auto-Assignment Rules
    |--------------------------------------------------------------------------
    |
    | Define rules for automatically assigning cases to lawyers.
    |
    */
    'auto_assignment' => [
        'enabled' => false,
        'strategy' => 'round_robin', // or 'by_case_type', 'by_workload'
    ],
];
