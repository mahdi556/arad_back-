<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SampleResource extends JsonResource
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
            'title' =>  $this->fa_name,
            'link' => $this->link,
            'ucode' => $this->ucode,
            'faDiscription' => $this->fa_discription,
            'Entitle' =>   $this->en_name,
            'enDiscription' => $this->en_discription,
            'file' => $this->file !== null ? url(env('USERS_FILES_UPLOAD_PATH') . $this->file) : url(env('USERS_IMAGES_UPLOAD_PATH') . '140021.png'),
        ];
    }
}
