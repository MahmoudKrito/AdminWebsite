<?php

namespace Modules\Categories\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:191',
            'name_ar' => 'required|max:191',
            'image' => 'required|max:191|mimes:jpg,jpeg,png,gif',
            'active' => 'nullable|boolean',
            'gender_id' => 'required|exists:genders,id',
            'layout_id' => 'required|exists:layouts,id',
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
