<?php

namespace App\Http\Controllers\Administration\Organization;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Administration\OrganizationManagement\BranchService;
use App\Services\Administration\OrganizationManagement\CompanyService;
use App\Http\Requests\Administration\OrganizationManagement\Branch\AddBranchRequest;
use App\Http\Requests\Administration\OrganizationManagement\Branch\UpdateBranchRequest;

class BranchController extends Controller
{
    public function __construct(BranchService $branchService, CompanyService $companyService)
    {
        $this->branchService = $branchService;
        $this->companyService = $companyService;
    }

    public function index(){

        $data['company'] = $this->companyService->getCompany();

        return view('pages/administration/organization-management/branch/branch', $data);
    }

    public function getBranchAjax()
    {
        $branch = $this->branchService->getBranch();

        // pr($branch);

        $data = [];
        $counter = 1;

        foreach ($branch as $branch) {
            $data[] = [
                'no' => $counter++,
                'company' => $branch->company->name ?? '-',
                'branch' => $branch->name ?? '-',
                'created_id' => get_user_creator($branch->created_id ?? '-'),
                'created_at' => format_date($branch->created_at),
                'updated_at' => format_date($branch->updated_at),
                'action' => '   <button class="btn btn-sm btn-warning rounded-circle d-inline-flex justify-content-center align-items-center"
                                    style="width: 30px; height: 30px;" 
                                    title="Update"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#updateBranchModal"
                                    data-id="' . $branch->id . '" 
                                    data-company="' . $branch->company_id . '"
                                    data-branch="' . $branch->name . '">
                                    <i class="fa fa-edit"></i>
                                </button>

                                <button class="btn btn-sm btn-danger rounded-circle d-inline-flex justify-content-center align-items-center btn-delete"
                                    style="width: 30px; height: 30px;" 
                                    title="Delete"
                                    data-id="' . $branch->id . '" 
                                    data-name="' . $branch->name . '">
                                    <i class="fa fa-trash"></i>
                                </button>
                            '
            ];
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function store(AddBranchRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $branch = $this->branchService->CreateBranch($data);

            DB::commit();

            return response()->json(['message' => 'Branch created successfully!'], 200);

        } catch (\Exception $e) {

            DB::rollBack();
            flush_log();

            Log::error('Branch creation failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Branch creation failed.',
                'error' => $e->getMessage()
            ], 500);

        }
    }

    public function updateBranch(UpdateBranchRequest $request)
    {
        $data = $request->validated();
        $data['id'] = $request->input('id');

        DB::beginTransaction();

        try {
            $branch = $this->branchService->UpdateBranch($data);

            DB::commit();
            flush_log();

            return response()->json(['message' => 'Branch created successfully!'], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Branch creation failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Branch creation failed.',
                'error' => $e->getMessage()
            ], 500);

        }
    }

    public function deleteBranch($branchId)
    {
        DB::beginTransaction();

        try {
            $this->branchService->deleteBranchById($branchId);

            DB::commit();
            flush_log();

            return response()->json(['message' => 'Branch deleted successfully!'], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Branch deletion failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Branch deletion failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
