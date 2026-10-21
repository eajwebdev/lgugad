<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vawc extends Model
{
    use HasFactory;

    protected $fillable = [
        'source',
        'cname',
        'nname',
        'dob',
        'pb',
        'age',
        'p_address',
        'gender',
        'religion',
        'h_address',
        'educ_attain',
        'school',
        'date_int',
        'mem_fname',
        'mem_relation',
        'mem_age',
        'mem_gender',
        'mem_educ',
        'mem_occup',
        'mem_monthly',
        'mem_address',
        'n_viewer',
        'problem',
        'findings',
        'remarks',
    ];
}
