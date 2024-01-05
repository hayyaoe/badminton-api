<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SetResource extends JsonResource
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
            "player1_score" => $this->player1_score,
            "player2_score" => $this->player2_score,
            "created_at"=> $this->created_at,
            "updated_at"=>$this->updated_at,
            "game_id"=> $this->game_id
        ];
    }
}
