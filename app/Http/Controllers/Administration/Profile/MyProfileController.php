<?php

namespace App\Http\Controllers\Administration\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyProfileController extends Controller
{
    public function index(){

        return view('pages/profile/my-profile/my-profile');

    }
}
