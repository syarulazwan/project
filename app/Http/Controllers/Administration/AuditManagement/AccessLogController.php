<?php

namespace App\Http\Controllers\Administration\AuditManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Administration\Audit\AccessLogService;

class AccessLogController extends Controller
{
    public function __construct(AccessLogService $accessLogService)
    {
        $this->accessLogService = $accessLogService;
    }

    public function index(){
        return view('pages/administration/audit-management/access-log/access-log');
    }

    public function getAccessLogAjax()
    {
        $accessLog = $this->accessLogService->getAccessLog();

        $data = [];
        $counter = 1;

        foreach ($accessLog as $accessLog) {
            $data[] = [
                'no' => $counter++,
                'user_id' => $accessLog->user_id ?? '-',
                'role_id' => $accessLog->role_id ?? '-',
                'action_type' => $accessLog->action ?? '-',
                'ip_address' => $accessLog->ip_address ?? '-',
                'user_agent' => $accessLog->user_agent ?? '-',
                'login_at' => format_date($accessLog->login_at ?? '-'),
                'logout_at' => format_date($accessLog->logout_at ?? '-'),
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
