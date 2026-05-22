<?php

namespace App\Http\Controllers;

use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudyProgramController extends Controller
{
    public function index()
    {
        $this->authorizePermission('study_programs_view');
        $studyPrograms = StudyProgram::latest()->paginate(10);
        return view('study_programs.index', compact('studyPrograms'));
    }

    public function create()
    {
        $this->authorizePermission('study_programs_create');
        return view('study_programs.create');
    }

    public function store(Request $request)
    {
        $this->authorizePermission('study_programs_create');
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:study_programs',
            'level' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'website_url' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('study_programs', 'public');
        }

        StudyProgram::create($data);

        return redirect()->route('study_programs.index')->with('success', 'Program Studi berhasil ditambahkan.');
    }

    public function edit(StudyProgram $studyProgram)
    {
        $this->authorizePermission('study_programs_edit');
        return view('study_programs.edit', compact('studyProgram'));
    }

    public function update(Request $request, StudyProgram $studyProgram)
    {
        $this->authorizePermission('study_programs_edit');
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:study_programs,code,' . $studyProgram->id,
            'level' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'website_url' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            if ($studyProgram->image) {
                Storage::disk('public')->delete($studyProgram->image);
            }
            $data['image'] = $request->file('image')->store('study_programs', 'public');
        }

        $studyProgram->update($data);

        return redirect()->route('study_programs.index')->with('success', 'Program Studi berhasil diperbarui.');
    }

    public function destroy(StudyProgram $studyProgram)
    {
        $this->authorizePermission('study_programs_delete');
        if ($studyProgram->image) {
            Storage::disk('public')->delete($studyProgram->image);
        }
        $studyProgram->delete();
        return redirect()->route('study_programs.index')->with('success', 'Program Studi berhasil dihapus.');
    }

    protected function authorizePermission($permission)
    {
        if (!auth()->user()->can($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
