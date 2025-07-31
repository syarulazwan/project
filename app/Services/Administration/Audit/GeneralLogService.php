<?php

namespace App\Services\Administration\Audit;
use App\Models\GeneralLog;

class GeneralLogService
{
    public function getGeneralLog()
    {
        return GeneralLog::select('*')->get();
    }

    
}
