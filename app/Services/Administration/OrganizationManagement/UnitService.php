<?php

namespace App\Services\Administration\OrganizationManagement;
use App\Models\Unit;

class UnitService
{
    public function getUnit()
    {
        return Unit::select('id', 'name', 'created_id', 'created_at', 'updated_at')->get();
    }
}
