<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
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

    public function store(Request $request)
    {
        $this->authorizePermission('documents_create');
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimetypes:application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/zip|max:10240',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string'
        ]);

        $data = $request->only(['title', 'category', 'description']);
        $file = $request->file('file');
        $filename = \Illuminate\Support\Str::uuid() . '.' . $file->getClientOriginalExtension();
        $data['file_path'] = $file->storeAs('documents', $filename, 'public');

        Document::create($data);

        return redirect()->route('documents.index')->with('success', 'Document uploaded successfully.');
    }

    public function edit(Document $document)
    {
        $this->authorizePermission('documents_edit');
        return view('documents.edit', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        $this->authorizePermission('documents_edit');
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|mimetypes:application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/zip|max:10240',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string'
        ]);

        $data = $request->only(['title', 'category', 'description', 'is_active']);

        if ($request->hasFile('file')) {
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }
            $file = $request->file('file');
            $filename = \Illuminate\Support\Str::uuid() . '.' . $file->getClientOriginalExtension();
            $data['file_path'] = $file->storeAs('documents', $filename, 'public');
        }

        $document->update($data);

        return redirect()->route('documents.index')->with('success', 'Document updated.');
    }

    public function destroy(Document $document)
    {
        $this->authorizePermission('documents_delete');
        Storage::disk('public')->delete($document->file_path);
        $document->delete();
        return redirect()->route('documents.index')->with('success', 'Document deleted.');
    }

    protected function authorizePermission($permission)
    {
        if (!auth()->user()->can($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
