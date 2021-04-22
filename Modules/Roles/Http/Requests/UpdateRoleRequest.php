<?php

namespace Modules\Roles\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable|max:191',
            'name_ar' => 'nullable|max:191',
            'guard_name' => 'nullable|max:191',
            'permissions' => 'required|array|exists:permissions,id',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
