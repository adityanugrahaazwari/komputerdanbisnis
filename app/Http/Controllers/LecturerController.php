<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LecturerController extends Controller
{
    use \App\Traits\LogsActivity;

    public function index()
    {
        $this->authorizePermission('lecturers_view');
        $lecturers = Lecturer::with('studyProgram')->orderBy('order')->paginate(10);
        return view('lecturers.index', compact('lecturers'));
    }

    public function create()
    {
        $this->authorizePermission('lecturers_create');
        $studyPrograms = StudyProgram::all();
        return view('lecturers.create', compact('studyPrograms'));
    }

    public function store(Request $request)
    {
        $this->authorizePermission('lecturers_create');
        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'nidn' => 'nullable|string|max:50',
            'position' => 'nullable|string|max:255',
            'expertise' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'google_scholar_url' => 'nullable|url|max:255',
            'sinta_url' => 'nullable|url|max:255',
            'study_program_id' => 'nullable|exists:study_programs,id',
            'photo' => 'nullable|image|mimetypes:image/jpeg,image/png|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $data = $request->except('photo');
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $data['photo'] = $file->storeAs('lecturers', $filename, 'public');
        }

        $lecturer = Lecturer::create($data);
        
        $this->logActivity('create', $lecturer, 'Added lecturer: ' . $lecturer->name);

        return redirect()->route('lecturers.index')->with('success', 'Lecturer added successfully.');
    }

    public function edit(Lecturer $lecturer)
    {
        $this->authorizePermission('lecturers_edit');
        $studyPrograms = StudyProgram::all();
        return view('lecturers.edit', compact('lecturer', 'studyPrograms'));
    }

    public function update(Request $request, Lecturer $lecturer)
    {
        $this->authorizePermission('lecturers_edit');
        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'nidn' => 'nullable|string|max:50',
            'position' => 'nullable|string|max:255',
            'expertise' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'google_scholar_url' => 'nullable|url|max:255',
            'sinta_url' => 'nullable|url|max:255',
            'study_program_id' => 'nullable|exists:study_programs,id',
            'photo' => 'nullable|image|mimetypes:image/jpeg,image/png|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $data = $request->except('photo');
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('photo')) {
            if ($lecturer->photo) {
                Storage::disk('public')->delete($lecturer->photo);
            }
            $file = $request->file('photo');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $data['photo'] = $file->storeAs('lecturers', $filename, 'public');
        }

        $lecturer->update($data);

        $this->logActivity('update', $lecturer, 'Updated lecturer: ' . $lecturer->name);

        return redirect()->route('lecturers.index')->with('success', 'Lecturer updated successfully.');
    }

    public function destroy(Lecturer $lecturer)
    {
        $this->authorizePermission('lecturers_delete');
        
        $name = $lecturer->name;
        
        if ($lecturer->photo) {
            Storage::disk('public')->delete($lecturer->photo);
        }
        $lecturer->delete();
        
        $this->logActivity('delete', null, 'Deleted lecturer: ' . $name);

        return redirect()->route('lecturers.index')->with('success', 'Lecturer deleted successfully.');
    }

    protected function authorizePermission($permission)
    {
        if (!auth()->user()->can($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
