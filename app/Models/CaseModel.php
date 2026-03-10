<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class CaseModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cases';

    protected $fillable = [
        'case_number',
        'docket_no',
        'old_folder_no',
        'case_title',
        'client_name',
        'case_type',
        'section',
        'court_agency',
        'region',
        'date_filed',
        'deadline_days',
        'deadline_date',
        'hearing_date',
        'status',
        'notes',
        'user_id',
        'assigned_lawyer',
        'handling_counsel_ncip',
        'actions_taken',
        // Agency-specific fields
        'action',
        'issues_grounds',
        'prayers_relief',
        'new_sc_no',
        'remarks',
        'optional_blank_section',
    ];

    protected $casts = [
        'date_filed' => 'date',
        'deadline_date' => 'date',
        'hearing_date' => 'date',
    ];

    /**
     * Automatically calculate deadline_date before saving
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($case) {
            if ($case->date_filed && $case->deadline_days) {
                $case->deadline_date = Carbon::parse($case->date_filed)
                    ->addDays($case->deadline_days);
                // Only set status if not already set to completed or archived
                if (!in_array($case->status, ['completed', 'archived'])) {
                    $case->status = self::calculateStatus($case->deadline_date);
                }
            } else {
                // Only set status if not already set to completed or archived
                if (!in_array($case->status, ['completed', 'archived'])) {
                    $case->status = 'active'; // Default status when no deadline
                }
            }
        });

        static::updating(function ($case) {
            // Don't recalculate status if case is marked as completed or archived
            if (in_array($case->status, ['completed', 'archived'])) {
                return;
            }
            
            if ($case->isDirty(['date_filed', 'deadline_days'])) {
                if ($case->date_filed && $case->deadline_days) {
                    $case->deadline_date = Carbon::parse($case->date_filed)
                        ->addDays($case->deadline_days);
                    $case->status = self::calculateStatus($case->deadline_date);
                } else {
                    $case->status = 'active'; // Default status when no deadline
                }
            } elseif ($case->deadline_date && !$case->isDirty('status')) {
                $case->status = self::calculateStatus($case->deadline_date);
            }
        });
    }

    /**
     * Calculate status based on deadline
     */
    public static function calculateStatus($deadlineDate)
    {
        $deadline = Carbon::parse($deadlineDate);
        $now = Carbon::now();
        $daysRemaining = $now->diffInDays($deadline, false);

        if ($daysRemaining < 0) {
            return 'overdue';
        } elseif ($daysRemaining <= 7) {
            return 'due_soon';
        } else {
            return 'active';
        }
    }

    /**
     * Get remaining days
     */
    public function getRemainingDaysAttribute()
    {
        return Carbon::now()->diffInDays($this->deadline_date, false);
    }

    /**
     * Get days until hearing
     */
    public function getDaysUntilHearingAttribute()
    {
        if (!$this->hearing_date) {
            return null;
        }
        return Carbon::now()->diffInDays($this->hearing_date, false);
    }

    /**
     * Check if overdue
     */
    public function isOverdue()
    {
        return $this->remaining_days < 0;
    }

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class, 'case_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'case_id');
    }

    /**
     * Scopes
     */
    public function scopeOverdue($query)
    {
        return $query->where('deadline_date', '<', Carbon::now())
            ->where('status', '!=', 'completed');
    }

    public function scopeDueSoon($query, $days = 7)
    {
        return $query->whereBetween('deadline_date', [
            Carbon::now(),
            Carbon::now()->addDays($days)
        ])->where('status', '!=', 'completed');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['active', 'due_soon', 'overdue']);
    }

    public function scopeHearingToday($query)
    {
        return $query->whereDate('hearing_date', Carbon::today());
    }

    public function scopeHearingTomorrow($query)
    {
        return $query->whereDate('hearing_date', Carbon::tomorrow());
    }
}
