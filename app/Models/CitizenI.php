<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Senior citizen: personal information and address.
 */
class CitizenI extends Model
{
    protected $table = 'citizen_i_s';

    /** Address columns that may be changed through the address dropdowns. */
    public const ADDRESS_COLUMNS = ['add_region', 'add_prov', 'add_city', 'add_brgy'];

    protected $fillable = [
        'cid',
        'bday',
        'age',
        'p_birth',
        'm_status',
        'gender',
        'contact',
        'email',
        'religion',
        'ethic_org',
        'ph',
        'sc_ass',
        'other_gov',
        'camp_travel',
        'add_region',
        'add_prov',
        'add_city',
        'add_brgy',
        'brgy',
        'house_purok',
        'street',
        'lang_spoke',
        'osca_idnum',
        'gsis_sss',
        'tin',
        'sbe',
        'curr_pension',
    ];

    public function citizen(): BelongsTo
    {
        return $this->belongsTo(Citizen::class, 'cid');
    }

    /**
     * Next 5-digit OSCA ID. Call inside a transaction so the lock holds until insert.
     */
    public static function nextOscaIdNumber(): string
    {
        $max = static::whereNotNull('osca_idnum')->lockForUpdate()->max('osca_idnum');

        return str_pad((int) $max + 1, 5, '0', STR_PAD_LEFT);
    }
}
