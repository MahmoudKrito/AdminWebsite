<?php

namespace Modules\Areas\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAreaRequest extends FormRequest
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
            'city_id' => 'nullable|exists:cities,id',
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
