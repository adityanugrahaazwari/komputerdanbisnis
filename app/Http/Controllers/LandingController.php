<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\StudyProgram;
use App\Models\Post;
use App\Models\SocialMedia;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Fetch all profile sections and key them by their 'key' for easy access
        $profiles = Profile::all()->keyBy('key');
        
        // Fetch active study programs
        $studyPrograms = StudyProgram::where('is_active', true)->get();
        
        // Fetch 3 latest published news posts
        $latestPosts = Post::where('status', 'published')
            ->with('user')
            ->latest()
            ->take(3)
            ->get();

        // Fetch active social media
        $socialMedia = SocialMedia::where('is_active', true)->orderBy('order')->get();

        return view('welcome', compact('profiles', 'studyPrograms', 'latestPosts', 'socialMedia'));
    }

    public function showPost($slug)
    {
        $post = Post::where('slug', $slug)->where('status', 'published')->firstOrFail();
        $socialMedia = SocialMedia::where('is_active', true)->orderBy('order')->get();
        return view('post-detail', compact('post', 'socialMedia'));
    }

    public function allPosts()
    {
        $posts = Post::where('status', 'published')
            ->with('user')
            ->latest()
            ->paginate(9);
        
        $socialMedia = SocialMedia::where('is_active', true)->orderBy('order')->get();
        
        return view('news-index', compact('posts', 'socialMedia'));
    }
}
