<?php

namespace Modules\Genders\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGenderRequest extends FormRequest
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
            'active' => 'nullable|boolean',
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
