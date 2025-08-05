<?php

namespace App\Services\Administration\Access\Permission;
use App\Models\Permission;

class PermissionService
{
   public function getPermissions() {

        return Permission::all()->keyBy(fn($p) => $p->role_id . '-' . $p->menu_id);
        
    }

    public function getPermissionsFilter($roleId) {

        return Permission::where('role_id', $roleId)->get()->keyBy(fn($p) => $p->role_id . '-' . $p->menu_id);
        
    }

    public function UpdatePermission(array $data)
    {

        $permission = Permission::where('role_id', $data['role_id'])
                                ->where('menu_id', $data['menu_id'])
                                ->first();

        if ($permission) {

            $permission->update([
                'is_menu' => $data['is_menu'],
                'read_all' => $data['read_all'],
                'read_single' => $data['read_single'],
                'add' => $data['add'],
                'edit' => $data['edit'],
                'delete' => $data['delete'],
            ]);
        } else {

            $permission = Permission::create([
                'role_id' => $data['role_id'],
                'menu_id' => $data['menu_id'],
                'is_menu' => $data['is_menu'],
                'read_all' => $data['read_all'],
                'read_single' => $data['read_single'],
                'add' => $data['add'],
                'edit' => $data['edit'],
                'delete' => $data['delete'],
            ]);
        }

        return $permission;
    }

}
