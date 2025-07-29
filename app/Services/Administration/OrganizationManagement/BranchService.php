<?php

namespace App\Services\Administration\OrganizationManagement;
use App\Models\Branch;

class BranchService
{
    public function getBranch()
    {
        return Branch::select('id', 'name', 'created_id', 'created_at', 'updated_at')->get();
    }
}
