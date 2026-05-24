<?php

namespace App\Http\Controllers;

use App\Models\OrganizationalStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizationalStructureController extends Controller
{
    public function index()
    {
        $this->authorizePermission('organizational_structures_view');
        // We get top level nodes and then use recursion in blade or a helper to show tree
        $structures = OrganizationalStructure::whereNull('parent_id')
            ->with('children')
            ->orderBy('order')
            ->get();
            
        return view('organizational_structures.index', compact('structures'));
    }

    public function create()
    {
        $this->authorizePermission('organizational_structures_create');
        $parents = OrganizationalStructure::all();
        return view('organizational_structures.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $this->authorizePermission('organizational_structures_create');
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:organizational_structures,id',
            'order' => 'integer',
            'image' => 'nullable|image|mimetypes:image/jpeg,image/png|max:2048'
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = \Illuminate\Support\Str::uuid() . '.' . $file->getClientOriginalExtension();
            $data['image'] = $file->storeAs('organizational', $filename, 'public');
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

    public function update(Request $request, OrganizationalStructure $organizationalStructure)
    {
        $this->authorizePermission('organizational_structures_edit');
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:organizational_structures,id',
            'order' => 'integer',
            'image' => 'nullable|image|mimetypes:image/jpeg,image/png|max:2048'
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            if ($organizationalStructure->image) {
                Storage::disk('public')->delete($organizationalStructure->image);
            }
            $file = $request->file('image');
            $filename = \Illuminate\Support\Str::uuid() . '.' . $file->getClientOriginalExtension();
            $data['image'] = $file->storeAs('organizational', $filename, 'public');
        }

        $organizationalStructure->update($data);

        return redirect()->route('organizational-structures.index')->with('success', 'Structure element updated successfully.');
    }

    public function destroy(OrganizationalStructure $organizationalStructure)
    {
        $this->authorizePermission('organizational_structures_delete');
        if ($organizationalStructure->image) {
            Storage::disk('public')->delete($organizationalStructure->image);
        }
        $organizationalStructure->delete();
        return redirect()->route('organizational-structures.index')->with('success', 'Structure element deleted successfully.');
    }

    protected function authorizePermission($permission)
    {
        if (!auth()->user()->hasPermission($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
