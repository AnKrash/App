<?php

namespace App\Services;

use App\Models\ResetPassword;
use App\Models\User;
use Illuminate\Support\Carbon;
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
        $resetToken = ResetPassword::where('token', '=', $data['token'])->first();
        if ($resetToken === null) {
            return false;
        }

        $user = User::where('id', '=', $resetToken->user_id)->first();
        if ($user === null) {
            return false;
        }

        $timeNow = Carbon::now()->gettimestamp();
        $tokenCreatedAt = Carbon::parse($resetToken->created_at)->gettimestamp();
        if ($timeNow - $tokenCreatedAt > 7200) {
            return false;
        }

        $data['password'] = Hash::make($data['password']);
        $user->password = $data['password'];
        $user->save();
        ResetPassword::where('id',$resetToken->id)->delete();


        return true;
    }

    public function update(array $data): bool
    {
        $user = User::where('id', '=', $data['id'])->first();
        if ($user === null) {
            return false;
        }
        if ($user->can('update', $data))
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->save();

        return true;
    }

}
