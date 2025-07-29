<?php

namespace App\Http\Controllers\Administration\Organization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Administration\OrganizationManagement\BranchService;

class BranchController extends Controller
{
    public function __construct(BranchService $branchService)
    {
        $this->branchService = $branchService;
    }

    public function index(){
        return view('pages/administration/organization-management/branch/branch');
    }

    public function getBranchAjax()
    {
        $branch = $this->branchService->getBranch();

        $data = [];
        $counter = 1;

        foreach ($branch as $branch) {
            $data[] = [
                'no' => $counter++,
                'name' => $branch->name ?? '-',
                'created_id' => $branch->created_id ?? '-',
                'created_at' => format_date($branch->created_at),
                'updated_at' => format_date($branch->updated_at),
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
