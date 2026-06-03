<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\StudyProgram;
use App\Models\Post;
use App\Models\SocialMedia;
use App\Models\OrganizationalStructure;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Visitor;
use App\Models\Announcement;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Fetch all profile sections and key them by their 'key' for easy access
        $profiles = Profile::all()->keyBy('key');
        
        // Fetch active study programs
        $studyPrograms = StudyProgram::active()->get();
        
        // Fetch hierarchical organizational structure
        $structures = OrganizationalStructure::whereNull('parent_id')
            ->with('children')
            ->ordered()
            ->get();

        // Fetch active external services
        $services = Service::active()->ordered()->get();
        
        // Fetch 3 latest published news posts
        $latestPosts = Post::where('status', 'published')
            ->with('user')
            ->latest()
            ->take(3)
            ->get();

        // Fetch active social media
        $socialMedia = SocialMedia::active()->ordered()->get();

        // Fetch active testimonials
        $testimonials = Testimonial::active()->ordered()->get();

        // Fetch active announcements
        $announcements = Announcement::active()->latest()->get();

        // Fetch some lecturers for landing page
        $lecturers = \App\Models\Lecturer::active()->with('studyProgram')->ordered()->take(8)->get();

        // Fetch total unique visitor count
        $visitorCount = Visitor::count();

        return view('welcome', compact('profiles', 'studyPrograms', 'structures', 'services', 'latestPosts', 'socialMedia', 'testimonials', 'visitorCount', 'lecturers', 'announcements'));
    }

    public function profile()
    {
        $profiles = Profile::all()->keyBy('key');
        $structures = OrganizationalStructure::whereNull('parent_id')
            ->with('children')
            ->ordered()
            ->get();
        $socialMedia = SocialMedia::active()->ordered()->get();

        $seoTitle = 'Profil Jurusan - JKB POLITALA';
        $seoDescription = 'Mengenal lebih dalam sejarah, visi, misi, dan struktur kepemimpinan Jurusan Komputer dan Bisnis Politala.';

        return view('profile', compact('profiles', 'structures', 'socialMedia', 'seoTitle', 'seoDescription'));
    }

    public function studyPrograms()
    {
        $studyPrograms = StudyProgram::active()->get();
        $socialMedia = SocialMedia::active()->ordered()->get();
        
        $seoTitle = 'Program Studi - JKB POLITALA';
        $seoDescription = 'Daftar program studi unggulan di Jurusan Komputer dan Bisnis Politeknik Negeri Tanah Laut.';
        
        return view('study-programs-landing', compact('studyPrograms', 'socialMedia', 'seoTitle', 'seoDescription'));
    }

    public function services()
    {
        $services = Service::active()->ordered()->get();
        $socialMedia = SocialMedia::active()->ordered()->get();
        
        $seoTitle = 'Layanan Eksternal - JKB POLITALA';
        $seoDescription = 'Berbagai layanan eksternal dan aplikasi pendukung yang disediakan oleh Jurusan Komputer dan Bisnis.';

        return view('services-landing', compact('services', 'socialMedia', 'seoTitle', 'seoDescription'));
    }

    public function showPost($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->with(['user', 'category', 'approvedComments'])
            ->firstOrFail();
            
        $socialMedia = SocialMedia::active()->ordered()->get();
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
        $socialMedia = SocialMedia::active()->ordered()->get();
        
        $seoTitle = 'Berita & Artikel - JKB POLITALA';
        $seoDescription = 'Dapatkan informasi terbaru mengenai kegiatan, prestasi, dan pengumuman di Jurusan Komputer dan Bisnis.';

        return view('news-index', compact('posts', 'socialMedia', 'categories', 'seoTitle', 'seoDescription'));
    }

    public function gallery()
    {
        $galleryGroups = \App\Models\GalleryGroup::active()
            ->with(['galleries' => function($q) {
                $q->active()->ordered();
            }])
            ->get();
            
        $ungroupedGalleries = \App\Models\Gallery::active()
            ->whereNull('gallery_group_id')
            ->ordered()
            ->paginate(12);

        $socialMedia = SocialMedia::active()->ordered()->get();
        
        $seoTitle = 'Galeri Foto - JKB POLITALA';
        $seoDescription = 'Koleksi dokumentasi kegiatan, fasilitas, dan momen berharga di Jurusan Komputer dan Bisnis.';

        return view('gallery-index', compact('galleryGroups', 'ungroupedGalleries', 'socialMedia', 'seoTitle', 'seoDescription'));
    }

    public function downloads()
    {
        $documents = \App\Models\Document::active()->latest()->get()->groupBy('category');
        $socialMedia = SocialMedia::active()->ordered()->get();
        
        $seoTitle = 'Pusat Unduhan - JKB POLITALA';
        $seoDescription = 'Unduh berbagai dokumen penting, formulir, kurikulum, dan materi pembelajaran di sini.';

        return view('downloads-index', compact('documents', 'socialMedia', 'seoTitle', 'seoDescription'));
    }

    public function lecturers(Request $request)
    {
        $query = \App\Models\Lecturer::active()->with('studyProgram')->ordered();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('expertise', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%");
            });
        }

        if ($request->filled('prodi')) {
            $query->whereHas('studyProgram', function($q) use ($request) {
                $q->where('slug', $request->prodi);
            });
        }

        $lecturers = $query->paginate(12)->withQueryString();
        $studyPrograms = StudyProgram::all();
        $socialMedia = SocialMedia::active()->ordered()->get();

        $seoTitle = 'Direktori Dosen & Staf - JKB POLITALA';
        $seoDescription = 'Daftar pengajar dan staf profesional di lingkungan Jurusan Komputer dan Bisnis Politala.';

        return view('lecturer-index', compact('lecturers', 'studyPrograms', 'socialMedia', 'seoTitle', 'seoDescription'));
    }

    public function calendar()
    {
        $events = \App\Models\Event::active()->orderBy('start_date')->get();
        $socialMedia = SocialMedia::active()->ordered()->get();
        
        $seoTitle = 'Kalender Akademik & Agenda - JKB POLITALA';
        $seoDescription = 'Pantau jadwal kegiatan akademik, seminar, webinar, dan event penting lainnya di JKB Politala.';

        return view('calendar-index', compact('events', 'socialMedia', 'seoTitle', 'seoDescription'));
    }
}
