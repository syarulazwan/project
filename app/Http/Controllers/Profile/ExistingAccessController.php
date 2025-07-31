<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExistingAccessController extends Controller
{
    public function index(){

        return view('pages/profile/existing-access/list-of-document');

    }
}
