<?php

namespace App\Http\Controllers\Project;

use App\Services\ChatAI\DIDService;

use App\Http\Controllers\Controller;

class DIDController extends Controller
{
    public function getVideo(string $id)
    {
        $did = new DIDService();
        $url = $did->getVideoUrl($id);
        return response()->json(['url' => $url]);
    }
}
