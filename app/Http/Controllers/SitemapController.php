<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\StudyProgram;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 'published')->latest()->get();
        $studyPrograms = StudyProgram::where('is_active', true)->get();
        
        return response()->view('sitemap', compact('posts', 'studyPrograms'))
            ->header('Content-Type', 'text/xml');
    }
}
