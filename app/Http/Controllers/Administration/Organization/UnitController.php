<?php

namespace App\Http\Controllers\Administration\Organization;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Administration\OrganizationManagement\UnitService;
use App\Http\Requests\Administration\OrganizationManagement\Unit\AddUnitRequest;
use App\Http\Requests\Administration\OrganizationManagement\Unit\UpdateUnitRequest;

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
                'created_id' => get_user_creator($unit->created_id ?? '-'),
                'created_at' => format_date($unit->created_at),
                'updated_at' => format_date($unit->updated_at),
                'action' => '   <button class="btn btn-sm btn-warning rounded-circle d-inline-flex justify-content-center align-items-center"
                                    style="width: 30px; height: 30px;" 
                                    title="Update"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#updateUnitModal"
                                    data-id="' . $unit->id . '" 
                                    data-name="' . $unit->name . '">
                                    <i class="fa fa-edit"></i>
                                </button>

                                <button class="btn btn-sm btn-danger rounded-circle d-inline-flex justify-content-center align-items-center btn-delete"
                                    style="width: 30px; height: 30px;" 
                                    title="Delete"
                                    data-id="' . $unit->id . '" 
                                    data-name="' . $unit->name . '">
                                    <i class="fa fa-trash"></i>
                                </button>
                            '
            ];
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function store(AddUnitRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $unit = $this->unitService->CreateUnit($data);

            DB::commit();

            return response()->json(['message' => 'Unit created successfully!'], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Unit creation failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Unit creation failed.',
                'error' => $e->getMessage()
            ], 500);

        }
    }

    public function updateUnit(UpdateUnitRequest $request)
    {
        $data = $request->validated();
        $data['id'] = $request->input('id');

        DB::beginTransaction();

        try {
            $unit = $this->unitService->UpdateUnit($data);

            DB::commit();

            return response()->json(['message' => 'Unit created successfully!'], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Unit creation failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Unit creation failed.',
                'error' => $e->getMessage()
            ], 500);

        }
    }

    public function deleteUnit($unit)
    {
        DB::beginTransaction();

        try {
            $this->unitService->deleteUnitById($unit);

            DB::commit();

            return response()->json(['message' => 'Unit deleted successfully!'], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Unit deletion failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Unit deletion failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
