<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\EventRequest;
use App\Traits\UploadsFiles;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    use LogsActivity, UploadsFiles;

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

    public function store(EventRequest $request)
    {
        $this->authorizePermission('events_create');

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->title);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'events');
        }

        $event = Event::create($data);
        
        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        $this->authorizePermission('events_edit');
        return view('events.edit', compact('event'));
    }

    public function update(EventRequest $request, Event $event)
    {
        $this->authorizePermission('events_edit');

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->title);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'events', $event->image);
        }

        $event->update($data);

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $this->authorizePermission('events_delete');
        
        $this->deleteFile($event->image);
        $event->delete();
        
        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}
