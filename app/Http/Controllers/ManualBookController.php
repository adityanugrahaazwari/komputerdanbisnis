<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManualBookController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('manual_book_view')) {
            abort(403);
        }
        return view('manual_book.index');
    }
}
