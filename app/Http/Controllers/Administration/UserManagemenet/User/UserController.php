<?php

namespace App\Http\Controllers\Administration\UserManagemenet\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return view('pages/administration/user-management/user/user');
    }
}
