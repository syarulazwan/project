<?php

namespace App\Http\Controllers\Project;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\PdfSection;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('chat');
    }

    // public function ask(Request $request)
    // {
    //     $question = $request->input('question');

    //     // Call OpenAI
    //     $response = Http::withToken(env('OPENAI_API_KEY'))->post('https://api.openai.com/v1/chat/completions', [
    //         'model' => 'gpt-4',
    //         'messages' => [
    //             ['role' => 'user', 'content' => $question],
    //         ],
    //     ]);

    //     $answer = $response['choices'][0]['message']['content'];

    //     Chat::create([
    //         'question' => $question,
    //         'answer' => $answer,
    //     ]);

    //     return response()->json(['answer' => $answer]);
    // }

    // public function ask(Request $request)
    // {
    //     $question = $request->input('question');

    //     // Cari 3 page kandungan yang ada kaitan dengan soalan
    //     $matchedSections = PdfSection::where('content', 'LIKE', '%' . $question . '%')
    //         ->limit(30)
    //         ->pluck('content')
    //         ->implode("\n\n");

    //     // Buat prompt dengan context PDF
    //     $prompt = "Kamu adalah pembantu sistem sokongan. Berdasarkan maklumat berikut dari manual sistem:\n" . $matchedSections . "\n\nJawab soalan ini dengan tepat: " . $question;

    //     // Call DeepSeek API
    //     $response = Http::withHeaders([
    //         'Authorization' => 'Bearer ' . env('DEEPSEEK_API_KEY'),
    //         'Content-Type' => 'application/json',
    //     ])->post('https://api.deepseek.com/v1/chat/completions', [
    //         'model' => 'deepseek-chat', // atau model lain yang tersedia
    //         'messages' => [
    //             ['role' => 'user', 'content' => $prompt],
    //         ],
    //         'temperature' => 0.7, // optional parameter
    //     ]);

    //     // Pastikan response sesuai dengan format DeepSeek
    //     $answer = $response->json()['choices'][0]['message']['content'];

    //     Chat::create([
    //         'question' => $question,
    //         'answer' => $answer,
    //     ]);

    //     return response()->json(['answer' => $answer]);
    // }

    // public function ask(Request $request)
    // {
    //     $request->validate([
    //         'question' => 'required|string|max:500'
    //     ]);

    //     $question = trim($request->input('question'));

    //     try {
    //         // Find relevant sections with better search
    //         $matchedSections = PdfSection::query()
    //             ->where(function ($query) use ($question) {
    //                 // Split question into keywords for better matching
    //                 $keywords = preg_split('/\s+/', $question);
    //                 foreach ($keywords as $keyword) {
    //                     if (strlen($keyword) > 2) { // ignore very short words
    //                         $query->orWhere('content', 'LIKE', '%' . $keyword . '%');
    //                     }
    //                 }
    //             })
    //             ->orderByRaw("
    //             LENGTH(content) ASC, -- Prefer shorter, more focused sections
    //             CASE 
    //                 WHEN content LIKE ? THEN 1 
    //                 WHEN content LIKE ? THEN 2 
    //                 ELSE 3 
    //             END
    //         ", ["%$question%", "%" . implode('%', explode(' ', $question)) . "%"])
    //             ->limit(10) // More manageable context size
    //             ->pluck('content')
    //             ->take(5000) // Limit total context characters
    //             ->implode("\n\n---\n"); // Better section separation

    //         if (empty($matchedSections)) {
    //             throw new \Exception('No relevant information found in documents.');
    //         }

    //         // Improved prompt engineering
    //         $prompt = "Anda adalah pembantu sistem sokongan yang profesional. Berdasarkan maklumat berikut dari manual sistem:\n\n"
    //             . $matchedSections
    //             . "\n\nJawab soalan pengguna dengan tepat dan ringkas dalam Bahasa Melayu. Jika maklumat tidak mencukupi, nyatakan 'Maklumat tidak ditemui dalam dokumen'.\n\nSoalan: "
    //             . $question;

    //         // Call DeepSeek API with error handling
    //         $response = Http::withHeaders([
    //             'Authorization' => 'Bearer ' . env('DEEPSEEK_API_KEY'),
    //             'Content-Type' => 'application/json',
    //         ])
    //             ->timeout(30) // Add timeout
    //             ->retry(2, 500) // Add retry mechanism
    //             ->post('https://api.deepseek.com/v1/chat/completions', [
    //                 'model' => 'deepseek-chat',
    //                 'messages' => [
    //                     ['role' => 'system', 'content' => 'Anda adalah pembantu yang membantu pengguna berdasarkan kandungan dokumen yang diberikan.'],
    //                     ['role' => 'user', 'content' => $prompt],
    //                 ],
    //                 'temperature' => 0.3, // Lower for more factual answers
    //                 'max_tokens' => 500, // Limit response length
    //             ]);

    //         if (!$response->successful()) {
    //             throw new \Exception('API request failed: ' . $response->body());
    //         }

    //         $responseData = $response->json();

    //         if (!isset($responseData['choices'][0]['message']['content'])) {
    //             throw new \Exception('Invalid API response format');
    //         }

    //         $answer = $responseData['choices'][0]['message']['content'];

    //         // Save to database
    //         Chat::create([
    //             'question' => $question,
    //             'answer' => $answer,
    //             'context_used' => $matchedSections, // Store context for debugging
    //         ]);

    //         return response()->json([
    //             'answer' => $answer,
    //             'context_length' => strlen($matchedSections), // For debugging
    //         ]);
    //     } catch (\Exception $e) {
    //         // Log::error('Ask function failed: ' . $e->getMessage());
    //         return response()->json([
    //             'error' => 'Maaf, terdapat masalah ketika memproses soalan anda.',
    //             'details' => config('app.debug') ? $e->getMessage() : null,
    //         ], 500);
    //     }
    // }

    // public function ask(Request $request)
    // {
    //     $request->validate([
    //         'question' => 'required|string|max:500'
    //     ]);

    //     $question = trim($request->input('question'));

    //     try {
    //         // Cari kandungan yang berkaitan berdasarkan kata kunci
    //         $matchedSections = PdfSection::query()
    //             ->where(function ($query) use ($question) {
    //                 $keywords = preg_split('/\s+/', $question);
    //                 foreach ($keywords as $keyword) {
    //                     if (strlen($keyword) > 2) {
    //                         $query->orWhere('content', 'LIKE', '%' . $keyword . '%');
    //                     }
    //                 }
    //             })
    //             ->limit(10)
    //             ->pluck('content')
    //             ->implode("\n\n---\n");

    //         if (empty($matchedSections)) {
    //             throw new \Exception('No relevant information found in documents.');
    //         }

    //         // Prompt untuk AI
    //         $prompt = "Anda adalah pembantu sistem yang bijak. Berdasarkan maklumat dari dokumen sistem di bawah:\n\n"
    //             . $matchedSections
    //             . "\n\nJawab soalan berikut secara profesional dan tepat dalam Bahasa Melayu. Jika tiada maklumat, nyatakan 'Maklumat tidak ditemui dalam dokumen'.\n\nSoalan: "
    //             . $question;

    //         // Panggil API OpenAI
    //         $response = Http::withHeaders([
    //             'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
    //         ])
    //             ->timeout(30)
    //             ->retry(2, 500)
    //             ->post('https://api.openai.com/v1/chat/completions', [
    //                 'model' => 'gpt-3.5-turbo', // atau 'gpt-4' jika mahu lebih tepat
    //                 'messages' => [
    //                     ['role' => 'system', 'content' => 'Anda adalah pembantu AI yang menjawab berdasarkan kandungan sistem.'],
    //                     ['role' => 'user', 'content' => $prompt],
    //                 ],
    //                 'temperature' => 0.3,
    //                 'max_tokens' => 500,
    //             ]);

    //         if (!$response->successful()) {
    //             throw new \Exception('API request failed: ' . $response->body());
    //         }

    //         $responseData = $response->json();

    //         if (!isset($responseData['choices'][0]['message']['content'])) {
    //             throw new \Exception('Invalid API response format');
    //         }

    //         $answer = $responseData['choices'][0]['message']['content'];

    //         // Simpan ke DB
    //         Chat::create([
    //             'question' => $question,
    //             'answer' => $answer,
    //             'context_used' => $matchedSections,
    //         ]);

    //         return response()->json([
    //             'answer' => $answer,
    //             'context_length' => strlen($matchedSections),
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'error' => 'Maaf, terdapat masalah ketika memproses soalan anda.',
    //             'details' => config('app.debug') ? $e->getMessage() : null,
    //         ], 500);
    //     }
    // }

    // public function ask(Request $request)
    // {
    //     $request->validate([
    //         'question' => 'required|string|max:500'
    //     ]);

    //     $question = trim($request->input('question'));

    //     try {
    //         // STEP 1: Dapatkan embedding vector untuk soalan user
    //         $embeddingResponse = Http::withHeaders([
    //             'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
    //         ])->post('https://api.openai.com/v1/embeddings', [
    //             'input' => $question,
    //             'model' => 'text-embedding-3-small',
    //         ]);

    //         $questionVector = $embeddingResponse->json()['data'][0]['embedding'] ?? null;

    //         if (!$questionVector) {
    //             throw new \Exception('Failed to get embedding for question.');
    //         }

    //         // STEP 2: Kira similarity setiap section
    //         $topSections = PdfSection::whereNotNull('embedding')->get()->map(function ($section) use ($questionVector) {
    //             $embeddingArray = json_decode($section->embedding, true);
    //             if (!is_array($embeddingArray)) {
    //                 // Tangani error jika decode gagal
    //                 $embeddingArray = []; // atau lempar exception
    //             }
    //             $section->similarity = $this->cosineSimilarity($questionVector, $embeddingArray);
    //             return $section;
    //         })->sortByDesc('similarity')->take(5); // Ambil 5 paling relevan

    //         // STEP 3: Gabungkan content
    //         $context = $topSections->pluck('content')->implode("\n\n---\n");

    //         // STEP 4: Bina prompt untuk OpenAI
    //         $previousChats = Chat::latest()->take(3)->get()->reverse();

    //         $historyPrompt = $previousChats->map(function ($chat) {
    //             return "Soalan: {$chat->question}\nJawapan: {$chat->answer}";
    //         })->implode("\n\n");

    //         $prompt = "Anda adalah pembantu sistem profesional. Berikut adalah sejarah sembang:\n\n"
    //             . $historyPrompt
    //             . "\n\nMaklumat dari dokumen sistem:\n\n"
    //             . $context
    //             . "\n\nSoalan baru: " . $question
    //             . "\n\nJawab dalam Bahasa English dengan fakta tepat berdasarkan dokumen. Jika tiada maklumat, jawab 'Maklumat tidak ditemui dalam dokumen.'";

    //         // STEP 5: Hantar ke OpenAI Chat Completion API
    //         $response = Http::withHeaders([
    //             'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
    //         ])->post('https://api.openai.com/v1/chat/completions', [
    //             'model' => 'gpt-3.5-turbo', // atau 'gpt-4' jika mahu lebih tepat
    //             'messages' => [
    //                 ['role' => 'system', 'content' => 'Anda adalah pembantu AI yang menjawab berdasarkan dokumen.'],
    //                 ['role' => 'user', 'content' => $prompt],
    //             ],
    //             'temperature' => 0.3,
    //             'max_tokens' => 500,
    //         ]);

    //         $answer = $response->json()['choices'][0]['message']['content'] ?? 'Tiada jawapan ditemui.';

    //         Chat::create([
    //             'question' => $question,
    //             'answer' => $answer,
    //             'context_used' => $context,
    //         ]);

    //         return response()->json([
    //             'answer' => $answer,
    //             'context_length' => strlen($context),
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'error' => 'Gagal menjawab soalan.',
    //             'details' => config('app.debug') ? $e->getMessage() : null,
    //         ], 500);
    //     }
    // }

    // public function ask(Request $request)
    // {
    //     $request->validate([
    //         'question' => 'required|string|max:500'
    //     ]);

    //     $mode = $request->input('mode');
    //     $documentId = $request->input('document_id');

    //     $question = trim($request->input('question'));

    //     if ($mode === 'general') {
    //         try {
    //             // STEP 1: Dapatkan embedding vector untuk soalan user
    //             $embeddingResponse = Http::withHeaders([
    //                 'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
    //             ])->post('https://api.openai.com/v1/embeddings', [
    //                 'input' => $question,
    //                 'model' => 'text-embedding-3-small',
    //             ]);

    //             $questionVector = $embeddingResponse->json()['data'][0]['embedding'] ?? null;

    //             if (!$questionVector) {
    //                 throw new \Exception('Failed to get embedding for question.');
    //             }

    //             // STEP 2: Kira similarity dan dapatkan top sections + dokumen
    //             $topSections = PdfSection::whereNotNull('embedding')
    //                 ->with('document')
    //                 ->get()
    //                 ->map(function ($section) use ($questionVector) {
    //                     $embeddingArray = json_decode($section->embedding, true) ?? [];
    //                     $section->similarity = $this->cosineSimilarity($questionVector, $embeddingArray);
    //                     return $section;
    //                 })
    //                 ->sortByDesc('similarity')
    //                 ->take(5);

    //             // Gabung content dengan dokumen + page
    //             $contextWithSource = $topSections->map(function ($section) {
    //                 $title = $section->document->title ?? 'Dokumen Tidak Dikenalpasti';
    //                 return "Dokumen: $title (Muka surat: $section->page)\n" . $section->content;
    //             })->implode("\n\n---\n");
    //             $context = $topSections->pluck('content')->implode("\n\n---\n");

    //             // STEP 3: Ambil chat history (terakhir)
    //             $previousChats = Chat::latest()->take(3)->get()->reverse();
    //             $historyPrompt = $previousChats->map(function ($chat) {
    //                 return "Soalan: {$chat->question}\nJawapan: {$chat->answer}";
    //             })->implode("\n\n");

    //             // STEP 4: Bina prompt penuh
    //             $prompt = "Anda adalah pembantu sistem profesional. Berikut adalah sejarah sembang:\n\n"
    //                 . $historyPrompt
    //                 . "\n\nMaklumat dari dokumen sistem:\n\n"
    //                 . $contextWithSource
    //                 . "\n\nSoalan baru: " . $question
    //                 . "\n\nJawab dalam Bahasa Inggeris dengan fakta tepat berdasarkan dokumen (kecuali user minta Bahasa Melayu). Jika soalan adalah ucapan biasa seperti 'Terima kasih', 'Hi', atau 'Ok', balas secara mesra sebagai pembantu AI. Jika maklumat tidak ditemui, jawab 'Maklumat tidak ditemui dalam dokumen.'";

    //             // STEP 5: Hantar ke OpenAI
    //             $response = Http::withHeaders([
    //                 'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
    //             ])->post('https://api.openai.com/v1/chat/completions', [
    //                 'model' => 'gpt-3.5-turbo',
    //                 'messages' => [
    //                     ['role' => 'system', 'content' => 'Anda adalah pembantu AI yang menjawab berdasarkan dokumen.'],
    //                     ['role' => 'user', 'content' => $prompt],
    //                 ],
    //                 'temperature' => 0.3,
    //                 'max_tokens' => 500,
    //             ]);

    //             $answer = $response->json()['choices'][0]['message']['content'] ?? 'Tiada jawapan ditemui.';

    //             // STEP 6: Simpan ke DB
    //             Chat::create([
    //                 'question' => $question,
    //                 'answer' => $answer,
    //                 'context_used' => $context,
    //             ]);

    //             return response()->json([
    //                 'answer' => $answer,
    //                 'context_length' => strlen($contextWithSource),
    //                 'source_pages' => $topSections->map(fn($s) => [
    //                     'document' => $s->document->title,
    //                     'page' => $s->page,
    //                     'context' => $context,
    //                 ]),
    //             ]);
    //         } catch (\Exception $e) {
    //             return response()->json([
    //                 'error' => 'Gagal menjawab soalan.',
    //                 'details' => config('app.debug') ? $e->getMessage() : null,
    //             ], 500);
    //         }
    //     } else {
    //         $sections = PdfSection::where('document_id', $documentId)
    //             ->whereNotNull('embedding')
    //             ->with('document')
    //             ->get();
    //     }
    // }

    public function ask(Request $request)
    {
        dd(env('APP_NAME'));

        $request->validate([
            'question' => 'required|string|max:500',
            'mode' => 'required|in:general,document',
            'document_id' => 'nullable|exists:documents,id',
        ]);

        $mode = $request->input('mode');
        $documentId = $request->input('document_id');
        $question = trim($request->input('question'));

        try {
            // STEP 1: Get embedding vector
            $embeddingResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            ])->post('https://api.openai.com/v1/embeddings', [
                'input' => $question,
                'model' => 'text-embedding-3-small',
            ]);

            $questionVector = $embeddingResponse->json()['data'][0]['embedding'] ?? null;

            if (!$questionVector) {
                throw new \Exception('Failed to get embedding for question.');
            }

            // STEP 2: Get relevant sections
            $sectionsQuery = PdfSection::whereNotNull('embedding')->with('document');

            if ($mode === 'document' && $documentId) {
                $sectionsQuery->where('document_id', $documentId);
            }

            $topSections = $sectionsQuery->get()->map(function ($section) use ($questionVector) {
                $embeddingArray = json_decode($section->embedding, true) ?? [];
                $section->similarity = $this->cosineSimilarity($questionVector, $embeddingArray);
                return $section;
            })->sortByDesc('similarity')->take(5);

            // STEP 3: Build context with source
            $contextWithSource = $topSections->map(function ($section) {
                $title = $section->document->title ?? 'Dokumen Tidak Dikenalpasti';
                return "Dokumen: $title (Muka surat: $section->page)\n" . $section->content;
            })->implode("\n\n---\n");

            $context = $topSections->pluck('content')->implode("\n\n---\n");

            // STEP 4: Previous chats
            $previousChats = Chat::latest()->take(3)->get()->reverse();
            $historyPrompt = $previousChats->map(function ($chat) {
                return "Soalan: {$chat->question}\nJawapan: {$chat->answer}";
            })->implode("\n\n");

            // STEP 5: Final prompt
            $prompt = "Anda adalah pembantu sistem profesional. Berikut adalah sejarah sembang:\n\n"
                . $historyPrompt
                . "\n\nMaklumat dari dokumen sistem:\n\n"
                . $contextWithSource
                . "\n\nSoalan baru: " . $question
                . "\n\nJawab dalam Bahasa Inggeris dengan fakta tepat berdasarkan dokumen (kecuali user minta Bahasa Melayu). "
                . "Jika soalan adalah ucapan biasa seperti 'Terima kasih', 'Hi', atau 'Ok' atau lain-lain, balas secara mesra sebagai pembantu AI. "
                . "Jika terdapat singkatan seperti 'nk', 'mcm', atau 'reg', anggap ia sebagai bentuk ringkas Bahasa Melayu atau Inggeris dan fahami mengikut konteks."
                . "Jika maklumat tidak ditemui, jawab 'Maklumat tidak ditemui dalam dokumen.'";

            // STEP 6: Hantar ke OpenAI
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'Anda adalah pembantu AI yang menjawab berdasarkan dokumen.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.3,
                'max_tokens' => 500,
            ]);

            $answer = $response->json()['choices'][0]['message']['content'] ?? 'Tiada jawapan ditemui.';

            // STEP 7: Simpan ke DB
            Chat::create([
                'question' => $question,
                'answer' => $answer,
                'context_used' => $context,
            ]);

            return response()->json([
                'answer' => $answer,
                'context_length' => strlen($contextWithSource),
                'source_pages' => $topSections->map(fn($s) => [
                    'document' => $s->document->title,
                    'page' => $s->page,
                ]),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal menjawab soalan.',
                'details' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }



    /**
     * Get context guna embedding ai
     */
    function cosineSimilarity(array $a, array $b)
    {
        $dotProduct = array_sum(array_map(fn($x, $y) => $x * $y, $a, $b));
        $magnitudeA = sqrt(array_sum(array_map(fn($x) => $x * $x, $a)));
        $magnitudeB = sqrt(array_sum(array_map(fn($y) => $y * $y, $b)));

        return $dotProduct / ($magnitudeA * $magnitudeB ?: 1);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
