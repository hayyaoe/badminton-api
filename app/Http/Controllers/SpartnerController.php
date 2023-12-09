<?php

namespace App\Http\Controllers;

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

        $spartner = Spartner::where('id', $request->id)->first();

        if(!empty($spartner)){
            $spartner->user2status = '1';

            $spartner->save();

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
}
