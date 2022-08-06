<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'user_id' => new UserResource($this->whenLoaded('user')),
            'order_id' => $this->order_id,
            'trans_id' => $this->trans_id,
            'amount' => $this->amount,
            'date' => $this->created_at,
            'status' => $this->status,
        ];
    }
}
