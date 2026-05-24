<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionGroupRequest extends FormRequest
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
        $permissionGroup = $this->route('permission_group');
        $id = $permissionGroup ? $permissionGroup->id : null;

        return [
            'name' => 'required|string|max:255|unique:permission_groups,name,' . $id,
        ];
    }
}
