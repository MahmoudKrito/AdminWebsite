<?php

namespace Modules\Zones\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ZoneResource extends JsonResource
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
            'area' => $this->area,
        ];
    }
}
