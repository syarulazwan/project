<?php

namespace App\Http\Controllers\Administration\Access\Role;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Administration\Access\Role\RoleService;

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
                'created_id' => $role->created_id ?? '-',
                'created_at' => format_date($role->created_at ?? '-'),
                'updated_at' => format_date($role->updated_at ?? '-'),
                'action' => '<button class="btn btn-sm btn-primary rounded-circle d-inline-flex justify-content-center align-items-center"
                                    style="width: 40px; height: 40px;" title="Lihat">
                                    <i class="fa fa-eye"></i>
                            </button>',
            ];

        }

        return response()->json([
            'data' => $data
        ]);
    }
}
