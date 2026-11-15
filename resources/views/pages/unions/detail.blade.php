@extends('layouts.website.website-layout')

@section('title', $union->name . ' — শৈলকূপা')

@push('styles')
<style>
  .slider-wrapper {
    position: relative;
    width: 100%;
    overflow: hidden;
    border-radius: 1.5rem;
  }
  .slider-track {
    display: flex;
    transition: transform 0.5s ease-in-out;
  }
  .slider-slide {
    min-width: 100%;
    height: 240px;
  }
  @media (min-width: 640px) {
    .slider-slide { height: 380px; }
  }
  @media (min-width: 1024px) {
    .slider-slide { height: 480px; }
  }
  .slider-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .slider-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.9);
    border: none;
    border-radius: 9999px;
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transition: all 0.2s;
    z-index: 20;
  }
  .slider-btn:hover {
    background: #ffffff;
    transform: translateY(-50%) scale(1.08);
  }
  .slider-dots {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 0.75rem;
  }
  .slider-dot {
    width: 10px;
    height: 10px;
    border-radius: 9999px;
    background: #d1d5db;
    cursor: pointer;
    transition: all 0.3s;
  }
  .slider-dot.active {
    background: #0b4622;
    width: 26px;
  }
  .prose p { margin-bottom: 0.85rem; line-height: 1.75; color: #374151; }
  .prose h3, .prose h4 { color: #0b4622; font-weight: 800; margin-top: 1.25rem; margin-bottom: 0.5rem; }
  .prose ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1rem; color: #374151; }
  .prose li { margin-bottom: 0.35rem; }
</style>
@endpush

@php
  if (!function_exists('toBnUnionNum')) {
    function toBnUnionNum($number) {
        $bn = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        return str_replace(range(0, 9), $bn, (string)$number);
    }
  }
@endphp

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10 space-y-8">

  {{-- Breadcrumb --}}
  <nav class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 bg-white px-4 py-2.5 rounded-xl border border-gray-200/80 shadow-2xs flex-wrap">
    <a href="{{ route('home') }}" class="hover:text-[#0b4622] flex items-center gap-1 transition">
      <i class="ri-home-4-line"></i><span>হোম</span>
    </a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <span class="text-gray-400">উপজেলা পরিচিতি</span>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <a href="{{ route('unions.index') }}" class="hover:text-[#0b4622] transition">ইউনিয়ন পরিচিতি</a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <span class="text-[#0b4622] font-bold">{{ $union->name }}</span>
  </nav>

  {{-- 1. FULL WIDTH BANNER / IMAGE SLIDER --}}
  <div class="w-full">
    @if($union->images->count() > 0)
      <div class="slider-wrapper bg-gray-100 shadow-md">
        <div class="slider-track" id="sliderTrack">
          @foreach($union->images as $img)
            <div class="slider-slide">
              <img src="{{ $img->url }}" alt="{{ $union->name }}">
            </div>
          @endforeach
        </div>
        @if($union->images->count() > 1)
          <button class="slider-btn left-4" onclick="slideMove(-1)" aria-label="Previous Slide">
            <i class="ri-arrow-left-s-line text-2xl text-gray-800"></i>
          </button>
          <button class="slider-btn right-4" onclick="slideMove(1)" aria-label="Next Slide">
            <i class="ri-arrow-right-s-line text-2xl text-gray-800"></i>
          </button>
        @endif
      </div>
      @if($union->images->count() > 1)
        <div class="slider-dots" id="sliderDots">
          @foreach($union->images as $i => $img)
            <div class="slider-dot {{ $i === 0 ? 'active' : '' }}" onclick="goToSlide({{ $i }})"></div>
          @endforeach
        </div>
      @endif
    @else
      <div class="w-full h-56 sm:h-72 lg:h-80 bg-gradient-to-br from-[#0b4622]/15 via-[#0b4622]/10 to-emerald-50 rounded-2xl flex flex-col items-center justify-center border border-gray-100">
        <i class="ri-community-line text-7xl text-[#0b4622]/30 mb-2"></i>
        <span class="text-sm font-semibold text-gray-400">{{ $union->name }}</span>
      </div>
    @endif
  </div>

  {{-- 2. UNION TITLE & QUICK STATISTICS BADGES --}}
  <div class="bg-white rounded-2xl border border-gray-200/90 shadow-2xs p-6 sm:p-8 space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <div class="flex flex-wrap items-center gap-2 mb-2">
          <span class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-50 text-[#0b4622] text-xs font-bold rounded-full border border-emerald-200">
            <i class="ri-community-line"></i> ইউনিয়ন পরিষদ
          </span>
          @if($union->location)
            <span class="inline-flex items-center gap-1 px-3 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded-full border border-gray-200">
              <i class="ri-map-pin-2-line text-[#0b4622]"></i> {{ $union->location }}
            </span>
          @endif
        </div>

        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-gray-900 tracking-tight leading-tight">
          {{ $union->name }}
        </h1>

        @if($union->short_description)
          <p class="text-xs sm:text-sm text-gray-600 mt-2 max-w-3xl leading-relaxed">
            {{ $union->short_description }}
          </p>
        @endif
      </div>

      <div class="flex flex-wrap items-center gap-2 shrink-0 self-start md:self-center">
        @if($union->map_url)
          <a href="{{ $union->map_url }}" target="_blank"
             class="inline-flex items-center gap-1.5 px-4 py-2 border border-gray-300 rounded-xl text-xs font-bold text-gray-700 bg-white hover:bg-gray-50 transition shadow-2xs">
            <i class="ri-map-2-line text-red-500"></i> গুগল ম্যাপ
          </a>
        @endif
        <a href="#member"
           class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0b4622] hover:bg-[#08351a] text-white rounded-xl text-xs font-bold transition shadow-2xs">
          <i class="ri-team-line"></i> জনপ্রতিনিধি
        </a>
      </div>
    </div>

    {{-- QUICK STATISTICS BADGES GRID --}}
    <div class="pt-5 border-t border-gray-100">
      <h2 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3 flex items-center gap-1.5">
        <i class="ri-bar-chart-2-line text-[#0b4622]"></i>
        <span>এক নজরে ইউনিয়ন পরিসংখ্যান</span>
      </h2>

      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        {{-- Area --}}
        <div class="bg-gray-50/80 p-3.5 rounded-2xl border border-gray-200/80 text-center">
          <span class="text-[11px] text-gray-500 block font-semibold">মোট আয়তন</span>
          <span class="text-sm sm:text-base font-black text-gray-900 mt-0.5 block">
            {{ $union->area_sq_km ? $union->area_sq_km . ' কিমি²' : '—' }}
          </span>
        </div>

        {{-- Population --}}
        <div class="bg-blue-50/60 p-3.5 rounded-2xl border border-blue-100 text-center">
          <span class="text-[11px] text-blue-700 block font-semibold">মোট জনসংখ্যা</span>
          <span class="text-sm sm:text-base font-black text-blue-900 mt-0.5 block">
            {{ $union->population ?: '—' }}
          </span>
        </div>

        {{-- Voters --}}
        <div class="bg-purple-50/60 p-3.5 rounded-2xl border border-purple-100 text-center">
          <span class="text-[11px] text-purple-700 block font-semibold">ভোটার সংখ্যা</span>
          <span class="text-sm sm:text-base font-black text-purple-900 mt-0.5 block">
            {{ $union->voter_count ?: '—' }}
          </span>
        </div>

        {{-- Villages --}}
        <div class="bg-emerald-50/60 p-3.5 rounded-2xl border border-emerald-100 text-center">
          <span class="text-[11px] text-[#0b4622] block font-semibold">গ্রাম সংখ্যা</span>
          <span class="text-sm sm:text-base font-black text-[#0b4622] mt-0.5 block">
            {{ $union->village_count ? toBnUnionNum($union->village_count) . ' টি' : '—' }}
          </span>
        </div>

        {{-- Mouzas --}}
        <div class="bg-amber-50/60 p-3.5 rounded-2xl border border-amber-100 text-center">
          <span class="text-[11px] text-amber-700 block font-semibold">মৌজার সংখ্যা</span>
          <span class="text-sm sm:text-base font-black text-amber-900 mt-0.5 block">
            {{ $union->mouza_count ? toBnUnionNum($union->mouza_count) . ' টি' : '—' }}
          </span>
        </div>

        {{-- Literacy --}}
        <div class="bg-rose-50/60 p-3.5 rounded-2xl border border-rose-100 text-center">
          <span class="text-[11px] text-rose-700 block font-semibold">সাক্ষরতার হার</span>
          <span class="text-sm sm:text-base font-black text-rose-900 mt-0.5 block">
            {{ $union->literacy_rate ?: '—' }}
          </span>
        </div>
      </div>
    </div>
  </div>

  {{-- 3. MEMBERS SECTION (CHAIRMAN & MEMBERS) --}}
  <div class="space-y-4" id="member">
    {{-- Also anchor target for #chairman and #members --}}
    <div id="chairman" class="scroll-mt-24"></div>
    <div id="members" class="scroll-mt-24"></div>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
      <div>
        <h2 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
          <i class="ri-team-line text-[#0b4622]"></i>
          <span>ইউনিয়ন পরিষদ ব্যক্তিবর্গ</span>
          <span class="text-xs font-bold bg-[#0b4622]/10 text-[#0b4622] px-2.5 py-0.5 rounded-full ml-1">
            {{ toBnUnionNum($union->members->count()) }} জন
          </span>
        </h2>
        <p class="text-xs text-gray-500 mt-0.5">ইউপি চেয়ারম্যান, সাধারণ মেম্বার ও সংরক্ষিত মহিলা মেম্বারদের তথ্য</p>
      </div>

      {{-- Role Quick Filter Pills --}}
      <div class="flex items-center gap-1.5 overflow-x-auto text-xs font-bold pb-1" id="member-filter-btns">
        <button type="button" onclick="filterMembers('all', this)" class="px-3 py-1.5 rounded-xl bg-[#0b4622] text-white transition member-filter-btn shadow-2xs">সকল</button>
        <button type="button" onclick="filterMembers('chairman', this)" class="px-3 py-1.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 transition member-filter-btn">চেয়ারম্যান</button>
        <button type="button" onclick="filterMembers('member', this)" class="px-3 py-1.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 transition member-filter-btn">সাধারণ সদস্য</button>
        <button type="button" onclick="filterMembers('female_member', this)" class="px-3 py-1.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 transition member-filter-btn">মহিলা সদস্য</button>
      </div>
    </div>

    @if($union->members->count() > 0)
      @php
        $hasQualification = $union->members->contains(fn($m) => !empty(trim((string)$m->qualification)));
        $hasPhone = $union->members->contains(fn($m) => !empty(trim((string)$m->phone)));
        $hasEmail = $union->members->contains(fn($m) => !empty(trim((string)$m->email)));
      @endphp

      {{-- Desktop View (Full Wide Table) --}}
      <div class="hidden md:block bg-white rounded-2xl border border-gray-300 overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse text-xs sm:text-sm">
            <thead class="bg-gray-50 border-b border-gray-300 text-gray-700 text-xs font-bold uppercase tracking-wider">
              <tr>
                <th class="px-4 py-3 text-center w-12 border-r border-gray-200">ক্র.</th>
                <th class="px-3 py-3 w-36 border-r border-gray-200 text-center">ছবি</th>
                <th class="px-4 py-3 border-r border-gray-200">নাম</th>
                <th class="px-4 py-3 border-r border-gray-200">পদবি</th>
                @if($hasQualification)
                  <th class="px-4 py-3 border-r border-gray-200">শিক্ষাগত যোগ্যতা</th>
                @endif
                @if($hasPhone)
                  <th class="px-4 py-3 border-r border-gray-200">ফোন / মোবাইল</th>
                @endif
                @if($hasEmail)
                  <th class="px-4 py-3">ইমেইল</th>
                @endif
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200" id="desktop-members-body">
              @foreach($union->members as $idx => $member)
                <tr class="hover:bg-emerald-50/30 transition align-middle member-row" data-type="{{ $member->member_type }}">
                  {{-- SL --}}
                  <td class="px-4 py-3 text-center font-bold text-gray-600 border-r border-gray-200 align-middle">
                    {{ toBnUnionNum($idx + 1) }}
                  </td>

                  {{-- Photo (Large Desktop Photo) --}}
                  <td class="px-3 py-3 border-r border-gray-200 text-center align-middle">
                    <img src="{{ $member->photo_url }}"
                         alt="{{ $member->name }}"
                         class="w-24 h-32 md:w-28 md:h-36 object-cover rounded-xl border border-gray-300 mx-auto shadow-2xs">
                  </td>

                  {{-- Name --}}
                  <td class="px-4 py-3 font-bold text-gray-900 border-r border-gray-200 whitespace-nowrap align-middle">
                    <span class="block text-sm">{{ $member->name }}</span>
                    @if($member->member_type === 'chairman')
                      <span class="inline-block mt-1 text-[10px] font-bold bg-amber-100 text-amber-800 px-2 py-0.5 rounded-full">ইউপি চেয়ারম্যান</span>
                    @elseif($member->member_type === 'female_member')
                      <span class="inline-block mt-1 text-[10px] font-bold bg-rose-50 text-rose-700 px-2 py-0.5 rounded-full">সংরক্ষিত নারী সদস্য</span>
                    @endif
                  </td>

                  {{-- Designation --}}
                  <td class="px-4 py-3 font-semibold text-[#0b4622] border-r border-gray-200 whitespace-nowrap align-middle">
                    {{ $member->designation }}
                  </td>

                  {{-- Qualification --}}
                  @if($hasQualification)
                    <td class="px-4 py-3 text-gray-700 border-r border-gray-200 align-middle">
                      {{ $member->qualification ?: '—' }}
                    </td>
                  @endif

                  {{-- Phone --}}
                  @if($hasPhone)
                    <td class="px-4 py-3 text-gray-700 border-r border-gray-200 whitespace-nowrap align-middle">
                      @if($member->phone)
                        <a href="tel:{{ $member->phone }}" class="text-[#0b4622] hover:underline font-semibold font-mono">
                          {{ $member->phone }}
                        </a>
                      @else
                        <span class="text-gray-400">—</span>
                      @endif
                    </td>
                  @endif

                  {{-- Email --}}
                  @if($hasEmail)
                    <td class="px-4 py-3 text-gray-700 whitespace-nowrap align-middle">
                      @if($member->email)
                        <a href="mailto:{{ $member->email }}" class="text-blue-600 hover:underline">
                          {{ $member->email }}
                        </a>
                      @else
                        <span class="text-gray-400">—</span>
                      @endif
                    </td>
                  @endif
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      {{-- Mobile View (Responsive 2-Column Attribute Table per Member with Colspan 2 Centered Image) --}}
      <div class="block md:hidden space-y-4" id="mobile-members-container">
        @foreach($union->members as $idx => $member)
          <div class="border border-gray-300 rounded-xl overflow-hidden bg-white shadow-2xs member-mobile-card" data-type="{{ $member->member_type }}">
            <table class="w-full text-xs sm:text-sm border-collapse">
              <tbody>
                {{-- Row 1: Image centered across 2 columns --}}
                <tr class="bg-gray-50 border-b border-gray-200">
                  <td colspan="2" class="p-5 text-center">
                    <img src="{{ $member->photo_url }}"
                         alt="{{ $member->name }}"
                         class="w-32 h-40 sm:w-36 sm:h-44 object-cover rounded-xl border border-gray-300 shadow-xs mx-auto">
                    @if($member->member_type === 'chairman')
                      <span class="inline-block mt-2 text-xs font-bold bg-amber-100 text-amber-800 px-3 py-1 rounded-full">ইউপি চেয়ারম্যান</span>
                    @elseif($member->member_type === 'female_member')
                      <span class="inline-block mt-2 text-xs font-bold bg-rose-50 text-rose-700 px-3 py-1 rounded-full">সংরক্ষিত নারী সদস্য</span>
                    @endif
                  </td>
                </tr>

                {{-- Name --}}
                <tr class="border-b border-gray-200">
                  <th class="w-28 sm:w-32 bg-gray-50/80 px-3.5 py-2.5 text-left font-semibold text-gray-700 border-r border-gray-200">নাম</th>
                  <td class="px-3.5 py-2.5 font-bold text-gray-900">{{ $member->name }}</td>
                </tr>

                {{-- Designation --}}
                <tr class="border-b border-gray-200">
                  <th class="bg-gray-50/80 px-3.5 py-2.5 text-left font-semibold text-gray-700 border-r border-gray-200">পদবি</th>
                  <td class="px-3.5 py-2.5 font-semibold text-[#0b4622]">{{ $member->designation }}</td>
                </tr>

                {{-- Qualification (if present) --}}
                @if(!empty(trim((string)$member->qualification)))
                  <tr class="border-b border-gray-200">
                    <th class="bg-gray-50/80 px-3.5 py-2.5 text-left font-semibold text-gray-700 border-r border-gray-200">শিক্ষাগত যোগ্যতা</th>
                    <td class="px-3.5 py-2.5 text-gray-700">{{ $member->qualification }}</td>
                  </tr>
                @endif

                {{-- Phone / Mobile (if present) --}}
                @if(!empty(trim((string)$member->phone)))
                  <tr class="border-b border-gray-200">
                    <th class="bg-gray-50/80 px-3.5 py-2.5 text-left font-semibold text-gray-700 border-r border-gray-200">ফোন / মোবাইল</th>
                    <td class="px-3.5 py-2.5 text-gray-700">
                      <a href="tel:{{ $member->phone }}" class="text-[#0b4622] font-semibold hover:underline font-mono">
                        {{ $member->phone }}
                      </a>
                    </td>
                  </tr>
                @endif

                {{-- Email (if present) --}}
                @if(!empty(trim((string)$member->email)))
                  <tr>
                    <th class="bg-gray-50/80 px-3.5 py-2.5 text-left font-semibold text-gray-700 border-r border-gray-200">ইমেইল</th>
                    <td class="px-3.5 py-2.5 text-gray-700">
                      <a href="mailto:{{ $member->email }}" class="text-blue-600 hover:underline break-all">
                        {{ $member->email }}
                      </a>
                    </td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
        @endforeach
      </div>
    @else
      <div class="bg-white rounded-2xl border border-gray-200 p-8 text-center text-gray-400">
        <i class="ri-user-search-line text-4xl block mb-2 text-gray-300"></i>
        <p class="text-sm font-semibold">কোনো জনপ্রতিনিধির তথ্য যুক্ত করা হয়নি।</p>
      </div>
    @endif
  </div>

  {{-- 4. UNION DESCRIPTION (QUILL CONTENT) --}}
  @if($union->description)
    <div class="bg-white rounded-2xl border border-gray-200/90 shadow-2xs p-6 sm:p-8 space-y-4">
      <h2 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2 pb-3 border-b border-gray-100">
        <i class="ri-article-line text-[#0b4622]"></i>
        <span>ইউনিয়ন পরিচিতি ও সার্বিক তথ্য</span>
      </h2>

      <div class="prose max-w-none text-gray-700 text-xs sm:text-sm leading-relaxed">
        {!! $union->description !!}
      </div>
    </div>
  @endif

  {{-- 5. CONTACT & OFFICE LOCATION CARD --}}
  <div class="bg-gradient-to-br from-emerald-50 via-white to-gray-50 rounded-2xl border border-emerald-200/80 p-6 sm:p-8 shadow-2xs">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
      <div class="space-y-2 max-w-2xl">
        <span class="text-xs font-bold text-[#0b4622] uppercase tracking-wider block">যোগাযোগ ও সেবা</span>
        <h3 class="text-lg sm:text-xl font-black text-gray-900">
          {{ $union->name }} কার্যালয়
        </h3>
        <p class="text-xs sm:text-sm text-gray-600">
          যেকোনো নাগরিক সেবা, পরামর্শ বা তথ্যের জন্য ইউনিয়ন পরিষদ ভবনে সরাসরি যোগাযোগ করুন অথবা হেল্পলাইনে কল করুন।
        </p>

        <div class="flex flex-wrap gap-4 pt-2 text-xs sm:text-sm text-gray-700">
          @if($union->location)
            <div class="flex items-center gap-1.5">
              <i class="ri-map-pin-2-fill text-red-500"></i>
              <span>{{ $union->location }}</span>
            </div>
          @endif

          @if($union->phone)
            <div class="flex items-center gap-1.5">
              <i class="ri-phone-fill text-[#0b4622]"></i>
              <a href="tel:{{ $union->phone }}" class="hover:underline font-bold text-gray-900">{{ $union->phone }}</a>
            </div>
          @endif

          @if($union->email)
            <div class="flex items-center gap-1.5">
              <i class="ri-mail-fill text-blue-600"></i>
              <a href="mailto:{{ $union->email }}" class="hover:underline text-gray-900">{{ $union->email }}</a>
            </div>
          @endif
        </div>
      </div>

      <div class="flex items-center gap-3 shrink-0">
        @if($union->map_url)
          <a href="{{ $union->map_url }}" target="_blank"
             class="px-5 py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs sm:text-sm font-bold rounded-xl transition shadow-xs flex items-center gap-2">
            <i class="ri-map-pin-line text-base"></i>
            <span>গুগল ম্যাপে দেখুন</span>
          </a>
        @endif

        <a href="{{ route('unions.index') }}"
           class="px-4 py-2.5 border border-gray-300 text-gray-700 text-xs sm:text-sm font-bold rounded-xl hover:bg-white transition shadow-2xs">
          সকল ইউনিয়ন
        </a>
      </div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
  // Image Slider Controller
  let currentSlide = 0;
  const track = document.getElementById('sliderTrack');
  const slides = document.querySelectorAll('.slider-slide');
  const dots = document.querySelectorAll('.slider-dot');
  const totalSlides = slides.length;

  function updateSlider() {
    if (track) {
      track.style.transform = `translateX(-${currentSlide * 100}%)`;
    }
    dots.forEach((dot, idx) => {
      dot.classList.toggle('active', idx === currentSlide);
    });
  }

  function slideMove(dir) {
    if (totalSlides <= 1) return;
    currentSlide = (currentSlide + dir + totalSlides) % totalSlides;
    updateSlider();
  }

  function goToSlide(index) {
    currentSlide = index;
    updateSlider();
  }

  // Auto slide every 5 seconds if multiple slides
  if (totalSlides > 1) {
    setInterval(() => {
      slideMove(1);
    }, 5000);
  }

  // Member Filter Pills
  function filterMembers(type, btn) {
    document.querySelectorAll('.member-filter-btn').forEach(b => {
      b.classList.remove('bg-[#0b4622]', 'text-white');
      b.classList.add('bg-gray-100', 'text-gray-700');
    });
    btn.classList.remove('bg-gray-100', 'text-gray-700');
    btn.classList.add('bg-[#0b4622]', 'text-white');

    // Desktop
    document.querySelectorAll('.member-row').forEach(row => {
      const rowType = row.getAttribute('data-type');
      if (type === 'all' || rowType === type) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });

    // Mobile
    document.querySelectorAll('.member-mobile-card').forEach(card => {
      const cardType = card.getAttribute('data-type');
      if (type === 'all' || cardType === type) {
        card.style.display = '';
      } else {
        card.style.display = 'none';
      }
    });
  }

  // Smooth scroll to anchor if URL has #member, #chairman, #members
  document.addEventListener('DOMContentLoaded', function() {
    const hash = window.location.hash;
    if (hash && (hash === '#member' || hash === '#chairman' || hash === '#members')) {
      const el = document.querySelector(hash);
      if (el) {
        setTimeout(() => {
          el.scrollIntoView({ behavior: 'smooth' });
        }, 200);
      }
    }
  });
</script>
@endpush
