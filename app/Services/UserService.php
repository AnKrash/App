<?php

namespace App\Services;

use App\Models\ResetPassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ResetPasswordMail;

class UserService
{
    public function create(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        $data['remember_token'] = Str::random(10);
        $user = User::create($data);

        $user->save();

        return $user;
    }

    public function login(array $data): ?User
    {
        $user = User::where('email', '=', $data['email'])->first();

        if ($user === null) {
            return null;
        }

        if (Hash::check($data['password'], $user->password)) {
            return $user;
        }

        return null;
    }

    public function reset(array $data): bool
    {
        $user = User::where('email', '=', $data['email'])->first();
        if ($user === null) {
            return false;
        }

        $reset = new ResetPassword();
        $reset->user_id = $user->id;
        $reset->token = Str::random(10);
        $reset->save();

        Mail::to($data['email'])->send(new ResetPasswordMail($reset->token));

        return true;
    }

    public function newPass(array $data): bool
    {
        $user = User::where('name', '=', $data['name'])->first();

        if ($user === null) {
            return false;
        }
        $resetToken = ResetPassword::where('token', '=', $data['token'])->first();

        if ($data['token'] === $resetToken->token) {
            $data['password'] = Hash::make($data['password']);
            $user->password = $data['password'];

            $user->save();

        }

        return true;
    }
}
