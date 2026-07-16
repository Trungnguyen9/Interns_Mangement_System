<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Weekly_report extends Model
{
    protected $table = 'weekly_reports';

    protected $fillable = [
        'intern_id',
        'week_start_date',
        'week_end_date',
        'completed_tasks',
        'difficulties',
        'next_plan',
        'reference_links',
        'mentor_comment',
    ];

    public function intern()
    {
        return $this->belongsTo(
            Intern_profiles::class,
            'intern_id'
        );
    }

    public function getWeekRangeAttribute()
    {
        return Carbon::parse($this->week_start_date)->format('d/m')
            . ' - ' .
            Carbon::parse($this->week_end_date)->format('d/m/Y');
    }

    
}
