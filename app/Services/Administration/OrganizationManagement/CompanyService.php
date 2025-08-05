<?php

namespace App\Services\Administration\OrganizationManagement;
use App\Models\Company;
use Illuminate\Support\Facades\Session;

class CompanyService
{
    public function getCompany()
    {
        return Company::select('id', 'name', 'email', 'website', 'created_id' ,'created_at', 'updated_at')->get();
    }

    public function CreateCompany($data){

        $createdId = Session::get('role_id');

        $company = Company::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'website' => $data['website'],
                    'created_id' => $createdId,
                ]);


        return $company;

    }

    public function UpdateCompany($data){


        $company = Company::find($data['id']);

        if (!$company) {
            throw new \Exception('Company not found.');
        }

        $company->update([
            'name'     => $data['name_update'],
            'email'    => $data['email_update'],
            'website'   => $data['website_update'],
        ]);

        return $company;

    }

    public function deleteCompanyById($companyId)
    {

        $company = Company::find($companyId);

        if (!$company) {
            throw new \Exception('Company not found.');
        }

        $company->delete();

        return true;
    }

}
