<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization is handled in Controller via authorizePermission
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $allowedStatuses = ['draft', 'pending'];
        if ($this->user()->can('posts_publish')) {
            $allowedStatuses[] = 'published';
            $allowedStatuses[] = 'rejected';
        }

        return [
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimetypes:image/jpeg,image/png,image/gif|max:2048',
            'status' => 'required|in:' . implode(',', $allowedStatuses),
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000'
        ];
    }
}
