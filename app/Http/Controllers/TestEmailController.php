<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\PHPMailer\Mailer;
use Illuminate\Support\Facades\Mail;

class TestEmailController extends Controller
{
    // public function send()
    // {
    //     $subject = 'Ujian Emel Laravel';
    //     $body = "Hai Syarul Azwan,\n\nIni adalah ujian emel dari sistem Laravel.\n\nTerima kasih.";

    //     Mail::raw($body, function ($message) use ($subject) {
    //         $message->to('syarulazwan.sa@gmail.com')
    //                 ->subject($subject);
    //     });

    //     return 'Emel telah dihantar ke syarulazwan.sa@gmail.com';
    // }

     public function send()
    {
        $mailer = new Mailer();
        $result = $mailer->send(
            'syarulazwan.sa@gmail.com',
            'Ujian dari PHPMailer Class',
            '<b>Ini dari reusable Mailer class</b>'
        );

        return is_bool($result) && $result === true
            ? 'Berjaya hantar emel!'
            : 'Gagal hantar emel: ' . $result;
    }
}
