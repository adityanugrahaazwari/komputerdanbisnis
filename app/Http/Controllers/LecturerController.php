<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\StudyProgram;
use App\Http\Requests\LecturerRequest;
use App\Traits\UploadsFiles;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LecturerController extends Controller
{
    use LogsActivity, UploadsFiles;

    public function index()
    {
        $this->authorizePermission('lecturers_view');
        $lecturers = Lecturer::with('studyProgram')->ordered()->paginate(10);
        return view('lecturers.index', compact('lecturers'));
    }

    public function create()
    {
        $this->authorizePermission('lecturers_create');
        $studyPrograms = StudyProgram::all();
        return view('lecturers.create', compact('studyPrograms'));
    }

    public function store(LecturerRequest $request)
    {
        $this->authorizePermission('lecturers_create');

        $data = $request->except('photo');
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->uploadFile($request->file('photo'), 'lecturers');
        }

        $lecturer = Lecturer::create($data);
        
        return redirect()->route('lecturers.index')->with('success', 'Lecturer added successfully.');
    }

    public function edit(Lecturer $lecturer)
    {
        $this->authorizePermission('lecturers_edit');
        $studyPrograms = StudyProgram::all();
        return view('lecturers.edit', compact('lecturer', 'studyPrograms'));
    }

    public function update(LecturerRequest $request, Lecturer $lecturer)
    {
        $this->authorizePermission('lecturers_edit');

        $data = $request->except('photo');
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->uploadFile($request->file('photo'), 'lecturers', $lecturer->photo);
        }

        $lecturer->update($data);

        return redirect()->route('lecturers.index')->with('success', 'Lecturer updated successfully.');
    }

    public function destroy(Lecturer $lecturer)
    {
        $this->authorizePermission('lecturers_delete');
        
        $this->deleteFile($lecturer->photo);
        $lecturer->delete();
        
        return redirect()->route('lecturers.index')->with('success', 'Lecturer deleted successfully.');
    }
}
