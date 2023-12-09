<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;

class ReviewController extends Controller
{

    public function createReview(Request $request){
        $review = new Review();

        $review->user_id = $request->user_id;
        $review->game_id = $request->game_id;
        $review->review = $request->review;

        $review->save();

        return[
            'status'=>Response::HTTP_OK,
            'message'=> "Review Created",
            'data'=> $review
        ];
    }

    public function getReviews(Request $request){
        $review = Review::where('game_id', $request->game_id)->get();

        if(!empty($review)){
            return[
                'status'=> Response::HTTP_OK,
                'message'=> "Review Created",
                'data'=> $review
            ];
        }

        return[
            'status'=> Response::HTTP_NOT_FOUND,
            'message'=> "Review Not Found",
            'data'=> []
        ];

    }
}
