<?php

namespace App\Http\Controllers\Administration\Access\Permission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Administration\Access\Menu\MenuService;
use App\Services\Administration\Access\Role\RoleService;
use App\Services\Administration\Access\Permission\PermissionService;

class PermissionController extends Controller
{
    public function __construct(
        PermissionService $permissionService,
        MenuService $menuService,
        RoleService $roleService
    ) {
        $this->permissionService = $permissionService;
        $this->menuService = $menuService;
        $this->roleService = $roleService;
    }

    public function index(){

        $data['roles'] = $this->roleService->getRole();
        
        // pr($data);
        return view('pages/administration/access-management/permission/permission', $data);

    }

    public function getPermissionAjax(Request $request)
    {
        $roleId = $request->get('role_id');
        $permissions = $this->permissionService->getPermissionsFilter($roleId);
        $menuTree = $this->menuService->getMenuTree();
        $grouped = [];
        $this->groupedFlattenMenuTree($menuTree, $grouped, $permissions, $roleId);

        $data = [];
        $counter = 1;
        foreach ($grouped as $row) {
            $row['no'] = $counter++;
            $data[] = $row;
        }

        return response()->json(['data' => $data]);
    }

    private function groupedFlattenMenuTree($tree, &$grouped, $permissions, $roleId, $level = 0)
    {
        foreach ($tree as $item) {
            $menu = $item['menu'];
            $menuId = $menu->id;
            $key = $roleId . '-' . $menuId;
            $perm = $permissions[$key] ?? null;

            // Tetapkan default value kalau permission tak ada
            $grouped[] = [
                'no' => 0,
                'name_menu' => str_repeat('— ', $level) . $menu->name,
                'is_menu' => '<input type="checkbox" ' . ($perm && $perm->is_menu ? 'checked' : '') . '>',
                'read_all' => '<input type="checkbox" ' . ($perm && $perm->read_all ? 'checked' : '') . '>',
                'read_single' => '<input type="checkbox" ' . ($perm && $perm->read_single ? 'checked' : '') . '>',
                'add' => '<input type="checkbox" ' . ($perm && $perm->add ? 'checked' : '') . '>',
                'edit' => '<input type="checkbox" ' . ($perm && $perm->edit ? 'checked' : '') . '>',
                'delete' => '<input type="checkbox" ' . ($perm && $perm->delete ? 'checked' : '') . '>',
                'action' => '<button class="btn btn-sm btn-primary rounded-circle d-inline-flex justify-content-center align-items-center"
                                style="width: 40px; height: 40px;" title="Lihat">
                                <i class="fa-solid fa-check"></i>
                            </button>',
            ];

            // Handle children
            if (!empty($item['children'])) {
                uasort($item['children'], fn($a, $b) => $a['menu']->priority <=> $b['menu']->priority);
                $this->groupedFlattenMenuTree($item['children'], $grouped, $permissions, $roleId, $level + 1);
            }
        }
    }

}
