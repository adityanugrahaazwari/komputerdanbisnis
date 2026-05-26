<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiteSettingRequest extends FormRequest
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
            'site_name' => 'nullable|string|max:255',
            'site_description' => 'nullable|string',
            'site_logo' => 'nullable|image|mimetypes:image/jpeg,image/png,image/svg+xml|max:2048',
            'site_favicon' => 'nullable|mimetypes:image/x-icon,image/png,image/jpeg|max:1024',
            'site_address' => 'nullable|string',
            'site_phone' => 'nullable|string|max:20',
            'site_email' => 'nullable|email|max:255',
            'contact_title' => 'nullable|string|max:255',
            'contact_description' => 'nullable|string',
            'hero_badge' => 'nullable|string|max:255',
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string',
            'hero_btn1_text' => 'nullable|string|max:255',
            'hero_btn1_url' => 'nullable|string|max:255',
            'hero_btn2_text' => 'nullable|string|max:255',
            'hero_btn2_url' => 'nullable|string|max:255',
            'footer_text' => 'nullable|string|max:255',
            'primary_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
        ];
    }
}
