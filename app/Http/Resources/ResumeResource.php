<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResumeResource extends JsonResource
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
            'user' => new UserResource($this->whenLoaded('user')),
            'title' => $this->title,
            'entitle' => $this->entitle,
            'type' => $this->type,
            'personal' => new PersonalResource($this->whenLoaded('personal')),
            'jobCategory' => new JobCategoryResource($this->whenLoaded('jobCategory')),
            'image' => url(env('USERS_IMAGES_UPLOAD_PATH') . $this->image->url),
            'experiences' => ExperienceResource::collection($this->whenLoaded('experiences')),
            'langExperts' => LangExpertResource::collection($this->whenLoaded('langExperts')),
            'softExperts' => SoftExpertResource::collection($this->whenLoaded('softExperts')),
            'degrees' => DegreeResource::collection($this->whenLoaded('degrees')),
            'samples' => SampleResource::collection($this->whenLoaded('samples')),
            'socials' => SocialResource::collection($this->whenLoaded('socials'))


        ];
    }
}
