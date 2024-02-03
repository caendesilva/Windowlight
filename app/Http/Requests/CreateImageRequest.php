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
        // Todo: Depending on what Aaron says regarding token usage, we may need to add logic here.
        //       We will also have rate limiting, regardless. (In a middleware)

        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            // Cast lineNumbers to a boolean
            'lineNumbers' => filter_var($this->input('lineNumbers') ?? true, FILTER_VALIDATE_BOOLEAN),
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
        ];
    }
}
