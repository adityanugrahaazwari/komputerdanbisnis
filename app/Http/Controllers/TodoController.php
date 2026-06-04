<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|string|max:255',
        ]);

        Todo::create([
            'user_id' => auth()->id(),
            'task' => $request->task,
            'is_completed' => false,
            'order' => Todo::where('user_id', auth()->id())->count() + 1,
        ]);

        return back()->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function toggle(Todo $todo)
    {
        if ($todo->user_id !== auth()->id()) {
            abort(403);
        }

        $todo->update(['is_completed' => !$todo->is_completed]);
        return back();
    }

    public function destroy(Todo $todo)
    {
        if ($todo->user_id !== auth()->id()) {
            abort(403);
        }

        $todo->delete();
        return back()->with('success', 'Tugas berhasil dihapus.');
    }
}
