<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\PHPMailer\Mailer;
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

    //  public function send()
    // {
    //    $tests = [
    //         ['host' => 'mail.zanko.com.my', 'port' => 587],
    //         ['host' => 'mail.zanko.com.my', 'port' => 465],
    //         ['host' => 'mail.zanko.com.my', 'port' => 25],
    //         ['host' => 'smtp.gmail.com', 'port' => 587],
    //     ];

    //     $output = '';
    //     foreach ($tests as $test) {
    //         $output .= "⏳ Testing {$test['host']}:{$test['port']}...<br>";
    //         $conn = @fsockopen($test['host'], $test['port'], $errno, $errstr, 10);
    //         if ($conn) {
    //             $output .= "✅ Connected to {$test['host']}:{$test['port']}<br><br>";
    //             fclose($conn);
    //         } else {
    //             $output .= "❌ FAILED to connect: ($errno) $errstr<br><br>";
    //         }
    //     }

    //     return response($output);
    // }
}
