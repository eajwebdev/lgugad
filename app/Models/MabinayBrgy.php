<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MabinayBrgy extends Model
{
    protected $table = 'mabinay_brgys';
    protected $fillable = [
        'brgy_name',
        'brgy_code',
    ];

    use HasFactory;
}
