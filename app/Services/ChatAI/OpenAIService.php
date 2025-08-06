<?php

namespace App\Services\ChatAI;


use Illuminate\Support\Facades\Http;

class OpenAIService
{
    public function getEmbedding(string $text): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        ])->post('https://api.openai.com/v1/embeddings', [
            'input' => $text,
            'model' => 'text-embedding-3-small',
        ]);

        return $response->json('data.0.embedding') ?? [];
    }


    // public function chatWithContext(string $context, string $question): string
    // {
    //     $res = Http::withToken(env('OPENAI_API_KEY'))->post('https://api.openai.com/v1/chat/completions', [
    //         'model' => 'gpt-4o',
    //         'messages' => [
    //             ['role' => 'system', 'content' => 'You are a helpful assistant answering questions based on provided document context.'],
    //             ['role' => 'user', 'content' => "Document:\n$context\n\nQuestion: $question also give me your reference from the document if there is any"]
    //         ]
    //     ]);

    //     return $res['choices'][0]['message']['content'];
    // }

    public function chatWithContext(string $context, string $question): string
    {
        $res = Http::withToken(env('OPENAI_API_KEY'))->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4o',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant. Answer the user\'s question based only on the provided documents. If the answer cannot be found in the documents, say you don\'t know. At the end, list the document titles+page/topic you referenced under "Sources Used" only if there is an answer based on document.'],
                ['role' => 'user', 'content' => "Documents:\n$context\n\nQuestion: $question"]
            ]
        ]);

        return $res['choices'][0]['message']['content'];
    }

    public function rewriteToFriendly(string $text): string
    {
        $prompt = "Please rewrite the following formal explanation into a friendly, cheerful conversation style suitable for a casual help assistant talking to a user (no emoji/emoticon, no quote or bold or anything). Just plain text. Use a light tone and simple language to make it easier to understand for someone new to the process. Keep it conversational like you're guiding a friend through it step-by-step. Make a text that can be speak less than 1 minute.

Here is the text: " . $text;

        return $this->chatWithContext('', $prompt);
    }
}
