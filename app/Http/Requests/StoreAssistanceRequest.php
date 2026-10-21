<?php

namespace App\Http\Requests;

class StoreAssistanceRequest extends BaseFormRequest
{
    protected function prepareForValidation(): void
    {
        $this->stripCommas('cost');
    }

    public function rules(): array
    {
        return [
            'did' => 'required|string',
            'fam_mem' => 'required|string|max:255',
            'em_dis' => 'required|string|max:255',
            'assistance' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'cost' => 'required|numeric|min:0',
            'provider' => 'required|string|max:255',
            'created_at' => 'required|date',
        ];
    }
}
