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

        $userGames = $game->userGames;
        $users = [];
        foreach($userGames as $us){

            $data =$us->user;
            $users[] = [
                "user_id" => $data->id,
                "photo" => $data->image_path,
                "username" => $data->username
            ];
        }

        return [
            "game_id"=> $game->id,
            "information"=> $game->information,
            "created_at"=> $game->created_at,
            "updated_at" => $game->updated_at,
            "score_1"=> $game->score_1,
            "score_2"=> $game->score_2,
            "gamecode"=> $game->gamecode,
            "gamestatus"=> $game->gamestatus,
            "players"=> $users,
        ];
    }

    public function updateGame(Request $request){
        if(!empty($request->gamecode)){
            $game = Game::where('gamecode',$request->gamecode )->first();
        }

        if(!empty($game)){
            try{
                $game->score_1= $request->score_1;
                $game->score_2= $request->score_2;
                $game->information = $request->information;
                $game->gamestatus = $request->gamestatus;
                $game->save();

                $userGames = $game->userGames;
                $users = [];
                foreach($userGames as $us){

                    $data =$us->user;
                    $users[] = [
                        "user_id" => $data->id,
                        "photo" => $data->image_path,
                        "username" => $data->username
                    ];
                }
                $information = "";
                if (!empty($game->information)) {
                   $information = $game->information;
                }

                return [
                    "game_id"=> $game->id,
                    "information"=> $information,
                    "created_at"=> $game->created_at,
                    "updated_at" => $game->updated_at,
                    "score_1"=> $game->score_1,
                    "score_2"=> $game->score_2,
                    "gamecode"=> $game->gamecode,
                    "players"=> $users,
                ];
            }catch(Exception $e){
                return[];
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
        $user = User::where('email', $request->email)->first();

        if(!empty($game)){
            $userGame = new UserGame();
            $userGame->user_id = $user->id;
            $userGame->game_id = $game->id;
            $userGame->save();

            $userGames = $game->userGames;
                $users = [];
                foreach($userGames as $us){

                    $data =$us->user;
                    $users[] = [
                        "user_id" => $data->id,
                        "photo" => $data->image_path,
                        "username" => $data->username
                    ];
                }
                $information = "";
                if (!empty($game->information)) {
                   $information = $game->information;
                }

                return [
                    "game_id"=> $game->id,
                    "information"=> $information,
                    "created_at"=> $game->created_at,
                    "updated_at" => $game->updated_at,
                    "score_1"=> $game->score_1,
                    "score_2"=> $game->score_2,
                    "gamecode"=> $game->gamecode,
                    "players"=> $users,
                ];
        }

        return [
            "game_id"=> 0,
        "information"=> "",
        "created_at"=> "",
        "updated_at" => "",
        "score_1"=> 0,
        "score_2"=> 0,
        "gamecode"=> "",
        "players"=> [],];
    }

    public function getGameDatas(Request $request){
        $game = Game::where('gamecode', $request->gamecode)->first();
        $user = User::where('email', $request->email)->first();

        $userGames = $game->userGames;
                $users = [];
                foreach($userGames as $us){

                    $data =$us->user;
                    $users[] = [
                        "user_id" => $data->id,
                        "photo" => $data->image_path,
                        "username" => $data->username
                    ];
                }
                $information = "";
                if (!empty($game->information)) {
                   $information = $game->information;
                }

                return [
                    "game_id"=> $game->id,
                    "information"=> $information,
                    "created_at"=> $game->created_at,
                    "updated_at" => $game->updated_at,
                    "score_1"=> $game->score_1,
                    "score_2"=> $game->score_2,
                    "gamecode"=> $game->gamecode,
                    "players"=> $users,
                    "sets"=> $game->sets
                ];
    }

    public function getGame(Request $request){
        $game = Game::where('id', $request->game_id)->first();

        return $game;
    }
}
