<?php

namespace App\Services\Administration\OrganizationManagement;
use App\Models\JobGrade;

class JobGradeService
{
    public function getJobGrade()
    {
        return JobGrade::select('id', 'name', 'code', 'level', 'seniority', 'created_id', 'created_at', 'updated_at')->get();
    }
}
