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
        //'category_name' => optional($this->resource->category)->name,
		 'options' => json_decode($this->options),
         //'options' => $this->options,
            'answer' => $this->resource->answer,
            'points' => $this->resource->points
        ];
    }

}
