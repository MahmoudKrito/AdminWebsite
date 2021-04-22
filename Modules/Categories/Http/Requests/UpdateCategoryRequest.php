<?php

namespace Modules\Categories\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'image' => 'nullable|max:191|mimes:jpg,jpeg,png,gif',
            'active' => 'nullable|boolean',
            'gender_id' => 'nullable|exists:genders,id',
            'layout_id' => 'nullable|exists:layouts,id',
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
