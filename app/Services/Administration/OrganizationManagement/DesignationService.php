<?php

namespace App\Services\Administration\OrganizationManagement;
use App\Models\Designation;

class DesignationService
{
    public function getDesignation()
    {
        return Designation::select('id', 'name', 'created_id','created_at', 'updated_at')->get();
    }
}
