<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentFileRequest;
use App\Models\Document;
use App\Models\DocumentFile;
use Illuminate\Http\Request;

class DocumentFileCountroller extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(StoreDocumentFileRequest $request, Document $document)
    {
        abort_unless($document->user_id === $request->user()->id, 403);

        $path = $request->file('file')->store('document_files', 'public');

        $document->documentFiles()->create([
            'file_name' => $request->file_name,
            'file_path' => $path,
        ]);

        return redirect()->route('documents.index')->with('success', 'File added to "' . $document->name . '".');
    }

    public function show(DocumentFile $documentFile)
    {
        //
    }
    public function edit(DocumentFile $documentFile)
    {
        //
    }

    public function update(Request $request, DocumentFile $documentFile)
    {
        //
    }
    public function destroy(DocumentFile $documentFile)
    {
        //
    }
}
