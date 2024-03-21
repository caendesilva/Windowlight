<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            // Cast checkbox inputs to booleans
            'lineNumbers' => $this->input('lineNumbers') === 'on',
            'useHeader' => $this->input('useHeader') === 'on',
            'headerButtons' => $this->input('headerButtons') === 'on',

            // Ensure the background color is a valid hex color
            'background' => $this->normalizeColor($this->input('background') ?: 'transparent'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string',
            'language' => 'nullable|string',
            'lineNumbers' => 'nullable|boolean',
            'useHeader' => 'nullable|boolean',
            'headerButtons' => 'nullable|boolean',
            'headerText' => 'nullable|string',
            'background' => 'nullable|string|regex:/^#[a-f0-9]{6}$/i',
        ];
    }

    protected function normalizeBoolean(?string $input, bool $default): bool
    {
        return filter_var($input ?? $default, FILTER_VALIDATE_BOOLEAN);
    }

    protected function normalizeColor(string $value): ?string
    {
        $value = strtolower($value);

        if ($value === 'transparent') {
            return null;
        }

        // Map common color names to hex values
        $colors = [
            'transparent' => null,
            'none' => null,
            'white' => '#ffffff',
            'black' => '#000000',
            'gray' => '#f3f4f6',
        ];

        if (isset($colors[$value])) {
            return $colors[$value];
        }

        // PHP version of the frontend normalization

        if (! str_starts_with($value, '#')) {
            $value = "#$value";
        }

        // Expand shorthand form (e.g., "03F") to full form (e.g., "0033FF")
        if (strlen($value) === 4) {
            $value = preg_replace('/^#(.)(.)(.)$/', '#$1$1$2$2$3$3', $value);
        }

        return $value;
    }
}
