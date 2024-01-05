<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            "email"=> "required",
            "password"=> "required"
        ]);

        $user = User::where("email", $request->email)->first();

        if(!empty($user)){
            if(Hash::check($request->password, $user->password)){
                return [
                    "status" => Response::HTTP_OK,
                    "message" => "Token Created",
                    "data" => [
                        $user->createToken('login')->plainTextToken,
                        $user->email
                        ]
                ];
            }else{
                return[
                    "status"=> Response::HTTP_FORBIDDEN,
                    "message"=>"Incorrect Password",
                    "data"=>[]
                ];
            }
        }else{
            return[
                "status"=> Response::HTTP_NOT_FOUND,
                "message"=> "User Not Found",
                "data"=> []
            ];
        }
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return[
            "status"=> Response::HTTP_OK,
            "message"=> "Logged Out",
            "data"=>[]
        ];
    }
}
