<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LoginService
{
    public function login(array $credentials): bool
    {
        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);

        if (Auth::attempt($credentials, $remember)) {
            session()->regenerate();

            $user = Auth::user();
            $roles = $user->roles()->pluck('name')->toArray();
            $roleId = $user->roles()->first()->id ?? null;

            session([
                'user_roles' => $roles,
                'main_role' => $roles[0] ?? null,
            ]);

            if ($roleId) {
                $allowedMenuIds = DB::table('permissions')
                    ->where('role_id', $roleId)
                    ->where('is_menu', 1)
                    ->pluck('menu_id')
                    ->toArray();

                session(['allowed_menu_ids' => $allowedMenuIds]);
            }

            log_access('login', $user->id);

            return true;
        }

        return false;
    }

}
