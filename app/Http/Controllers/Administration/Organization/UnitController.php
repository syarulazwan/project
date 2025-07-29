<?php

namespace App\Http\Controllers\Administration\Organization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Administration\OrganizationManagement\UnitService;

class UnitController extends Controller
{
    public function __construct(UnitService $unitService)
    {
        $this->unitService = $unitService;
    }

    public function index(){
        return view('pages/administration/organization-management/unit/unit');
    }

    public function getUnitAjax()
    {
        $unit = $this->unitService->getUnit();

        $data = [];
        $counter = 1;

        foreach ($unit as $unit) {
            $data[] = [
                'no' => $counter++,
                'name' => $unit->name ?? '-',
                'created_id' => $unit->created_id ?? '-',
                'created_at' => format_date($unit->created_at),
                'updated_at' => format_date($unit->updated_at),
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
