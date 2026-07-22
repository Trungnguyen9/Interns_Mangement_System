<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intern_profiles extends Model
{
    protected $table = 'intern_profiles';

    protected $fillable = [
        'user_id',
        'full_name',
        'school',
        'academic_year',
        'desired_technology',
        'start_date',
        'end_date',
        'status',
        'mentor_id',
    ];
    // intern thuộc user
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }



    // intern thuộc mentor
    public function mentor()
    {
        return $this->belongsTo(
            Mentor_profiles::class,
            'mentor_id'
        );
    }



    // intern có nhiều task
    public function tasks()
    {
        return $this->hasMany(
            Task::class,
            'intern_id'
        );
    }



    // intern có nhiều báo cáo
    public function weeklyReports()
    {
        return $this->hasMany(
            Weekly_report::class,
            'intern_id'
        );
    }

    public function getTotalTasksAttribute()
    {
        return $this->tasks()->count();
    }

    public function getDoneTasksCountAttribute()
    {
        return $this->tasks()->where('status', 'Done')->count();
    }

    public function getReviewTasksCountAttribute()
    {
        return $this->tasks()->where('status', 'Review')->count();
    }

    public function getPendingTasksCountAttribute()
    {
        return $this->total_tasks - $this->done_tasks_count - $this->review_tasks_count;
    }

    public function getOverdueTasksCountAttribute()
    {
        return $this->tasks()
            ->whereNotIn('status', ['Done', 'Review'])
            ->where('deadline', '<', now())
            ->count();
    }

    public function getProgressPercentAttribute()
    {
        return $this->total_tasks > 0
            ? round(($this->done_tasks_count / $this->total_tasks) * 100)
            : 0;
    }
    // <div>Tiến độ: {{ $intern->progress_percent }}%</div>

}
