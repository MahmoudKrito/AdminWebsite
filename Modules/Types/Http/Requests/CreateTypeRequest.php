<?php

namespace Modules\Types\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTypeRequest extends FormRequest
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
            'image' => 'nullable|max:191|mimes:jpg,jpeg,png,gif',
            'active' => 'nullable|boolean',
            'parent_id' => 'required|exists:categories,id',
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
