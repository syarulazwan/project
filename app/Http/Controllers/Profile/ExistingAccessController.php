<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExistingAccessController extends Controller
{
    public function index(){

        return view('pages/profile/existing-access/list-of-document');

    }

    public function getUserRoleAjax()
    {
        $userId = auth()->id();  
        
        $userRoles = \DB::table('user_roles')
            ->join('roles', 'user_roles.role_id', '=', 'roles.id')
            ->where('user_roles.user_id', $userId)
            ->select('user_roles.*', 'roles.name as role_name')
            ->get();

        $data = [];
        $counter = 1;

        foreach ($userRoles as $userRole) {
            $data[] = [
                'no' => $counter++,
                'role_name' => $userRole->role_name ?? '-',
                'created_id' => get_user_creator($userRole->created_id ?? '-'),
                'created_at' => format_date($userRole->created_at),
                'updated_at' => format_date($userRole->updated_at),
            ];
        }

        return response()->json([
            'data' => $data
        ]);
    }

}
