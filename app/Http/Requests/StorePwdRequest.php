<?php

namespace App\Http\Requests;

class StorePwdRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'applicant' => 'required|string|max:255',
            'person_with' => 'required|string|max:255',
            'date_app' => 'required|date',
            'lname' => 'required|string|max:255',
            'fname' => 'required|string|max:255',
            'mname' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:20',
            'dob' => 'required|date|before:today',
            'gender' => 'required|in:M,F',
            'c_status' => 'required|string|max:255',
            'r_address' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'brangay' => 'required|integer|exists:mabinay_brgys,id',
            'municipality' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'l_no' => 'required|string|max:255',
            'm_no' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'type_dis' => 'nullable|array',
            'type_dis.*' => 'string|max:255',
            'cause_dis' => 'nullable|array',
            'cause_dis.*' => 'string|max:255',
            'educ_attain' => 'required|string|max:255',
        ];
    }

    public function toModelData(): array
    {
        return array_merge($this->validated(), [
            'type_dis' => $this->csv('type_dis'),
            'cause_dis' => $this->csv('cause_dis'),
        ]);
    }
}
