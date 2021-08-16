<?php

use App\Http\Controllers\AuthController;
use App\Http\Resources\UserResourses;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\UserCollection;

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
//Route::name('user/')->group(function () {
    Route::post('user/reset', [AuthController::class, 'resetUser']);
//});
Route::post('/user', [AuthController::class, 'store']);
Route::post('/user/login', [AuthController::class, 'loginUser']);

Route::post('/user/new_password', [AuthController::class, 'newPasswordUser']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user/{id}', function ($id) {
        $user = User::find($id);
        return new UserResourses($user);
    });
    Route::put('/user/update', [AuthController::class, 'updateUser']);
});

Route::get('/users', function () {
    return new UserCollection(User::all());
});



//        Route::get('/user', function (Request $request) {
//            return $request->user();
//        });

//Route::get('/users/{id}',[AuthController::class, 'getUser'] );
//Route::get('/users/{id}', function ($id) {
////    return new UserCollection(\App\Http\Resources\UserResourses::findOrFail($id));
//    $user = User::find($id);
//    return new \App\Http\Resources\UserResourses($user);
//});
//Route::get('/users', [AuthController::class, 'emailUsers']);
//Route::get('/users', [AuthController::class, 'getUsers']);
//Route::put('/user/update', [AuthController::class, 'updateUser']);
//Route::put('/user/update', [AuthController::class, 'updateUser']);
//    ->middleware('auth');
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
