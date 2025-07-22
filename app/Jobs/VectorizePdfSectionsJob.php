<?php

namespace App\Jobs;

use App\Models\PdfSection;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class VectorizePdfSectionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $sections = PdfSection::whereNull('embedding')->get();

        foreach ($sections as $section) {
            try {
                $text = mb_convert_encoding(substr($section->content, 0, 1000), 'UTF-8', 'UTF-8');

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                ])->post('https://api.openai.com/v1/embeddings', [
                    'input' => $text,
                    'model' => 'text-embedding-3-small',
                ]);

                $embedding = $response->json()['data'][0]['embedding'] ?? null;

                if ($embedding) {
                    $section->embedding = json_encode($embedding);
                    $section->save();
                }
            } catch (\Exception $e) {
                Log::error("Vectorize fail: " . $e->getMessage());
            }
            usleep(300000); // 0.3s delay to avoid rate limit
        }
    }
}
