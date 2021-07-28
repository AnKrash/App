<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
//    protected $var;
//
//    public function __construct(classname $var)
//    {
//        $this->var = $var;
//    }

    public function store(RegisterRequest $request)
    {
        $request['password'] = Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user = User::create($request->toArray());
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token];

        return response($response, 201);
    }
}
