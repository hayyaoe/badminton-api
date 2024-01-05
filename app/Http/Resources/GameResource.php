<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'score_1'=> $this->score_1,
            'score_2' => $this->score_2,
            'information' => $this->information,
            'gamecode' =>$this->gamecode,
            'gamestatus' => $this->gamestatus
        ];
    }
}
