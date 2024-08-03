<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // This is a public form

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
            'useShadow' => $this->input('useShadow') === 'on',

            // Ensure the background color is a valid hex color
            'background' => $this->normalizeColor($this->input('background') ?: 'transparent'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string',
            'language' => 'nullable|string',
            'lineNumbers' => 'nullable|boolean',
            'useHeader' => 'nullable|boolean',
            'useShadow' => 'nullable|boolean',
            'headerButtons' => 'nullable|boolean',
            'headerText' => 'nullable|string',
            'background' => 'nullable|string|regex:/^#[a-f0-9]{6}$/i',
            'padding' => 'nullable|string|in:small,medium,large',
        ];
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
