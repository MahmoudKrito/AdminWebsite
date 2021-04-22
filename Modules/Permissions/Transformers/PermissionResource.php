<?php

namespace Modules\Permissions\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
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
            'group' => $this->group,
            'guard_name' => $this->guard_name,
            'permission_name' => $this->permission_name,
            'permission_name_ar' => $this->permission_name_ar,
        ];
    }
}
