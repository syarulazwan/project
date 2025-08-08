<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Menu;
use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Project;
use App\Models\Document;
use App\Models\Employee;
use App\Models\JobGrade;
use App\Models\AccessLog;
use App\Models\Department;
use App\Models\GeneralLog;
use App\Models\Permission;
use App\Models\ChatHistory;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {


        $apiKey = getenv('OPENAI_API_KEY');


        var_dump($apiKey);
        die();
        $data = [
            'profile' => Employee::count(),
            'request_access' => 0,
            'existing_access' => 0,
            'project' => Project::count(),
            'list_project' => Project::count(),
            'zara_chat' => ChatHistory::count(),
            'zara_upload' => Document::count(),
            'user' => User::count(),
            'company' => Company::count(),
            'branch' => Branch::count(),
            'department' => Department::count(),
            'unit' => Unit::count(),
            'job_grade' => JobGrade::count(),
            'designation' => Designation::count(),
            'role' => Role::count(),
            'menu' => Menu::count(),
            'permission' => Permission::count(),
            'access_log' => AccessLog::count(),
            'general_log' => GeneralLog::count(),
        ];

        return view('pages.dashboard.dashboard', $data);
    }
}
