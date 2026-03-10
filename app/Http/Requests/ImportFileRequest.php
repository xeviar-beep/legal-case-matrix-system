<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Import File Upload Request Validation
 * 
 * Validates uploaded files for the import system
 */
class ImportFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $maxSizeMb = config('import.limits.max_file_size_mb', 50);
        $maxSizeKb = $maxSizeMb * 1024;

        return [
            'import_file' => [
                'required',
                'file',
                "max:{$maxSizeKb}",
                'mimes:csv,txt,xlsx,xls',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        $maxSizeMb = config('import.limits.max_file_size_mb', 50);

        return [
            'import_file.required' => 'Please select a file to import.',
            'import_file.file' => 'The uploaded file is invalid.',
            'import_file.max' => "File size must not exceed {$maxSizeMb}MB.",
            'import_file.mimes' => 'File must be in CSV, TXT, XLS, or XLSX format.',
        ];
    }
}
