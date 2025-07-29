<?php

namespace App\Services\Administration\OrganizationManagement;
use App\Models\Department;

class DepartmentService
{
    public function getDepartment()
    {
        return Department::select('id', 'name', 'created_id', 'created_at', 'updated_at')->get();
    }
}
