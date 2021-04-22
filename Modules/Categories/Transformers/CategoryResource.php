<?php

namespace Modules\Categories\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name_ar' => $this->name_ar,
            'image' => $this->image,
            'active' => $this->active,
            'gender' => $this->gender,
            'layout' => $this->layout,
        ];
    }
}
