<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pwd extends Model
{
    /** Codes stored in `type_dis` (CSV), as labelled on the PWD application form. */
    public const DISABILITY_TYPES = [
        '1' => 'Deaf or hard of hearing',
        '2' => 'Intellectual disability',
        '3' => 'Learning disability',
        '4' => 'Mental disability',
        '5' => 'Physical disability (orthopedic)',
        '6' => 'Psychosocial disability',
        '7' => 'Speech and language impairment',
        '8' => 'Visual disability',
        '9' => 'Cancer (RA 11215)',
        '10' => 'Rare disease (RA 10747)',
    ];

    /** Codes stored in `cause_dis` (CSV): 1–4 congenital/inborn, 5–7 acquired. */
    public const DISABILITY_CAUSES = [
        '1' => 'Autism (congenital)',
        '2' => 'ADHD (congenital)',
        '3' => 'Cerebral palsy (congenital)',
        '4' => 'Down syndrome (congenital)',
        '5' => 'Chronic illness (acquired)',
        '6' => 'Cerebral palsy (acquired)',
        '7' => 'Injury (acquired)',
    ];

    protected $fillable = [
        'applicant',
        'person_with',
        'date_app',
        'lname',
        'fname',
        'mname',
        'suffix',
        'dob',
        'gender',
        'c_status',
        'type_dis',
        'cause_dis',
        'r_address',
        'street',
        'brangay',
        'municipality',
        'province',
        'region',
        'l_no',
        'm_no',
        'email',
        'educ_attain',
    ];

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(MabinayBrgy::class, 'brangay');
    }
}
