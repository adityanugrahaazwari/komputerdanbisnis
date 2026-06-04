<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnouncementRequest;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $this->authorizePermission('announcements_view');
        $announcements = Announcement::with('user')->latest()->paginate(10);
        return view('announcements.index', compact('announcements'));
    }

    public function create()
    {
        $this->authorizePermission('announcements_create');
        $roles = \App\Models\Role::all();
        return view('announcements.create', compact('roles'));
    }

    public function store(AnnouncementRequest $request)
    {
        $this->authorizePermission('announcements_create');
        
        $validated = $request->validated();

        Announcement::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'message' => $validated['message'],
            'type' => $validated['type'],
            'target_role' => $validated['target_role'],
            'is_active' => true,
        ]);

        return redirect()->route('announcements.index')->with('success', 'Announcement broadcasted successfully.');
    }

    public function destroy(Announcement $announcement)
    {
        $this->authorizePermission('announcements_delete');
        $announcement->delete();
        return redirect()->route('announcements.index')->with('success', 'Announcement deleted successfully.');
    }

    public function toggle(Announcement $announcement)
    {
        $this->authorizePermission('announcements_edit');
        $announcement->update(['is_active' => !$announcement->is_active]);
        return back()->with('success', 'Announcement status updated.');
    }
}
