<?php

namespace App\Http\Controllers\Administration\Organization;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Administration\OrganizationManagement\DepartmentService;
use App\Http\Requests\Administration\OrganizationManagement\Department\AddDepartmentRequest;
use App\Http\Requests\Administration\OrganizationManagement\Department\UpdateDepartmentRequest;

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
                'created_id' => get_user_creator($department->created_id ?? '-'),
                'created_at' => format_date($department->created_at),
                'updated_at' => format_date($department->updated_at),
                'action' => '   <button class="btn btn-sm btn-warning rounded-circle d-inline-flex justify-content-center align-items-center"
                                    style="width: 30px; height: 30px;" 
                                    title="Update"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#updateDepartmentModal"
                                    data-id="' . $department->id . '" 
                                    data-name="' . $department->name . '">
                                    <i class="fa fa-edit"></i>
                                </button>

                                <button class="btn btn-sm btn-danger rounded-circle d-inline-flex justify-content-center align-items-center btn-delete"
                                    style="width: 30px; height: 30px;" 
                                    title="Delete"
                                    data-id="' . $department->id . '" 
                                    data-name="' . $department->name . '">
                                    <i class="fa fa-trash"></i>
                                </button>
                            '
            ];
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function store(AddDepartmentRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $department = $this->departmentService->CreateDepartment($data);

            DB::commit();

            return response()->json(['message' => 'Department created successfully!'], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Department creation failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Department creation failed.',
                'error' => $e->getMessage()
            ], 500);

        }
    }

    public function updateDepartment(UpdateDepartmentRequest $request)
    {
        $data = $request->validated();
        $data['id'] = $request->input('id');

        DB::beginTransaction();

        try {
            $department = $this->departmentService->UpdateDepartment($data);

            DB::commit();

            return response()->json(['message' => 'Department created successfully!'], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Department creation failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Department creation failed.',
                'error' => $e->getMessage()
            ], 500);

        }
    }

    public function deleteDepartment($userId)
    {
        DB::beginTransaction();

        try {
            $this->departmentService->deleteDepartmentById($userId);

            DB::commit();

            return response()->json(['message' => 'Department deleted successfully!'], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Department deletion failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Department deletion failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
