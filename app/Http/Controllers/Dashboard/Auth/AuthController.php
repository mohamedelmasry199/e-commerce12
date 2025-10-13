<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\LoginRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class AuthController extends Controller implements HasMiddleware
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        // $this->middleware('guest')->except('logout');
    }
    public static function middleware(): array
    {
        return [
            new Middleware('guest:admin', except: ['logout']),
        ];
    }

    public function showLoginForm()
    {
        return view('dashboard.auth.login');
    }
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if ($this->authService->login($credentials, 'admin', $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard.index'));
        }
        return back()->withErrors([
            'email' => __('auth.The provided credentials do not match our records.'),
        ])->onlyInput('email');
    }
}
