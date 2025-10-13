<?php
namespace App\Repositories\Auth;

class AuthRepository{

    public function login(array $credentials, $guard, bool $remember = false): mixed
    {
        return auth()->guard($guard)->attempt($credentials, $remember);
    }
}

