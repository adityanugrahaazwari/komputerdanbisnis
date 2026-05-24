<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
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
        $rules = [
            'gallery_group_id' => 'nullable|exists:gallery_groups,id',
            'title' => 'required|string|max:255',
            'order' => 'nullable|integer',
            'description' => 'nullable|string'
        ];

        if ($this->isMethod('post')) {
            $rules['image'] = 'required|image|mimetypes:image/jpeg,image/png,image/gif|max:5120';
        } else {
            $rules['image'] = 'nullable|image|mimetypes:image/jpeg,image/png,image/gif|max:5120';
        }

        return $rules;
    }
}
