<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'pending_users' => User::where('status', 'pending')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
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
                'status' => 'success',
                'message' => 'ক্যাশ, ভিউ, রাউট সফলভাবে ক্লিয়ার হয়েছে এবং স্টোরেজ লিংক নিশ্চিত করা হয়েছে!',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'রিফ্রেশ করতে সমস্যা হয়েছে: ' . $e->getMessage(),
            ], 500);
        }
    }
}
