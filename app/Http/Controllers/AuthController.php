<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\NewPasswordRequest;
use App\Http\Requests\ResetRequest;
use App\Http\Resources\UserCollection;
use App\Services\UserService;
use App\Http\Requests\RegisterRequest;
use http\Client\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Gate;

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

    public function newPasswordUser(NewPasswordRequest $request)
    {
        $response = $this->userService->newPass($request->toArray());

        return response(["success" => $response]);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function updateUser(RegisterRequest $request)
    {
        $this->authorize('update', User::class);

        $header = $request->header('Authorization');

        if (strlen($header) != 12) {
            return response(['success' => false]);
        };

        $response = $this->userService->update($request->toArray());

        return response(["success" => $response]);

    }

    public function getUser($id)
    {
        $response = $this->userService->User($id);

        return response(["success" => $response]);
    }
}
