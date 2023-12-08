<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;

class GameController extends Controller
{

    public function createGame(Request $request){
        $game = new Game();
        $game->score_1 = 0;
        $game->score_2 = 0;
        $game->information = $request->information;
        $game->save();
        return [
            "status"=>Response::HTTP_OK,
            "message"=> "success",
            "data"=>$game
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
                $game->information = $request->informaton;
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
            return[
                "satus"=> Response::HTTP_OK,
                "message"=> "Game Updated",
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
