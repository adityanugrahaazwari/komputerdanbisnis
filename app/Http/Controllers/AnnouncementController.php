<?php

namespace App\Http\Controllers;

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
        return view('announcements.create');
    }

    public function store(Request $request)
    {
        $this->authorizePermission('announcements_create');
        
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,success,warning,danger',
        ]);

        Announcement::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'message' => $request->message,
            'type' => $request->type,
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

    protected function authorizePermission($permission)
    {
        if (!auth()->user()->hasPermission($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
