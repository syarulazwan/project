<?php

namespace App\Http\Controllers\Administration\Organization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Administration\OrganizationManagement\CompanyService;

class CompanyController extends Controller
{
     public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index(){
        return view('pages/administration/organization-management/company/company');
    }

    public function getCompanyAjax()
    {
        $company = $this->companyService->getCompany();

        $data = [];
        $counter = 1;

        foreach ($company as $company) {
            $data[] = [
                'no' => $counter++,
                'name' => $company->name ?? '-',
                'email' => $company->email ?? '-',
                'website' => $company->website ?? '-',
                'created_id' => $company->created_id ?? '-',
                'created_at' => format_date($company->created_at),
                'updated_at' => format_date($company->updated_at),
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
