<?php

namespace App\Http\Controllers\Administration\Access\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SwitchRoleController extends Controller
{
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function switch(Request $request)
    {
        $role = $request->role;

        if (in_array($role, session('user_roles', []))) {
            session(['main_role' => $role]);

            $roleId = $this->roleService->getRoleIdByName($role);

            if ($roleId) {
                $allowedMenuIds = $this->roleService->getAllowedMenuIdsByRoleId($roleId);
                session(['allowed_menu_ids' => $allowedMenuIds]);
            }

            return response()->json([
                'status' => 'ok',
                'redirect' => route('dashboard'), // or any role-based route
            ]);
        }

        return response()->json(['status' => 'fail'], 403);
    }
}
