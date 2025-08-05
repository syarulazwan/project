<?php

namespace App\Services\Administration\OrganizationManagement;
use App\Models\Unit;
use Illuminate\Support\Facades\Session;

class UnitService
{
    public function getUnit()
    {
        return Unit::select('id', 'name', 'created_id', 'created_at', 'updated_at')->get();
    }

    public function CreateUnit($data){

        $createdId = Session::get('role_id');

        $unit = Unit::create([
                    'name' => $data['name'],
                    'created_id' => $createdId,
                ]);


        return $unit;

    }

    public function UpdateUnit($data){

        $unit = Unit::find($data['id']);

        if (!$unit) {
            throw new \Exception('Unit not found.');
        }

        $unit->update([
            'name'     => $data['name_update'],
        ]);

        return $unit;

    }

    public function deleteUnitById($unitId)
    {

        $Unit = Unit::find($unitId);

        if (!$Unit) {
            throw new \Exception('Unit not found.');
        }

        $Unit->delete();

        return true;
    }


}
