<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'title',
        'description',
        'deadline',
        'priority',
        'status',
        'mentor_id',
        'intern_id',
        'mentor_comment'
    ];

    public function mentor()
    {
        return $this->belongsTo(
            Mentor_profiles::class,
            'mentor_id'
        );
    }



    public function intern()
    {
        return $this->belongsTo(
            Intern_profiles::class,
            'intern_id'
        );
    }
}
