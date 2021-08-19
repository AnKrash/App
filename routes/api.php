<?php

use App\Http\Controllers\AuthController;
use App\Http\Resources\UserResourses;
use App\Models\User;
use Illuminate\Support\Facades\Route;


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
// todo wrap in group user
// create and register user policy
// create method in controller and service
// write unit and feature tests
//Route::group(['middleware' => 'auth'], function () {
//    Route::group([
//        'prefix' => 'user',
//        'as' => 'user'
//    ], function () {
//
//    });
//});
//
//);

//Route::post('user/reset', [AuthController::class, 'resetUser']);
//Route::post('/user', [AuthController::class, 'store']);
//Route::post('/user/login', [AuthController::class, 'loginUser']);
//Route::post('/user/new_password', [AuthController::class, 'newPasswordUser']);
//Route::put('/user/update', [AuthController::class, 'updateUser']);

Route::prefix('user')->group(function () {
    Route::post('/login', [AuthController::class, 'loginUser']);
    Route::post('/reset', [AuthController::class, 'resetUser']);
    Route::post('/', [AuthController::class, 'store']);
    Route::get('/', [AuthController::class, 'index']);
    Route::post('/login', [AuthController::class, 'loginUser']);
    Route::post('/new_password', [AuthController::class, 'newPasswordUser']);
    Route::put('/update', [AuthController::class, 'updateUser']);
    Route::delete('/{id}', [AuthController::class, 'delete']);
    Route::middleware('auth:api')->group(function () {
        Route::get('/{id}', [AuthController::class, 'show']);
        //Route::delete('/{id}', [AuthController::class, 'delete']);
    });
});

