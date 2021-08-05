<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
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
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function store(RegisterRequest $request)
    {
        $user = $this->userService->create($request->toArray());
        $token = $user->createToken('token')->accessToken;
        $response = ['token' => $token];

        return response($response, 201);
    }

    public function createUser(RegisterRequest $request)
    {

    }
}
