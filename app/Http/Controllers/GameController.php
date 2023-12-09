<?php

namespace App\Http\Controllers;

use App\Models\Set;
use App\Models\Game;
use App\Models\UserGame;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;

class GameController extends Controller
{

    public function createGame(Request $request){
        $game = new Game();
        $game->score_1 = 0;
        $game->score_2 = 0;
        $game->information = $request->information;
        $game->gamecode = $request->gamecode;
        $game->save();

        $userGame = new UserGame();
        $userGame->user_id = $request->user_id;
        $userGame->game_id = $game->id;
        $userGame->save();

        $set = new Set();

        $set->player1_score = 0;
        $set->player2_score = 0;
        $set->game_id = $game->id;
        $set->save();

        $set = new Set();

        $set->player1_score = 0;
        $set->player2_score = 0;
        $set->game_id = $game->id;
        $set->save();

        return [
            "status"=>Response::HTTP_OK,
            "message"=> "success",
            "data"=>[$game, $userGame]
        ];
    }

    public function updateGame(Request $request){
        if(!empty($request->gamecode)){
            $game = Game::where('gamecode',$request->gamecode )->first();
        }else{
            $game = Game::where('id',$request->id )->first();
        }

        if(!empty($game)){
            try{
                $game->score_1= $request->score_1;
                $game->score_2= $request->score_2;
                $game->information = $request->information;
                $game->gamestatus;
                $game->save();

                return[
                    "satus"=> Response::HTTP_OK,
                    "message"=> "Game Updated",
                    "data"=> $game
                ];
            }catch(Exception $e){
                return[
                    "satus"=> Response::HTTP_INTERNAL_SERVER_ERROR,
                    "message"=> $e->getMessage(),
                    "data"=> []
                ];
            }
        }

        return [
            'status'=> Response::HTTP_NOT_FOUND,
            'message'=> 'Game Not Found',
            'data'=> []
        ];

    }

    public function joinGame(Request $request){
        $game = Game::where('gamecode', $request->gamecode)->first();

        if(!empty($game)){
            $userGame = new UserGame();
            $userGame->user_id = $request->user_id;
            $userGame->game_id = $game->id;
            $userGame->save();
            return[
                "satus"=> Response::HTTP_OK,
                "message"=> "Game Joined",
                "data"=> $game
            ];
        }

        return [
            'status'=> Response::HTTP_NOT_FOUND,
            'message'=> 'Game Not Found',
            'data'=> []
        ];
    }
}
