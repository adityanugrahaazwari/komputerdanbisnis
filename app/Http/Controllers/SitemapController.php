<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 'published')->latest()->get();
        
        return response()->view('sitemap', compact('posts'))
            ->header('Content-Type', 'text/xml');
    }
}
