<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            "email"=> "requeired|email",
            "password"=> "required"
        ]);

        $user = User::where("email", $request->email)->first();

        if(!empty($user)){
            if(Hash::check($request->password, $user->password)){
                return [
                    "status" => Response::HTTP_OK,
                    "message" => "Token Created",
                    "data" => $user->createToken('login')->plainTextToken
                ];
            }else{
                return[
                    "status"=> RESPONSE::HTTP_FORBIDDEN,
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