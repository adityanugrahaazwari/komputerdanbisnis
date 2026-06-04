<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostSubmission;
use App\Http\Requests\PostRequest;
use App\Traits\UploadsFiles;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    use LogsActivity, UploadsFiles;

    public function index(Request $request)
    {
        $this->authorizePermission('posts_view');
        
        $query = Post::with(['user', 'category'])->latest();
        
        if (!auth()->user()->can('posts_publish')) {
            $query->where('user_id', auth()->id());
        }

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $posts = $query->paginate(10)->withQueryString();
        $categories = \App\Models\Category::all();

        return view('posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $this->authorizePermission('posts_create');
        $categories = \App\Models\Category::all();
        return view('posts.create', compact('categories'));
    }

    public function store(PostRequest $request)
    {
        $this->authorizePermission('posts_create');
        
        $data = $request->only(['title', 'content', 'status', 'category_id', 'meta_description', 'meta_keywords']);
        $data['content'] = clean($request->content);
        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'posts');
        }

        $post = Post::create($data);

        // Record submission log
        PostSubmission::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'status' => $post->status,
            'notes' => $request->notes ?? 'Initial submission'
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        $this->authorizePermission('posts_view');
        $post->load('submissions.user');
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $this->authorizePermission('posts_edit');
        
        if (!auth()->user()->can('posts_publish') && $post->user_id !== auth()->id()) {
            abort(403);
        }

        $categories = \App\Models\Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $this->authorizePermission('posts_edit');
        
        if (!auth()->user()->can('posts_publish') && $post->user_id !== auth()->id()) {
            abort(403);
        }

        $oldStatus = $post->status;
        $data = $request->only(['title', 'content', 'status', 'category_id', 'meta_description', 'meta_keywords']);
        $data['content'] = clean($request->content);
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'posts', $post->image);
        }

        $post->update($data);

        // Record log if status changed or notes provided
        if ($oldStatus !== $post->status || $request->filled('notes')) {
            PostSubmission::create([
                'post_id' => $post->id,
                'user_id' => auth()->id(),
                'status' => $post->status,
                'notes' => $request->notes ?? 'Status updated'
            ]);
        }

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $this->authorizePermission('posts_delete');
        
        if (!auth()->user()->can('posts_publish') && $post->user_id !== auth()->id()) {
            abort(403);
        }

        $this->deleteFile($post->image);
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
