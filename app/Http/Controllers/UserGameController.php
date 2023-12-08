<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserGameRequest;
use App\Http\Requests\UpdateUserGameRequest;
use App\Models\UserGame;

class UserGameController extends Controller
{

    public function createUserGame(Request $request){
        $userGame = new UserGame();
        $userGame->user_id = $request->user_id;
        $userGame->game_id = $request->user_id;
        $userGame->save();

        return[
            'status'=> HTTP_OK,
            'message'=> 'user game created',
            'data'=> $userGame
        ];
    }

    public function getUserGame(Request $request){
        $userGame = UserGame::where('id', $request->id)->frist();

        if(!empty($userGame)){
            return[
                'status'=> HTTP_OK,
                'message'=> 'user game found',
                'data'=> $userGame
            ];
        }
        return[
            'status'=> HTTP_NOT_FOUND,
            'message'=> 'user game not found',
            'data'=> []
        ];

    }
}
