<?php

namespace App\Http\Controllers\Administration\Organization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Administration\OrganizationManagement\DesignationService;

class DesignationController extends Controller
{
    public function __construct(DesignationService $designationService)
    {
        $this->designationService = $designationService;
    }

    public function index(){
        return view('pages/administration/organization-management/designation/designation');
    }

    public function getDesignationAjax()
    {
        $designation = $this->designationService->getDesignation();

        $data = [];
        $counter = 1;

        foreach ($designation as $designation) {
            $data[] = [
                'no' => $counter++,
                'name' => $designation->name ?? '-',
                'created_id' => $designation->created_id ?? '-',
                'created_at' => format_date($designation->created_at),
                'updated_at' => format_date($designation->updated_at),
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
