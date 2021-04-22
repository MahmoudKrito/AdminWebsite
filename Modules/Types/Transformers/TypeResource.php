<?php

namespace Modules\Types\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class TypeResource extends JsonResource
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
            'parent' => $this->parent_id?$this->category:null,
        ];
    }
}
