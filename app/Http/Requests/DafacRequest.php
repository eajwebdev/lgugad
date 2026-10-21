<?php

namespace App\Http\Requests;

/**
 * Create and update of a DAFAC (family assistance card) record.
 */
class DafacRequest extends BaseFormRequest
{
    private const MEMBER_FIELDS = [
        'mem_fname', 'mem_relation', 'mem_bdate', 'mem_age',
        'mem_gender', 'mem_educ', 'mem_occup', 'mem_remarks',
    ];

    private const CHECKLIST_SIZE = 6;

    protected function prepareForValidation(): void
    {
        $this->stripCommas('mincome');
    }

    public function rules(): array
    {
        $rules = [
            'add_region' => 'nullable|string|max:10',
            'add_prov' => 'nullable|string|max:10',
            'add_city' => 'nullable|string|max:10',
            'add_brgy' => 'required|integer',
            'district' => 'required|string|max:255',
            'brgy_evac_site' => 'required|string|max:255',
            'count' => 'nullable|string|max:10',
            'serial' => 'nullable|string|max:255',
            'surname' => 'required|string|max:255',
            'fname' => 'required|string|max:255',
            'mname' => 'required|string|max:255',
            'ext' => 'nullable|string|max:20',
            'gender' => 'required|in:M,F',
            'd_birth' => 'required|date',
            'age' => 'required|integer|min:0|max:150',
            'b_place' => 'required|string|max:255',
            'civil_status' => 'required|string|max:255',
            'm_maid_name' => 'required|string|max:255',
            'religion' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
            'mincome' => 'required|numeric|min:0',
            'city_mun_head' => 'nullable|integer',
            'id_present' => 'required|string|max:255',
            'id_cardnum' => 'required|string|max:255',
            'contact_1' => 'nullable|string|max:255',
            'contact_2' => 'nullable|string|max:255',
            'per_address' => 'required|string|max:255',
            'type_ethnicity' => 'nullable|string|max:255',
        ];

        for ($i = 1; $i <= self::CHECKLIST_SIZE; $i++) {
            $rules["checklist{$i}"] = 'nullable|integer|min:0';
        }

        foreach (self::MEMBER_FIELDS as $field) {
            $rules[$field] = 'nullable|array';
            $rules["{$field}.*"] = 'nullable|string|max:255';
        }

        return $rules;
    }

    /**
     * Attributes ready for Dafac::create() / update().
     */
    public function toModelData(): array
    {
        $data = collect($this->validated())
            ->except(array_merge(self::MEMBER_FIELDS, $this->checklistKeys()))
            ->all();

        $data['contact_1'] = $data['contact_1'] ?? '';
        $data['contact_2'] = $data['contact_2'] ?? '';
        $data['ps_benef'] = $this->boolean('ps_benef');
        $data['ip'] = $this->boolean('ip');
        $data['checklist'] = implode(',', array_map(
            fn ($key) => (int) $this->validated($key, 0),
            $this->checklistKeys()
        ));

        foreach (self::MEMBER_FIELDS as $field) {
            $data[$field] = $this->csv($field);
        }

        return $data;
    }

    private function checklistKeys(): array
    {
        return array_map(fn ($i) => "checklist{$i}", range(1, self::CHECKLIST_SIZE));
    }
}
