<?php

namespace App\Http\Requests;

class StoreCitizenRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'lname' => 'required|string|max:255',
            'fname' => 'required|string|max:255',
            'mname' => 'required|string|max:255',
            'ext' => 'nullable|string|max:20',
            'gender' => 'required|in:Male,Female',
            'bday' => 'required|date|before:today',
            'age' => 'required|integer|min:0|max:150',
        ];
    }
}
