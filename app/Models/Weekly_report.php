<?php

namespace App\Models;

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
}
