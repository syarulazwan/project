<?php

namespace App\Services\Profile;
use App\Models\Profile;
use App\Models\Employee;
use App\Models\UserRoleRequest;
use Illuminate\Support\Facades\Session;

class RequestAccessService
{

    public function GetRequestAccess(){
        $userId = auth()->id();

        return UserRoleRequest::select('user_role_requests.*', 'users.name as user_name', 'users.email')
            ->join('users', 'user_role_requests.user_id', '=', 'users.id')
            ->where('user_role_requests.user_id', $userId)
            ->get();
    }

    public function CreateRequestAccess($data)
    {

        $employee = Employee::where('user_id', $data['id'])->first();

        if (!$employee) {
            throw new \Exception("Employee dengan user_id {$data['id']} tidak ditemui.");
        }

        $roles = json_decode($data['roles'], true) ?? [];
        $customPermissions = json_decode($data['custom_permissions'], true) ?? [];

        foreach ($roles as $role) {
            $requestType = $role['requestType'] ?? 'existing';
            $roleId = $role['roleId'] ?? null;


            $customPermissionsJson = null;

            if ($requestType === 'custom' && isset($customPermissions[$roleId])) {
        
                $customPermissionsJson = json_encode($customPermissions[$roleId]);
            }

            $requestedRoleName = $requestType === 'custom' ? $employee->number_staf : null;

            UserRoleRequest::create([
                'user_id' => $data['id'],
                'request_type' => $requestType,
                'requested_role_id' => $requestType === 'existing' ? $roleId : null,
                'menu_ids' => $customPermissionsJson,  
                'requested_role_name' => $requestedRoleName,
                'status' => 'pending',
            ]);
        }

        return true;
    }

    public function deleteRequestAccessById($requestId){

        $requestAccess = UserRoleRequest::find($requestId);

        if (!$requestAccess) {
            throw new \Exception('Request Access not found.');
        }

        $requestAccess->delete();

        return true;

    }

    


}