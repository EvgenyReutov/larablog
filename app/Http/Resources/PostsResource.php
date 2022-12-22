<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PostsResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection
            //'id' => $this->id,
            //'title' => $this->title,
            //'status' => $this->status,
            //'authorName' => $this->author->name,
        ];
        //return parent::toArray($request);
    }
}
