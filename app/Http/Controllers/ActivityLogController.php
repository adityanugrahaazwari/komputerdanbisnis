<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $this->authorizePermission('logs_view');
        $logs = ActivityLog::with('user')->latest()->paginate(20);
        return view('logs.index', compact('logs'));
    }
}
