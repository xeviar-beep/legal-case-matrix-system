<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'case_id',
        'reminder_type',
        'reminder_date',
        'sent',
        'sent_at',
    ];

    protected $casts = [
        'reminder_date' => 'date',
        'sent' => 'boolean',
        'sent_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function case()
    {
        return $this->belongsTo(CaseModel::class, 'case_id');
    }

    /**
     * Scopes
     */
    public function scopePending($query)
    {
        return $query->where('sent', false);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('reminder_date', today());
    }
}
