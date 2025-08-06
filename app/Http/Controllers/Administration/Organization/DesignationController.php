<?php

namespace App\Http\Controllers\Administration\Organization;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Administration\OrganizationManagement\DesignationService;
use App\Http\Requests\Administration\OrganizationManagement\Designation\AddDesignationRequest;
use App\Http\Requests\Administration\OrganizationManagement\Designation\UpdateDesignationRequest;

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
                'created_id' => get_user_creator($designation->created_id ?? '-'),
                'created_at' => format_date($designation->created_at),
                'updated_at' => format_date($designation->updated_at),
                'action' => '   <button class="btn btn-sm btn-warning rounded-circle d-inline-flex justify-content-center align-items-center"
                                    style="width: 30px; height: 30px;" 
                                    title="Update"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#updateDesignationModal"
                                    data-id="' . $designation->id . '" 
                                    data-name="' . $designation->name . '">
                                    <i class="fa fa-edit"></i>
                                </button>

                                <button class="btn btn-sm btn-danger rounded-circle d-inline-flex justify-content-center align-items-center btn-delete"
                                    style="width: 30px; height: 30px;" 
                                    title="Delete"
                                    data-id="' . $designation->id . '" 
                                    data-name="' . $designation->name . '">
                                    <i class="fa fa-trash"></i>
                                </button>
                            '
            ];
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function store(AddDesignationRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $designation = $this->designationService->CreateDesignation($data);

            DB::commit();
            flush_log();

            return response()->json(['message' => 'Designation created successfully!'], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Designation creation failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Designation creation failed.',
                'error' => $e->getMessage()
            ], 500);

        }
    }

    public function updateDesignation(UpdateDesignationRequest $request)
    {
        $data = $request->validated();
        $data['id'] = $request->input('id');

        DB::beginTransaction();

        try {
            $designation = $this->designationService->UpdateDesignation($data);

            DB::commit();
            flush_log();

            return response()->json(['message' => 'Designation created successfully!'], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Designtion creation failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Designtion creation failed.',
                'error' => $e->getMessage()
            ], 500);

        }
    }

    public function deleteDesignation($userId)
    {
        DB::beginTransaction();

        try {
            $this->designationService->deleteDesignationById($userId);

            DB::commit();
            flush_log();

            return response()->json(['message' => 'Designation deleted successfully!'], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Designation deletion failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Designation deletion failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
