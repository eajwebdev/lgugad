<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $table = 'provinces';

    protected $fillable = [
        'code',
        'name',
        'region_id',
        'province_id',
    ];

    public $timestamps = false;

    // Define the relationship
    public function cities()
    {
        return $this->hasMany(City::class, 'province_id', 'province_id');
    }
}
