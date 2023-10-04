<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->user->name,
            'title' => $this->title,
            'description' => $this->description,
            'created_at' => $this->created_at
        ];
    }

    public function with($request)
    {
        return [
            'status' => 'Ok'
        ];
    }
}
