<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LocationController;

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


Route::post('create_user',[UserController::class],'createUser');
Route::post('login',[AuthController::class],'login');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(
    function(){
        Route::get('check_password',[UserController::class,"checkPassword"]);
        Route::patch('update_user',[UserController::class,"updateUser"]);
        Route::delete('delete_user',[UserController::class,"deleteUser"]);

        Route::get('get_location',[LocationController::class, "getLocation"]);
        Route::delete('logout',[AuthController::class],'logout');

        Route::get('create_game',[GameController::class,'createGame']);
        Route::get('update_game',[GameController::class,'updateGame']);
    }
);
