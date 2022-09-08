<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SMSResource extends JsonResource
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
            'from_phone_number' => $this->from_phone_number,
            'to_phone_number' => $this->to_phone_number,
            'sent' => $this->sent,
            'sender' => UserResource::make($this->whenLoaded('sender')),
            'recipient' => UserResource::make($this->whenLoaded('recipient')),
            'message' => $this->message,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'link' => route('sms.show', ['sms' => $this->id]),
        ];
    }
}
