<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Volunteer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    /**
     * Mark a specific notification as read and redirect to its target management page.
     */
    public function read(string $id): RedirectResponse
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $notification = $user->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();

            $type = $notification->data['type'] ?? null;
            $sourceId = $notification->data['source_id'] ?? null;

            // Route to volunteer management page
            if ($type === 'volunteer_registration') {
                if ($sourceId && Volunteer::where('id', $sourceId)->exists()) {
                    return redirect()->route('admin.volunteers.show', $sourceId);
                }
                return redirect()->route('admin.volunteers.index');
            }

            // Route to member management page
            if ($type === 'member_registration') {
                if ($sourceId && Member::where('id', $sourceId)->exists()) {
                    return redirect()->route('admin.members.show', $sourceId);
                }
                return redirect()->route('admin.members.index');
            }

            // Route to donation details page
            if ($type === 'donation_received') {
                if ($sourceId && \App\Models\Donation::where('id', $sourceId)->exists()) {
                    return redirect()->route('admin.donations.show', $sourceId);
                }
                return redirect()->route('admin.donations.index');
            }

            $targetUrl = $notification->data['url'] ?? route('admin.dashboard');
            return redirect($targetUrl);
        }

        return redirect()->route('admin.dashboard');
    }

    /**
     * Mark all unread notifications as read for current user.
     */
    public function markAllRead(): RedirectResponse
    {
        $user = auth()->user();
        if ($user) {
            $user->unreadNotifications->markAsRead();
        }

        return back()->with('success', 'সকল নোটিফিকেশন পড়া হয়েছে বলে চিহ্নিত করা হয়েছে।');
    }
}
