<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Public: Store comment
    public function store(CommentRequest $request, Post $post)
    {
        $validated = $request->validated();

        $post->comments()->create([
            'user_name' => $validated['user_name'],
            'user_email' => $validated['user_email'],
            'comment' => $validated['comment'],
            'status' => 'pending' // Default to pending for moderation
        ]);

        return redirect()->back()->with('success', 'Komentar Anda telah terkirim dan menunggu moderasi.');
    }

    // Admin: List comments for moderation
    public function index()
    {
        $this->authorizePermission('comments_view');
        $comments = Comment::with('post')->latest()->paginate(15);
        return view('comments.index', compact('comments'));
    }

    // Admin: Show comment detail
    public function show(Comment $comment)
    {
        $this->authorizePermission('comments_view');
        $comment->load('post');
        return view('comments.show', compact('comment'));
    }

    // Admin: Approve comment
    public function approve(Comment $comment)
    {
        $this->authorizePermission('comments_approve');
        $comment->update(['status' => 'approved']);
        return redirect()->route('comments.index')->with('success', 'Comment approved.');
    }

    // Admin: Reject/Spam comment
    public function reject(Comment $comment)
    {
        $this->authorizePermission('comments_reject');
        $comment->update(['status' => 'spam']);
        return redirect()->route('comments.index')->with('success', 'Comment marked as spam.');
    }

    // Admin: Delete comment
    public function destroy(Comment $comment)
    {
        $this->authorizePermission('comments_delete');
        $comment->delete();
        return redirect()->back()->with('success', 'Comment deleted.');
    }
}
