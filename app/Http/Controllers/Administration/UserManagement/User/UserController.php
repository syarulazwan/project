<?php

namespace App\Http\Controllers\Administration\UserManagement\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Administration\UserManagement\UserService;

class UserController extends Controller
{
    public function __construct(UserService $userService) {

        $this->userService = $userService;

    }
    public function index(){

        return view('pages/administration/user-management/user/user');

    }

    public function getUserAjax() {
        
        $user = $this->userService->getUser();

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
