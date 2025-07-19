<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Auth;

class LoginService
{
    public function login(array $credentials): ?string
    {
        $remember = $credentials['remember'] ?? false;

        unset($credentials['remember']);

        if (Auth::attempt($credentials, $remember)) {
            session()->regenerate();
            return csrf_token(); // Untuk frontend atau testing
        }

        return null;
    }
}
