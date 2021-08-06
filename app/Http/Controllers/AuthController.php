<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetRequest;
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

    public function loginUser(RegisterRequest $request)
    {
        $user = $this->userService->login($request->toArray());
        if ($user == null) {
            return response('');
        }

        $token = $user->createToken('token')->accessToken;
        $response = ['token' => $token];

        return response($response);
    }
//    protected $reset;
//
//    public function __construct(UserService $reset)
//    {
//        $this->userService = $reset;
//    }

    public function resetUser(ResetRequest $request)
    {
        $user = $this->userService->reset($request->toArray());
        if ($user == null) {
            $mes='Not user in DB!';
            return response($mes);
        }

        return response('');
    }
}
