<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
     public function Logout(){
        $user = Auth::user(); 
        log_access('logout', $user->id);
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return Redirect()->route('home');
    }
}


