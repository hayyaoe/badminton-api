<?php

namespace App\Http\Controllers;

use App\Models\Set;
use App\Models\Game;
use App\Models\User;
use App\Models\UserGame;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;

class GameController extends Controller
{

    static function generateUniqueCode(): string {
        $code = Str::random(6);
        $game = Game::where("gamecode",$code)->first();
        if(!empty($game)){
            $code = generateUniqueCode();
        }
        return $code;
    }

    public function createGame(Request $request){
        if(!empty($request->email)){
            $user = User::where('email', $request->email)->first();
        }
        $game = new Game();
        $game->score_1 = 0;
        $game->score_2 = 0;
        $game->information = "";
        $game->gamecode = GameController::generateUniqueCode();
        $game->save();

        $userGame = new UserGame();
        $userGame->user_id = $user->id;
        $userGame->game_id = $game->id;
        $userGame->save();

        $set1 = new Set();

        $set1->player1_score = 0;
        $set1->player2_score = 0;
        $set1->game_id = $game->id;
        $set1->save();

        $set2 = new Set();

        $set2->player1_score = 0;
        $set2->player2_score = 0;
        $set2->game_id = $game->id;
        $set2->save();

        return [
            "game_id"=> $game->id,
            "set1_id"=> $set1->id,
            "set2_id"=> $set2->id,
            "information"=> $game->information,
            "score_1"=> $game->score_1,
            "score_2"=> $game->score_2,
            "gamecode"=> $game->gamecode,
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
                $game->gamestatus = $request->gamestatus;
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

    public function getGame(Request $request){
        $game = Game::where('id', $request->game_id)->first();

        return $game;
    }
}
