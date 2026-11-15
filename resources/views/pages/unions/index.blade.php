@extends('layouts.website.website-layout')

@section('title', 'ইউনিয়ন পরিচিতি — শৈলকূপা উপজেলা')

@php
  if (!function_exists('toBnNum')) {
      function toBnNum($number) {
          $bn = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
          return str_replace(range(0, 9), $bn, (string)$number);
      }
  }
@endphp

@section('content')
<main class="min-h-screen bg-gray-50/50 py-6 sm:py-8">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs font-semibold text-gray-500 bg-white px-4 py-2.5 rounded-xl border border-gray-200/80 shadow-2xs">
      <a href="{{ route('home') }}" class="hover:text-[#0b4622] flex items-center gap-1 transition">
        <i class="ri-home-4-line text-sm"></i>
        <span>হোম</span>
      </a>
      <i class="ri-arrow-right-s-line text-gray-400"></i>
      <span class="text-gray-400">উপজেলা পরিচিতি</span>
      <i class="ri-arrow-right-s-line text-gray-400"></i>
      <span class="text-[#0b4622] font-bold">ইউনিয়ন পরিচিতি</span>
    </nav>

    {{-- Header Banner --}}
    <div class="bg-gradient-to-r from-[#0b4622] via-[#0d592b] to-[#08351a] rounded-3xl p-6 sm:p-10 text-white shadow-xl relative overflow-hidden">
      <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
      <div class="relative z-10 max-w-3xl space-y-3">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-emerald-200 text-xs font-bold tracking-wide">
          <i class="ri-community-line"></i>
          <span>শৈলকূপা উপজেলা প্রশাসন</span>
        </div>
        <h1 class="text-2xl sm:text-4xl font-black tracking-tight text-white">
          শৈলকূপার ইউনিয়ন পরিষদসমূহ
        </h1>
        <p class="text-xs sm:text-sm text-emerald-100/90 leading-relaxed">
          ঐতিহ্যবাহী শৈলকূপা উপজেলার ১৪টি ইউনিয়ন পরিষদের পরিচিতি, চেয়ারম্যান ও মেম্বারদের তথ্য, ভৌগোলিক পরিসংখ্যান এবং নাগরিক সেবা এক নজরে।
        </p>

        {{-- Top Badges --}}
        <div class="flex flex-wrap items-center gap-2.5 pt-2 text-xs font-bold text-white">
          <span class="px-3 py-1 rounded-lg bg-white/15 backdrop-blur-xs flex items-center gap-1.5">
            <i class="ri-community-line text-emerald-300"></i> ১৪টি ইউনিয়ন পরিষদ
          </span>
          <span class="px-3 py-1 rounded-lg bg-white/15 backdrop-blur-xs flex items-center gap-1.5">
            <i class="ri-team-line text-emerald-300"></i> নির্বাচিত জনপ্রতিনিধিবৃন্দ
          </span>
          <span class="px-3 py-1 rounded-lg bg-white/15 backdrop-blur-xs flex items-center gap-1.5">
            <i class="ri-map-pin-2-line text-emerald-300"></i> ঝিনাইদহ জেলা
          </span>
        </div>
      </div>
    </div>

    {{-- Union Cards Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @forelse($unions as $idx => $union)
        <div class="bg-white rounded-2xl border border-gray-200/90 shadow-2xs hover:shadow-md transition-all duration-300 flex flex-col overflow-hidden group">
          {{-- Card Image Header --}}
          <div class="relative aspect-16/9 bg-gray-100 overflow-hidden">
            <img src="{{ $union->thumbnail_url }}"
                 alt="{{ $union->name }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>

            <div class="absolute top-3 left-3">
              <span class="px-2.5 py-1 rounded-lg bg-[#0b4622]/90 backdrop-blur-xs text-white text-[11px] font-bold shadow-xs">
                {{ toBnNum($idx + 1) }} নং ইউনিয়ন
              </span>
            </div>

            <div class="absolute bottom-3 left-3 right-3 text-white">
              <h3 class="text-lg font-black tracking-tight drop-shadow-sm">
                {{ $union->name }}
              </h3>
              @if($union->location)
                <p class="text-[11px] text-gray-200 flex items-center gap-1 mt-0.5 truncate">
                  <i class="ri-map-pin-line text-emerald-400"></i>
                  <span>{{ $union->location }}</span>
                </p>
              @endif
            </div>
          </div>

          {{-- Card Body --}}
          <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between space-y-4">
            {{-- Quick Statistics Badges --}}
            <div class="grid grid-cols-3 gap-2 text-center text-xs">
              <div class="bg-gray-50 p-2 rounded-xl border border-gray-100">
                <span class="text-[10px] text-gray-500 block font-semibold">আয়তন</span>
                <span class="font-bold text-gray-900">{{ $union->area_sq_km ? $union->area_sq_km . ' কিমি²' : '—' }}</span>
              </div>
              <div class="bg-gray-50 p-2 rounded-xl border border-gray-100">
                <span class="text-[10px] text-gray-500 block font-semibold">জনসংখ্যা</span>
                <span class="font-bold text-[#0b4622]">{{ $union->population ?: '—' }}</span>
              </div>
              <div class="bg-gray-50 p-2 rounded-xl border border-gray-100">
                <span class="text-[10px] text-gray-500 block font-semibold">গ্রাম সংখ্যা</span>
                <span class="font-bold text-gray-900">{{ $union->village_count ? toBnNum($union->village_count) : '—' }}</span>
              </div>
            </div>

            {{-- Chairman Preview --}}
            @if($union->chairman)
              <div class="bg-emerald-50/50 rounded-xl p-3 border border-emerald-100/80 flex items-center gap-3">
                <img src="{{ $union->chairman->photo_url }}"
                     alt="{{ $union->chairman->name }}"
                     class="w-11 h-11 rounded-full object-cover border-2 border-white shadow-2xs shrink-0">
                <div class="min-w-0 flex-1">
                  <span class="text-[10px] font-bold uppercase tracking-wider text-[#0b4622] block">ইউপি চেয়ারম্যান</span>
                  <h4 class="text-xs sm:text-sm font-bold text-gray-900 truncate">{{ $union->chairman->name }}</h4>
                  @if($union->chairman->phone)
                    <a href="tel:{{ $union->chairman->phone }}" class="text-[11px] text-gray-500 hover:text-[#0b4622] flex items-center gap-1 mt-0.5 font-mono">
                      <i class="ri-phone-fill text-[#0b4622]"></i> {{ $union->chairman->phone }}
                    </a>
                  @endif
                </div>
              </div>
            @endif

            {{-- Card Footer Links --}}
            <div class="pt-2 border-t border-gray-100 flex items-center gap-2">
              <a href="{{ route('unions.detail', $union->slug) }}"
                 class="flex-1 py-2 px-3 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl text-center transition flex items-center justify-center gap-1.5 shadow-2xs">
                <span>বিস্তারিত দেখুন</span>
                <i class="ri-arrow-right-line"></i>
              </a>

              <a href="{{ route('unions.detail', $union->slug) }}#member"
                 class="py-2 px-3 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl text-center transition flex items-center gap-1"
                 title="জনপ্রতিনিধিদের তালিকা">
                <i class="ri-team-line text-sm"></i>
                <span class="hidden sm:inline">জনপ্রতিনিধি</span>
              </a>
            </div>
          </div>
        </div>
      @empty
        <div class="col-span-full bg-white rounded-2xl border border-gray-200 p-12 text-center text-gray-400">
          <i class="ri-community-line text-5xl text-gray-300 block mb-3"></i>
          <p class="text-sm font-semibold">কোনো ইউনিয়ন পরিষদের তথ্য যোগ করা হয়নি।</p>
        </div>
      @endforelse
    </div>

  </div>
</main>
@endsection
