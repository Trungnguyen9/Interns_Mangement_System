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
}
