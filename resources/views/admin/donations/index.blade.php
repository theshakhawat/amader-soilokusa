@extends('layouts.admin.admin-layout')

@section('title', 'অনুদানের তালিকা')

@section('content')
<div class="space-y-6">
  {{-- Header with Breadcrumb --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight flex items-center gap-2.5">
        <span class="w-10 h-10 rounded-xl bg-red-50 text-[#c8102e] flex items-center justify-center text-xl shadow-2xs">
          <i class="ri-heart-3-line"></i>
        </span>
        <span>অনুদান সংগ্রহ ও তালিকা</span>
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-1 font-medium">ডিজি পে (DGePay) গেটওয়ে ও অফলাইন মাধ্যমে সংগৃহীত সকল অনুদানের হিসাব</p>
    </div>

    <div class="flex items-center gap-2">
      <a href="{{ route('admin.donations.create') }}"
         class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white rounded-xl text-xs sm:text-sm font-bold shadow-xs hover:shadow transition">
        <i class="ri-add-circle-line text-base"></i>
        <span>নতুন অনুদান এন্ট্রি</span>
      </a>
    </div>
  </div>

  {{-- Stats Summary Cards --}}
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    {{-- Total Collected --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-4 sm:p-5 shadow-2xs flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold text-gray-500">মোট সংগৃহীত অনুদান</p>
        <h3 class="text-xl sm:text-2xl font-black text-[#0b4622] mt-1">৳{{ number_format($totalCollected, 2) }}</h3>
      </div>
      <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#0b4622] flex items-center justify-center text-2xl shrink-0">
        <i class="ri-money-dollar-circle-line"></i>
      </div>
    </div>

    {{-- Success Count --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-4 sm:p-5 shadow-2xs flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold text-gray-500">সফল অনুদান</p>
        <h3 class="text-xl sm:text-2xl font-black text-emerald-600 mt-1">{{ number_format($totalSuccessCount) }} টি</h3>
      </div>
      <div class="w-12 h-12 rounded-xl bg-green-50 text-emerald-600 flex items-center justify-center text-2xl shrink-0">
        <i class="ri-checkbox-circle-line"></i>
      </div>
    </div>

    {{-- Pending Count --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-4 sm:p-5 shadow-2xs flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold text-gray-500">পেন্ডিং ট্রানজ্যাকশন</p>
        <h3 class="text-xl sm:text-2xl font-black text-amber-500 mt-1">{{ number_format($totalPendingCount) }} টি</h3>
      </div>
      <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl shrink-0">
        <i class="ri-time-line"></i>
      </div>
    </div>

    {{-- Manual Offline Count --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-4 sm:p-5 shadow-2xs flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold text-gray-500">অফলাইন / ম্যানুয়াল এন্ট্রি</p>
        <h3 class="text-xl sm:text-2xl font-black text-blue-600 mt-1">{{ number_format($totalManualCount) }} টি</h3>
      </div>
      <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl shrink-0">
        <i class="ri-hand-coin-line"></i>
      </div>
    </div>
  </div>

  {{-- Filters and Search Bar --}}
  <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-2xs">
    <form action="{{ route('admin.donations.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
      {{-- Search --}}
      <div class="relative">
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="দাতার নাম, ফোন, Trx ID..."
               class="w-full pl-9 pr-3 py-2 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622] transition">
        <i class="ri-search-line absolute left-3 top-2.5 text-gray-400"></i>
      </div>

      {{-- Status Filter --}}
      <div>
        <select name="status" class="w-full px-3 py-2 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622] transition bg-white">
          <option value="all" {{ request('status') === 'all' || !request('status') ? 'selected' : '' }}>সকল স্ট্যাটাস</option>
          <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>সফল (Success)</option>
          <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>পেন্ডিং (Pending)</option>
          <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>ব্যর্থ (Failed)</option>
          <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>বাতিল (Cancelled)</option>
        </select>
      </div>

      {{-- Type Filter --}}
      <div>
        <select name="type" class="w-full px-3 py-2 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622] transition bg-white">
          <option value="all" {{ request('type') === 'all' || !request('type') ? 'selected' : '' }}>সকল ধরন</option>
          <option value="online" {{ request('type') === 'online' ? 'selected' : '' }}>অনলাইন (DGePay Gateway)</option>
          <option value="manual" {{ request('type') === 'manual' ? 'selected' : '' }}>অফলাইন / ম্যানুয়াল</option>
        </select>
      </div>

      {{-- Actions --}}
      <div class="flex items-center gap-2">
        <button type="submit" class="w-full px-4 py-2 bg-gray-900 hover:bg-black text-white text-xs sm:text-sm font-bold rounded-xl transition flex items-center justify-center gap-1.5 shadow-2xs">
          <i class="ri-filter-3-line"></i> ফিল্টার
        </button>
        @if(request()->hasAny(['search', 'status', 'type']))
          <a href="{{ route('admin.donations.index') }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-semibold rounded-xl transition" title="রিসেট">
            <i class="ri-refresh-line"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  {{-- Donations Table --}}
  <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-2xs">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse text-xs sm:text-sm">
        <thead class="bg-gray-50/80 border-b border-gray-200 text-gray-600 font-bold uppercase tracking-wider text-[11px]">
          <tr>
            <th class="px-4 py-3.5 text-center w-12 border-r border-gray-200">ক্র.</th>
            <th class="px-4 py-3.5 border-r border-gray-200">ট্রানজ্যাকশন আইডি</th>
            <th class="px-4 py-3.5 border-r border-gray-200">দাতার তথ্য</th>
            <th class="px-4 py-3.5 border-r border-gray-200 text-right">পরিমাণ</th>
            <th class="px-4 py-3.5 border-r border-gray-200 text-center">মাধ্যম / ধরন</th>
            <th class="px-4 py-3.5 border-r border-gray-200 text-center">স্ট্যাটাস</th>
            <th class="px-4 py-3.5 border-r border-gray-200">তারিখ ও সময়</th>
            <th class="px-4 py-3.5 text-center w-24">অ্যাকশন</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          @forelse($donations as $idx => $donation)
            <tr class="hover:bg-gray-50/60 transition align-middle">
              {{-- SL --}}
              <td class="px-4 py-3.5 text-center font-bold text-gray-500 border-r border-gray-200">
                {{ $donations->firstItem() + $idx }}
              </td>

              {{-- Trx ID --}}
              <td class="px-4 py-3.5 border-r border-gray-200 font-mono">
                <span class="font-bold text-gray-900 block">{{ $donation->trx_id }}</span>
                @if($donation->gateway_trx_id)
                  <span class="text-[10px] text-gray-500 flex items-center gap-1 mt-0.5" title="গেটওয়ে ট্রানজ্যাকশন আইডি">
                    <i class="ri-bank-card-line text-emerald-600"></i> {{ $donation->gateway_trx_id }}
                  </span>
                @endif
              </td>

              {{-- Donor Info --}}
              <td class="px-4 py-3.5 border-r border-gray-200">
                <span class="font-bold text-gray-900 block">{{ $donation->donor_name }}</span>
                <a href="tel:{{ $donation->donor_phone }}" class="text-xs text-[#0b4622] hover:underline flex items-center gap-1 mt-0.5">
                  <i class="ri-phone-line"></i> {{ $donation->donor_phone }}
                </a>
                @if($donation->donor_email)
                  <span class="text-[11px] text-gray-400 block">{{ $donation->donor_email }}</span>
                @endif
              </td>

              {{-- Amount --}}
              <td class="px-4 py-3.5 border-r border-gray-200 text-right">
                <span class="text-sm font-black text-[#0b4622] block">৳{{ number_format($donation->amount, 2) }}</span>
                <span class="text-[10px] text-gray-400 uppercase font-semibold">{{ $donation->currency }}</span>
              </td>

              {{-- Payment Method / Type --}}
              <td class="px-4 py-3.5 border-r border-gray-200 text-center">
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold {{ $donation->is_manual ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700' }}">
                  <i class="{{ $donation->is_manual ? 'ri-hand-coin-line' : 'ri-shield-flash-line' }}"></i>
                  {{ $donation->payment_method ?: ($donation->is_manual ? 'অফলাইন' : 'DGePay') }}
                </span>
                @if($donation->is_manual)
                  <span class="block text-[10px] text-gray-400 mt-0.5">ম্যানুয়াল এন্ট্রি</span>
                @else
                  <span class="block text-[10px] text-gray-400 mt-0.5">অনলাইন গেটওয়ে</span>
                @endif
              </td>

              {{-- Status --}}
              <td class="px-4 py-3.5 border-r border-gray-200 text-center">
                @if($donation->status === 'success')
                  <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    <i class="ri-checkbox-circle-fill text-emerald-500"></i> সফল
                  </span>
                @elseif($donation->status === 'pending')
                  <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                    <i class="ri-time-line text-amber-500"></i> পেন্ডিং
                  </span>
                @elseif($donation->status === 'cancelled')
                  <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-700 border border-gray-200">
                    <i class="ri-close-circle-line text-gray-500"></i> বাতিল
                  </span>
                @else
                  <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200">
                    <i class="ri-error-warning-fill text-red-500"></i> ব্যর্থ
                  </span>
                @endif
              </td>

              {{-- Date & Time --}}
              <td class="px-4 py-3.5 border-r border-gray-200 text-xs text-gray-600 whitespace-nowrap">
                <span class="font-semibold block text-gray-900">{{ $donation->created_at->format('d M, Y') }}</span>
                <span class="text-[11px] text-gray-400">{{ $donation->created_at->format('h:i A') }}</span>
              </td>

              {{-- Actions --}}
              <td class="px-4 py-3.5 text-center">
                <div class="flex items-center justify-center gap-1.5">
                  <a href="{{ route('admin.donations.show', $donation->id) }}"
                     class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 flex items-center justify-center transition"
                     title="বিস্তারিত দেখুন">
                    <i class="ri-eye-line text-sm"></i>
                  </a>

                  <form action="{{ route('admin.donations.destroy', $donation->id) }}"
                        method="POST"
                        onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই অনুদানের তথ্যটি মুছে ফেলতে চান?');"
                        class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 flex items-center justify-center transition"
                            title="মুছে ফেলুন">
                      <i class="ri-delete-bin-line text-sm"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="p-12 text-center text-gray-400">
                <i class="ri-heart-add-line text-5xl text-gray-300 block mb-3"></i>
                <p class="text-sm font-semibold text-gray-600">কোনো অনুদানের তথ্য পাওয়া যায়নি।</p>
                <p class="text-xs text-gray-400 mt-1">ফিল্টারিং পরিবর্তন করুন অথবা নতুন অনুদান এন্ট্রি করুন।</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($donations->hasPages())
      <div class="px-4 py-3 border-t border-gray-200 bg-gray-50/50">
        {{ $donations->links() }}
      </div>
    @endif
  </div>
</div>
@endsection

