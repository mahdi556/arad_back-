<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExperienceResource extends JsonResource
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
            'fa_title' => $this->fa_title,
            'fa_org' => $this->fa_org,
            'fa_reason' => $this->fa_reason,
            'fa_start_m' => $this->fa_start_m,
            'fa_start_y' => $this->fa_start_y,
            'fa_finish_m' => $this->fa_finish_m,
            'fa_finish_y' => $this->fa_finish_y,
            'fa_active'=>$this->fa_active,
            'en_title' => $this->en_title,
            'en_org' => $this->en_org,
            'en_reason' => $this->en_reason,
            'en_start_m' => $this->en_start_m,
            'en_start_y' => $this->en_start_y,
            'en_finish_m' => $this->en_finish_m,
            'en_finish_y' => $this->en_finish_y,
            'en_active'=>$this->en_active,

        ];
    }
}
