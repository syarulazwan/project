<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Models\Employee;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistrationService
{
   public function register(array $credentials): ?string
    {
        $user = User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password']),
            'status' => 'ACTIVE',
        ]);

        UserRole::create([
            'user_id' => $user->id,
            'role_id' => 2,
            'created_id' => $user->id,
        ]);

        $numberStaf = 'STAFF' . str_pad($user->id, 4, '0', STR_PAD_LEFT);

        Employee::create([
            'user_id' => $user->id,
            'company_id' => null, 
            'branch_id' => null,
            'department_id' => null,
            'unit_id' => null,
            'job_grade_id' => null,
            'designation_id' => null,
            'number_staf' => $numberStaf,
            'resign_date' => null,
            'employment_status' => 'active',
            'employment_type' => null,
            'created_id' => $user->id,
        ]);
                
        return $user;
    }
}
