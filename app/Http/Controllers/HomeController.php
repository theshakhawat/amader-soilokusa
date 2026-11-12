<?php

namespace App\Http\Controllers;

use App\Models\AboutSection;
use App\Models\Committee;
use App\Models\CommitteeMember;
use App\Models\DonationSetting;
use App\Models\Event;
use App\Models\GalleryItem;
use App\Models\HeroBanner;
use App\Models\Notice;
use App\Models\PresidentMessage;
use App\Models\Pride;
use App\Models\Place;
use App\Models\Category;
use App\Models\Post;
use App\Models\Project;
use App\Models\StatCounter;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $heroBanners = HeroBanner::where('status', true)->orderBy('order')->get();
        $statCounters = StatCounter::where('status', true)->orderBy('order')->get();
        $about = AboutSection::first();
        $president = PresidentMessage::first();
        $events = Event::whereIn('status', ['active', 'upcoming', 'ongoing'])
            ->orderBy('order_index', 'asc')
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->take(3)
            ->get();

        $notices = Notice::whereIn('status', ['active', 'pinned'])
            ->orderByRaw("CASE WHEN status = 'pinned' THEN 0 ELSE 1 END")
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();

        $donation = DonationSetting::first();
        $latestPosts = Post::with('category')
            ->where('status', true)
            ->orderBy('published', 'desc')
            ->orderBy('id', 'desc')
            ->take(3)
            ->get();
        $prides = Pride::where('status', true)
            ->orderBy('order_index', 'asc')
            ->orderBy('id', 'asc')
            ->take(4)
            ->get();

        $heroSlidesData = $heroBanners->map(function ($banner) {
            return [
                'title' => $banner->title,
                'subtitle' => $banner->subtitle ?? '',
                'primaryBtn' => $banner->primary_button_text,
                'primaryTarget' => $banner->primary_button_link ?? '#about-section',
                'secondaryBtn' => $banner->secondary_button_text ?? 'ভিডিও দেখুন',
                'secondaryTarget' => $banner->secondary_button_link ?? '#',
                'badge' => $banner->badge ?? '',
                'image' => $banner->image_url,
            ];
        })->values()->all();

        $committee = Committee::where('is_active', true)
            ->orderBy('order', 'asc')
            ->orderBy('id', 'desc')
            ->first();

        return view('home', compact('heroBanners', 'statCounters', 'heroSlidesData', 'about', 'president', 'events', 'notices', 'prides', 'donation', 'latestPosts', 'committee'));
    }

    /**
     * Show the detailed About Us public page.
     */
    public function aboutUs(): View
    {
        $about = AboutSection::firstOrCreate([], [
            'title' => 'আমাদের সম্পর্কে',
            'subtitle' => 'ঐতিহ্য, উন্নয়ন ও মানবিক শৈলকুপা',
            'short_description' => 'আগামীর শৈলকুপা একটি অরাজনৈতিক সামাজিক উদ্যোগ, যা শৈলকুপার সার্বিক উন্নয়ন, শিক্ষা, স্বাস্থ্য, সামাজিক কল্যাণ ও ঐতিহ্য সংরক্ষণে কাজ করে যাচ্ছে।',
            'description' => '<p><strong>আগামীর শৈলকুপা</strong> একটি সম্পূর্ণ অরাজনৈতিক, জনকল্যাণমুখী ও স্বেচ্ছাসেবী সামাজিক সংগঠন।</p>',
            'button_text' => 'বিস্তারিত পড়ুন',
        ]);

        return view('pages.about', compact('about'));
    }

    /**
     * Show the detailed President / Chairman Message public page.
     */
    public function chairmanMessage(): View
    {
        $president = PresidentMessage::firstOrCreate([], [
            'title' => 'সভাপতির বাণী',
            'name' => 'মোঃ আব্দুল করিম',
            'designation' => 'সভাপতি, আগামীর শৈলকুপা',
            'quote' => 'শৈলকুপাকে একটি আধুনিক, শিক্ষিত, সমৃদ্ধ ও মানবিক জনপদে রূপ দিতে আমরা সবাই একসাথে কাজ করছি।',
            'message' => '<p>একটি সুন্দর, আলোকিত ও টেকসই আগামী গড়ার দৃঢ় প্রত্যয় নিয়ে আমরা <strong>আগামীর শৈলকুপা</strong> সামাজিক প্ল্যাটফর্মটির সূচনা করেছি।</p>',
        ]);

        return view('pages.president', compact('president'));
    }

    /**
     * Show all events page (কার্যক্রম ও ইভেন্ট তালিকা).
     */
    public function eventsIndex(Request $request): View
    {
        $today = now()->startOfDay()->toDateString();

        $query = Event::with('photos')->where('status', '!=', 'inactive');

        if ($request->filled('type')) {
            if ($request->type === 'upcoming') {
                $query->where(function ($q) use ($today) {
                    $q->where('status', 'upcoming')
                      ->orWhere(function ($sub) use ($today) {
                          $sub->whereIn('status', ['active'])
                              ->where('date', '>=', $today);
                      });
                });
            } elseif ($request->type === 'past') {
                $query->where(function ($q) use ($today) {
                    $q->where('status', 'completed')
                      ->orWhere(function ($sub) use ($today) {
                          $sub->where('date', '<', $today);
                      });
                });
            }
        }

        // Order for cursor paginate: must order by unique deterministic column (e.g. id)
        $events = $query->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->cursorPaginate(9)
            ->withQueryString();

        return view('pages.events-index', compact('events'));
    }

    /**
     * Show the detailed Event public page.
     */
    public function eventDetails(Event $event): View
    {
        $event->load('photos');
        $recentEvents = Event::where('id', '!=', $event->id)
            ->whereIn('status', ['active', 'upcoming', 'ongoing'])
            ->orderBy('date', 'desc')
            ->take(4)
            ->get();

        return view('pages.event-details', compact('event', 'recentEvents'));
    }

    /**
     * Show all notices page.
     */
    public function noticesIndex(): View
    {
        $notices = Notice::with('files')
            ->whereIn('status', ['active', 'pinned'])
            ->orderByRaw("CASE WHEN status = 'pinned' THEN 0 ELSE 1 END")
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('pages.notices-index', compact('notices'));
    }

    /**
     * Show single notice details page.
     */
    public function noticeDetails(Notice $notice): View
    {
        $notice->load('files');
        $recentNotices = Notice::where('id', '!=', $notice->id)
            ->whereIn('status', ['active', 'pinned'])
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();

        return view('pages.notice-details', compact('notice', 'recentNotices'));
    }

    /**
     * Show Our Pride (কৃতি সন্তান) public page.
     */
    public function ourPride(): View
    {
        // First order person (order_index = 1 or top ordered active)
        $topPride = Pride::where('status', true)->orderBy('order_index', 'asc')->orderBy('id', 'asc')->first();

        // Remaining prides
        $otherPrides = Pride::where('status', true)
            ->when($topPride, function ($q) use ($topPride) {
                $q->where('id', '!=', $topPride->id);
            })
            ->orderBy('order_index', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return view('pages.our-pride', compact('topPride', 'otherPrides'));
    }

    /**
     * Show single Pride details page.
     */
    public function prideDetails(Pride $pride): View
    {
        $recentPrides = Pride::where('id', '!=', $pride->id)
            ->where('status', true)
            ->orderBy('order_index', 'asc')
            ->orderBy('id', 'asc')
            ->take(6)
            ->get();

        return view('pages.pride-details', compact('pride', 'recentPrides'));
    }

    /**
     * Show Public Gallery page (/gallery).
     */
    public function gallery(Request $request): View
    {
        $activeTab = $request->query('tab', 'photo');
        if (!in_array($activeTab, ['photo', 'video'])) {
            $activeTab = 'photo';
        }

        $photos = GalleryItem::where('type', 'photo')
            ->where('status', true)
            ->orderBy('order_index', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        $videos = GalleryItem::where('type', 'video')
            ->where('status', true)
            ->orderBy('order_index', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        return view('pages.gallery', compact('photos', 'videos', 'activeTab'));
    }

    /**
     * Show Public Projects list page (/projects).
     */
    public function projectsIndex(Request $request): View
    {
        $statusFilter = $request->query('status'); // all, running, completed, upcoming

        $query = Project::where('status', true)->with('photos');

        if ($statusFilter && in_array($statusFilter, ['running', 'completed', 'upcoming'])) {
            $query->where('project_status', $statusFilter);
        }

        $projects = $query->orderBy('order_index', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(12)
            ->withQueryString();

        $runningCount = Project::where('status', true)->where('project_status', 'running')->count();
        $completedCount = Project::where('status', true)->where('project_status', 'completed')->count();
        $totalCount = Project::where('status', true)->count();

        return view('pages.projects', compact('projects', 'statusFilter', 'runningCount', 'completedCount', 'totalCount'));
    }

    /**
     * Show Public Project Details page (/projects/{project}).
     */
    public function projectDetails(Project $project): View
    {
        if (!$project->status) {
            abort(404);
        }

        $project->load('photos');

        $otherProjects = Project::where('status', true)
            ->where('id', '!=', $project->id)
            ->orderBy('order_index', 'asc')
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();

        return view('pages.project-details', compact('project', 'otherProjects'));
    }

    /**
     * Show Public Places list page (/places).
     */
    public function placesIndex(Request $request): View
    {
        $places = Place::where('status', true)
            ->with('photos')
            ->orderBy('order_index', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(12)
            ->withQueryString();

        $totalCount = Place::where('status', true)->count();

        return view('pages.places', compact('places', 'totalCount'));
    }

    /**
     * Show Public Place Details page (/places/{place}).
     */
    public function placeDetails(Place $place): View
    {
        if (!$place->status) {
            abort(404);
        }

        $place->load('photos');

        $otherPlaces = Place::where('status', true)
            ->where('id', '!=', $place->id)
            ->orderBy('order_index', 'asc')
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();

        return view('pages.place-details', compact('place', 'otherPlaces'));
    }

    /**
     * Show Public Blogs list page (/blogs).
     */
    public function blogsIndex(Request $request): View
    {
        $query = Post::with('category')->where('status', true);

        if ($request->filled('category')) {
            $catSlug = $request->category;
            $query->whereHas('category', function ($q) use ($catSlug) {
                $q->where('slug', $catSlug);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->orderBy('published', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(9)
            ->withQueryString();

        $categories = Category::where('status', true)->withCount(['posts' => function ($q) {
            $q->where('status', true);
        }])->get();

        $recentPosts = Post::where('status', true)
            ->orderBy('published', 'desc')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        return view('pages.blogs', compact('posts', 'categories', 'recentPosts'));
    }

    /**
     * Show Public Blog Details page (/blogs/{slug}).
     */
    public function blogDetails(string $slug): View
    {
        $post = Post::with('category')->where('slug', $slug)->firstOrFail();

        if (!$post->status) {
            abort(404);
        }

        $relatedPosts = Post::with('category')
            ->where('status', true)
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->orderBy('published', 'desc')
            ->take(4)
            ->get();

        if ($relatedPosts->isEmpty()) {
            $relatedPosts = Post::with('category')
                ->where('status', true)
                ->where('id', '!=', $post->id)
                ->orderBy('published', 'desc')
                ->take(4)
                ->get();
        }

        $categories = Category::where('status', true)->withCount(['posts' => function ($q) {
            $q->where('status', true);
        }])->get();

        return view('pages.blog-details', compact('post', 'relatedPosts', 'categories'));
    }

    /**
     * Public Committee Listing Page
     */
    public function committeeIndex(): View
    {
        $activeCommittee = Committee::where('is_active', true)
            ->orderBy('order', 'asc')
            ->orderBy('id', 'desc')
            ->first();

        $membersQuery = CommitteeMember::where('status', true);
        if ($activeCommittee) {
            $membersQuery->where(function ($q) use ($activeCommittee) {
                $q->where('committee_id', $activeCommittee->id)
                  ->orWhereNull('committee_id');
            });
        }

        $allMembers = $membersQuery->orderBy('order', 'asc')->orderBy('id', 'asc')->get();

        // Row 1: সভাপতি (Order = 1)
        $president = $allMembers->firstWhere('order', 1);

        // Row 2: দুই জন (Order = 2 এবং 3)
        $secondRowMembers = $allMembers->filter(function ($m) {
            return $m->order == 2 || $m->order == 3;
        })->values();

        // Row 3+: বাকি সদস্যরা (Order 4 বা তার বেশি)
        $otherMembers = $allMembers->filter(function ($m) use ($president, $secondRowMembers) {
            if ($president && $m->id === $president->id) return false;
            if ($secondRowMembers->contains('id', $m->id)) return false;
            return true;
        })->values();

        return view('pages.committee', compact('activeCommittee', 'president', 'secondRowMembers', 'otherMembers'));
    }
}