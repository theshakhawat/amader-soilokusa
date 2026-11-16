<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Committee;
use App\Models\CommitteeMember;
use App\Models\ContactMessage;
use App\Models\Donation;
use App\Models\Event;
use App\Models\GalleryItem;
use App\Models\Institution;
use App\Models\Member;
use App\Models\Notice;
use App\Models\Office;
use App\Models\Place;
use App\Models\Post;
use App\Models\Pride;
use App\Models\Project;
use App\Models\Union;
use App\Models\User;
use App\Models\Volunteer;
use App\Services\CacheService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dynamic admin dashboard.
     */
    public function index(): View
    {
        // 1. Primary Metrics (Cached with 300s TTL, auto-invalidated on model updates)
        $cachedDashboard = Cache::remember(CacheService::KEY_ADMIN_DASHBOARD, 300, function () {
            $stats = [
                // Members
                'total_members'    => Member::count(),
                'active_members'   => Member::where('status', true)->count(),
                'pending_members'  => Member::where('status', false)->count(),

                // Volunteers
                'total_volunteers'   => Volunteer::count(),
                'active_volunteers'  => Volunteer::where('status', true)->count(),
                'pending_volunteers' => Volunteer::where('status', false)->count(),

                // Donations
                'total_donations'       => (float) Donation::where('status', 'success')->sum('amount'),
                'this_month_donations'  => (float) Donation::where('status', 'success')
                                            ->whereMonth('created_at', now()->month)
                                            ->whereYear('created_at', now()->year)
                                            ->sum('amount'),
                'donations_count'       => Donation::where('status', 'success')->count(),

                // Projects
                'total_projects'     => Project::count(),
                'running_projects'   => Project::where('project_status', 'running')->count(),
                'completed_projects' => Project::where('project_status', 'completed')->count(),

                // Notices
                'total_notices'   => Notice::count(),
                'active_notices'  => Notice::where('status', 'active')->count(),

                // Events
                'total_events'    => Event::count(),
                'active_events'   => Event::where('status', 'active')->count(),

                // Committees & Members
                'total_committee_members' => CommitteeMember::count(),
                'total_committees'        => Committee::count(),

                // Media & Blog
                'total_gallery_items' => GalleryItem::count(),
                'total_posts'         => Post::count(),

                // Messages
                'total_messages'  => ContactMessage::count(),
                'unread_messages' => ContactMessage::where('is_read', false)->count(),

                // Regional & Info
                'total_pages'        => \App\Models\Page::count(),
                'total_institutions' => Institution::count(),
                'total_offices'      => Office::count(),
                'total_unions'       => Union::count(),
                'total_prides'       => Pride::count(),
                'total_places'       => Place::count(),

                // Users
                'total_users'  => User::count(),
                'active_users' => User::where('status', 'active')->count(),
            ];

            // 2. Chart Analytics Data (6-Month Trend)
            $months = [];
            $donationTrend = [];
            $memberTrend = [];
            $volunteerTrend = [];

            $bnMonths = [
                1 => 'জানু', 2 => 'ফেব্রু', 3 => 'মার্চ', 4 => 'এপ্রিল',
                5 => 'মে', 6 => 'জুন', 7 => 'জুলাই', 8 => 'আগস্ট',
                9 => 'সেপ্টে', 10 => 'অক্টো', 11 => 'নভে', 12 => 'ডিসে'
            ];

            for ($i = 5; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $monthNum = (int) $date->format('n');
                $year = $date->year;
                $label = ($bnMonths[$monthNum] ?? $date->format('M')) . ' ' . $date->format('y');

                $months[] = $label;

                $dSum = Donation::where('status', 'success')
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $monthNum)
                    ->sum('amount');
                $donationTrend[] = (float) $dSum;

                $mCount = Member::whereYear('created_at', $year)
                    ->whereMonth('created_at', $monthNum)
                    ->count();
                $memberTrend[] = $mCount;

                $vCount = Volunteer::whereYear('created_at', $year)
                    ->whereMonth('created_at', $monthNum)
                    ->count();
                $volunteerTrend[] = $vCount;
            }

            // Blood Groups Pool (Members + Volunteers combined)
            $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
            $bloodGroupCounts = [];
            foreach ($bloodGroups as $bg) {
                $mCount = Member::where('blood_group', $bg)->count();
                $vCount = Volunteer::where('blood_group', $bg)->count();
                $bloodGroupCounts[$bg] = $mCount + $vCount;
            }

            // Donation Methods Breakdown
            $donationMethods = Donation::where('status', 'success')
                ->selectRaw('payment_method, count(*) as count, sum(amount) as total')
                ->groupBy('payment_method')
                ->get();

            return compact('stats', 'months', 'donationTrend', 'memberTrend', 'volunteerTrend', 'bloodGroupCounts', 'donationMethods');
        });

        $stats = $cachedDashboard['stats'];
        $months = $cachedDashboard['months'];
        $donationTrend = $cachedDashboard['donationTrend'];
        $memberTrend = $cachedDashboard['memberTrend'];
        $volunteerTrend = $cachedDashboard['volunteerTrend'];
        $bloodGroupCounts = $cachedDashboard['bloodGroupCounts'];
        $donationMethods = $cachedDashboard['donationMethods'];
        $donationMethods = Donation::where('status', 'success')
            ->selectRaw('payment_method, count(*) as count, sum(amount) as total')
            ->groupBy('payment_method')
            ->get();

        $chartData = [
            'labels'            => $months,
            'donations'         => $donationTrend,
            'members'           => $memberTrend,
            'volunteers'        => $volunteerTrend,
            'months'            => $months,
            'donation_trend'    => $donationTrend,
            'member_trend'      => $memberTrend,
            'volunteer_trend'   => $volunteerTrend,
            'blood_groups'      => $bloodGroupCounts,
            'donation_methods'  => $donationMethods,
        ];

        // 3. Real-time Recent Feeds
        $recentDonations  = Donation::latest()->take(5)->get();
        $recentMembers    = Member::latest()->take(4)->get();
        $recentVolunteers = Volunteer::latest()->take(4)->get();
        $recentNotices    = Notice::latest()->take(4)->get();
        $recentMessages   = ContactMessage::latest()->take(4)->get();

        return view('admin.dashboard', compact(
            'stats',
            'chartData',
            'recentDonations',
            'recentMembers',
            'recentVolunteers',
            'recentNotices',
            'recentMessages'
        ));
    }

    /**
     * Clear application cache, routes, views, config and ensure storage link.
     */
    public function optimizeCache(): JsonResponse
    {
        try {
            Artisan::call('optimize:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');
            Artisan::call('config:clear');
            Artisan::call('cache:clear');
            Artisan::call('storage:link');

            return response()->json([
                'status'  => 'success',
                'message' => 'ক্যাশ, ভিউ, রাউট সফলভাবে ক্লিয়ার হয়েছে এবং স্টোরেজ লিংক নিশ্চিত করা হয়েছে!',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'রিফ্রেশ করতে সমস্যা হয়েছে: ' . $e->getMessage(),
            ], 500);
        }
    }
}
