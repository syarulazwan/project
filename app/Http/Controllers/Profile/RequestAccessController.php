<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequestAccessController extends Controller
{
    public function index(){

        return view('pages/profile/request-access/user');

    }
}
