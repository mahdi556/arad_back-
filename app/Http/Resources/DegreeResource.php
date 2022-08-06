<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DegreeResource extends JsonResource
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
            'fa_name' => $this->fa_name,
            'fa_degree' => $this->fa_major,
            'fa_date_d' => $this->fa_date_d,
            'fa_date_m' => $this->fa_date_m,
            'fa_date_y' => $this->fa_date_y,
            'fa_active'=>$this->fa_active,
            'en_name' => $this->en_name,
            'en_degree' => $this->en_major,
            'en_date_d' => $this->en_date_d,
            'en_date_m' => $this->en_date_m,
            'en_date_y' => $this->en_date_y,
            'en_active'=>$this->en_active


        ];
    }
}
