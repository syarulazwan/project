<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Document;
use App\Models\DocumentChunk;
use App\Services\ChatAI\OpenAIService;
use Smalot\PdfParser\Parser;

class ProcessPdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $documentId;

    public function __construct(int $documentId)
    {
        $this->documentId = $documentId;
    }

    public function handle()
    {
        $document = Document::find($this->documentId);

        if (!$document) {
            throw new \Exception("Document not found with ID: {$this->documentId}");
        }

        $pdfPath = storage_path('app/' . $document->file_path);

        if (!file_exists($pdfPath)) {
            throw new \Exception("PDF file not found at: " . $pdfPath);
        }

        $parser = new Parser();
        $pdf = $parser->parseFile($pdfPath);
        $text = $pdf->getText();
        $chunks = str_split($text, 2000);

        $openai = new OpenAIService();

        foreach ($chunks as $chunk) {
            $cleanChunk = mb_convert_encoding($chunk, 'UTF-8', 'UTF-8');
            $cleanChunk = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $cleanChunk);

            if (trim($cleanChunk) === '') continue;

            $embedding = $openai->getEmbedding($cleanChunk);

            // Normalize the vector – replace NaN/INF
            $embedding = array_map(function ($val) {
                return is_finite($val) ? (float) $val : 0.0;
            }, $embedding);

            // Encode with error fallback
            $embeddingJson = json_encode($embedding, JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Embedding JSON error: ' . json_last_error_msg());
            }

            DocumentChunk::create([
                'document_id' => $document->id,
                'content' => $cleanChunk,
                'embedding' => $embeddingJson,
            ]);
        }


        $document->update(['status' => 'processed']);
    }
}
