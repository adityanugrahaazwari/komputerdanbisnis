<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\StudyProgram;
use App\Models\Post;
use App\Models\SocialMedia;
use App\Models\OrganizationalStructure;
use App\Models\Service;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Fetch all profile sections and key them by their 'key' for easy access
        $profiles = Profile::all()->keyBy('key');
        
        // Fetch active study programs
        $studyPrograms = StudyProgram::where('is_active', true)->get();
        
        // Fetch hierarchical organizational structure
        $structures = OrganizationalStructure::whereNull('parent_id')
            ->with('children')
            ->orderBy('order')
            ->get();

        // Fetch active external services
        $services = Service::where('is_active', true)->orderBy('order')->get();
        
        // Fetch 3 latest published news posts
        $latestPosts = Post::where('status', 'published')
            ->with('user')
            ->latest()
            ->take(3)
            ->get();

        // Fetch active social media
        $socialMedia = SocialMedia::where('is_active', true)->orderBy('order')->get();

        return view('welcome', compact('profiles', 'studyPrograms', 'structures', 'services', 'latestPosts', 'socialMedia'));
    }

    public function profile()
    {
        $profiles = Profile::all()->keyBy('key');
        $structures = OrganizationalStructure::whereNull('parent_id')
            ->with('children')
            ->orderBy('order')
            ->get();
        $socialMedia = SocialMedia::where('is_active', true)->orderBy('order')->get();

        return view('profile', compact('profiles', 'structures', 'socialMedia'));
    }

    public function studyPrograms()
    {
        $studyPrograms = StudyProgram::where('is_active', true)->get();
        $socialMedia = SocialMedia::where('is_active', true)->orderBy('order')->get();
        return view('study-programs-landing', compact('studyPrograms', 'socialMedia'));
    }

    public function services()
    {
        $services = Service::where('is_active', true)->orderBy('order')->get();
        $socialMedia = SocialMedia::where('is_active', true)->orderBy('order')->get();
        return view('services-landing', compact('services', 'socialMedia'));
    }

    public function showPost($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->with(['user', 'category', 'approvedComments'])
            ->firstOrFail();
            
        $socialMedia = SocialMedia::where('is_active', true)->orderBy('order')->get();
        return view('post-detail', compact('post', 'socialMedia'));
    }

    public function allPosts(Request $request)
    {
        $query = Post::where('status', 'published')
            ->with(['user', 'category'])
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $posts = $query->paginate(9)->withQueryString();
        
        $categories = \App\Models\Category::all();
        $socialMedia = SocialMedia::where('is_active', true)->orderBy('order')->get();
        
        return view('news-index', compact('posts', 'socialMedia', 'categories'));
    }

    public function gallery()
    {
        $galleries = \App\Models\Gallery::where('is_active', true)->orderBy('order')->paginate(12);
        $socialMedia = SocialMedia::where('is_active', true)->orderBy('order')->get();
        return view('gallery-index', compact('galleries', 'socialMedia'));
    }

    public function downloads()
    {
        $documents = \App\Models\Document::where('is_active', true)->latest()->get()->groupBy('category');
        $socialMedia = SocialMedia::where('is_active', true)->orderBy('order')->get();
        return view('downloads-index', compact('documents', 'socialMedia'));
    }
}
