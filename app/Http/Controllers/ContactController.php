<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Public: Store contact message
    public function store(ContactRequest $request)
    {
        $validated = $request->validated();

        Contact::create($validated);

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
}
