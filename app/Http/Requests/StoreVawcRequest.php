<?php

namespace App\Http\Requests;

class StoreVawcRequest extends BaseFormRequest
{
    private const MEMBER_FIELDS = [
        'mem_fname' => 'string|max:255',
        'mem_relation' => 'string|max:255',
        'mem_age' => 'integer|min:0|max:150',
        'mem_gender' => 'string|max:10',
        'mem_educ' => 'string|max:255',
        'mem_occup' => 'string|max:255',
        'mem_monthly' => 'string|max:255',
        'mem_address' => 'string|max:255',
    ];

    public function rules(): array
    {
        $rules = [
            'source' => 'required|string|max:255',
            'cname' => 'required|string|max:255',
            'nname' => 'required|string|max:255',
            'dob' => 'required|date|before:today',
            'age' => 'required|integer|min:0|max:150',
            'gender' => 'required|in:M,F',
            'religion' => 'required|string|max:255',
            'pb' => 'required|string|max:255',
            'n_viewer' => 'required|string|max:255',
            'problem' => 'required|string',
            'findings' => 'required|string',
            'remarks' => 'required|string',
            'p_address' => 'required|string|max:255',
            'h_address' => 'required|string|max:255',
            'educ_attain' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'date_int' => 'required|date',
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
