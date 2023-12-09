<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SpartnerController;
use App\Http\Controllers\UserGameController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('all_location', [LocationController::class,'getAllLocation']);
Route::post('login', [AuthController::class, 'login']);


Route::post('register',[UserController::class,'register']);


Route::middleware('auth:sanctum')->group(
    function(){

        // Auth
        Route::get('check_password',[UserController::class,"checkPassword"]);
        Route::delete('logout',[AuthController::class,'logout']);

        // User
        Route::patch('update_user', [UserController::class, 'updateUser']);
        Route::delete('delete_user',[UserController::class,"deleteUser"]);

        // Location
        Route::get('get_location',[LocationController::class, "getLocation"]);

        // Game
        Route::post('create_game',[GameController::class,'createGame']);
        Route::patch('update_game', [GameController::class, 'updateGame']);
        Route::post('join_game',[GameController::class,'joinGame']);

        // Reviews
        Route::get('get_reviews',[ReviewController::class,'getReviews']);
        Route::post('create_review',[ReviewController::class,'createReview']);

        // Set
        Route::post('create_set',[SetController::class,'createSet']);
        Route::get('get_set',[SetController::class,'getSet']);
        Route::patch('update_set',[SetController::class,'updateSet']);

        // Spartner
        Route::get('get_spartner',[SpartnerController::class,'getSpartner']);
        Route::patch('update_spartner',[SpartnerController::class,'updateSpartner']);
        Route::post('create_spartner',[SpartnerController::class,'createSpartner']);

        // UserGame
        Route::post('create_user_game',[UserGameController::class,'createUserGame']);
        Route::get('get_user_games',[UserGameController::class,'getUserGames']);
    }
);
