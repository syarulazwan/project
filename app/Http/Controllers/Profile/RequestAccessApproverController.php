<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequestAccessApproverController extends Controller
{
    public function index(){

        return view('pages/profile/request-access/approver');

    }
}
