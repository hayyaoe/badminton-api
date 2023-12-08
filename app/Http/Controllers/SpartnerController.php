<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSpartnerRequest;
use App\Http\Requests\UpdateSpartnerRequest;
use App\Models\Spartner;

class SpartnerController extends Controller
{

    public function createSpartner(Request $request){

        $spartner = new Spartner();

        $spartner->user1 = $request->user1;
        $spartner->user2 = $request->user2;
        $spartner->save();

        return [
            'status'=> HTTP_OK,
            'message'=> "Spartner Created",
            'data'=> $spartner
        ];
    }

    public function updateSpartner(Requset $request){

        $spartner = Spartner::where('id', $request->id);

        if(!empty($spartner)){
            $spartner->user2status = '1';

            $spartner->save();

            return[
                'status'=> HTTP_OK,
                'message'=> "Spartner Added",
                'data'=>$spartner
            ];
        }

        return[
            'status'=> HTTP_NOT_FOUND,
            'message'=> "Spartner Not Found",
            'data'=>[]
        ];
    }
}
