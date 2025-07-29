<?php

namespace App\Services\ChatAI;


use Illuminate\Support\Facades\Http;

class DIDService
{
    public function generateVideo(string $text): ?string
    {
        $apiKey = env('DID_API_KEY');

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($apiKey . ':'),
            'Content-Type' => 'application/json',
        ])->post('https://api.d-id.com/talks', [
            'script' => [
                'type' => 'text',
                'input' => $text,
                'provider' => ['type' => 'microsoft', 'voice_id' => 'en-US-JennyNeural', "voice_config" => ["style" => "Cheerful"]],
                'ssml' => false,
            ],
            'config' => [
                'fluent' => true,
                'pad_audio' => 0.5,
            ],
            'source_url' => 'https://d-id-public-bucket.s3.us-west-2.amazonaws.com/alice.jpg',
        ]);

        if ($response->successful()) {
            $data = $response->json(); 
            return $data['id'] ?? null; 
        }

        return null;
    }


    public function getVideoUrl(string $id): ?string
    {
        $apiKey = env('DID_API_KEY');

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($apiKey . ':'),
            'Accept' => 'application/json',
        ])->get("https://api.d-id.com/talks/$id");

        if ($response->successful()) {
            $data = $response->json(); 
            return $data['result_url'] ?? null;
        }

        return null;
    }

    // public function getVideoUrl(string $id): ?string
    // {
    //     $apiKey = env('DID_API_KEY');

    //     $response = Http::withHeaders([
    //         'Authorization' => 'Basic ' . base64_encode($apiKey . ':'),
    //         'Accept' => 'application/json',
    //     ])->get("https://api.d-id.com/clips/$id");

    //     if ($response->successful()) {
    //         $data = $response->json();
    //         return $data['result_url'] ?? null;
    //     }

    //     return null;
    // }

    // public function generateVideo(string $text): ?string
    // {
    //     $apiKey = env('DID_API_KEY');

    //     $response = Http::withHeaders([
    //         'Authorization' => 'Basic ' . base64_encode($apiKey . ':'),
    //         'Content-Type' => 'application/json',
    //     ])->post('https://api.d-id.com/clips', [
    //         'script' => [
    //             'type' => 'text',
    //             'input' => $text,
    //             'provider' => [
    //                 'type' => 'microsoft',
    //                 'voice_id' => 'en-GB-AbbiNeural',
    //                 'voice_config' => ['style' => 'Excited']
    //             ],
    //             'ssml' => false,
    //         ],
    //         'presenter_id' => 'amy-Aq6OmGZnMt',
    //         'driver_id' => 'Vcq0R4a8F0', // Valid expressive driver
    //         'background' => ["color" => "#c9c9c9"],
    //         'config' => [
    //             'resolution' => '1080p', // Half-body framing
    //             'fluent' => true,
    //             'pad_audio' => 0.4,
    //         ],
    //     ]);


    //     if ($response->successful()) {
    //         $data = $response->json();
    //         return $data['id'] ?? null;
    //     }

    //     return null;
    // }
}
