<?php

namespace App\Services\Profile;
use App\Models\Profile;
use App\Models\Employee;
use Illuminate\Support\Facades\Session;

class ProfileService
{
    public function getProfile()
    {
        return Profile::select('*')->get();
    }

    public function UpdateProfile($data)
    {

        $employee = Employee::where('user_id', $data['id'])->first();
        if (!$employee) {
            throw new \Exception("Employee not found");
        }

        $employee->update([
            'company_id'        => $data['company']['company_id'] ?? null,
            'branch_id'         => $data['branch']['branch_id'] ?? null,
            'department_id'     => $data['department']['department_id'] ?? null,
            'unit_id'           => $data['unit']['unit_id'] ?? null,
            'job_grade_id'      => $data['job_grade']['job_grade_id'] ?? null,
            'designation_id'    => $data['designation']['designation_id'] ?? null,

            'joined_date'       => $data['staff']['join_date'] ?? null,
            'effective_date'    => $data['staff']['effective_date'] ?? null,
            'resign_date'       => $data['staff']['resign_date'] ?? null,
            'employment_type'   => $data['staff']['staff_type'] ?? null,
            'employment_status' => $data['staff']['status'] ?? null,
        ]);

        $profile = Profile::where('employee_id', $employee->id)->first();
        if (!$profile) {
            throw new \Exception("Profile not found");
        }

        $profile->update([
            'full_name'     => $data['staff']['full_name'] ?? null,
            'ic_no'         => $data['staff']['ic_number'] ?? null,
            'date_of_birth' => $data['staff']['birthday'] ?? null,
            'gender'        => $data['staff']['gender'] ?? null,
            'phone_no'      => $data['staff']['phone'] ?? null,
            'email'         => $data['staff']['email'] ?? null,
            'address'       => $data['staff']['address'] ?? null,
        ]);

        return $profile;
    }




}