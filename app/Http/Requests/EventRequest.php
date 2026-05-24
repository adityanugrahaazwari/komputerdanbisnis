<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'type' => 'required|in:academic,webinar,competition,holiday,other',
            'color' => 'required|string|max:20',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimetypes:image/jpeg,image/png|max:2048',
            'is_active' => 'boolean'
        ];
    }
}
