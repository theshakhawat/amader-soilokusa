@extends('layouts.admin.admin-layout')

@section('title', 'অনুদান সংগ্রহ ও ট্র্যাকিং')

@section('content')
<div class="space-y-4">
  {{-- 1. Minimal Top Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
      <h1 class="text-xl sm:text-2xl font-bold text-gray-900 tracking-tight">
        অনুদান সংগ্রহ ও ট্র্যাকিং
      </h1>
      <p class="text-xs text-gray-500 mt-0.5">সংগৃহীত অনুদানের তালিকা ও বিস্তারিত হিসাব</p>
    </div>

    <div class="flex flex-wrap items-center gap-2">
      {{-- Export Button --}}
      <a href="{{ route('admin.donations.export', request()->query()) }}"
         class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 rounded-lg text-xs font-semibold shadow-2xs transition"
         title="এক্সপোর্ট করুন">
        <i class="ri-file-excel-2-line text-sm text-gray-500"></i>
        <span>এক্সপোর্ট</span>
      </a>

      {{-- Print Button --}}
      <button type="button"
              onclick="window.print()"
              class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 rounded-lg text-xs font-semibold shadow-2xs transition">
        <i class="ri-printer-line text-sm text-gray-500"></i>
        <span>প্রিন্ট</span>
      </button>

      {{-- New Manual Donation Button --}}
      <a href="{{ route('admin.donations.create') }}"
         class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-[#0b4622] hover:bg-[#08351a] text-white rounded-lg text-xs font-semibold shadow-2xs transition">
        <i class="ri-add-line text-sm"></i>
        <span>+ নতুন অনুদান এন্ট্রি</span>
      </a>
    </div>
  </div>

  {{-- 2. Minimal Summary Cards (Clean, Subtle, No Bulky Gradients or Repetitive Text) --}}
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
    {{-- Card 1: This Month --}}
    <div class="bg-white rounded-xl border border-gray-200/90 px-4 py-3 shadow-2xs">
      <span class="text-xs text-gray-500 font-medium block">চলতি মাস ({{ now()->translatedFormat('F') }})</span>
      <span class="text-xl sm:text-2xl font-bold text-gray-900 block mt-0.5">৳{{ number_format($thisMonthCollected, 2) }}</span>
    </div>

    {{-- Card 2: This Week --}}
    <div class="bg-white rounded-xl border border-gray-200/90 px-4 py-3 shadow-2xs">
      <span class="text-xs text-gray-500 font-medium block">চলতি সপ্তাহ</span>
      <span class="text-xl sm:text-2xl font-bold text-gray-900 block mt-0.5">৳{{ number_format($thisWeekCollected, 2) }}</span>
    </div>

    {{-- Card 3: Total Collected --}}
    <div class="bg-white rounded-xl border border-gray-200/90 px-4 py-3 shadow-2xs sm:col-span-1">
      <span class="text-xs text-gray-500 font-medium block">সর্বমোট অনুদান</span>
      <span class="text-xl sm:text-2xl font-bold text-gray-900 block mt-0.5">৳{{ number_format($totalCollected, 2) }}</span>
    </div>
  </div>

  {{-- 3. Minimal Filter Bar (Visible Filter Buttons: সকল, এই মাসে, এই সপ্তাহে, আজকে) --}}
  <div class="bg-white rounded-xl border border-gray-200 p-2.5 sm:p-3 shadow-2xs space-y-2.5">
    @php
      $currentPeriod = request('period', 'all');
    @endphp

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-2.5">
      {{-- Visible Clean Filter Segmented Buttons --}}
      <div class="flex items-center gap-1.5 flex-wrap">
        {{-- সকল --}}
        <a href="{{ route('admin.donations.index', array_merge(request()->except(['period', 'page', 'start_date', 'end_date']), ['period' => 'all'])) }}"
           class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ ($currentPeriod === 'all' || !$currentPeriod) && !request('start_date') ? 'bg-[#0b4622] text-white shadow-2xs' : 'bg-gray-50 text-gray-700 hover:bg-gray-100 border border-gray-200' }}">
          সকল
        </a>

        {{-- এই মাসে --}}
        <a href="{{ route('admin.donations.index', array_merge(request()->except(['period', 'page', 'start_date', 'end_date']), ['period' => 'this_month'])) }}"
           class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $currentPeriod === 'this_month' ? 'bg-[#0b4622] text-white shadow-2xs' : 'bg-gray-50 text-gray-700 hover:bg-gray-100 border border-gray-200' }}">
          এই মাসে
        </a>

        {{-- এই সপ্তাহে --}}
        <a href="{{ route('admin.donations.index', array_merge(request()->except(['period', 'page', 'start_date', 'end_date']), ['period' => 'this_week'])) }}"
           class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $currentPeriod === 'this_week' ? 'bg-[#0b4622] text-white shadow-2xs' : 'bg-gray-50 text-gray-700 hover:bg-gray-100 border border-gray-200' }}">
          এই সপ্তাহে
        </a>

        {{-- আজকে --}}
        <a href="{{ route('admin.donations.index', array_merge(request()->except(['period', 'page', 'start_date', 'end_date']), ['period' => 'today'])) }}"
           class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $currentPeriod === 'today' ? 'bg-[#0b4622] text-white shadow-2xs' : 'bg-gray-50 text-gray-700 hover:bg-gray-100 border border-gray-200' }}">
          আজকে
        </a>
      </div>

      {{-- Search Input & Filter Toggle --}}
      <div class="flex items-center gap-2">
        <form action="{{ route('admin.donations.index') }}" method="GET" class="relative">
          @if(request('period') && request('period') !== 'all')
            <input type="hidden" name="period" value="{{ request('period') }}">
          @endif
          @if(request('status'))
            <input type="hidden" name="status" value="{{ request('status') }}">
          @endif
          @if(request('type'))
            <input type="hidden" name="type" value="{{ request('type') }}">
          @endif

          <input type="text"
                 name="search"
                 value="{{ request('search') }}"
                 placeholder="নাম, ফোন বা Trx ID..."
                 class="w-52 sm:w-60 pl-8 pr-3 py-1.5 text-xs border border-gray-200 rounded-lg focus:outline-none focus:border-[#0b4622] bg-gray-50 focus:bg-white transition">
          <i class="ri-search-line absolute left-2.5 top-2 text-gray-400 text-xs"></i>
        </form>

        <button type="button"
                onclick="document.getElementById('advancedFilterBox').classList.toggle('hidden')"
                class="px-2.5 py-1.5 bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-600 rounded-lg text-xs font-medium transition flex items-center gap-1 cursor-pointer"
                title="কাস্টম ফিল্টার">
          <i class="ri-equalizer-line text-xs text-gray-500"></i>
          <span class="hidden sm:inline">ফিল্টার</span>
        </button>

        @if($hasActiveFilter)
          <a href="{{ route('admin.donations.index') }}"
             class="px-2 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg text-xs font-medium transition flex items-center gap-1"
             title="রিসেট">
            <i class="ri-refresh-line text-xs"></i>
          </a>
        @endif
      </div>
    </div>

    {{-- Collapsible Advanced Filter --}}
    <div id="advancedFilterBox" class="{{ $hasActiveFilter && ($currentPeriod === 'custom' || request('start_date') || request('end_date') || request('status') || request('type')) ? '' : 'hidden' }} pt-2.5 border-t border-gray-100">
      <form action="{{ route('admin.donations.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2.5 text-xs">
        @if(request('search'))
          <input type="hidden" name="search" value="{{ request('search') }}">
        @endif

        {{-- Status Filter --}}
        <div>
          <label class="block text-[11px] font-medium text-gray-500 mb-1">স্ট্যাটাস</label>
          <select name="status" class="w-full px-2.5 py-1.5 text-xs border border-gray-200 rounded-lg focus:outline-none focus:border-[#0b4622] bg-white">
            <option value="all" {{ request('status') === 'all' || !request('status') ? 'selected' : '' }}>সকল স্ট্যাটাস</option>
            <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>সফল (Success)</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>পেন্ডিং (Pending)</option>
            <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>ব্যর্থ (Failed)</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>বাতিল (Cancelled)</option>
          </select>
        </div>

        {{-- Type Filter --}}
        <div>
          <label class="block text-[11px] font-medium text-gray-500 mb-1">মাধ্যম</label>
          <select name="type" class="w-full px-2.5 py-1.5 text-xs border border-gray-200 rounded-lg focus:outline-none focus:border-[#0b4622] bg-white">
            <option value="all" {{ request('type') === 'all' || !request('type') ? 'selected' : '' }}>সকল মাধ্যম</option>
            <option value="online" {{ request('type') === 'online' ? 'selected' : '' }}>অনলাইন (DGePay)</option>
            <option value="manual" {{ request('type') === 'manual' ? 'selected' : '' }}>অফলাইন / ম্যানুয়াল</option>
          </select>
        </div>

        {{-- Start Date --}}
        <div>
          <label class="block text-[11px] font-medium text-gray-500 mb-1">শুরুর তারিখ</label>
          <input type="date"
                 name="start_date"
                 value="{{ request('start_date') }}"
                 class="w-full px-2.5 py-1.5 text-xs border border-gray-200 rounded-lg focus:outline-none focus:border-[#0b4622] bg-white">
        </div>

        {{-- End Date & Submit --}}
        <div>
          <label class="block text-[11px] font-medium text-gray-500 mb-1">শেষের তারিখ</label>
          <div class="flex items-center gap-1.5">
            <input type="date"
                   name="end_date"
                   value="{{ request('end_date') }}"
                   class="w-full px-2.5 py-1.5 text-xs border border-gray-200 rounded-lg focus:outline-none focus:border-[#0b4622] bg-white">
            <button type="submit" class="px-3 py-1.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-semibold rounded-lg shrink-0 cursor-pointer">
              প্রয়োগ
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  {{-- 4. Minimal Active Filter Indicator (if filtered) --}}
  @if($hasActiveFilter)
    <div class="flex items-center justify-between text-xs text-gray-600 bg-gray-50 border border-gray-200 rounded-xl px-4 py-2">
      <div class="flex items-center gap-2">
        <i class="ri-filter-3-line text-gray-400"></i>
        <span>ফিল্টারকৃত মোট: <strong class="text-gray-900 font-bold">{{ number_format($filteredTotalCount) }}</strong> টি অনুদান</span>
        @if($filteredTotalAmount !== null)
          <span class="text-gray-300">|</span>
          <span>মোট অর্থ: <strong class="text-gray-900 font-bold">৳{{ number_format($filteredTotalAmount, 2) }}</strong></span>
        @endif
      </div>
      <a href="{{ route('admin.donations.index') }}" class="text-gray-500 hover:text-gray-800 font-medium flex items-center gap-1">
        <i class="ri-close-line"></i> ফিল্টার মুছুন
      </a>
    </div>
  @endif

  {{-- 5. Donations Table --}}
  <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-2xs">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse text-xs sm:text-sm">
        <thead class="bg-gray-50/80 border-b border-gray-200 text-gray-500 font-semibold text-[11px]">
          <tr>
            <th class="px-3.5 py-3 text-center w-12 border-r border-gray-200">ক্র.</th>
            <th class="px-3.5 py-3 border-r border-gray-200">ট্রানজ্যাকশন আইডি</th>
            <th class="px-3.5 py-3 border-r border-gray-200">দাতার তথ্য</th>
            <th class="px-3.5 py-3 border-r border-gray-200 text-right">পরিমাণ</th>
            <th class="px-3.5 py-3 border-r border-gray-200 text-center">মাধ্যম</th>
            <th class="px-3.5 py-3 border-r border-gray-200 text-center">স্ট্যাটাস</th>
            <th class="px-3.5 py-3 border-r border-gray-200">তারিখ ও সময়</th>
            <th class="px-3.5 py-3 text-center w-20">অ্যাকশন</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 text-xs sm:text-sm">
          @forelse($donations as $idx => $donation)
            <tr class="hover:bg-gray-50/60 transition align-middle">
              {{-- SL --}}
              <td class="px-3.5 py-3 text-center font-medium text-gray-500 border-r border-gray-200">
                {{ $donations->firstItem() + $idx }}
              </td>

              {{-- Trx ID --}}
              <td class="px-3.5 py-3 border-r border-gray-200 font-mono">
                <span class="font-bold text-gray-900 block text-xs">{{ $donation->trx_id }}</span>
                @if($donation->gateway_trx_id)
                  <span class="text-[10px] text-gray-500 flex items-center gap-1 mt-0.5" title="রসিদ নং">
                    <i class="ri-bank-card-line text-gray-400"></i> {{ $donation->gateway_trx_id }}
                  </span>
                @endif
              </td>

              {{-- Donor Info --}}
              <td class="px-3.5 py-3 border-r border-gray-200">
                <span class="font-bold text-gray-900 block text-xs sm:text-sm">{{ $donation->donor_name }}</span>
                <a href="tel:{{ $donation->donor_phone }}" class="text-xs text-gray-600 hover:text-[#0b4622] flex items-center gap-1 mt-0.5">
                  <i class="ri-phone-line text-gray-400"></i> {{ $donation->donor_phone }}
                </a>
                @if($donation->donor_email)
                  <span class="text-[11px] text-gray-400 block">{{ $donation->donor_email }}</span>
                @endif
              </td>

              {{-- Amount --}}
              <td class="px-3.5 py-3 border-r border-gray-200 text-right">
                <span class="text-xs sm:text-sm font-bold text-gray-900 block">৳{{ number_format($donation->amount, 2) }}</span>
                <span class="text-[10px] text-gray-400 uppercase font-medium">{{ $donation->currency ?? 'BDT' }}</span>
              </td>

              {{-- Payment Method / Type (Minimal Badge) --}}
              <td class="px-3.5 py-3 border-r border-gray-200 text-center">
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-medium bg-gray-50 text-gray-700 border border-gray-200">
                  {{ $donation->payment_method ?: ($donation->is_manual ? 'অফলাইন' : 'DGePay') }}
                </span>
                <span class="block text-[10px] text-gray-400 mt-0.5">
                  {{ $donation->is_manual ? 'ম্যানুয়াল' : 'অনলাইন' }}
                </span>
              </td>

              {{-- Status (Minimal Badge) --}}
              <td class="px-3.5 py-3 border-r border-gray-200 text-center">
                @if($donation->status === 'success')
                  <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200/60">
                    <i class="ri-checkbox-circle-fill text-emerald-600 text-[11px]"></i> সফল
                  </span>
                @elseif($donation->status === 'pending')
                  <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200/60">
                    <i class="ri-time-line text-amber-600 text-[11px]"></i> পেন্ডিং
                  </span>
                @elseif($donation->status === 'cancelled')
                  <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                    বাতিল
                  </span>
                @else
                  <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-red-800 border border-red-200/60">
                    ব্যর্থ
                  </span>
                @endif
              </td>

              {{-- Date & Time --}}
              <td class="px-3.5 py-3 border-r border-gray-200 text-xs text-gray-600 whitespace-nowrap">
                <span class="font-medium block text-gray-900">{{ $donation->created_at->format('d M, Y') }}</span>
                <span class="text-[11px] text-gray-400">{{ $donation->created_at->format('h:i A') }}</span>
              </td>

              {{-- Actions --}}
              <td class="px-3.5 py-3 text-center">
                <div class="flex items-center justify-center gap-1">
                  <a href="{{ route('admin.donations.show', $donation->id) }}"
                     class="w-7 h-7 rounded-lg bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-600 flex items-center justify-center transition"
                     title="বিস্তারিত দেখুন">
                    <i class="ri-eye-line text-xs"></i>
                  </a>

                  <form action="{{ route('admin.donations.destroy', $donation->id) }}"
                        method="POST"
                        onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই অনুদানের তথ্যটি মুছে ফেলতে চান?');"
                        class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-7 h-7 rounded-lg bg-gray-50 hover:bg-red-50 hover:text-red-600 border border-gray-200 text-gray-400 flex items-center justify-center transition cursor-pointer"
                            title="মুছে ফেলুন">
                      <i class="ri-delete-bin-line text-xs"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="p-10 text-center text-gray-400">
                <i class="ri-heart-line text-4xl text-gray-300 block mb-2"></i>
                <p class="text-xs sm:text-sm font-semibold text-gray-600">কোনো অনুদানের তথ্য পাওয়া যায়নি।</p>
                <p class="text-xs text-gray-400 mt-0.5">ফিল্টারিং পরিবর্তন করুন অথবা নতুন অনুদান এন্ট্রি করুন।</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($donations->hasPages())
      <div class="px-4 py-2.5 border-t border-gray-200 bg-gray-50/50">
        {{ $donations->links() }}
      </div>
    @endif
  </div>
</div>
@endsection
