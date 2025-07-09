<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public static $wrap = 'user';
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'username' => $this->resource->username,
            'email' => $this->resource->email,
            'role' => $this->resource->role,
            'avatar'=> $this->resource->avatar ?? 'default.jpg',
        ];
    }

}
