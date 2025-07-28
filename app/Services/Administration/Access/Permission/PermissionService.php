<?php

namespace App\Services\Administration\Access\Permission;
use App\Models\Permission;

class PermissionService
{
   public function getPermissions() {

        return Permission::all()->keyBy(fn($p) => $p->role_id . '-' . $p->menu_id);
        
    }
}
