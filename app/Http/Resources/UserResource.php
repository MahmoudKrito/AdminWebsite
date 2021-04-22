<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'access_token' => $this->createToken('auth_token')->plainTextToken,
            'token_type' => 'Bearer',
            'name' => $this->name,
            'code' => $this->code,
            'active' => $this->active,
            'image' => $this->image
        ];
    }
}
