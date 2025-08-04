<?php

namespace App\Http\Controllers\Administration\UserManagement\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\Administration\Access\Role\RoleService;
use App\Services\Administration\UserManagement\UserService;

class UserController extends Controller
{
    public function __construct(UserService $userService, RoleService $roleService) {

        $this->userService = $userService;
        $this->roleService = $roleService;

    }
    public function index(){

        return view('pages/administration/user-management/user/user');

    }

    public function getUserAjax(Request $request) {
        
        $data = $request->only(['name', 'email', 'status']);
        $user = $this->userService->getUserFilter($data);

        $data = [];
        $counter = 1;

        foreach ($user as $user) {

            $data[] = [
                'no' => $counter++,
                'name' => $user->name ?? '-',
                'email' => $user->email ?? '-',
                'status' => $user->status ?? '-',
                'created_id' => $user->created_id ?? '-',
                'created_at' => format_date($user->created_at ?? '-'),
                'updated_at' => format_date($user->updated_at ?? '-'),
                'action' => '<button class="btn btn-sm btn-primary rounded-circle d-inline-flex justify-content-center align-items-center"
                                style="width: 40px; height: 40px;" 
                                title="Lihat"
                                data-bs-toggle="modal" 
                                data-bs-target="#exampleModalScrollable3"
                                data-id="' . $user->id . '" 
                                data-name="' . $user->name . '">
                                <i class="fa fa-id-badge"></i>
                            </button>',
            ];

        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function getRoleUserAjax()
    {
        $roles = DB::table('roles')->select('id', 'name')->get();
        return response()->json($roles);
    }

    public function getUserRoles($userId)
    {
        // pr($userId);
        $roles = DB::table('user_roles')
            ->join('roles', 'user_roles.role_id', '=', 'roles.id')
            ->where('user_roles.user_id', $userId)
            ->select('roles.id', 'roles.name')
            ->get();

        // pr($roles);

        return response()->json($roles);
    }

    public function assignRoles(Request $request)
    {
        // pr($request);
        $userId = $request->input('user_id');
        $roles = $request->input('roles'); // array of role IDs

        DB::beginTransaction();
        try {
            DB::table('user_roles')->where('user_id', $userId)->delete();

            foreach ($roles as $roleId) {
                DB::table('user_roles')->insert([
                    'user_id' => $userId,
                    'role_id' => $roleId,
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Roles assigned successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to assign roles'], 500);
        }
    }

    
}
