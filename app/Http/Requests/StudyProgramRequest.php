<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudyProgramRequest extends FormRequest
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
        $studyProgramId = $this->route('study_program') ? $this->route('study_program')->id : null;

        return [
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:study_programs,code,' . $studyProgramId,
            'level' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'website_url' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimetypes:image/jpeg,image/png|max:2048',
        ];
    }
}
