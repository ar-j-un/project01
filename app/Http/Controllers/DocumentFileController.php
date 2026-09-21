<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentFileRequest;
use App\Http\Requests\UpdateDocumentFileRequest;
use App\Models\Document;
use App\Models\DocumentFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentFileController extends Controller
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

        $file = $document->documentFiles()->create([
            'file_name' => $request->file_name,
            'file_path' => $path,
        ]);

         if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'File added to "' . $document->name . '".',
                'file' => [
                    'id' => $file->id,
                    'file_name' => $file->file_name,
                    'extension' => $file->extension,
                    'is_image' => $file->is_image,
                    'url' => $file->url,
                ],
                'routes' => [
                    'update' => route('document-files.update', [$document, $file]),
                    'destroy' => route('document-files.destroy', $file),
                ],
            ]);
        }

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

    public function update(UpdateDocumentFileRequest $request, Document $document, DocumentFile $documentFile)
    {
        abort_unless($document->user_id === $request->user()->id, 403);
        abort_unless($documentFile->document_id === $document->id, 404);

        $data = [];
        if ($request->filled('file_name')) {
            $data['file_name'] = $request->file_name;
        }
        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('document_files', 'public');

            if ($documentFile->file_path) {
            Storage::disk('public')->delete($documentFile->file_path);
            }
        }

        $documentFile->update($data);
        
        return redirect()->route('documents.index')->with('success', 'File updated to "' . $document->name . '".');
    }
    public function destroy(DocumentFile $documentFile)
    {
        abort_unless($documentFile->document->user_id === request()->user()->id, 403);

        if ($documentFile->file_path) {
            Storage::disk('public')->delete($documentFile->file_path);
        }

        $documentFile->delete();

        return response()->json([
            'success' => true,
            'message' => 'File deleted from "' . $documentFile->document->name . '".',
        ]);
    }
}
