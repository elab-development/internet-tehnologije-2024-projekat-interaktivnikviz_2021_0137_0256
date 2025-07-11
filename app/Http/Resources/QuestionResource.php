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
            // Umesto cele category vraćamo samo naziv
        'category_name' => $this->resource->category ? $this->resource->category->name : null,
		 'options' => json_decode($this->options),
            'answer' => $this->resource->answer,
            'points' => $this->resource->points
        ];
    }

}
