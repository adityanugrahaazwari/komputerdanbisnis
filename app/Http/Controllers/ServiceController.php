<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $this->authorizePermission('services_view');
        $services = Service::orderBy('order')->paginate(15);
        return view('services.index', compact('services'));
    }

    public function create()
    {
        $this->authorizePermission('services_create');
        return view('services.create');
    }

    public function store(Request $request)
    {
        $this->authorizePermission('services_create');
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'icon' => 'nullable|string',
            'order' => 'integer',
        ]);

        Service::create($request->all());
        return redirect()->route('services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Service $service)
    {
        $this->authorizePermission('services_edit');
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $this->authorizePermission('services_edit');
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'icon' => 'nullable|string',
            'order' => 'integer',
        ]);

        $service->update($request->all());
        return redirect()->route('services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        $this->authorizePermission('services_delete');
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Layanan berhasil dihapus.');
    }

    protected function authorizePermission($permission)
    {
        if (!auth()->user()->can($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
