<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weekly_report extends Model
{
    protected $table = 'weekly_reports';
    protected $fillable = [
        'completed_tasks',
        'difficulties',
        'next_plan',
        'reference_links',
        'mentor_comments'
    ];
}
