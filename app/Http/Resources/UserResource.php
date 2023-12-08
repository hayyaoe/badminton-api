<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            "id"=> $this->id,
            "username"=> $this->username,
            "password"=> $this->password,
            "profile_path"=> $this->profile_path,
            "rank"=> $this->rank,
            "location_id"=> $this->location_id
        ];
    }
}