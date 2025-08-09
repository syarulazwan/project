<?php

namespace App\Services\Project\Project;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\ProjectLocation;
use Illuminate\Support\Facades\Session;

class ProjectService
{
    public function getProject()
    {
        return Project::select('*')->get();
    }

    public function CreateProject($data){

        $createdId = Session::get('role_id');

        $project = Project::create([
                    'code' => $data['code'],
                    'name' => $data['name'],
                    'status' => $data['status'],
                    'start_date' => $data['start_date'],
                    'end_date' => $data['end_date'],
                    'created_id' => $createdId,
                ]);


        return $project;

    }

    public function UpdateProject($data){


        $project = Project::find($data['id']);

        if (!$project) {
            throw new \Exception('Project not found.');
        }

        $project->update([
            'code' => $data['code_update'],
            'name' => $data['name_update'],
            'status' => $data['status_update'],
            'start_date' => $data['start_date_update'],
            'end_date' => $data['end_date_update'],
        ]);

        return $project;

    }

    public function deleteProjectById($projectId)
    {

        $project = Project::find($projectId);

        if (!$project) {
            throw new \Exception('Project not found.');
        }

        $project->delete();

        return true;
    }

    public function getSingleProject($id){

         return Project::where('id', $id)->first();

    }

    public function getProjectMember($projectId){

        return ProjectMember::where('project_id', $projectId)->get();
        
    }

    public function getProjectLocation($projectId){

        return ProjectLocation::where('project_id', $projectId)->get();

    }

}