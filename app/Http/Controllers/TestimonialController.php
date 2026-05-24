<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use App\Http\Requests\TestimonialRequest;
use App\Traits\UploadsFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    use UploadsFiles;

    public function index()
    {
        $this->authorizePermission('testimonials_view');
        $testimonials = Testimonial::latest()->paginate(15);
        return view('testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        $this->authorizePermission('testimonials_create');
        return view('testimonials.create');
    }

    public function store(TestimonialRequest $request)
    {
        $this->authorizePermission('testimonials_create');

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'testimonials');
        }

        Testimonial::create($data);
        return redirect()->route('testimonials.index')->with('success', 'Testimoni berhasil ditambahkan.');
    }

    public function edit(Testimonial $testimonial)
    {
        $this->authorizePermission('testimonials_edit');
        return view('testimonials.edit', compact('testimonial'));
    }

    public function update(TestimonialRequest $request, Testimonial $testimonial)
    {
        $this->authorizePermission('testimonials_edit');

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'testimonials', $testimonial->image);
        }

        $testimonial->update($data);
        return redirect()->route('testimonials.index')->with('success', 'Testimoni berhasil diperbarui.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $this->authorizePermission('testimonials_delete');
        $this->deleteFile($testimonial->image);
        $testimonial->delete();
        return redirect()->route('testimonials.index')->with('success', 'Testimoni berhasil dihapus.');
    }
}
