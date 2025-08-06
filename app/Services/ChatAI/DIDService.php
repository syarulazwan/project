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
                'driver_expression' => [
                    'expressions' => [
                        'start_frame' => 0,
                        'expression' => 'Happy',
                        'intensity' => 1,
                    ]
                ],
                'background' => 'original',
            ],
            // 'source_url' => 'https://create-images-results.d-id.com/auth0|6892b5263a9a4fc1bd7c083c/upl_O_TUXPKgnkUkStN-bmsMw/image.jpeg',
            // 'source_url' => 'https://create-images-results.d-id.com/auth0|6892c7f9d2b5dc282a9cac3f/upl_ll9Y5FhPphyZ0mk2uXgXW/image.jpeg',
            'source_url' => 'https://create-images-results.d-id.com/auth0|6892cbd546680eaebe2e7a05/upl_D5_cJWSSowy7705HavUDP/image.jpeg',
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
    //                 'voice_id' => 'en-US-JennyNeural',
    //                 'voice_config' => ['style' => 'Cheerful'] // Gaya suara ceria
    //             ],
    //             'ssml' => false,
    //         ],
    //         'presenter_id' => 'amy-Aq6OmGZnMt', // Presenter expressive (free)
    //         'driver_id' => 'Vcq0R4a8F0', // Driver expressive (free)
    //         'background' => ["color" => "#ffffff"], // Putih bersih
    //         'config' => [
    //             'resolution' => '1080p',
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


    // public function getVideoUrl(string $id): ?string
    // {
    //     $apiKey = env('DID_API_KEY');

    //     $response = Http::withHeaders([
    //         'Authorization' => 'Basic ' . base64_encode($apiKey . ':'),
    //         'Accept' => 'application/json',
    //     ])->get("https://api.d-id.com/clips/{$id}");

    //     if ($response->successful()) {
    //         $data = $response->json();
    //         return $data['result_url'] ?? null;
    //     }

    //     return null;
    // }
}
