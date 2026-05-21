<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    use \App\Traits\LogsActivity;

    public function index()
    {
        $this->authorizePermission('posts_view');
        
        $query = Post::with(['user', 'category'])->latest();
        
        if (!auth()->user()->can('posts_publish')) {
            $query->where('user_id', auth()->id());
        }

        $posts = $query->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $this->authorizePermission('posts_create');
        $categories = \App\Models\Category::all();
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->authorizePermission('posts_create');
        
        $allowedStatuses = ['draft', 'pending'];
        if (auth()->user()->can('posts_publish')) {
            $allowedStatuses[] = 'published';
            $allowedStatuses[] = 'rejected';
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:' . implode(',', $allowedStatuses),
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000'
        ]);

        $data = $request->only(['title', 'content', 'status', 'category_id', 'meta_description', 'meta_keywords']);
        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create($data);

        $this->logActivity('create', $post, 'Created post: ' . $post->title);

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

    public function update(Request $request, Post $post)
    {
        $this->authorizePermission('posts_edit');
        
        if (!auth()->user()->can('posts_publish') && $post->user_id !== auth()->id()) {
            abort(403);
        }

        $allowedStatuses = ['draft', 'pending'];
        if (auth()->user()->can('posts_publish')) {
            $allowedStatuses[] = 'published';
            $allowedStatuses[] = 'rejected';
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:' . implode(',', $allowedStatuses),
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000'
        ]);

        $oldStatus = $post->status;
        $data = $request->only(['title', 'content', 'status', 'category_id', 'meta_description', 'meta_keywords']);
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($data);

        $this->logActivity('update', $post, 'Updated post: ' . $post->title);

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

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }

    protected function authorizePermission($permission)
    {
        if (!auth()->user()->can($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }
}
