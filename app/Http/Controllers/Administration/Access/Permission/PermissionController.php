<?php

namespace App\Http\Controllers\Administration\Access\Permission;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

            $grouped[] = [
                'no' => 0,
                'name_menu' => str_repeat('— ', $level) . $menu->name,
                'is_menu' => '<input type="checkbox" ' . ($perm && $perm->is_menu ? 'checked' : '') . '>',
                'read_all' => '<input type="checkbox" ' . ($perm && $perm->read_all ? 'checked' : '') . '>',
                'read_single' => '<input type="checkbox" ' . ($perm && $perm->read_single ? 'checked' : '') . '>',
                'add' => '<input type="checkbox" ' . ($perm && $perm->add ? 'checked' : '') . '>',
                'edit' => '<input type="checkbox" ' . ($perm && $perm->edit ? 'checked' : '') . '>',
                'delete' => '<input type="checkbox" ' . ($perm && $perm->delete ? 'checked' : '') . '>',
                'action' => '<button class="btn btn-sm btn-primary rounded-circle d-inline-flex justify-content-center align-items-center update-permission"
                                data-role_id="' . $roleId . '"
                                data-menu_id="' . $menuId . '"
                                style="width: 30px; height: 30px;" title="Update">
                                <i class="fa-solid fa-check"></i>
                            </button>',

            ];

            if (!empty($item['children'])) {
                uasort($item['children'], fn($a, $b) => $a['menu']->priority <=> $b['menu']->priority);
                $this->groupedFlattenMenuTree($item['children'], $grouped, $permissions, $roleId, $level + 1);
            }
        }
    }

    public function updatePermission(Request $request){

        $data['role_id'] = $request->input('role_id');
        $data['menu_id'] = $request->input('menu_id');
        $data['is_menu'] = $request->input('is_menu');
        $data['read_all'] = $request->input('read_all');
        $data['read_single'] = $request->input('read_single');
        $data['add'] = $request->input('add');
        $data['edit'] = $request->input('edit');
        $data['delete'] = $request->input('delete');


        DB::beginTransaction();

        try {

            $create = $this->permissionService->UpdatePermission($data);

            DB::commit();

            return response()->json(['message' => 'Role created successfully!'], 200);
            
        } catch (\Exception $e) {

            DB::rollback();

            Log::error('Role creation failed: ' . $e->getMessage());

            return response()->json([
                                        'message' => 'Role creation failed.',
                                        'error' => $e->getMessage()
                                    ], 500);
        }

    }

    public function updatePermissionBulk(Request $request)
    {
        $permissions = $request->input('permissions', []);

        DB::beginTransaction();

        try {
            foreach ($permissions as $perm) {
                $this->permissionService->UpdatePermission($perm);
            }

            DB::commit();

            return response()->json(['message' => 'All permissions updated successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bulk update error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Bulk update failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
