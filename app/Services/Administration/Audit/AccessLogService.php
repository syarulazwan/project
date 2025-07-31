<?php

namespace App\Services\Administration\Audit;
use App\Models\AccessLog;

class AccessLogService
{
    public function getAccessLog()
    {
        return AccessLog::select('*')->get();
    }

    
}
