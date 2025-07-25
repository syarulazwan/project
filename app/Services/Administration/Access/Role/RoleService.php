<?php

namespace App\Services\Administration\Access\Role;
use App\Models\Role;

class RoleService
{
    public function getRole()
    {
        return Role::select('id', 'name')->get();
    }

    public function getRoleIdByName(string $roleName): ?int
    {
        return Role::where('name', $roleName)->value('id');
    }

    public function getAllowedMenuIdsByRoleId(int $roleId): array
    {
        return Role::with('permissions')
            ->find($roleId)?->permissions
            ->where('is_menu', 1)
            ->pluck('menu_id')
            ->toArray() ?? [];
    }

    public function getRoleNameMap() {

        return Role::pluck('name', 'id');
        
    }

}
