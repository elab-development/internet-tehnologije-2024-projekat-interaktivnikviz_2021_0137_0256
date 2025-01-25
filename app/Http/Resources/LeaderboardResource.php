<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LeaderboardResource extends JsonResource
{
    public static $wrap = 'leaderboard';
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'=>$this->resource->id,
            'user' => new UserResource($this->resource->user),
            'points'=>$this->resource->points
        ];
    }
}
