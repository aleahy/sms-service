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
            'name' => $this->name,
            'email' => $this->email,
            'webhook' => $this->whenLoaded('webhook', fn() => $this->webhook),
            'tokens' => TokenResource::collection($this->whenLoaded('tokens')),
            'received_sms_count' => $this->whenCounted('receivedSMSs'),
            'link' => $this->showLink(),
        ];
    }
}
