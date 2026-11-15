<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavItem;
use Illuminate\Http\Request;

class NavbarSettingController extends Controller
{
    /**
     * Display navigation management interface.
     */
    public function index()
    {
        $rootNavItems = NavItem::whereNull('parent_id')
            ->with(['children.children'])
            ->orderBy('order', 'asc')
            ->get();

        // For parent select dropdown
        $allPossibleParents = NavItem::orderBy('order', 'asc')->get();

        return view('admin.customization.navbar', compact('rootNavItems', 'allPossibleParents'));
    }

    /**
     * Store a newly created nav item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'url'       => 'required|string|max:500',
            'parent_id' => 'nullable|exists:nav_items,id',
            'target'    => 'required|in:_self,_blank',
            'icon'      => 'nullable|string|max:100',
            'status'    => 'nullable|boolean',
        ]);

        $maxOrder = NavItem::where('parent_id', $validated['parent_id'] ?? null)->max('order') ?? 0;

        NavItem::create([
            'parent_id' => $validated['parent_id'] ?: null,
            'title'     => $validated['title'],
            'url'       => $validated['url'],
            'target'    => $validated['target'],
            'icon'      => $validated['icon'] ?? null,
            'order'     => $maxOrder + 1,
            'status'    => $request->boolean('status', true),
        ]);

        return redirect()->route('admin.customization.navbar')->with('success', 'মেন্যু আইটেম সফলভাবে যোগ করা হয়েছে!');
    }

    /**
     * Update an existing nav item.
     */
    public function update(Request $request, NavItem $navItem)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'url'       => 'required|string|max:500',
            'parent_id' => 'nullable|exists:nav_items,id',
            'target'    => 'required|in:_self,_blank',
            'icon'      => 'nullable|string|max:100',
            'status'    => 'nullable|boolean',
        ]);

        // Prevent setting self as parent
        if ($validated['parent_id'] == $navItem->id) {
            return redirect()->back()->with('error', 'কোনো আইটেম নিজের প্যারেন্ট হতে পারে না!');
        }

        $navItem->update([
            'parent_id' => $validated['parent_id'] ?: null,
            'title'     => $validated['title'],
            'url'       => $validated['url'],
            'target'    => $validated['target'],
            'icon'      => $validated['icon'] ?? null,
            'status'    => $request->boolean('status', false),
        ]);

        return redirect()->route('admin.customization.navbar')->with('success', 'মেন্যু আইটেম সফলভাবে হালনাগাদ করা হয়েছে!');
    }

    /**
     * Delete a nav item.
     */
    public function destroy(NavItem $navItem)
    {
        $navItem->delete();

        return redirect()->route('admin.customization.navbar')->with('success', 'মেন্যু আইটেম সফলভাবে মুছে ফেলা হয়েছে!');
    }

    /**
     * Toggle status.
     */
    public function toggleStatus(NavItem $navItem)
    {
        $navItem->status = !$navItem->status;
        $navItem->save();

        return response()->json([
            'success' => true,
            'status'  => $navItem->status,
            'message' => 'স্ট্যাটাস পরিবর্তিত হয়েছে!',
        ]);
    }

    /**
     * Update order via Drag and Drop (Nested tree).
     */
    public function updateOrder(Request $request)
    {
        $items = $request->input('items', []);

        $this->updateTree($items, null);

        return response()->json([
            'success' => true,
            'message' => 'নেভবার মেন্যু ক্রম সফলভাবে সাজানো হয়েছে!',
        ]);
    }

    /**
     * Recursive tree update helper.
     */
    private function updateTree(array $items, ?int $parentId)
    {
        foreach ($items as $index => $itemData) {
            if (isset($itemData['id'])) {
                NavItem::where('id', $itemData['id'])->update([
                    'order'     => $index + 1,
                    'parent_id' => $parentId,
                ]);

                if (!empty($itemData['children']) && is_array($itemData['children'])) {
                    $this->updateTree($itemData['children'], $itemData['id']);
                }
            }
        }
    }
}
