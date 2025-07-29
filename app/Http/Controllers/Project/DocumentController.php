<?php

namespace App\Http\Controllers\Project;


use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\DocumentChunk;
use App\Services\OpenAIService;
use Smalot\PdfParser\Parser;
use App\Jobs\ProcessPdfJob;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class DocumentController extends Controller
{
    public function uploadPage()
    {
        $documents = Document::latest()->get();
        return view('chatai.upload', compact('documents'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:51200',
        ]);

        $file = $request->file('pdf');
        $path = $file->store('public/pdfs');

        $doc = Document::create([
            'title' => $file->getClientOriginalName(),
            'file_path' => $path,
            'status' => 'pending'
        ]);
        if (!$doc || !$doc->id) {
            throw new \Exception("Failed to save document before dispatching job.");
        }
        ProcessPdfJob::dispatch($doc->id); // Background processing

        return redirect('zara/pdf/')->with('status', 'File uploaded. Processing in background.');
    }

    public function destroy(Document $document)
    {
        // Optional: delete the file from storage
        if (Storage::exists($document->file_path)) {
            Storage::delete($document->file_path);
        }

        $document->delete();

        return redirect()->back()->with('success', 'PDF deleted successfully.');
    }
}
