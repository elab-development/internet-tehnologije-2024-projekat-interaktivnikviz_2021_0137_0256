<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    public static $wrap = 'question';
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'=>$this->resource->id,
            'question'=>$this->resource->question,
            'category'=>$this->resource->category,
		 'options'=>$this->resource->options,
            'answer' => $this->resource->answer,
            'points' => $this->resource->points
        ];
    }

}
