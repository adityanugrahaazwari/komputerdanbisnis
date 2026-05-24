<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Models\Document;
use App\Traits\UploadsFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    use UploadsFiles;

    public function index()
    {
        $this->authorizePermission('documents_view');
        $documents = Document::latest()->paginate(10);
        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        $this->authorizePermission('documents_create');
        return view('documents.create');
    }

    public function store(DocumentRequest $request)
    {
        $this->authorizePermission('documents_create');
        
        $validated = $request->validated();

        $data = $request->only(['title', 'category', 'description']);
        $data['file_path'] = $this->uploadFile($request->file('file'), 'documents');

        Document::create($data);

        return redirect()->route('documents.index')->with('success', 'Document uploaded successfully.');
    }

    public function edit(Document $document)
    {
        $this->authorizePermission('documents_edit');
        return view('documents.edit', compact('document'));
    }

    public function update(DocumentRequest $request, Document $document)
    {
        $this->authorizePermission('documents_edit');
        
        $validated = $request->validated();

        $data = $request->only(['title', 'category', 'description', 'is_active']);

        if ($request->hasFile('file')) {
            $data['file_path'] = $this->uploadFile($request->file('file'), 'documents', $document->file_path);
        }

        $document->update($data);

        return redirect()->route('documents.index')->with('success', 'Document updated.');
    }

    public function destroy(Document $document)
    {
        $this->authorizePermission('documents_delete');
        $this->deleteFile($document->file_path);
        $document->delete();
        return redirect()->route('documents.index')->with('success', 'Document deleted.');
    }
}
