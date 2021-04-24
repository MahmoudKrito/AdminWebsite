<?php

namespace Modules\Countries\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCountryRequest extends FormRequest
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
//            'name_ar' => 'nullable|max:191',
//            'code' => 'nullable|max:5',
//            'image' => 'nullable|max:191|mimes:jpg,jpeg,png,gif',
            'phone_code' => 'nullable|max:191',
            'active' => 'nullable|boolean',
            'currency_id' => 'nullable|exists:currencies,id',
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
