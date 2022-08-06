<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RAdsResource extends JsonResource
{
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
            'user_id' => $this->user_id,
            'user_name'=> $this->user->first_name .' '.$this->user->last_name,
            'title' => $this->title,
            'slug' => $this->slug,
            'type' => $this->type,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'personal' => new PersonalResource($this->whenLoaded('personal')),
            'jobCategory' => new JobCategoryResource($this->whenLoaded('jobCategory')),
            'image' =>  url(env('USERS_IMAGES_UPLOAD_PATH') . $this->image->url),
            'experiences' => ExperienceResource::collection($this->whenLoaded('experiences')),

        ];
    }
}
