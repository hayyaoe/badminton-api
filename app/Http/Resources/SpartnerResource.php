<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpartnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "user1"=> $this->user1,
            "user2"=>$this->user2,
            "user1status"=>$this->user1status,
            "user2status"=>$this->user2status,
        ];
    }
}
