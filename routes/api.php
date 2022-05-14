<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserStatesController;
use App\Http\Controllers\NoticeController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [AuthController::class, 'login']);
Route::post('signup', [AuthController::class, 'register']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::get('all', [UserController::class, 'getAll']);
        Route::get('states', [UserStatesController::class, 'getAll']);
        Route::get('by-id/{id}', [UserController::class, 'getId']);
        Route::get('by-state/{id}', [UserController::class, 'getByState']);
        Route::put('update/{id}', [UserController::class, 'update']);
        Route::delete('delete/{id}', [UserController::class, 'delete']);
    });
    Route::group(['prefix' => 'notice'], function () {
        Route::get('all', [NoticeController::class, 'getAll']);
        Route::get('by-id/{id}', [NoticeController::class, 'getId']);
        Route::post('create', [NoticeController::class, 'create']);
        Route::put('update/{id}', [NoticeController::class, 'update']);
        Route::delete('delete/{id}', [NoticeController::class, 'delete']);
        //...
    });
    Route::post('logout', [AuthController::class, 'logout']);
});
