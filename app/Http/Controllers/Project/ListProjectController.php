<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\AddProjectRequest;
use App\Services\Project\Project\ProjectService;
use App\Http\Requests\Project\UpdateProjectRequest;

class ListProjectController extends Controller
{
    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index(){

        return view('pages/project/list-project/list-project');

    }

    public function getProjectAjax()
    {
        $project = $this->projectService->getProject();

        $data = [];
        $counter = 1;

        foreach ($project as $project) {
            $data[] = [
                'no' => $counter++,
                'code' => $project->code ?? '-',
                'name' => $project->name ?? '-',
                'status' => $project->status ?? '-',
                'start_date' => format_date($project->start_date),
                'end_date' => format_date($project->end_date),
                'action' => '   <button class="btn btn-sm btn-warning rounded-circle d-inline-flex justify-content-center align-items-center"
                                    style="width: 30px; height: 30px;" 
                                    title="Update"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#updateProjectModal"
                                    data-id="' . $project->id . '" 
                                    data-code="' . $project->code . '"
                                    data-name="' . $project->name . '" 
                                    data-status="' . $project->status . '"
                                    data-start_date="' . $project->start_date . '"
                                    data-end_date="' . $project->end_date . '">
                                    <i class="fa fa-edit"></i>
                                </button>

                                <button class="btn btn-sm btn-danger rounded-circle d-inline-flex justify-content-center align-items-center btn-delete"
                                    style="width: 30px; height: 30px;" 
                                    title="Delete"
                                    data-id="' . $project->id . '" 
                                    data-name="' . $project->name . '">
                                    <i class="fa fa-trash"></i>
                                </button>
                            '
            ];
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function store(AddProjectRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $project = $this->projectService->CreateProject($data);

            DB::commit();
            flush_log();

            return response()->json(['message' => 'Project created successfully!'], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Project creation failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Project creation failed.',
                'error' => $e->getMessage()
            ], 500);

        }
    }

    public function updateProject(UpdateProjectRequest $request)
    {
        $data = $request->validated();
        $data['id'] = $request->input('id');

        DB::beginTransaction();

        try {
            $project = $this->projectService->UpdateProject($data);

            DB::commit();
            flush_log();

            return response()->json(['message' => 'Project update successfully!'], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Project update failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Project update failed.',
                'error' => $e->getMessage()
            ], 500);

        }
    }

    public function deleteProject($userId)
    {
        DB::beginTransaction();

        try {
            $this->projectService->deleteProjectById($userId);

            DB::commit();
            flush_log();

            return response()->json(['message' => 'Project deleted successfully!'], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Project deletion failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Project deletion failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
