<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\StudyProgram;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\ActivityLog;
use App\Models\Gallery;
use App\Models\Document;
use App\Models\Announcement;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'posts_published' => Post::where('status', 'published')->count(),
            'posts_pending' => Post::where('status', 'pending')->count(),
            'study_programs' => StudyProgram::count(),
            'comments_pending' => Comment::where('status', 'pending')->count(),
            'contacts_unread' => Contact::where('is_read', false)->count(),
            'galleries' => Gallery::count(),
            'documents' => Document::count(),
        ];

        $recentPosts = Post::with('user')->latest()->take(5)->get();
        $recentComments = Comment::with('post')->latest()->take(5)->get();
        $recentContacts = Contact::latest()->take(5)->get();
        $recentLogs = ActivityLog::with('user')->latest()->take(10)->get();
        $announcements = Announcement::where('is_active', true)->latest()->take(3)->get();
        
        $role = auth()->user()->roles->first();
        $settings = $role ? $role->dashboardSetting : null;

        return view('dashboard', compact('stats', 'recentPosts', 'recentComments', 'recentContacts', 'recentLogs', 'announcements', 'settings'));
    }
}
