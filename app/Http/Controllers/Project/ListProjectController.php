<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ListProjectController extends Controller
{
    public function index(){

        return view('pages/project/list-project/list-project');

    }
}
