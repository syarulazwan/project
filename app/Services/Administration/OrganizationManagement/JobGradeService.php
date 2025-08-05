<?php

namespace App\Services\Administration\OrganizationManagement;
use App\Models\JobGrade;
use Illuminate\Support\Facades\Session;

class JobGradeService
{
    public function getJobGrade()
    {
        return JobGrade::select('id', 'name', 'code', 'level', 'seniority', 'created_id', 'created_at', 'updated_at')->get();
    }

    public function CreateJobGrade($data){

        $createdId = Session::get('role_id');

        $jobGrade = JobGrade::create([
                    'name' => $data['name'],
                    'code' => $data['code'],
                    'level' => $data['level'],
                    'seniority' => $data['seniority'],
                    'created_id' => $createdId,
                ]);


        return $jobGrade;

    }

    public function UpdateJobGrade($data){


        $jobGrade = JobGrade::find($data['id']);

        if (!$jobGrade) {
            throw new \Exception('Job Grade not found.');
        }

        $jobGrade->update([
            'name'     => $data['name_update'],
            'code'    => $data['code_update'],
            'level'   => $data['level_update'],
            'seniority'   => $data['seniority_update'],
        ]);

        return $jobGrade;

    }

    public function deleteJobGradeById($jobGradeId)
    {

        $jobGrade = JobGrade::find($jobGradeId);

        if (!$jobGrade) {
            throw new \Exception('Job Grade not found.');
        }

        $jobGrade->delete();

        return true;
    }
}
