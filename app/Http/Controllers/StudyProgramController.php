<?php

namespace App\Http\Controllers;

use App\Models\StudyProgram;
use App\Http\Requests\StudyProgramRequest;
use App\Traits\UploadsFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudyProgramController extends Controller
{
    use UploadsFiles;

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

    public function store(StudyProgramRequest $request)
    {
        $this->authorizePermission('study_programs_create');

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'study_programs');
        }

        StudyProgram::create($data);

        return redirect()->route('study_programs.index')->with('success', 'Program Studi berhasil ditambahkan.');
    }

    public function edit(StudyProgram $studyProgram)
    {
        $this->authorizePermission('study_programs_edit');
        return view('study_programs.edit', compact('studyProgram'));
    }

    public function update(StudyProgramRequest $request, StudyProgram $studyProgram)
    {
        $this->authorizePermission('study_programs_edit');

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'study_programs', $studyProgram->image);
        }

        $studyProgram->update($data);

        return redirect()->route('study_programs.index')->with('success', 'Program Studi berhasil diperbarui.');
    }

    public function destroy(StudyProgram $studyProgram)
    {
        $this->authorizePermission('study_programs_delete');
        $this->deleteFile($studyProgram->image);
        $studyProgram->delete();
        return redirect()->route('study_programs.index')->with('success', 'Program Studi berhasil dihapus.');
    }
}
