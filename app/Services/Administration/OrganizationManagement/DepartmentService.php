<?php

namespace App\Services\Administration\OrganizationManagement;
use App\Models\Department;
use Illuminate\Support\Facades\Session;

class DepartmentService
{
    public function getDepartment()
    {
        return Department::select('id', 'name', 'created_id', 'created_at', 'updated_at')->get();
    }

    public function CreateDepartment($data){

        $createdId = Session::get('role_id');

        $department = Department::create([
                    'name' => $data['name'],
                    'created_id' => $createdId,
                ]);


        return $department;

    }

    public function UpdateDepartment($data){


        $department = Department::find($data['id']);

        if (!$department) {
            throw new \Exception('Department not found.');
        }

        $department->update([
            'name'     => $data['name_update'],
        ]);

        return $department;

    }

    public function deleteDepartmentById($departmentId)
    {

        $department = Department::find($departmentId);

        if (!$department) {
            throw new \Exception('Department not found.');
        }

        $department->delete();

        return true;
    }
}
