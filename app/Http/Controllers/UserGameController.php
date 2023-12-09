<?php

namespace App\Http\Controllers;

use App\Models\UserGame;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserGameRequest;
use App\Http\Requests\UpdateUserGameRequest;

class UserGameController extends Controller
{

    public function createUserGame(Request $request){
        $userGame = new UserGame();
        $userGame->user_id = $request->user_id;
        $userGame->game_id = $request->game_id;
        $userGame->save();

        return[
            'status'=> Response::HTTP_OK,
            'message'=> 'user game created',
            'data'=> $userGame
        ];
    }

    public function getUserGames(Request $request){
        $userGames = UserGame::where('user_id', $request->user_id)->get();

        if(!empty($userGames)){
            return[
                'status'=> Response::HTTP_OK,
                'message'=> 'user game found',
                'data'=> $userGames
            ];
        }
        return[
            'status'=> Response::HTTP_NOT_FOUND,
            'message'=> 'user game not found',
            'data'=> []
        ];

    }
}
