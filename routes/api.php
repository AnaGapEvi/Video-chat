<?php

use App\Http\Controllers\Api\PostsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\TwilioChatController;
use App\Http\Controllers\VideoChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;

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
//Route::resource('posts', PostsController::class);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);




Route::middleware('auth:api')->group(function () {
    Broadcast::routes();
    Route::post('/token', [TwilioChatController::class, 'getToken']);

    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/auth-user', [AuthController::class, 'authUser']);
    Route::get('/get-all-users', [AuthController::class, 'getAllUsers']);
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword']);

    Route::get('/chat/rooms', [ChatController::class, 'rooms']);
    Route::get('/chat/room/{roomId}/messages', [ChatController::class, 'messages']);
    Route::post('/chat/room/{roomId}/message', [ChatController::class, 'newMessage']);

    Route::get('/video_chat', [VideoChatController::class, 'index']);
    Route::post('/auth/video_chat', [VideoChatController::class, 'auth']);

});
