<?php

namespace App\Http\Controllers\Administration\Orgnization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Administration\OrganizationManagement\DepartmentService;

class DepartmentController extends Controller
{
    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function index(){
        return view('pages/administration/organization-management/department/department');
    }

    public function getDepartmentAjax()
    {
        $department = $this->departmentService->getDepartment();

        $data = [];
        $counter = 1;

        foreach ($department as $department) {
            $data[] = [
                'no' => $counter++,
                'name' => $department->name ?? '-',
                'created_at' => format_date($department->created_at),
                'updated_at' => format_date($department->updated_at),
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
