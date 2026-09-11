<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentFileRequest extends FormRequest
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
            'file_name' => 'required|string|max:255',
            'file' => 'required|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,xlsx,csv',
        ];
    }

    public function messages(): array
    {
        return [
            'file_name.required' => 'Please enter a name for the file.',
            'file_name.string'   => 'The file name must be a valid text string.',
            'file_name.max'      => 'The file name cannot exceed 255 characters.',
            'file.required'      => 'Please select a file to upload.',
            'file.file'          => 'The uploaded item must be a valid file.',
            'file.max'           => 'The file size cannot exceed 10MB.',
            'file.mimes'         => 'The file must be a PDF, Word document, Excel spreadsheet, CSV, or image (JPG, PNG).',
        ];
    }
}
