<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Broadcast::routes(["middleware" => ["auth:sanctum"]]);//chat用の認証

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->get('/users/search/{name_prefix}', [UserController::class, 'getUsersByNamePrefix']);
Route::middleware('auth:sanctum')->get('/users/{user_id}', [UserController::class, 'getUserById']);

Route::apiResources(['posts' => PostController::class]);
Route::get('/posts/friend/{friend_id}', [PostController::class, 'getFriendPosts']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/friend/status/{friend_id}', [FriendshipController::class, 'getStatus']);
    Route::post('/friend/request/{friend_id}', [FriendshipController::class, 'sendRequest']);
    Route::post('/friend/accept/{user_id}', [FriendshipController::class, 'acceptRequest']);//このuseridは自分のではなくrequestを送ってきた相手のuserid
    Route::post('/friend/reject/{user_id}', [FriendshipController::class, 'rejectRequest']);//このuseridは自分のではなくrequestを送ってきた相手のuserid
    Route::post('/friend/unfriend/{friend_id}', [FriendshipController::class, 'unfriend']);
    Route::get('/friends', [FriendshipController::class, 'getFriends']);
    Route::get('/requesters', [FriendshipController::class, 'getFriendRequestSenders']);
});


Route::middleware("auth:sanctum")->group(function(){
    Route::get('/messages/{chat_id}', [MessageController::class, 'messages'])
        ->name('messages');
    Route::post('/message/{chat_id}', [MessageController::class, 'message'])
        ->name('message');

});

