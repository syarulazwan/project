<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\PdfSection;
use Smalot\PdfParser\Parser;
use \Illuminate\Support\Facades\Artisan;
use App\Jobs\VectorizePdfSectionsJob;
use App\Http\Controllers\Controller;

class DocumentController extends Controller
{
    public function index()
    {
        return view('admin.pdf');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'pdf' => 'required|mimes:pdf',
        ]);

        $file = $request->file('pdf');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('/pdfs', $filename);

        $document = Document::create([
            'title' => $request->title,
            'filename' => $filename,
        ]);

        $parser = new Parser();
        $pdf = $parser->parseFile(storage_path('app/private/pdfs/' . $filename));
        $pages = $pdf->getPages();

        foreach ($pages as $index => $page) {
            PdfSection::create([
                'document_id' => $document->id,
                'page' => $index + 1,
                'content' => $page->getText(),
            ]);
        }
        // Artisan::call('vectorize:pdf');
        VectorizePdfSectionsJob::dispatch();

        return back()->with('success', 'PDF berjaya dimuat naik dan diproses!');
    }
}
