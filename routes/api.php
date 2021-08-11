<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
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

Route::post('/user', [AuthController::class, 'store']);
Route::post('/user/login', [AuthController::class, 'loginUser']);
Route::post('/user/reset', [AuthController::class, 'resetUser']);
Route::post('/user/new_password', [AuthController::class, 'newPasswordUser']);
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
