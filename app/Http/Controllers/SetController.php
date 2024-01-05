<?php

namespace App\Http\Controllers;

use App\Models\Set;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\SetResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSetRequest;
use App\Http\Requests\UpdateSetRequest;

class SetController extends Controller
{

    public function createSet(Request $request){
        $set = new Set();

        $set->player1_score = 0;
        $set->player2_score = 0;
        $set->game_id = $request->game_id;
        $set->save();

        return[
            'status'=> Response::HTTP_OK,
            'message'=>"set created",
            'data'=> $set
        ];
    }

    public function updateSet(Request $request){
        $set = Set::where('id', $request->id)->first();

        if(!empty($set)){
            $set->player1_score = $request->player1_score;
            $set->player2_score = $request->player2_score;
            $set->save();

            return[
                'status'=> Response::HTTP_OK,
                'message'=> "Set Updated",
                'data'=>$set
            ];
        }

        return[
            'status'=> Response::HTTP_NOT_FOUND,
            'message'=> "Set Not Found",
            'data'=>[]
        ];
    }

    public function getSets(Request $request){
        $sets = Set::where('game_id', $request->game_id)->get();

        if(!empty($sets)){
            return SetResource::collection($sets);
        }

        return[
        ];

    }
}
