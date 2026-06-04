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
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'posts_published' => Post::where('status', 'published')->count(),
            'posts_pending' => Post::where('status', 'pending')->count(),
            'posts_this_month' => Post::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
            'posts_total' => Post::count(),
            'study_programs' => StudyProgram::count(),
            'comments_pending' => Comment::where('status', 'pending')->count(),
            'comments_total' => Comment::count(),
            'contacts_unread' => Contact::where('is_read', false)->count(),
            'contacts_total' => Contact::count(),
            'galleries' => Gallery::count(),
            'documents' => Document::count(),
            'lecturers' => \App\Models\Lecturer::count(),
            'events' => \App\Models\Event::count(),
            'visitors_total' => Visitor::count(),
            'visitors_today' => Visitor::where('visit_date', now()->toDateString())->count(),
        ];

        $chartData = $this->getVisitorChartData('daily');

        $recentPosts = Post::with('user')->latest()->take(5)->get();
        $recentComments = Comment::with('post')->latest()->take(5)->get();
        $recentContacts = Contact::latest()->take(5)->get();
        $recentLogs = ActivityLog::with('user')->latest()->take(10)->get();
        $announcements = Announcement::active()->forUser(auth()->user())->latest()->take(5)->get();
        
        $popularPosts = Post::orderBy('views', 'desc')->take(5)->get();
        $upcomingEvents = \App\Models\Event::where('start_date', '>=', now())->orderBy('start_date', 'asc')->take(5)->get();
        $myTodos = \App\Models\Todo::where('user_id', auth()->id())->orderBy('is_completed')->orderBy('order')->latest()->get();

        $serverInfo = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'disk_free' => $this->formatBytes(disk_free_space(base_path())),
            'disk_total' => $this->formatBytes(disk_total_space(base_path())),
            'disk_usage_percent' => round((1 - (disk_free_space(base_path()) / disk_total_space(base_path()))) * 100),
        ];

        $role = auth()->user()->roles->first();
        $settings = $role ? $role->dashboardSetting : null;

        return view('dashboard', compact('stats', 'recentPosts', 'recentComments', 'recentContacts', 'recentLogs', 'announcements', 'settings', 'chartData', 'popularPosts', 'upcomingEvents', 'myTodos', 'serverInfo'));
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    public function chartData(Request $request)
    {
        $range = $request->get('range', 'daily');
        return response()->json($this->getVisitorChartData($range));
    }

    private function getVisitorChartData($range)
    {
        $query = Visitor::query();

        switch ($range) {
            case 'weekly':
                // Group by week (last 12 weeks)
                $stats = $query->select(
                        DB::raw("DATE_FORMAT(visit_date, '%x-%v') as label_key"),
                        DB::raw("MIN(visit_date) as min_date"),
                        DB::raw('count(*) as total')
                    )
                    ->where('visit_date', '>=', now()->subWeeks(12)->toDateString())
                    ->groupBy('label_key')
                    ->orderBy('label_key')
                    ->get();
                
                $labels = $stats->map(fn($item) => 'Minggu ' . date('W', strtotime($item->min_date)));
                break;

            case 'monthly':
                // Group by month (last 12 months)
                $stats = $query->select(
                        DB::raw("DATE_FORMAT(visit_date, '%Y-%m') as label_key"),
                        DB::raw('count(*) as total')
                    )
                    ->where('visit_date', '>=', now()->subMonths(12)->startOfMonth()->toDateString())
                    ->groupBy('label_key')
                    ->orderBy('label_key')
                    ->get();
                
                $labels = $stats->map(fn($item) => date('M Y', strtotime($item->label_key . '-01')));
                break;

            case 'yearly':
                // Group by year
                $stats = $query->select(
                        DB::raw("DATE_FORMAT(visit_date, '%Y') as label_key"),
                        DB::raw('count(*) as total')
                    )
                    ->groupBy('label_key')
                    ->orderBy('label_key')
                    ->get();
                
                $labels = $stats->pluck('label_key');
                break;

            case 'daily':
            default:
                // Group by date (last 30 days)
                $stats = $query->select('visit_date as label_key', DB::raw('count(*) as total'))
                    ->where('visit_date', '>=', now()->subDays(30)->toDateString())
                    ->groupBy('visit_date')
                    ->orderBy('visit_date')
                    ->get();
                
                $labels = $stats->map(fn($item) => date('d M', strtotime($item->label_key)));
                break;
        }

        return [
            'labels' => $labels,
            'data' => $stats->pluck('total'),
        ];
    }
}
