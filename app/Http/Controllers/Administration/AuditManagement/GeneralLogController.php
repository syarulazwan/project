<?php

namespace App\Http\Controllers\Administration\AuditManagement;

use Illuminate\Support\Str;
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
        $generalLogs = $this->generalLogService->getGeneralLog(); // pastikan eager load user kalau guna

        $data = [];
        $counter = 1;

        foreach ($generalLogs as $log) {
            $data[] = [
                'no' => $counter++,
                'log_type' => $log->log_type ?? '-',
                'table' => $log->table ?? '-',
                'after' => '<button class="btn btn-sm btn-info rounded-circle d-inline-flex justify-content-center align-items-center view-after-btn"
                                style="width: 30px; height: 30px;"
                                title="Lihat perubahan selepas"
                                data-after="' . e(json_encode(json_decode($log->after), JSON_PRETTY_PRINT)) . '">
                                <i class="fa fa-eye"></i>
                            </button>',
                'user_id' => optional($log->user)->name ?? $log->user_id ?? '-',
                'ip_address' => $log->ip_address ?? '-',
                'user_agent' => Str::limit($log->user_agent, 30), // pendekkan
                'created_at' => $log->created_at->format('d-m-Y H:i:s'),
            ];
        }

        return response()->json([
            'data' => $data
        ]);
    }

}
