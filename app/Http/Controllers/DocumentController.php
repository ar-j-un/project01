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
        request()->user()->documents()->create($request->validated());

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

    public function update(Request $request, Document $document)
    {
        //
    }

    public function destroy(Document $document)
    {
        //
    }
}
