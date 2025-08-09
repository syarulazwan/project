<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Project\Project\ProjectService;

class MyProjectController extends Controller
{
    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }
    
    public function index(){

        return view('pages/project/my-project/my-project');

    }

     public function getMYProjectAjax()
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
                'action' => '  
                                <button class="btn btn-sm btn-info rounded-circle d-inline-flex justify-content-center align-items-center me-1"
                                    style="width: 30px; height: 30px;"
                                    title="View"
                                    data-id="' . $project->id . '"
                                    onclick="window.location.href=\'' . route('project.my-project.show', $project->id) . '\'">
                                    <i class="fa fa-eye"></i>
                                </button>
                            '
            ];
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function show($id)
    {
         $listProjectController = new ListProjectController($this->projectService);
         return $listProjectController->show($id);
    }


}

