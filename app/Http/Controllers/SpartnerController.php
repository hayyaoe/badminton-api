<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Spartner;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSpartnerRequest;
use App\Http\Requests\UpdateSpartnerRequest;

class SpartnerController extends Controller
{

    public function createSpartner(Request $request){

        $spartner = new Spartner();

        $spartner->user1 = $request->user1;
        $spartner->user2 = $request->user2;
        $spartner->save();

        return [
            'status'=> Response::HTTP_OK,
            'message'=> "Spartner Created",
            'data'=> $spartner
        ];
    }

    public function updateSpartner(Request $request){

        $spartner = Spartner::where('id', $request->game_id)->first();

        if(!empty($spartner)){
            $spartner->user2status = 1;

            $spartner->save();

            return $spartner;
        }

        return[];
    }

    public function getSpartnerRequest(Request $request){
        $spartnerRequests = Spartner::where('user2', $request->user_id)->whereAnd('user2status',0)->get();

        $requests=[];
        foreach($spartnerRequests as $spartnerRequest ){

            $user= User::where('id', $spartnerRequest->user1)->first();
            $requests[] = [
            "id"=> $spartnerRequest->id,
            "created_at"=> $spartnerRequest->created_at,
            "updated_at"=> $spartnerRequest->updated_at,
            "user1"=> $spartnerRequest->user1,
            "user2"=> $spartnerRequest->user2,
            "user1status" => $spartnerRequest->user1status,
            "user2status"=> $spartnerRequest->user1status,
            "user1data" => $user
            ];
        }
        return [
            "spartnerRequests" =>$requests
        ];

    }

    public function getSpartner(Request $request){
        $spartner = Spartner::where('id', $request->id)->first();

        if(!empty($spartner)){
            return[
                'status'=> Response::HTTP_OK,
                'message'=> "Spartner Added",
                'data'=>$spartner
            ];
        }
        return[
            'status'=> Response::HTTP_NOT_FOUND,
            'message'=> "Spartner Not Found",
            'data'=>[]
        ];

    }

    public function getSpartners(Request $request){
        $spartner = [];
        $users = [];
        $spartner = Spartner::where('user1', $request->user_id)
                    ->where('user1status', 1)
                    ->where('user2status', 1)
                    ->get();
        $spartner = Spartner::where('user2', $request->user_id)
                    ->where('user1status', 1)
                    ->where('user2status', 1)
                    ->get();

        foreach($spartner as $sparts){
            if($sparts->user1 == $request->user_1){
                $users[] = User::where('id',$sparts->user2)->first();
            }else{
                $users[] = User::where('id',$sparts->user1)->first();
            }

        }

        return [
            "spartner"=>$users
        ];
    }
}
