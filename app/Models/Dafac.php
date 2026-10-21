<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dafac extends Model
{
    protected $fillable = [
        'add_region',
        'add_prov',
        'add_city',
        'add_brgy',
        'district',
        'b_place',
        'civil_status',
        'm_maid_name',
        'religion',
        'city_mun_head',
        'id_present',
        'id_cardnum',
        'contact_1',
        'contact_2',
        'per_address',
        'brgy_evac_site',
        'count',
        'serial',
        'surname',
        'fname',
        'mname',
        'ext',
        'gender',
        'd_birth',
        'age',
        'occupation',
        'mincome',
        'ps_benef',
        'ip',
        'type_ethnicity',
        'checklist',
        'mem_fname',
        'mem_relation',
        'mem_bdate',
        'mem_age',
        'mem_gender',
        'mem_educ',
        'mem_occup',
        'mem_remarks',
    ];

    protected $casts = [
        'ps_benef' => 'boolean',
        'ip' => 'boolean',
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'add_region', 'region_id');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'add_prov', 'province_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'add_city', 'city_id');
    }

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'add_brgy');
    }

    public function headBarangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'city_mun_head');
    }

    public function assistances(): HasMany
    {
        return $this->hasMany(Assistance::class);
    }

    /**
     * Adds regionname, provincename, cityname and brgyname columns used by the list and PDF views.
     */
    public function scopeWithAddressNames(Builder $query): Builder
    {
        return $query->leftJoin('regions', 'regions.region_id', '=', 'dafacs.add_region')
            ->leftJoin('provinces', 'provinces.province_id', '=', 'dafacs.add_prov')
            ->leftJoin('cities', 'cities.city_id', '=', 'dafacs.add_city')
            ->leftJoin('barangays', 'barangays.id', '=', 'dafacs.add_brgy')
            ->select(
                'dafacs.*',
                'regions.name as regionname',
                'provinces.name as provincename',
                'cities.name as cityname',
                'barangays.name as brgyname'
            );
    }

    /**
     * Next 4-digit family count number.
     */
    public static function nextCount(): string
    {
        return str_pad((int) static::max('count') + 1, 4, '0', STR_PAD_LEFT);
    }
}
