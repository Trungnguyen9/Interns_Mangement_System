<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mentor_profiles extends Model
{
    protected $table = 'mentor_profiles';

    protected $fillable = [
        'user_id',
        'department',
        'position',
        'max_interns',
    ];
}
