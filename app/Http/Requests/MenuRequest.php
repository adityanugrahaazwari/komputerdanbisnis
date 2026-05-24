<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
            'url' => 'nullable|string|max:255',
            'location' => 'required|in:admin,frontend',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'permission_slug' => 'nullable|string|max:255',
            'order' => 'required|integer',
        ];
    }
}
