<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Profile\RequestAccessService;

class RequestAccessController extends Controller
{
    public function __construct(RequestAccessService $requestAccessService)
    {
        $this->requestAccessService = $requestAccessService;
    }

    public function index(){

        return view('pages/profile/request-access/user');

    }

    public function getRequestAccessAjax()
    {
        $accessService = $this->requestAccessService->GetRequestAccess();

        $data = [];
        $counter = 1;

        foreach ($accessService as $accessService) {
            $data[] = [
                'no' => $counter++,
                'user_name' => $accessService->user_name ?? '-',
                'request_type' => $accessService->request_type ?? '-',
                'requested_role_name' => $accessService->requested_role_name ?? '-',
                'status' => $accessService->status ?? '-',
                'approved_by' => $accessService->approved_by ?? '-',
                'approved_at' => format_date($accessService->approved_at ?? '-'),
                'action' => '  
                                <button class="btn btn-sm btn-danger rounded-circle d-inline-flex justify-content-center align-items-center btn-delete"
                                    style="width: 30px; height: 30px;" 
                                    title="Delete"
                                    data-id="' . $accessService->id . '">
                                    <i class="fa fa-trash"></i>
                                </button>
                            '
            ];
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function getRequestAccessAppoverAjax()
    {
        $accessService = $this->requestAccessService->GetRequestApproverAccess();

        $data = [];
        $counter = 1;

        foreach ($accessService as $accessService) {
            $data[] = [
                'no' => $counter++,
                'user_name' => $accessService->user_name ?? '-',
                'request_type' => $accessService->request_type ?? '-',
                'requested_role_name' => $accessService->requested_role_name ?? '-',
                'status' => $accessService->status ?? '-',
                'approved_by' => $accessService->approved_by ?? '-',
                'approved_at' => format_date($accessService->approved_at ?? '-'),
                'action' => '  
                            '
            ];
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {


        $data['custom_permissions'] = $request->input('custom_permissions');
        $data['roles']        = $request->input('roles');
        $data['id']        = $request->input('user_id');



        DB::beginTransaction();

        try {
            $company = $this->requestAccessService->CreateRequestAccess($data);

            DB::commit();

            return response()->json(['message' => 'Request Access created successfully!'], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Request Access creation failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Request Access creation failed.',
                'error' => $e->getMessage()
            ], 500);

        }
    }

    public function deleteRequestAccess($userId)
    {
        DB::beginTransaction();

        try {
            $this->requestAccessService->deleteRequestAccessById($userId);

            DB::commit();

            return response()->json(['message' => 'Request Access deleted successfully!'], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Request Access deletion failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Request Access deletion failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
