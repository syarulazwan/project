<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\DocumentChunk;
use App\Services\ChatAI\OpenAIService;
use App\Models\ChatHistory;
use App\Services\ChatAI\DIDService;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    public function main()
    {
        $documents = Document::all();
        return view('chatai.chat_main', compact('documents'));
    }

    public function ask(Request $request)
    {
        $request->validate([
            'chat_type' => 'required|in:general,specific',
            'question' => 'required',
            'document_id' => 'required_if:chat_type,specific|exists:documents,id',
        ]);

        $question = $request->question;
        $chatType = $request->chat_type;
        $docId = $request->document_id ?? null;

        $openai = new OpenAIService();
        $questionEmbedding = $openai->getEmbedding($question);

        $chunks = DocumentChunk::query()
            ->with('document')
            ->when($chatType === 'specific', fn($q) => $q->where('document_id', $docId))
            ->get();

        $scored = $chunks->map(function ($chunk) use ($questionEmbedding) {
            $chunkEmbedding = json_decode($chunk->embedding, true);
            return [
                'score' => $this->cosineSimilarity($chunkEmbedding, $questionEmbedding),
                'chunk' => "[Document: {$chunk->document->title}]\n" . $chunk->content
            ];
        })->sortByDesc('score')->take(5);

        $context = implode("\n\n", $scored->pluck('chunk')->toArray());
        $answer = $openai->chatWithContext($context, $question);

        // Save chat
        ChatHistory::create([
            'chat_type' => $chatType,
            'document_id' => $docId,
            'question' => $question,
            'answer' => $answer,
        ]);

        // Trigger D-ID
        $did = new DIDService();
        $friendlyAnswer = $openai->rewriteToFriendly($answer);
        $talkId = $did->generateVideo($friendlyAnswer);

        return response()->json([
            'answer' => $answer,
            'ai_answer' => $friendlyAnswer,
            'talk_id' => $talkId,
        ]);
    }

    private function cosineSimilarity(array $a, array $b): float
    {
        $dot = collect($a)->zip($b)->reduce(fn($c, $p) => $c + ($p[0] * $p[1]), 0);
        $magA = sqrt(collect($a)->reduce(fn($c, $v) => $c + ($v * $v), 0));
        $magB = sqrt(collect($b)->reduce(fn($c, $v) => $c + ($v * $v), 0));
        return $magA * $magB == 0 ? 0 : $dot / ($magA * $magB);
    }
}
