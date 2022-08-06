<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class RecievedResumeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $link=DB::table('files')->where('ads_id',$this->ads_id)->where('sender_id',$this->sender_id)->pluck('file')->first();
        return [
            'id' => $this->id,
            // 'ad' => new RAdsResource($this->whenLoaded('ad')->load('personal')->load('jobCategories')->load('experiences')->load('langExperts')->load('langExperts')),
            'ad' => new RAdsResource($this->whenLoaded('ad')->load('personal')),
            'resume'=> $this->type == 'site' ? new EAdsResource($this->whenLoaded('resume')
            ->load('personal')->load('jobCategory')->load('experiences')) : url(env('USERS_RESUMES_UPLOAD_PATH') . $link),
            'status' => $this->status,
            'type' => $this->type,


        ];
    }
}
