<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mentor_profiles extends Model
{
    protected $table = 'mentor_profiles';

    protected $fillable = [
        'user_id',
        'full_name',
        'department',
        'position',
        'max_interns',
    ];

    // mentor thuộc user
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }



    // mentor quản lý nhiều intern
    public function interns()
    {
        return $this->hasMany(
            Intern_profiles::class,
            'mentor_id'
        );
    }



    // mentor tạo nhiều task
    public function tasks()
    {
        return $this->hasMany(
            Task::class,
            'mentor_id'
        );
    }
}
