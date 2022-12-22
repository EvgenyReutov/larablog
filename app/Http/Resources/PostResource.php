<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    //public static $wrap = 'values';

    //public $with = ['varsion' => '1.0'];
    //public $additional = ['asd' => 1];

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'status' => $this->status,
            'authorName' => $this->author->name,
        ];
        //return parent::toArray($request);
    }

    public function with($request)
    {
        return [
            'metadata' => [
                'page' => '1',
                'nasNext' => false,
            ]
        ];
    }
}
