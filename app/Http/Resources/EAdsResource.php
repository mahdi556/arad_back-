<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EAdsResource extends JsonResource
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
            'user'=>new UserResource($this->whenLoaded('user')),
            'title' => $this->title,
            'slug' => $this->slug,
            'type' => $this->type,
            'status'=>$this->status,
            'created_at'=>$this->created_at,
            'personal' => new PersonalResource($this->whenLoaded('personal')),
            'jobCategory' =>new JobCategoryResource($this->whenLoaded('jobCategory')),
            'image' =>$this->image !== null ? url(env('USERS_IMAGES_UPLOAD_PATH') . $this->image->url) : url(env('USERS_IMAGES_UPLOAD_PATH') .'140021.png' ),
            'video' =>$this->video !== null   ? url(env('USERS_VIDEOS_UPLOAD_PATH') . $this->video->url) : null,
            'experiences'=>ExperienceResource::collection($this->whenLoaded('experiences')),
            'langExperts'=>LangExpertResource::collection($this->whenLoaded('langExperts')),
            'softExperts'=>SoftExpertResource::collection($this->whenLoaded('softExperts')),
            'degrees'=>DegreeResource::collection($this->whenLoaded('degrees')),
            'samples'=>SampleResource::collection($this->whenLoaded('samples')),
            
        
        ];
    }
}
