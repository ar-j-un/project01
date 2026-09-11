<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name"=> "required|string|max:255",
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter a name for the file.',
            'name.string'   => 'The file name must be a valid text string.',
            'name.max'      => 'The file name cannot exceed 255 characters.',
        ];
    }
}
