<?php

namespace Modules\Genders\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateGenderRequest extends FormRequest
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
