<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportError extends Model
{
    use HasFactory;

    protected $fillable = [
        'import_log_id',
        'row_number',
        'case_number',
        'case_title',
        'error_type',
        'error_message',
        'row_data',
    ];

    protected $casts = [
        'row_data' => 'array',
    ];

    /**
     * Get the import log that owns the error
     */
    public function importLog()
    {
        return $this->belongsTo(ImportLog::class);
    }
}
