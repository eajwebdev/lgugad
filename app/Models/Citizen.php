<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Citizen extends Model
{
    use HasFactory;

    public const STATUSES = ['Waiting', 'Active / Pensioner', 'Deceased'];

    protected $table = 'citizens';

    protected $fillable = [
        'lname',
        'fname',
        'mname',
        'ext',
        'status',
        'files',
        'profile',
    ];

    public function personal(): HasOne
    {
        return $this->hasOne(CitizenI::class, 'cid');
    }

    public function family(): HasOne
    {
        return $this->hasOne(CitizenII::class, 'cid');
    }

    public function education(): HasOne
    {
        return $this->hasOne(CitizenIII::class, 'cid');
    }

    public function background(): HasOne
    {
        return $this->hasOne(CitizenBck::class, 'cid');
    }

    /**
     * Uploaded document filenames (stored as a CSV list).
     */
    public function fileList(): array
    {
        return $this->files ? array_values(array_filter(explode(',', $this->files))) : [];
    }

    /** Legacy dumps store age as text; calculate it from the birthday when possible. */
    public function getCurrentAgeAttribute(): ?int
    {
        $birthday = $this->validBirthday();
        if ($birthday) {
            return $birthday->diffInYears(today());
        }

        $storedAge = $this->attributes['age'] ?? $this->personal?->age;
        return is_numeric($storedAge) ? (int) $storedAge : null;
    }

    public function getBirthDateLabelAttribute(): string
    {
        return $this->validBirthday()?->format('F j, Y') ?? ((string) ($this->birthdayValue() ?: 'Not recorded'));
    }

    private function validBirthday(): ?Carbon
    {
        $value = (string) ($this->birthdayValue() ?? '');
        if (! preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $value, $parts)
            || ! checkdate((int) $parts[2], (int) $parts[3], (int) $parts[1])) {
            return null;
        }

        $date = Carbon::createFromDate((int) $parts[1], (int) $parts[2], (int) $parts[3])->startOfDay();
        return $date->isFuture() ? null : $date;
    }

    private function birthdayValue(): ?string
    {
        return $this->attributes['bday'] ?? $this->personal?->bday;
    }

    /**
     * Citizen row merged with its personal info (citizen_i_s), as the list and report views expect.
     */
    public function scopeWithPersonalInfo(Builder $query): Builder
    {
        return $query->join('citizen_i_s', 'citizens.id', '=', 'citizen_i_s.cid')
            ->select('citizens.*', 'citizen_i_s.*', 'citizens.id as id');
    }
}
