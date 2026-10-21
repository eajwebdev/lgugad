<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Senior citizen: education and skills.
 */
class CitizenIII extends Model
{
    protected $table = 'citizen_i_i_i_s';

    protected $fillable = [
        'cid',
        'educ_attain',
        'share_skill',
        'area_techskill',
        'comm_serveinv',
    ];

    public function citizen(): BelongsTo
    {
        return $this->belongsTo(Citizen::class, 'cid');
    }
}
