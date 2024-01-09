<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserGame;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Http\Resources\UserGameResource;
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
        $user = User::where('email', $request->email)->first();
        $userGames = UserGame::where('user_id', $user->id)->get();

        $games = [];
        if (!empty($userGames)) {
            foreach ($userGames as $userGame) {

                $games[] = $userGame->game;
            }
        }

        $gamedatas = [];
        foreach($games as $game){
            $users = [];
                foreach($game->userGames as $us){
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
            $gamedatas[]=[
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
            "history"=>$gamedatas
        ];


    }

    public function getUserInAGame(Request $request){
        $userGames = UserGame::where('game_id', $request->game_id)->get();
        return UserGameResource::collection($userGames);
    }
}
