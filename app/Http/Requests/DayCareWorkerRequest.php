<?php

namespace App\Http\Requests;

use App\Models\DayCareWorker;
use Illuminate\Validation\Rule;

/**
 * Create and update of a Child Development (Day Care) Worker profile (ECCD Form 6).
 */
class DayCareWorkerRequest extends BaseFormRequest
{
    private const MONEY_FIELDS = ['total_compensation', 'amount_barangay', 'amount_city', 'amount_ngo', 'amount_parents'];

    protected function prepareForValidation(): void
    {
        $this->stripCommas(...self::MONEY_FIELDS);
    }

    public function rules(): array
    {
        $in = fn (array $options) => Rule::in(array_map('strval', $options));

        $rules = [
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'sex' => ['required', $in(DayCareWorker::SEXES)],
            'birthday' => 'required|date|before:today',
            'religion' => 'nullable|string|max:255',
            'ethnicity' => 'nullable|string|max:255',
            'civil_status' => ['required', $in(DayCareWorker::CIVIL_STATUSES)],
            'no_children' => 'nullable|integer|min:0|max:50',
            'address_no' => 'nullable|string|max:255',
            'address_street' => 'nullable|string|max:255',
            'address_barangay' => 'required|string|max:255',
            'address_city' => 'nullable|string|max:255',
            'address_province' => 'nullable|string|max:255',
            'address_region' => 'nullable|string|max:255',
            'home_no' => 'nullable|string|max:50',
            'office_no' => 'nullable|string|max:50',
            'mobile_no' => 'nullable|string|max:50',
            'fax_no' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'education' => ['nullable', $in(DayCareWorker::EDUCATION)],
            'degree' => 'nullable|string|max:255',
            'eligibility' => 'nullable|array',
            'eligibility.*' => [$in(DayCareWorker::ELIGIBILITY)],
            'eligibility_other' => 'nullable|string|max:255',

            'years_as_cdw' => 'nullable|integer|min:0|max:80',
            'center_name' => 'required|string|max:255',
            'compensation_types' => 'nullable|array',
            'compensation_types.*' => [$in(DayCareWorker::COMPENSATION_TYPES)],
            'total_compensation' => 'nullable|numeric|min:0',
            'compensation_sources' => 'nullable|array',
            'compensation_sources.*' => [$in(array_keys(DayCareWorker::COMPENSATION_SOURCES))],
            'source_others' => 'nullable|string|max:255',
            'employment_term' => ['nullable', $in(DayCareWorker::EMPLOYMENT_TERMS)],
            'trainings' => 'nullable|array|max:' . DayCareWorker::TRAINING_ROWS,
            'trainings.*.title' => 'nullable|string|max:255',
            'trainings.*.dates' => 'nullable|string|max:100',
            'trainings.*.hours' => 'nullable|numeric|min:0|max:9999',
            'trainings.*.sponsor' => 'nullable|string|max:255',
            'other_courses' => 'nullable|array|max:' . DayCareWorker::COURSE_ROWS,
            'other_courses.*.course' => 'nullable|string|max:255',
            'other_courses.*.year' => 'nullable|integer|min:1950|max:' . (date('Y') + 1),
            'accreditation_status' => ['nullable', $in(DayCareWorker::ACCREDITATION_STATUSES)],
            'date_accredited' => 'nullable|date',
            'accreditation_no' => 'nullable|string|max:255',
            'accreditation_level' => ['nullable', $in(DayCareWorker::ACCREDITATION_LEVELS)],

            'children_served' => 'nullable|integer|min:0|max:1000',
            'sessions_per_day' => ['nullable', $in(DayCareWorker::SESSIONS_PER_DAY)],
            'hours_per_session' => ['nullable', $in(array_keys(DayCareWorker::HOURS_PER_SESSION))],
            'children_ages' => 'nullable|array',
            'children_ages.*' => [$in(array_keys(DayCareWorker::CHILDREN_AGES))],
            'hours_in_center' => ['nullable', $in(array_keys(DayCareWorker::HOURS_IN_CENTER))],
            'session_method' => ['nullable', $in(DayCareWorker::SESSION_METHODS)],
            'date_conducted' => 'nullable|date',
        ];

        foreach (array_keys(DayCareWorker::COMPENSATION_SOURCES) as $source) {
            $rules["amount_{$source}"] = 'nullable|numeric|min:0';
        }

        return $rules;
    }

    /**
     * Attributes ready for DayCareWorker::create() / update(). Unchecked groups become empty lists
     * and blank training/course rows are dropped.
     */
    public function toModelData(): array
    {
        $data = $this->validated();

        foreach (['eligibility', 'compensation_types', 'compensation_sources', 'children_ages'] as $list) {
            $data[$list] = array_values($data[$list] ?? []);
        }

        $data['trainings'] = $this->filledRows($data['trainings'] ?? [], ['title', 'dates', 'hours', 'sponsor']);
        $data['other_courses'] = $this->filledRows($data['other_courses'] ?? [], ['course', 'year']);

        if (! in_array('Others', $data['eligibility'], true)) {
            $data['eligibility_other'] = null;
        }

        return $data;
    }

    private function filledRows(array $rows, array $columns): array
    {
        return collect($rows)
            ->map(fn ($row) => collect($columns)->mapWithKeys(fn ($col) => [$col => $row[$col] ?? null])->all())
            ->filter(fn ($row) => collect($row)->filter(fn ($v) => $v !== null && $v !== '')->isNotEmpty())
            ->values()
            ->all();
    }
}
