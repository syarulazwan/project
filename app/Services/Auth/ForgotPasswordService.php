<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ForgotPasswordService
{
    public function sendResetLink(array $credentials): bool
    {
        $status = Password::sendResetLink($credentials);

        return $status === Password::RESET_LINK_SENT;
    }
}
