<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Multiple Files Import Request Validation
 * 
 * Validates multiple file uploads for batch import
 */
class ImportMultipleFilesRequest extends FormRequest
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
            'import_files' => 'required|array|min:1|max:10',
            'import_files.*' => [
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
            'import_files.required' => 'Please select at least one file to import.',
            'import_files.array' => 'Invalid file upload format.',
            'import_files.min' => 'Please select at least one file.',
            'import_files.max' => 'You can upload a maximum of 10 files at once.',
            'import_files.*.required' => 'One or more files are missing.',
            'import_files.*.file' => 'One or more uploaded files are invalid.',
            'import_files.*.max' => "Each file must not exceed {$maxSizeMb}MB.",
            'import_files.*.mimes' => 'All files must be in CSV, TXT, XLS, or XLSX format.',
        ];
    }
}
