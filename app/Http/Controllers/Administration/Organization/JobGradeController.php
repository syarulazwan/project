<?php

namespace App\Http\Controllers\Administration\Organization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Administration\OrganizationManagement\JobGradeService;

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
                'created_id' => $jobgrade->created_id ?? '-',
                'created_at' => format_date($jobgrade->created_at),
                'updated_at' => format_date($jobgrade->updated_at),
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
