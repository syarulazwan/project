<?php

namespace App\Services\Administration\OrganizationManagement;
use App\Models\Company;

class CompanyService
{
    public function getCompany()
    {
        return Company::select('id', 'name', 'email', 'website', 'created_id' ,'created_at', 'updated_at')->get();
    }
}
