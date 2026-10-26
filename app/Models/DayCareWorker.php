<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Child Development (Day Care) Worker profile — ECCD Council Form 6.
 *
 * The option lists below are the choices printed on the paper form; the web form, validation
 * and the Form 6 PDF all read from them.
 */
class DayCareWorker extends Model
{
    use HasFactory;

    public const SEXES = ['Male', 'Female'];

    public const CIVIL_STATUSES = ['Single', 'Married', 'Separated', 'Widow/Widower', 'Live in'];

    public const EDUCATION = [
        'Elem. Undergraduate', 'Elem. Graduate', 'HS Undergraduate', 'HS Graduate',
        'College Undergraduate', 'College Graduate', 'Vocational', 'With Masteral Units', 'Post Graduate',
    ];

    public const ELIGIBILITY = [
        'Civil Service Sub-Professional', 'Civil Service Professional',
        'Licensure Examination for Teachers', 'None', 'Others',
    ];

    public const COMPENSATION_TYPES = ['Salary', 'Honoraria', 'Allowance', "Parents' Monthly Contribution/Pledges"];

    /** Source key => label; each key has a matching amount_<key> column. */
    public const COMPENSATION_SOURCES = [
        'barangay' => 'Barangay',
        'city' => 'City/Municipal',
        'ngo' => 'NGOs/NGAs',
        'parents' => 'Parents',
    ];

    public const EMPLOYMENT_TERMS = [
        'Plantilla', 'Contract of Service', 'Casual', 'Co-Terminus w/ Hiring Authority', 'Voluntary',
    ];

    public const ACCREDITATION_STATUSES = ['Accredited', 'Not Accredited', 'Accredited but Expired'];

    public const ACCREDITATION_LEVELS = [1, 2, 3];

    public const SESSIONS_PER_DAY = [1, 2, 3, 4];

    public const HOURS_PER_SESSION = ['1' => '1 hr.', '2' => '2 hrs.', '2.5' => '2 ½ hrs.', '3' => '3 hrs.'];

    public const CHILDREN_AGES = [
        '0' => 'Below 1 y/o', '1' => '1 year old', '2' => '2 years old', '3' => '3 years old', '4' => '4 years old',
    ];

    public const HOURS_IN_CENTER = [
        '1-2' => '1-2 hrs.', '2.5-3' => '2 ½ - 3 hrs.', '4-5' => '4-5 hrs.', '6-7' => '6-7 hrs.', '8' => '8 hours',
    ];

    public const SESSION_METHODS = ['With reference materials', 'Without reference materials'];

    /** Rows printed on Form 6. */
    public const TRAINING_ROWS = 4;
    public const COURSE_ROWS = 2;

    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'sex',
        'birthday',
        'religion',
        'ethnicity',
        'civil_status',
        'no_children',
        'address_no',
        'address_street',
        'address_barangay',
        'address_city',
        'address_province',
        'address_region',
        'home_no',
        'office_no',
        'mobile_no',
        'fax_no',
        'email',
        'education',
        'degree',
        'eligibility',
        'eligibility_other',
        'years_as_cdw',
        'center_name',
        'compensation_types',
        'total_compensation',
        'compensation_sources',
        'amount_barangay',
        'amount_city',
        'amount_ngo',
        'amount_parents',
        'source_others',
        'employment_term',
        'trainings',
        'other_courses',
        'accreditation_status',
        'date_accredited',
        'accreditation_no',
        'accreditation_level',
        'children_served',
        'sessions_per_day',
        'hours_per_session',
        'children_ages',
        'hours_in_center',
        'session_method',
        'date_conducted',
    ];

    protected $casts = [
        'birthday' => 'date',
        'date_accredited' => 'date',
        'date_conducted' => 'date',
        'eligibility' => 'array',
        'compensation_types' => 'array',
        'compensation_sources' => 'array',
        'trainings' => 'array',
        'other_courses' => 'array',
        'children_ages' => 'array',
        'no_children' => 'integer',
        'years_as_cdw' => 'integer',
        'accreditation_level' => 'integer',
        'children_served' => 'integer',
        'sessions_per_day' => 'integer',
    ];

    /**
     * "Dela Cruz, Juana Santos" — the order printed under the Name line of Form 6.
     */
    public function getFormNameAttribute(): string
    {
        return trim($this->last_name . ', ' . trim($this->first_name . ' ' . $this->middle_name), ', ');
    }

    public function getFullNameAttribute(): string
    {
        return trim(preg_replace('/\s+/', ' ', "{$this->first_name} {$this->middle_name} {$this->last_name}"));
    }

    /**
     * Age on the date the profile was conducted (today when not yet set).
     */
    public function getAgeAttribute(): ?int
    {
        return $this->birthday?->diffInYears($this->date_conducted ?? Carbon::today());
    }

    public function hasChoice(string $attribute, $value): bool
    {
        return in_array((string) $value, array_map('strval', $this->{$attribute} ?? []), true);
    }
}
