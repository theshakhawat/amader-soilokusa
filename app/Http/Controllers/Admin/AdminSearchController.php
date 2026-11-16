<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminSearchItem;
use App\Models\Donation;
use App\Models\Event;
use App\Models\Member;
use App\Models\Notice;
use App\Models\Post;
use App\Models\Volunteer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AdminSearchController extends Controller
{
    /**
     * Search admin features, menus, and database records.
     */
    public function search(Request $request): JsonResponse
    {
        $query = trim((string) $request->get('q', ''));

        // If query is empty, return popular / quick suggestions
        if (mb_strlen($query) === 0) {
            $popularItems = AdminSearchItem::where('is_active', true)
                ->orderBy('order')
                ->take(8)
                ->get()
                ->map(fn($item) => [
                    'id'       => $item->id,
                    'title'    => $item->title_bn,
                    'subtitle' => $item->title_en,
                    'group'    => $item->group_name,
                    'icon'     => $item->icon,
                    'badge'    => $item->badge,
                    'url'      => $item->target_url,
                ]);

            return response()->json([
                'is_empty'   => true,
                'menu_items' => $popularItems,
                'records'    => [],
            ]);
        }

        // 1. Search Admin Search Items (Menus & Actions)
        $terms = array_filter(explode(' ', $query));
        $menuQuery = AdminSearchItem::where('is_active', true);

        $menuQuery->where(function ($q) use ($query, $terms) {
            $q->where('title_bn', 'like', "%{$query}%")
              ->orWhere('title_en', 'like', "%{$query}%")
              ->orWhere('group_name', 'like', "%{$query}%")
              ->orWhere('keywords', 'like', "%{$query}%");

            foreach ($terms as $t) {
                if (mb_strlen($t) >= 2) {
                    $q->orWhere('keywords', 'like', "%{$t}%")
                      ->orWhere('title_bn', 'like', "%{$t}%")
                      ->orWhere('title_en', 'like', "%{$t}%");
                }
            }
        });

        $menuResults = $menuQuery->orderBy('order')
            ->take(10)
            ->get()
            ->map(fn($item) => [
                'id'       => $item->id,
                'title'    => $item->title_bn,
                'subtitle' => $item->title_en,
                'group'    => $item->group_name,
                'icon'     => $item->icon,
                'badge'    => $item->badge,
                'url'      => $item->target_url,
            ]);

        // 2. Search Live Database Records (Notices, Volunteers, Members, Donations, Posts)
        $records = [];

        // Search Notices
        if (class_exists(Notice::class)) {
            $notices = Notice::where('title', 'like', "%{$query}%")
                ->latest()
                ->take(3)
                ->get();
            foreach ($notices as $n) {
                $url = Route::has('admin.notices.show') ? route('admin.notices.show', $n->id) : (Route::has('admin.notices.edit') ? route('admin.notices.edit', $n->id) : '#');
                $records[] = [
                    'type'     => 'নোটিশ',
                    'title'    => $n->title,
                    'subtitle' => 'প্রকাশ: ' . ($n->created_at ? $n->created_at->format('d M, Y') : ''),
                    'icon'     => 'ri-notification-badge-line',
                    'badge'    => 'রেকর্ড',
                    'url'      => $url,
                ];
            }
        }

        // Search Volunteers
        if (class_exists(Volunteer::class)) {
            $volunteers = Volunteer::where('name', 'like', "%{$query}%")
                ->orWhere('phone', 'like', "%{$query}%")
                ->orWhere('id_card_number', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%")
                ->latest()
                ->take(3)
                ->get();
            foreach ($volunteers as $v) {
                $records[] = [
                    'type'     => 'স্বেচ্ছাসেবী',
                    'title'    => $v->name . ($v->card_id_number ? " ({$v->card_id_number})" : ''),
                    'subtitle' => 'ফোন: ' . $v->phone . ' | ' . ($v->status ? 'অনুমোদিত' : 'অপেক্ষমাণ'),
                    'icon'     => 'ri-user-heart-line',
                    'badge'    => 'কর্মী',
                    'url'      => route('admin.volunteers.show', $v->id),
                ];
            }
        }

        // Search Members
        if (class_exists(Member::class)) {
            $members = Member::where('name', 'like', "%{$query}%")
                ->orWhere('phone', 'like', "%{$query}%")
                ->orWhere('id_card_number', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%")
                ->latest()
                ->take(3)
                ->get();
            foreach ($members as $m) {
                $records[] = [
                    'type'     => 'সদস্য',
                    'title'    => $m->name . ($m->card_id_number ? " ({$m->card_id_number})" : ''),
                    'subtitle' => 'ফোন: ' . $m->phone . ' | ' . ($m->status ? 'Active' : 'Inactive'),
                    'icon'     => 'ri-vip-crown-line',
                    'badge'    => 'সদস্য',
                    'url'      => route('admin.members.show', $m->id),
                ];
            }
        }

        // Search Donations
        if (class_exists(Donation::class)) {
            $donations = Donation::where('donor_name', 'like', "%{$query}%")
                ->orWhere('donor_phone', 'like', "%{$query}%")
                ->orWhere('transaction_id', 'like', "%{$query}%")
                ->latest()
                ->take(3)
                ->get();
            foreach ($donations as $d) {
                $records[] = [
                    'type'     => 'অনুদান',
                    'title'    => ($d->donor_name ?: 'নামহীন দাতা') . " (৳" . number_format($d->amount) . ")",
                    'subtitle' => 'Trx: ' . ($d->transaction_id ?: 'N/A') . ' | ' . ($d->payment_method ?: 'Cash'),
                    'icon'     => 'ri-hand-heart-line',
                    'badge'    => 'অনুদান',
                    'url'      => route('admin.donations.show', $d->id),
                ];
            }
        }

        // Search Blog Posts
        if (class_exists(Post::class)) {
            $posts = Post::where('title', 'like', "%{$query}%")
                ->latest()
                ->take(2)
                ->get();
            foreach ($posts as $p) {
                $records[] = [
                    'type'     => 'ব্লগ',
                    'title'    => $p->title,
                    'subtitle' => 'ব্লগ পোস্ট বিবরণ ও সম্পাদনা',
                    'icon'     => 'ri-article-line',
                    'badge'    => 'পোস্ট',
                    'url'      => Route::has('admin.posts.edit') ? route('admin.posts.edit', $p->id) : '#',
                ];
            }
        }

        return response()->json([
            'is_empty'   => false,
            'query'      => $query,
            'menu_items' => $menuResults,
            'records'    => $records,
            'total'      => count($menuResults) + count($records),
        ]);
    }
}
