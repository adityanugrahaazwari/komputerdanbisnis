<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $this->authorizePermission('categories_view');
        $categories = Category::latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $this->authorizePermission('categories_create');
        return view('categories.create');
    }

    public function store(CategoryRequest $request)
    {
        $this->authorizePermission('categories_create');
        
        $validated = $request->validated();

        Category::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description']
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        $this->authorizePermission('categories_edit');
        return view('categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $this->authorizePermission('categories_edit');
        
        $validated = $request->validated();

        $category->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description']
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $this->authorizePermission('categories_delete');
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
