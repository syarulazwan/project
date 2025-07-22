<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TestEmailController extends Controller
{
    public function send()
    {
        $subject = 'Ujian Emel Laravel';
        $body = "Hai Syarul Azwan,\n\nIni adalah ujian emel dari sistem Laravel.\n\nTerima kasih.";

        Mail::raw($body, function ($message) use ($subject) {
            $message->to('syarulazwan.sa@gmail.com')
                    ->subject($subject);
        });

        return 'Emel telah dihantar ke syarulazwan.sa@gmail.com';
    }
}
