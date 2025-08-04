<?php

namespace App\Services\Administration\Access\Role;
use App\Models\Role;
use Illuminate\Support\Facades\Session;

class RoleService
{
    public function getRole()
    {
        return Role::select('id', 'name', 'created_id', 'created_at', 'updated_at')->get();
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

    public function CreateRole($data){

        $createdId = Session::get('role_id');

        $role = Role::create([
                    'name' => $data['name'],
                    'created_id' => $createdId,
                ]);

        return $role;
    }

}
