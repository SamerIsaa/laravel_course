<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('login' , [UserController::class , 'login']);
Route::post('logout' , [UserController::class , 'logout'])->middleware('auth:api');


Route::group(['prefix' => 'users'] , function () {
    Route::get('all' , [UserController::class , 'index']);
    Route::get('{id}/show' , [UserController::class , 'show']);
    Route::post('/' , [UserController::class , 'store']);
    Route::put('{id}/update' , [UserController::class , 'update']);
    Route::delete('{id}/delete' , [UserController::class , 'delete']);
});


Route::get('my-data' , [UserController::class , 'myData'])->middleware('auth:api');

