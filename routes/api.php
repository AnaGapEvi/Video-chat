<?php

use App\Http\Controllers\Api\PostsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
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
//    Broadcast::routes(['middleware' => ['auth:api']]);
    Route::get('/auth-user', [AuthController::class, 'authUser']);
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::get('/video_chat', [VideoChatController::class, 'index']);
    Route::get('/chat/rooms', [ChatController::class, 'rooms']);
    Route::get('/auth/video_chat', [VideoChatController::class, 'auth']);
    Route::post('/chat/room/{roomId}/message', [ChatController::class, 'newMessage']);
    Route::get('/chat/room/{roomId}/messages', [ChatController::class, 'messages']);
});
