<?php

namespace Modules\Countries\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
//            'name_ar' => $this->name_ar,
//            'code' => $this->code,
//            'image' => $this->image,
            'phone_code' => $this->phone_code,
            'active' => $this->active,
            'currency' => $this->currency,
        ];
    }
}
