<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Document;
use App\Models\StudyProgram;
use App\Models\SocialMedia;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $results = [
            'posts' => collect(),
            'documents' => collect(),
            'study_programs' => collect(),
        ];

        if ($query) {
            $results['posts'] = Post::where('status', 'published')
                ->where(function($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('content', 'like', "%{$query}%");
                })
                ->latest()
                ->get();

            $results['documents'] = Document::where('is_active', true)
                ->where(function($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%");
                })
                ->get();

            $results['study_programs'] = StudyProgram::where('is_active', true)
                ->where(function($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%");
                })
                ->get();
        }

        $totalCount = $results['posts']->count() + $results['documents']->count() + $results['study_programs']->count();
        $socialMedia = SocialMedia::where('is_active', true)->orderBy('order')->get();

        return view('search-results', compact('results', 'query', 'totalCount', 'socialMedia'));
    }
}
