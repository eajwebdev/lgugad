<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assistance extends Model
{
    use HasFactory;

    protected $fillable = [
        'dafac_id',
        'fam_mem',
        'em_dis',
        'assistance',
        'unit',
        'quantity',
        'cost',
        'provider',
    ];

    public function dafac(): BelongsTo
    {
        return $this->belongsTo(Dafac::class);
    }
}
