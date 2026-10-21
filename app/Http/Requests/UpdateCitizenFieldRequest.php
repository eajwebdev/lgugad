<?php

namespace App\Http\Requests;

use App\Models\Citizen;
use App\Models\CitizenBck;
use App\Models\CitizenI;
use App\Models\CitizenII;
use App\Models\CitizenIII;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Validator;

/**
 * Inline edit of a single field on the senior "more info" page.
 *
 * `model` and `data` (column) come from the browser, so both are checked against an allow-list
 * before anything touches the database.
 */
class UpdateCitizenFieldRequest extends BaseFormRequest
{
    public const MODELS = [
        'Citizen' => Citizen::class,
        'CitizenI' => CitizenI::class,
        'CitizenII' => CitizenII::class,
        'CitizenIII' => CitizenIII::class,
        'CitizenBck' => CitizenBck::class,
    ];

    /** Columns that are system-managed and never editable inline. */
    private const PROTECTED_COLUMNS = ['cid', 'files', 'profile', 'status'];

    public function rules(): array
    {
        return [
            'cid' => 'required|integer|exists:citizens,id',
            'model' => 'required|in:' . implode(',', array_keys(self::MODELS)),
            'data' => 'required|string',
            'value' => 'nullable|string|max:255',
            'array' => 'nullable|integer|min:0|max:50',
            'age' => 'nullable|integer|min:0|max:150',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $class = self::MODELS[$this->input('model')] ?? null;

            if ($class && ! in_array($this->input('data'), $this->editableColumns($class), true)) {
                $validator->errors()->add('data', 'This field cannot be updated.');
            }
        });
    }

    /**
     * The record being edited (the citizen itself, or one of its detail rows).
     */
    public function record(): Model
    {
        $class = self::MODELS[$this->validated('model')];
        $cid = $this->validated('cid');

        return $class === Citizen::class
            ? Citizen::findOrFail($cid)
            : $class::firstOrCreate(['cid' => $cid]);
    }

    private function editableColumns(string $class): array
    {
        return array_values(array_diff((new $class)->getFillable(), self::PROTECTED_COLUMNS));
    }
}
