<?php

namespace Modules\Countries\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCountryRequest extends FormRequest
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
//            'name_ar' => 'required|max:191',
//            'code' => 'required|max:5',
//            'image' => 'required|max:191|mimes:jpg,jpeg,png,gif',
            'phone_code' => 'required|max:191',
            'active' => 'nullable|boolean',
            'currency_id' => 'required|exists:currencies,id',
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
