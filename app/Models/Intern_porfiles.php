<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intern_porfiles extends Model
{
    protected $table = 'intern_profiles';

    protected $fillable = [
        'fullname',
        'school',
        'academic_year',
        'desired_technology',
        'start_date',
        'end_date',
        'status',
        'id_mentor',     
    ];
}
