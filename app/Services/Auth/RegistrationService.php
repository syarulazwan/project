<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistrationService
{
   public function register(array $credentials): ?string
    {
        $user = User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password']),
        ]);

        UserRole::create([
            'user_id' => $user->id,
            'role_id' => 2,
        ]);
                
        return $user;
    }
}
