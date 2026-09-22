<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $documents = $request->user()->documents()->with('documentFiles')->get();
        return view("documents.index", compact("documents"));
    }

    public function create()
    {
        //
    }

    public function store(StoreDocumentRequest $request)
    {
        $document = request()->user()->documents()->create($request->validated());

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Document created successfully.',
                'html' => view('documents._document-card', ['document' => $document])->render(),
            ]);
        }

        return redirect()->route("documents.index")->with("success","Document created successfully");
    }

    public function show(Document $document)
    {
        //
    }

    public function edit(Document $document)
    {
        //
    }

    public function update(StoreDocumentRequest $request, Document $document)
    {
        abort_unless($document->user_id === $request->user()->id, 403);

        $document->update($request->validated());

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Document updated successfully.',
                'document' => [
                    'id' => $document->id,
                    'name' => $document->name,
                ],
            ]);
        }

        return redirect()->route("documents.index")->with("success","Document updated successfully");
    }

    public function destroy(Document $document)
    {
        //
    }
}
