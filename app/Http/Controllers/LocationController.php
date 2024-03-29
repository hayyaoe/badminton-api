<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\LocationResource;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;

class LocationController extends Controller
{

    public function getAllLocation(){
        $locations = Location::all();
        return LocationResource::collection($locations);
    }

    public function getLocation(Request $request){
        $location = Location::where('id', $request->id)->first();

        if(!empty($location)){
            return[
                'status'=> Response::HTTP_OK,
                'message'=> "Location Found",
                "data"=> $location
            ];
        }

        return[
            'status'=> Response::HTTP_NOT_FOUND,
                'message'=> "Location Not Found",
                "data"=> []
        ];
    }
}
