<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function getAllUser(){
        $users = User::all();
        return UserResource::collection($users);
     }

     public function getUser(Request $request){
        if(!empty($request->email)){
            $user = User::firstWhere("email", $request->email);
            return $user;
        }else if(!empty($request->user_id)){
            $user = User::firstWhere("id", $request->user_id);
            return $user;
        }

        return [];
     }

     public function updateRank(Request $request){
        $user = User::where("email", $request->email)->first();
     }

     public function checkPassword(){
        $users = User::all();
        $check = [];

        foreach($users as $user){
            array_push(
                $check,
                Hash::check("Badminton1", $user->password
            )
        );

        return $check;
        }
     }

     public function emailCheck(Request $request){
       $email = User::where("email", $request->email)->first();

       if(!empty($email)){
        return [
            'status' => Response::HTTP_OK,
            'message' => "Already Used",
            'data' => [
                "isValid"=>false
            ]
        ];
       }else{
        return [
            'status' => Response::HTTP_OK,
            'message' => "Good",
            'data' => [
                "isValid"=>true
            ]
        ];
       }
     }

     public function register(Request $request){

        $request->validate([
            "username" => "required",
            "email"=> "required | email",
            "password"=> "required",
            // "phone_number"=>"required",
            // "contacts"=>"required"
        ]);

        try{

            $user = new User();
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->rank = $request->rank;
            $user->contacts= "";
            $user->phone_number = "";
            $user->save();

            return [
                'status' => Response::HTTP_OK,
                'message' => "Success",
                'data' => [
                    $user->email,
                    $user->createToken('login')->plainTextToken]
            ];
        }catch(Exception $e){
            return [
                'status'=> Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
                'data'=> []
            ];
        }

     }


     public function deleteUser(Request $request){
        if(!empty($request->email)){
            $user = User::where('email', $request->email)->first();
        }else{
            $user = User::where('id', $request->id)->first();
        }

        if(!empty($user)){
            $user->delete();

            return [
                'status'=> Response::HTTP_OK,
                'message'=> 'Delete Success',
                'data'=> []
            ];
        }

        return [
            'status'=> Response::HTTP_NOT_FOUND,
            'message'=> 'User Not Found',
            'data'=> []
        ];
    }

    public function uploadPicture(Request $request){
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:4048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
            $image_path = '/images/' . $imageName;
            return response()->json($image_path);
        }
        return "Image Not Found";

    }

    public function updateUser(Request $request){

        if(!empty($request->email)){
            $user = User::where("email", $request->email)->first();
        }

        if(!empty($user)){
            try{
                $user->username = $request->username;
                $user->email = $request->email;
                if(!empty($request->password)){
                    $user->password = Hash::make($request->password);
                }
                $user->rank = $request->rank;
                $user->location_id = $request->location_id;
                if(!empty($request->image)){
                    $user->image_path = $image_path;
                }
                $user->contacts= $request->contacts;
                $user->phone_number =$request->phone_number;
                $user->save();

                return $user;
            }catch(Exception $e){
                return [];

            }
        }
    }

    public function getUsers(Request $request){
        $user = User::where("email", $request->email)->first();
        $users = User::where("location_id", $user->location_id )->get();

        return UserResource::collection($users);
    }

    public function updateProfilePict(Request $request){

        $user = User::where("email", $request->email)->first();
        if(!empty($user)){
            $user->image_path = $request->image_path;
            $user->save();
        }


    }

}
