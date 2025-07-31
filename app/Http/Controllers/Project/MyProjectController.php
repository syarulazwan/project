<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyProjectController extends Controller
{
    public function index(){

        return view('pages/project/my-project/my-project');

    }
}
