<?php

namespace Modules\Areas\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AreaResource extends JsonResource
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
            'name' => $this->name,
            'name_ar' => $this->name_ar,
            'active' => $this->active,
            'city' => $this->city,
        ];
    }
}
