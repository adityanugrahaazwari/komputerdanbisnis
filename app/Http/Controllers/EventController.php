<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    use \App\Traits\LogsActivity;

    public function index()
    {
        $this->authorizePermission('events_view');
        $events = Event::latest('start_date')->paginate(10);
        return view('events.index', compact('events'));
    }

    public function create()
    {
        $this->authorizePermission('events_create');
        return view('events.create');
    }

    public function store(Request $request)
    {
        $this->authorizePermission('events_create');
        $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'type' => 'required|in:academic,webinar,competition,holiday,other',
            'color' => 'required|string|max:20',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimetypes:image/jpeg,image/png|max:2048',
            'is_active' => 'boolean'
        ]);

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->title);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $data['image'] = $file->storeAs('events', $filename, 'public');
        }

        $event = Event::create($data);
        
        $this->logActivity('create', $event, 'Created event: ' . $event->title);

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        $this->authorizePermission('events_edit');
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorizePermission('events_edit');
        $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'type' => 'required|in:academic,webinar,competition,holiday,other',
            'color' => 'required|string|max:20',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimetypes:image/jpeg,image/png|max:2048',
            'is_active' => 'boolean'
        ]);

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->title);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $file = $request->file('image');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $data['image'] = $file->storeAs('events', $filename, 'public');
        }

        $event->update($data);

        $this->logActivity('update', $event, 'Updated event: ' . $event->title);

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $this->authorizePermission('events_delete');
        
        $title = $event->title;
        
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }
        $event->delete();
        
        $this->logActivity('delete', null, 'Deleted event: ' . $title);

        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }

    protected function authorizePermission($permission)
    {
        if (!auth()->user()->can($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
