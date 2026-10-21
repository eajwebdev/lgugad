<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoloParent extends Model
{
    use HasFactory;

    protected $fillable = [
        'cname',
        'gender',
        'dob',
        'age',
        'address',
        'h_education',
        'occupation',
        'monthly_income',
        'mem_fname',
        'mem_relation',
        'mem_age',
        'mem_status',
        'mem_educ',
        'mem_bdate',
        'class_circum',
        'needs_prob',
    ];
}
