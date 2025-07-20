<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ForgotPasswordService
{
   public function resetPassword(array $credentials): bool
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return false;
        }

        $user->password = Hash::make($credentials['password']);
        $user->save();

        return true;
    }
}
