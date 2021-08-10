<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetRequest;
use App\Services\UserService;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    protected $userService;

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

    public function loginUser(LoginRequest $request)
    {
        $user = $this->userService->login($request->toArray());

        if ($user == null) {
            return response(['success' => false]);
        }

        $token = $user->createToken('token')->accessToken;
        $response = ['token' => $token];

        return response($response);
    }

    public function resetUser(ResetRequest $request)
    {
        $response = $this->userService->reset($request->toArray());

        return response(["success" => $response]);
    }
}
