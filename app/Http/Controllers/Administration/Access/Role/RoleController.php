<?php

namespace App\Http\Controllers\Administration\Access\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Administration\Access\Role\RoleService;
use App\Http\Requests\Administration\Access\Role\RoleRequest;
use App\Http\Requests\Administration\Access\Menu\UpdateRoleRequest;

class RoleController extends Controller
{
    public function __construct(RoleService $roleService) {

        $this->roleService = $roleService;

    }
    public function index(){

        return view('pages/administration/access-management/role/role');

    }

    public function getRoleAjax() {
        
        $role = $this->roleService->getRole();

        $data = [];
        $counter = 1;

        foreach ($role as $role) {

            $data[] = [
                'no' => $counter++,
                'name' => $role->name ?? '-',
                'created_id' => get_user_creator($role->created_id ?? null),
                'created_at' => format_date($role->created_at ?? '-'),
                'updated_at' => format_date($role->updated_at ?? '-'),
                'action' => '   <button class="btn btn-sm btn-warning rounded-circle d-inline-flex justify-content-center align-items-center"
                                    style="width: 30px; height: 30px;" 
                                    title="Update"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#updateRoleModal"
                                    data-id="' . $role->id . '" 
                                    data-name="' . $role->name . '">
                                    <i class="fa fa-edit"></i>
                                </button>

                                <button class="btn btn-sm btn-danger rounded-circle d-inline-flex justify-content-center align-items-center btn-delete"
                                    style="width: 30px; height: 30px;" 
                                    title="Delete"
                                    data-id="' . $role->id . '">
                                    <i class="fa fa-trash"></i>
                                </button>
                            '
            ];

        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function store(RoleRequest $request){

        $data = $request->validated();

        DB::beginTransaction();

        try {

            $create = $this->roleService->CreateRole($data);

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

    public function updateRole(UpdateRoleRequest $request){

        $data = $request->validated();
        $data['id'] = $request->input('id');

        DB::beginTransaction();

        try {

            $create = $this->roleService->UpdateRole($data);

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

    public function deleteRole($userId)
    {
        DB::beginTransaction();

        try {
            $this->roleService->deleteRoleById($userId);

            DB::commit();

            return response()->json(['message' => 'User deleted successfully!'], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('User deletion failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'User deletion failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
