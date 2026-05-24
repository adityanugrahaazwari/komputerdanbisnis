<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LecturerRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'nidn' => 'nullable|string|max:50',
            'position' => 'nullable|string|max:255',
            'expertise' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'google_scholar_url' => 'nullable|url|max:255',
            'sinta_url' => 'nullable|url|max:255',
            'study_program_id' => 'nullable|exists:study_programs,id',
            'photo' => 'nullable|image|mimetypes:image/jpeg,image/png|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ];
    }
}
