<?php

namespace App\Services\Administration\OrganizationManagement;
use App\Models\Branch;
use Illuminate\Support\Facades\Session;

class BranchService
{
    public function getBranch()
    {
        return Branch::with('company')
            ->select('id', 'name', 'created_id', 'created_at', 'updated_at', 'company_id')
            ->get();
    }

    public function CreateBranch($data){

        $createdId = Session::get('role_id');

        $branch = Branch::create([
                    'company_id' => $data['company'],
                    'name' => $data['branch'],
                    'created_id' => $createdId,
                ]);


        return $branch;

    }

    public function UpdateBranch($data){


        $branch = Branch::find($data['id']);

        if (!$branch) {
            throw new \Exception('Branch not found.');
        }

        $branch->update([
            'company_id'     => $data['company_update'],
            'name'    => $data['branch_update'],
        ]);

        return $branch;

    }

    public function deleteBranchById($BranchID)
    {

        $branch = Branch::find($BranchID);

        if (!$branch) {
            throw new \Exception('Branch not found.');
        }

        $branch->delete();

        return true;
    }

    
}
