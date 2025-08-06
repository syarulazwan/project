<?php

namespace App\Http\Controllers\Administration\Organization;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Administration\OrganizationManagement\CompanyService;
use App\Http\Requests\Administration\OrganizationManagement\Company\CompanyRequest;
use App\Http\Requests\Administration\OrganizationManagement\Company\UpdateCompanyRequest;

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
                'created_id' => get_user_creator($company->created_id ?? '-'),
                'created_at' => format_date($company->created_at),
                'updated_at' => format_date($company->updated_at),
                'action' => '   <button class="btn btn-sm btn-warning rounded-circle d-inline-flex justify-content-center align-items-center"
                                    style="width: 30px; height: 30px;" 
                                    title="Update"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#updateCompanyModal"
                                    data-id="' . $company->id . '" 
                                    data-name="' . $company->name . '"
                                    data-email="' . $company->email . '" 
                                    data-website="' . $company->website . '">
                                    <i class="fa fa-edit"></i>
                                </button>

                                <button class="btn btn-sm btn-danger rounded-circle d-inline-flex justify-content-center align-items-center btn-delete"
                                    style="width: 30px; height: 30px;" 
                                    title="Delete"
                                    data-id="' . $company->id . '" 
                                    data-name="' . $company->name . '">
                                    <i class="fa fa-trash"></i>
                                </button>
                            '
            ];
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function store(CompanyRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $company = $this->companyService->CreateCompany($data);

            DB::commit();
            flush_log();

            return response()->json(['message' => 'Company created successfully!'], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Company creation failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Company creation failed.',
                'error' => $e->getMessage()
            ], 500);

        }
    }

    public function updateCompany(UpdateCompanyRequest $request)
    {
        $data = $request->validated();
        $data['id'] = $request->input('id');

        DB::beginTransaction();

        try {
            $company = $this->companyService->UpdateCompany($data);

            DB::commit();
            flush_log();

            return response()->json(['message' => 'Company created successfully!'], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Company creation failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Company creation failed.',
                'error' => $e->getMessage()
            ], 500);

        }
    }

    public function deleteCompany($userId)
    {
        DB::beginTransaction();

        try {
            $this->companyService->deleteCompanyById($userId);

            DB::commit();
            flush_log();

            return response()->json(['message' => 'Company deleted successfully!'], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Company deletion failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Company deletion failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
