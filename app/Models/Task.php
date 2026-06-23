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
}
