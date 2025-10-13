<?php
namespace App\Services\Auth;

use App\Repositories\Auth\AuthRepository;

class AuthService{
    protected $authRepository;
    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }
    public function login(array $credentials, $guard, bool $remember): mixed
    {
        return $this->authRepository->login($credentials, $guard, $remember);
    }

}
