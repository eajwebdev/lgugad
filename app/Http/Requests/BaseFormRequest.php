<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Shared helpers for the module forms. Route access is enforced by middleware, so authorize() is open.
 */
abstract class BaseFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Repeating form rows (name="field[]") are stored as one CSV column per field.
     */
    protected function csv(string $key): ?string
    {
        $values = $this->validated($key);

        return is_array($values) ? implode(',', array_map(fn ($v) => (string) $v, $values)) : null;
    }

    /**
     * Strips thousands separators from money inputs before validation ("1,500.00" -> "1500.00").
     */
    protected function stripCommas(string ...$keys): void
    {
        $clean = [];
        foreach ($keys as $key) {
            if (is_string($this->input($key))) {
                $clean[$key] = str_replace(',', '', $this->input($key));
            }
        }
        $this->merge($clean);
    }
}
