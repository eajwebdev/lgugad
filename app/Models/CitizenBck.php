<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Senior citizen: economic, health and living background.
 */
class CitizenBck extends Model
{
    protected $table = 'citizen_bcks';

    protected $fillable = [
        'cid',
        'living_reside',
        'house_cond',
        'source_inass',
        'assreal_immov',
        'assr_permov',
        'month_inc',
        'prob_needs',
        'med_concern',
        'den_conern',
        'optical',
        'hearing',
        'soc_emo',
        'area_diff',
        'med_main',
        'med_sched',
        'med_schedyes',
    ];

    public function citizen(): BelongsTo
    {
        return $this->belongsTo(Citizen::class, 'cid');
    }
}
