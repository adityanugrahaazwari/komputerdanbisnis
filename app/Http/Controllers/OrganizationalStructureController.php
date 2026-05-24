<?php

namespace App\Http\Controllers;

use App\Models\OrganizationalStructure;
use App\Http\Requests\OrganizationalStructureRequest;
use App\Traits\UploadsFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizationalStructureController extends Controller
{
    use UploadsFiles;

    public function index()
    {
        $this->authorizePermission('organizational_structures_view');
        // We get top level nodes and then use recursion in blade or a helper to show tree
        $structures = OrganizationalStructure::whereNull('parent_id')
            ->with('children')
            ->ordered()
            ->get();
            
        return view('organizational_structures.index', compact('structures'));
    }

    public function create()
    {
        $this->authorizePermission('organizational_structures_create');
        $parents = OrganizationalStructure::all();
        return view('organizational_structures.create', compact('parents'));
    }

    public function store(OrganizationalStructureRequest $request)
    {
        $this->authorizePermission('organizational_structures_create');

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'organizational');
        }

        OrganizationalStructure::create($data);

        return redirect()->route('organizational-structures.index')->with('success', 'Structure element created successfully.');
    }

    public function edit(OrganizationalStructure $organizationalStructure)
    {
        $this->authorizePermission('organizational_structures_edit');
        $parents = OrganizationalStructure::where('id', '!=', $organizationalStructure->id)->get();
        return view('organizational_structures.edit', compact('organizationalStructure', 'parents'));
    }

    public function update(OrganizationalStructureRequest $request, OrganizationalStructure $organizationalStructure)
    {
        $this->authorizePermission('organizational_structures_edit');

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'organizational', $organizationalStructure->image);
        }

        $organizationalStructure->update($data);

        return redirect()->route('organizational-structures.index')->with('success', 'Structure element updated successfully.');
    }

    public function destroy(OrganizationalStructure $organizationalStructure)
    {
        $this->authorizePermission('organizational_structures_delete');
        $this->deleteFile($organizationalStructure->image);
        $organizationalStructure->delete();
        return redirect()->route('organizational-structures.index')->with('success', 'Structure element deleted successfully.');
    }
}
