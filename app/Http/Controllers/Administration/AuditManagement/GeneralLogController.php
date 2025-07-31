<?php

namespace App\Http\Controllers\Administration\AuditManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Administration\Audit\GeneralLogService;

class GeneralLogController extends Controller
{
    public function __construct(GeneralLogService $generalLogService)
    {
        $this->generalLogService = $generalLogService;
    }

    public function index(){
        return view('pages/administration/audit-management/general-log/general-log');
    }

    public function getGeneralLogAjax()
    {
        $generalLog = $this->generalLogService->getGeneralLog();

        $data = [];
        $counter = 1;

        foreach ($generalLog as $generalLog) {
            $data[] = [
                'no' => $counter++,
                'log_type' => $generalLog->log_type ?? '-',
                'model_type' => $generalLog->model_type ?? '-',
                'model_id' => $generalLog->model_id ?? '-',
                'before' => $generalLog->before ?? '-',
                'after' => $generalLog->after ?? '-',
                'ip_address' => $generalLog->ip_address ?? '-',
                'user_agent' => $generalLog->user_agent ?? '-',
                'user_id' => $generalLog->user_id ?? '-',
                'created_at' => format_date($generalLog->created_at ?? '-'),
                'updated_at' => format_date($generalLog->updated_at ?? '-'),
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
