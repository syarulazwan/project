<?php

namespace App\Http\Controllers\Administration\Profile;

use App\Models\Profile;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Profile\ProfileService;

class MyProfileController extends Controller
{
    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    
    public function index()
    {
        $userId = auth()->id();

        $data = [];

        $data['employee'] = Employee::where('user_id', $userId)->first();

        $data['profile'] = $data['employee']
            ? Profile::where('employee_id', $data['employee']->id)->first()
            : null;


        // pr($data);

        return view('pages/profile/my-profile/my-profile', $data);
    }

    public function updateProfile(Request $request)
    {


        $data['staff']          = $request->input('staff', []);
        $data['company']        = $request->input('company', []);
        $data['branch']        = $request->input('branch', []);
        $data['department']    = $request->input('department', []);
        $data['unit']          = $request->input('unit', []);
        $data['job_grade']     = $request->input('job_grade', []);
        $data['designation']   = $request->input('designation', []);
        $data['id']            = $request->input('id');

        DB::beginTransaction();

        try {
            $profile = $this->profileService->UpdateProfile($data);

            DB::commit();

            return response()->json(['message' => 'Profile created successfully!'], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Profile creation failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Profile creation failed.',
                'error' => $e->getMessage()
            ], 500);

        }
    }
}

