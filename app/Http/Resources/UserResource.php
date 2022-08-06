<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->first_name . ' ' . $this->last_name,
            'first_name' => $this->first_name ,
            'last_name' => $this->last_name ,
            'cellphone' => $this->cellphone,
            'token' => $this->remember_token,
            'step' => $this->step,
            'status' => $this->status,
            'new' => $this->new,
            'created_at'=>$this->created_at,
            'role' => $this->getRoleNames(),
            'ads_count'=>count($this->ads),
        ];
    }
}
