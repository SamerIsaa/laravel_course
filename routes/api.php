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
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:api');


Route::group(['prefix' => 'users'], function () {
    Route::get('all', [UserController::class, 'index']);
    Route::get('{id}/show', [UserController::class, 'show']);
    Route::post('/', [UserController::class, 'store']);
    Route::put('{id}/update', [UserController::class, 'update']);
    Route::delete('{id}/delete', [UserController::class, 'delete']);

    Route::post('send-notifications', [UserController::class, 'sendNotifications']);
    Route::post('send-mail', [UserController::class, 'sendMail']);
    Route::post('{id}/get-notifications', [UserController::class, 'getUserNotification']);
    Route::post('{id}/n/{nid}/read', [UserController::class, 'markNotificationAsRead']);;
});


Route::group(['middleware' => 'auth:api'], function () {
    Route::get('my-data', [UserController::class, 'myData']);
    Route::get('fetch-post/{id}', [UserController::class, 'findPost']);
    Route::get('fetch-address/{id}', [UserController::class, 'findAddress']);
    Route::get('load-comments', [UserController::class, 'loadUserComments']);


});


Route::get('fetch-users-with-materials', [UserController::class, 'fetchUsersWithMaterials']);


