<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Public: Store contact message
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create($request->all());

        return redirect()->back()->with('success', 'Pesan Anda telah terkirim. Terima kasih!');
    }

    // Admin: List contact messages
    public function index()
    {
        $this->authorizePermission('contacts_view');
        $contacts = Contact::latest()->paginate(10);
        return view('contacts.index', compact('contacts'));
    }

    // Admin: Show contact message
    public function show(Contact $contact)
    {
        $this->authorizePermission('contacts_view');
        $contact->update(['is_read' => true]);
        return view('contacts.show', compact('contact'));
    }

    // Admin: Delete contact message
    public function destroy(Contact $contact)
    {
        $this->authorizePermission('contacts_delete');
        $contact->delete();
        return redirect()->route('contacts.index')->with('success', 'Message deleted successfully.');
    }

    protected function authorizePermission($permission)
    {
        if (!auth()->user()->can($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
