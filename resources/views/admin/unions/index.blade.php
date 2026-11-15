@extends('layouts.admin.admin-layout')

@section('title', 'সকল ইউনিয়ন পরিষদ')

@php
  if (!function_exists('toBnNum')) {
      function toBnNum($number) {
          $bn = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
          return str_replace(range(0, 9), $bn, (string)$number);
      }
  }
@endphp

@section('content')
<div class="space-y-6">
  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight flex items-center gap-2.5">
        <span class="w-10 h-10 rounded-xl bg-emerald-50 text-[#0b4622] flex items-center justify-center text-xl shadow-2xs">
          <i class="ri-community-line"></i>
        </span>
        <span>ইউনিয়ন পরিষদ পরিচিতি ও ব্যবস্থাপনা</span>
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-1 font-medium">শৈলকূপা উপজেলার সকল ইউনিয়ন, চেয়ারম্যান ও মেম্বারদের তথ্য ব্যবস্থাপনা</p>
    </div>

    <div class="flex items-center gap-2">
      <a href="{{ route('admin.unions.create') }}"
         class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white rounded-xl text-xs sm:text-sm font-bold shadow-xs hover:shadow transition">
        <i class="ri-add-circle-line text-base"></i>
        <span>নতুন ইউনিয়ন যোগ করুন</span>
      </a>
    </div>
  </div>

  {{-- Metrics Cards --}}
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-2xs flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold text-gray-500">মোট ইউনিয়ন</p>
        <h3 class="text-2xl font-black text-[#0b4622] mt-1">{{ toBnNum($totalUnions) }} টি</h3>
      </div>
      <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#0b4622] flex items-center justify-center text-2xl">
        <i class="ri-community-line"></i>
      </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-2xs flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold text-gray-500">সক্রিয় ইউনিয়ন</p>
        <h3 class="text-2xl font-black text-emerald-600 mt-1">{{ toBnNum($activeUnions) }} টি</h3>
      </div>
      <div class="w-12 h-12 rounded-xl bg-green-50 text-emerald-600 flex items-center justify-center text-2xl">
        <i class="ri-checkbox-circle-line"></i>
      </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-2xs flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold text-gray-500">মোট চেয়ারম্যান ও মেম্বার</p>
        <h3 class="text-2xl font-black text-blue-600 mt-1">{{ toBnNum($totalMembers) }} জন</h3>
      </div>
      <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl">
        <i class="ri-team-line"></i>
      </div>
    </div>
  </div>

  {{-- Search Bar --}}
  <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-2xs">
    <form action="{{ route('admin.unions.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
      <div class="relative flex-1">
        <input type="text"
               name="search"
               value="{{ $search }}"
               placeholder="ইউনিয়নের নাম বা অবস্থান দিয়ে খুঁজুন..."
               class="w-full pl-9 pr-3 py-2 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622] transition">
        <i class="ri-search-line absolute left-3 top-2.5 text-gray-400"></i>
      </div>

      <button type="submit" class="px-5 py-2 bg-gray-900 hover:bg-black text-white text-xs sm:text-sm font-bold rounded-xl transition flex items-center justify-center gap-1.5 shadow-2xs">
        <i class="ri-search-line"></i> খুঁজুন
      </button>

      @if($search)
        <a href="{{ route('admin.unions.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-semibold rounded-xl transition flex items-center justify-center gap-1">
          <i class="ri-close-line"></i> রিসেট
        </a>
      @endif
    </form>
  </div>

  {{-- Unions Table --}}
  <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-2xs">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse text-xs sm:text-sm">
        <thead class="bg-gray-50 border-b border-gray-200 text-gray-600 font-bold uppercase tracking-wider text-[11px]">
          <tr>
            <th class="px-4 py-3.5 text-center w-12 border-r border-gray-200">ক্রম</th>
            <th class="px-4 py-3.5 border-r border-gray-200">ইউনিয়নের নাম</th>
            <th class="px-4 py-3.5 border-r border-gray-200">অবস্থান / ঠিকানা</th>
            <th class="px-4 py-3.5 border-r border-gray-200">ইউপি চেয়ারম্যান</th>
            <th class="px-4 py-3.5 border-r border-gray-200 text-center">ব্যক্তিবর্গ</th>
            <th class="px-4 py-3.5 border-r border-gray-200">পরিসংখ্যান (এক নজরে)</th>
            <th class="px-4 py-3.5 border-r border-gray-200 text-center w-24">স্ট্যাটাস</th>
            <th class="px-4 py-3.5 text-center w-28">অ্যাকশন</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          @forelse($unions as $idx => $union)
            <tr class="hover:bg-gray-50/60 transition align-middle">
              {{-- SL --}}
              <td class="px-4 py-3.5 text-center font-bold text-gray-500 border-r border-gray-200">
                {{ toBnNum($unions->firstItem() + $idx) }}
              </td>

              {{-- Name & Thumbnail --}}
              <td class="px-4 py-3.5 border-r border-gray-200">
                <div class="flex items-center gap-3">
                  <img src="{{ $union->thumbnail_url }}"
                       alt="{{ $union->name }}"
                       class="w-12 h-12 rounded-xl object-cover border border-gray-200 shrink-0 shadow-2xs">
                  <div>
                    <a href="{{ route('admin.unions.edit', $union->id) }}" class="font-bold text-gray-900 hover:text-[#0b4622] transition block">
                      {{ $union->name }}
                    </a>
                    <span class="text-[11px] text-gray-400 font-mono">/unions/{{ $union->slug }}</span>
                  </div>
                </div>
              </td>

              {{-- Location --}}
              <td class="px-4 py-3.5 border-r border-gray-200 text-gray-700">
                <span class="flex items-center gap-1 font-medium">
                  <i class="ri-map-pin-line text-red-500"></i>
                  {{ $union->location ?: '—' }}
                </span>
                @if($union->phone)
                  <span class="block text-[11px] text-gray-500 mt-0.5">
                    <i class="ri-phone-line text-[#0b4622]"></i> {{ $union->phone }}
                  </span>
                @endif
              </td>

              {{-- Chairman --}}
              <td class="px-4 py-3.5 border-r border-gray-200">
                @if($union->chairman)
                  <div class="flex items-center gap-2">
                    <img src="{{ $union->chairman->photo_url }}"
                         alt="{{ $union->chairman->name }}"
                         class="w-8 h-8 rounded-full object-cover border border-gray-200 shrink-0">
                    <div>
                      <span class="font-bold text-gray-900 block">{{ $union->chairman->name }}</span>
                      <span class="text-[10px] text-[#0b4622] font-semibold">{{ $union->chairman->designation }}</span>
                    </div>
                  </div>
                @else
                  <span class="text-xs text-gray-400 italic">চেয়ারম্যান নির্ধারিত নেই</span>
                @endif
              </td>

              {{-- Members Count --}}
              <td class="px-4 py-3.5 border-r border-gray-200 text-center">
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-[#0b4622]">
                  <i class="ri-user-line"></i> {{ toBnNum($union->members_count) }} জন
                </span>
              </td>

              {{-- Statistics Badges --}}
              <td class="px-4 py-3.5 border-r border-gray-200 text-xs">
                <div class="flex flex-wrap gap-1">
                  @if($union->area_sq_km)
                    <span class="px-2 py-0.5 bg-gray-100 rounded text-[11px] font-medium text-gray-700">আয়তন: {{ $union->area_sq_km }} কিমি²</span>
                  @endif
                  @if($union->population)
                    <span class="px-2 py-0.5 bg-blue-50 text-blue-700 rounded text-[11px] font-medium">জনসংখ্যা: {{ $union->population }}</span>
                  @endif
                  @if($union->village_count)
                    <span class="px-2 py-0.5 bg-emerald-50 text-[#0b4622] rounded text-[11px] font-medium">গ্রাম: {{ toBnNum($union->village_count) }}</span>
                  @endif
                </div>
              </td>

              {{-- Status --}}
              <td class="px-4 py-3.5 border-r border-gray-200 text-center">
                <form action="{{ route('admin.unions.status', $union->id) }}" method="POST">
                  @csrf
                  @method('PATCH')
                  <button type="submit"
                          class="px-2.5 py-1 rounded-full text-xs font-bold transition {{ $union->status ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' : 'bg-red-50 text-red-700 hover:bg-red-100' }}"
                          title="স্ট্যাটাস পরিবর্তন করতে ক্লিক করুন">
                    {{ $union->status ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}
                  </button>
                </form>
              </td>

              {{-- Actions --}}
              <td class="px-4 py-3.5 text-center">
                <div class="flex items-center justify-center gap-1.5">
                  {{-- Public View --}}
                  <a href="{{ route('unions.detail', $union->slug) }}"
                     target="_blank"
                     class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 flex items-center justify-center transition"
                     title="পাবলিক পেজ দেখুন">
                    <i class="ri-external-link-line text-sm"></i>
                  </a>

                  {{-- Edit --}}
                  <a href="{{ route('admin.unions.edit', $union->id) }}"
                     class="w-8 h-8 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-[#0b4622] flex items-center justify-center transition"
                     title="সম্পাদনা">
                    <i class="ri-edit-line text-sm"></i>
                  </a>

                  {{-- Delete --}}
                  <form action="{{ route('admin.unions.destroy', $union->id) }}"
                        method="POST"
                        onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই ইউনিয়ন এবং এর সকল তথ্য মুছে ফেলতে চান?');"
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
                <i class="ri-community-line text-5xl text-gray-300 block mb-3"></i>
                <p class="text-sm font-semibold text-gray-600">কোনো ইউনিয়ন পাওয়া যায়নি।</p>
                <p class="text-xs text-gray-400 mt-1">নতুন ইউনিয়ন যোগ করতে ওপরের বাটনে ক্লিক করুন।</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($unions->hasPages())
      <div class="px-4 py-3 border-t border-gray-200 bg-gray-50/50">
        {{ $unions->links() }}
      </div>
    @endif
  </div>
</div>
@endsection
