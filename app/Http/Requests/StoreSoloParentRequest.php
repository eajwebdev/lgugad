<?php

namespace App\Http\Requests;

class StoreSoloParentRequest extends BaseFormRequest
{
    private const MEMBER_FIELDS = [
        'mem_fname' => 'string|max:255',
        'mem_relation' => 'string|max:255',
        'mem_age' => 'integer|min:0|max:150',
        'mem_status' => 'string|max:255',
        'mem_educ' => 'string|max:255',
        'mem_bdate' => 'date',
    ];

    public function rules(): array
    {
        $rules = [
            'cname' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'dob' => 'required|date|before:today',
            'age' => 'required|integer|min:0|max:150',
            'address' => 'required|string|max:255',
            'h_education' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
            'monthly_income' => 'required|string|max:255',
            'class_circum' => 'required|string',
            'needs_prob' => 'required|string',
        ];

        foreach (self::MEMBER_FIELDS as $field => $itemRule) {
            $rules[$field] = 'required|array';
            $rules["{$field}.*"] = $itemRule;
        }

        return $rules;
    }

    public function toModelData(): array
    {
        $data = collect($this->validated())->except(array_keys(self::MEMBER_FIELDS))->all();

        foreach (array_keys(self::MEMBER_FIELDS) as $field) {
            $data[$field] = $this->csv($field);
        }

        return $data;
    }
}
