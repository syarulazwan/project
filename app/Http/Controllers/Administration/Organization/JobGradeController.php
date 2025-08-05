<?php

namespace App\Http\Controllers\Administration\Organization;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Administration\OrganizationManagement\JobGradeService;
use App\Http\Requests\Administration\OrganizationManagement\JobGrade\AddJobGradeRequest;
use App\Http\Requests\Administration\OrganizationManagement\JobGrade\UpdateJobGradeRequest;

class JobGradeController extends Controller
{
    public function __construct(JobGradeService $jobGradeService)
    {
        $this->jobGradeService = $jobGradeService;
    }

    public function index(){
        return view('pages/administration/organization-management/job-grade/job-grade');
    }

    public function getJobGradeAjax()
    {
        $jobgrade = $this->jobGradeService->getJobgrade();

        $data = [];
        $counter = 1;

        foreach ($jobgrade as $jobgrade) {
            $data[] = [
                'no' => $counter++,
                'name' => $jobgrade->name ?? '-',
                'code' => $jobgrade->code ?? '-',
                'level' => $jobgrade->level ?? '-',
                'seniority' => $jobgrade->seniority ?? '-',
                'created_id' => get_user_creator($jobgrade->created_id ?? '-'),
                'created_at' => format_date($jobgrade->created_at),
                'updated_at' => format_date($jobgrade->updated_at),
                'action' => '   <button class="btn btn-sm btn-warning rounded-circle d-inline-flex justify-content-center align-items-center"
                                    style="width: 30px; height: 30px;" 
                                    title="Update"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#updateJobGradeModal"
                                    data-id="' . $jobgrade->id . '" 
                                    data-name="' . $jobgrade->name . '"
                                    data-code="' . $jobgrade->code . '" 
                                    data-level="' . $jobgrade->level . '"
                                    data-seniority="' . $jobgrade->seniority . '">
                                    <i class="fa fa-edit"></i>
                                </button>

                                <button class="btn btn-sm btn-danger rounded-circle d-inline-flex justify-content-center align-items-center btn-delete"
                                    style="width: 30px; height: 30px;" 
                                    title="Delete"
                                    data-id="' . $jobgrade->id . '" 
                                    data-name="' . $jobgrade->name . '">
                                    <i class="fa fa-trash"></i>
                                </button>
                            '
            ];
        }

        return response()->json([
            'data' => $data
        ]);
    }
    
    public function store(AddJobGradeRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $jobGrade = $this->jobGradeService->CreateJobGrade($data);

            DB::commit();

            return response()->json(['message' => 'Job Grade created successfully!'], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Job Grade creation failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Job Grade creation failed.',
                'error' => $e->getMessage()
            ], 500);

        }
    }

    public function updateJobGrade(UpdateJobGradeRequest $request)
    {
        $data = $request->validated();
        $data['id'] = $request->input('id');

        DB::beginTransaction();

        try {
            $jobGrade = $this->jobGradeService->UpdateJobGrade($data);

            DB::commit();

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

    public function deleteJobGrade($jobGradeID)
    {
        DB::beginTransaction();

        try {
            $this->jobGradeService->deleteJobGradeById($jobGradeID);

            DB::commit();

            return response()->json(['message' => 'Job Grade deleted successfully!'], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Job Grade deletion failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Job Grade deletion failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }




    
}
