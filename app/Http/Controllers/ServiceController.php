<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Http\Requests\ServiceRequest;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $this->authorizePermission('services_view');
        $services = Service::ordered()->paginate(15);
        return view('services.index', compact('services'));
    }

    public function create()
    {
        $this->authorizePermission('services_create');
        return view('services.create');
    }

    public function store(ServiceRequest $request)
    {
        $this->authorizePermission('services_create');

        Service::create($request->all());
        return redirect()->route('services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Service $service)
    {
        $this->authorizePermission('services_edit');
        return view('services.edit', compact('service'));
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $this->authorizePermission('services_edit');

        $service->update($request->all());
        return redirect()->route('services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        $this->authorizePermission('services_delete');
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
