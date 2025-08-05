<?php

namespace App\Services\Administration\OrganizationManagement;
use App\Models\Designation;
use Illuminate\Support\Facades\Session;

class DesignationService
{
    public function getDesignation()
    {
        return Designation::select('id', 'name', 'created_id','created_at', 'updated_at')->get();
    }

    public function CreateDesignation($data){

        $createdId = Session::get('role_id');

        $designation = Designation::create([
                    'name' => $data['name'],
                    'created_id' => $createdId,
                ]);

        return $designation;

    }

    public function UpdateDesignation($data){


        $designation = Designation::find($data['id']);

        if (!$designation) {
            throw new \Exception('Designation not found.');
        }

        $designation->update([
            'name'     => $data['name_update'],
        ]);

        return $designation;

    }

    public function deleteDesignationById($designationID)
    {

        $designation = Designation::find($designationID);

        if (!$designation) {
            throw new \Exception('Company not found.');
        }

        $designation->delete();

        return true;
    }
}
