<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationRule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OrganizationRuleController extends Controller
{
    /**
     * Display a listing of the rules/parts.
     */
    public function index(): View
    {
        $rules = OrganizationRule::orderBy('order', 'asc')->orderBy('id', 'asc')->get();
        return view('admin.rules.index', compact('rules'));
    }

    /**
     * Show the form for creating a new part.
     */
    public function create(): View
    {
        $nextOrder = (OrganizationRule::max('order') ?? 0) + 1;
        return view('admin.rules.create', compact('nextOrder'));
    }

    /**
     * Store a newly created part.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'part_no' => ['required', 'string', 'max:100'],
            'title'   => ['required', 'string', 'max:255'],
            'slug'    => ['nullable', 'string', 'max:255', 'unique:organization_rules,slug'],
            'summary' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'order'   => ['nullable', 'integer', 'min:0'],
            'status'  => ['nullable', 'boolean'],
        ], [
            'part_no.required' => 'ভাগের নাম (যেমন: ১ম ভাগ বা প্রথম অধ্যায়) আবশ্যক।',
            'title.required'   => 'শিরোনাম আবশ্যক।',
            'content.required' => 'বিস্তারিত নীতিমালা বা ধারাগুলো প্রদান করুন।',
        ]);

        $validated['status'] = $request->has('status');
        $validated['order']  = $validated['order'] ?? ((OrganizationRule::max('order') ?? 0) + 1);

        if (empty($validated['slug'])) {
            $base = Str::slug($validated['part_no'] . '-' . $validated['title']);
            $validated['slug'] = $base ?: ('part-' . time());
        }

        OrganizationRule::create($validated);

        return redirect()->route('admin.rules.index')->with('success', 'নতুন বিধিমালার অংশ সফলভাবে যুক্ত করা হয়েছে!');
    }

    /**
     * Show the form for editing the specified part.
     */
    public function edit(OrganizationRule $rule): View
    {
        return view('admin.rules.edit', compact('rule'));
    }

    /**
     * Update the specified part.
     */
    public function update(Request $request, OrganizationRule $rule): RedirectResponse
    {
        $validated = $request->validate([
            'part_no' => ['required', 'string', 'max:100'],
            'title'   => ['required', 'string', 'max:255'],
            'slug'    => ['nullable', 'string', 'max:255', 'unique:organization_rules,slug,' . $rule->id],
            'summary' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'order'   => ['nullable', 'integer', 'min:0'],
            'status'  => ['nullable', 'boolean'],
        ], [
            'part_no.required' => 'ভাগের নাম আবশ্যক।',
            'title.required'   => 'শিরোনাম আবশ্যক।',
            'content.required' => 'বিস্তারিত ধারা বা কনটেন্ট প্রদান করুন।',
        ]);

        $validated['status'] = $request->has('status');
        $validated['order']  = $validated['order'] ?? $rule->order;

        if (empty($validated['slug'])) {
            $base = Str::slug($validated['part_no'] . '-' . $validated['title']);
            $validated['slug'] = $base ?: ('part-' . $rule->id);
        }

        $rule->update($validated);

        return redirect()->route('admin.rules.index')->with('success', 'বিধিমালা সফলভাবে হালনাগাদ করা হয়েছে!');
    }

    /**
     * Toggle active/inactive status.
     */
    public function toggleStatus(OrganizationRule $rule): RedirectResponse
    {
        $rule->update(['status' => !$rule->status]);
        $statusText = $rule->status ? 'সক্রিয়' : 'নিষ্ক্রিয়';
        return redirect()->back()->with('success', "বিধিমালার স্ট্যাটাস {$statusText} করা হয়েছে!");
    }

    /**
     * Remove the specified part from storage.
     */
    public function destroy(OrganizationRule $rule): RedirectResponse
    {
        $rule->delete();
        return redirect()->route('admin.rules.index')->with('success', 'বিধিমালা সফলভাবে মুছে ফেলা হয়েছে!');
    }
}
