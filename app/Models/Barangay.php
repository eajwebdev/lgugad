<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;

    protected $table = 'barangays';

    protected $fillable = [
        'code',
        'name',
        'region_id',
        'province_id',
        'city_id',
    ];

    public $timestamps = false;
    
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'city_id');
    }
}
