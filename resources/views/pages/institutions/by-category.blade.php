@extends('layouts.website.website-layout')

@section('title', $category->name . ' — প্রতিষ্ঠান সমূহ | আগামীর শৈলকুপা')

@php
if (!function_exists('toBnCatNum')) {
    function toBnCatNum($number) {
        $bn = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        return str_replace(range(0, 9), $bn, (string)$number);
    }
}
@endphp

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-8">

  {{-- Breadcrumb --}}
  <nav class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 bg-white px-4 py-2.5 rounded-xl border border-gray-100 shadow-2xs flex-wrap">
    <a href="{{ route('home') }}" class="hover:text-[#0b4622] flex items-center gap-1 transition">
      <i class="ri-home-4-line"></i><span>হোম</span>
    </a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <a href="{{ route('institutions.home') }}" class="hover:text-[#0b4622] transition">প্রতিষ্ঠান সমূহ</a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <span class="text-[#0b4622] font-semibold">{{ $category->name }}</span>
  </nav>

  {{-- Header with View Switcher --}}
  <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 flex flex-col md:flex-row md:items-center justify-between gap-5">
    <div>
      <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-[#0b4622] border border-emerald-200 mb-2">
        <i class="ri-price-tag-3-line"></i> {{ $category->name }}
      </span>
      <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">{{ $category->name }}</h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-1">শৈলকূপার {{ $category->name }}-এর তালিকা</p>
    </div>

    <div class="flex flex-wrap items-center gap-3 shrink-0">
      {{-- Count Badge --}}
      <span class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold bg-gray-50 border border-gray-200 text-gray-700">
        <i class="ri-building-2-line text-[#0b4622]"></i>
        মোট {{ toBnCatNum($institutions->count()) }}টি প্রতিষ্ঠান
      </span>

      {{-- View Switcher Buttons (Grid vs List) --}}
      <div class="inline-flex items-center bg-gray-100 p-1 rounded-xl border border-gray-200">
        <button type="button" id="btn-grid-view" onclick="setViewMode('grid')"
                class="view-toggle-btn inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200"
                title="গ্রিড ভিউ">
          <i class="ri-grid-fill text-sm"></i>
          <span class="hidden sm:inline">গ্রিড ভিউ</span>
        </button>
        <button type="button" id="btn-list-view" onclick="setViewMode('list')"
                class="view-toggle-btn inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200"
                title="লিস্ট / টেবিল ভিউ">
          <i class="ri-list-check-2 text-sm"></i>
          <span class="hidden sm:inline">লিস্ট ভিউ</span>
        </button>
      </div>

      {{-- Back Button --}}
      <a href="{{ route('institutions.home') }}"
         class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold border border-gray-200 text-gray-600 hover:bg-gray-50 transition shadow-2xs">
        <i class="ri-arrow-left-line"></i> সকল ক্যাটাগরি
      </a>
    </div>
  </div>

  @if($institutions->isEmpty())
    <div class="text-center py-20 bg-white rounded-3xl border border-gray-100">
      <i class="ri-building-2-line text-6xl text-gray-200 block mb-4"></i>
      <h3 class="text-lg font-bold text-gray-500">এই ক্যাটাগরিতে এখনো কোনো প্রতিষ্ঠান যুক্ত হয়নি</h3>
      <p class="text-sm text-gray-400 mt-1">শীঘ্রই আপডেট করা হবে।</p>
      <a href="{{ route('institutions.home') }}" class="mt-4 inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#0b4622] text-white text-xs font-bold hover:bg-[#08351a] transition">
        <i class="ri-arrow-left-line"></i> ফিরে যান
      </a>
    </div>
  @else

    {{-- ============================================================== --}}
    {{-- 1. GRID VIEW (কার্ড আকার) --}}
    {{-- ============================================================== --}}
    <div id="institutions-grid-view" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 transition-opacity duration-300">
      @foreach($institutions as $institution)
        <a href="{{ route('institutions.detail', [$category->slug, $institution->slug]) }}"
           class="group bg-white rounded-2xl border border-gray-200/80 shadow-2xs hover:shadow-xl hover:border-[#0b4622]/30 transition-all duration-300 overflow-hidden flex flex-col">
          {{-- Thumbnail / Slider preview --}}
          <div class="relative h-52 bg-gray-100 overflow-hidden">
            @if($institution->images->count() > 0)
              <img src="{{ $institution->thumbnail_url }}"
                   alt="{{ $institution->name }}"
                   class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
              @if($institution->images->count() > 1)
                <div class="absolute bottom-3 right-3 bg-black/55 text-white text-[11px] px-2.5 py-0.5 rounded-full backdrop-blur-sm font-semibold flex items-center gap-1">
                  <i class="ri-image-2-line"></i>+{{ toBnCatNum($institution->images->count() - 1) }} ছবি
                </div>
              @endif
            @else
              <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#0b4622]/10 to-[#0b4622]/20">
                <i class="ri-building-2-line text-6xl text-[#0b4622]/30"></i>
              </div>
            @endif
            {{-- Category badge --}}
            <div class="absolute top-3 left-3">
              <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-white/95 text-[#0b4622] text-xs font-bold rounded-full backdrop-blur-sm shadow-sm">
                <i class="ri-price-tag-3-line"></i> {{ $category->name }}
              </span>
            </div>
          </div>

          {{-- Content --}}
          <div class="p-5 flex flex-col flex-1">
            <h3 class="font-bold text-gray-900 text-base leading-snug group-hover:text-[#0b4622] transition mb-1">
              {{ $institution->name }}
            </h3>

            @if($institution->location)
              <div class="flex items-center gap-1 text-xs text-gray-500 mb-2">
                <i class="ri-map-pin-line text-[#0b4622] shrink-0"></i>
                <span class="truncate">{{ $institution->location }}</span>
              </div>
            @endif

            @if($institution->description)
              <p class="text-xs text-gray-500 leading-relaxed line-clamp-2 flex-1">
                {!! strip_tags($institution->description) !!}
              </p>
            @endif

            <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-100">
              <div class="flex items-center gap-3 text-xs text-gray-500">
                @php $memberCount = $institution->members instanceof \Illuminate\Database\Eloquent\Collection ? $institution->members->count() : 0; @endphp
                @if($memberCount > 0)
                  <span class="flex items-center gap-1 font-medium">
                    <i class="ri-team-line text-[#0b4622]"></i> {{ toBnCatNum($memberCount) }} জন কর্মকর্তা
                  </span>
                @else
                  <span class="text-gray-400 text-[11px]">—</span>
                @endif
              </div>
              <span class="inline-flex items-center gap-1 text-xs font-bold text-[#0b4622] bg-[#0b4622]/10 px-3 py-1 rounded-full group-hover:bg-[#0b4622] group-hover:text-white transition">
                বিস্তারিত <i class="ri-arrow-right-line"></i>
              </span>
            </div>
          </div>
        </a>
      @endforeach
    </div>

    {{-- ============================================================== --}}
    {{-- 2. LIST VIEW (টেবিল আকার) --}}
    {{-- ============================================================== --}}
    <div id="institutions-list-view" class="hidden transition-opacity duration-300">
      <div class="bg-white rounded-2xl border border-gray-200/90 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse text-xs sm:text-sm">
            <thead class="bg-gray-50 border-b border-gray-200 text-gray-700 text-xs font-bold uppercase tracking-wider">
              <tr>
                <th class="px-4 py-3.5 text-center w-12">ক্র.</th>
                <th class="px-4 py-3.5 w-20">ছবি</th>
                <th class="px-4 py-3.5">প্রতিষ্ঠানের নাম</th>
                <th class="px-4 py-3.5">ক্যাটাগরি</th>
                <th class="px-4 py-3.5">অবস্থান / ঠিকানা</th>
                <th class="px-4 py-3.5 text-center">কর্মকর্তা</th>
                <th class="px-4 py-3.5 text-right w-28">অ্যাকশন</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              @foreach($institutions as $idx => $institution)
                <tr class="hover:bg-emerald-50/40 transition group">
                  {{-- SL --}}
                  <td class="px-4 py-3.5 text-center font-bold text-gray-600">
                    {{ toBnCatNum($idx + 1) }}
                  </td>
                  {{-- Thumbnail --}}
                  <td class="px-4 py-3.5">
                    <a href="{{ route('institutions.detail', [$category->slug, $institution->slug]) }}" class="block">
                      @if($institution->images->count() > 0)
                        <img src="{{ $institution->thumbnail_url }}" alt="{{ $institution->name }}"
                             class="w-14 h-12 object-cover rounded-lg border border-gray-200 group-hover:scale-105 transition-transform">
                      @else
                        <div class="w-14 h-12 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200">
                          <i class="ri-building-2-line text-gray-400 text-lg"></i>
                        </div>
                      @endif
                    </a>
                  </td>
                  {{-- Name --}}
                  <td class="px-4 py-3.5">
                    <a href="{{ route('institutions.detail', [$category->slug, $institution->slug]) }}"
                       class="font-bold text-gray-900 group-hover:text-[#0b4622] transition text-sm sm:text-base block">
                      {{ $institution->name }}
                    </a>
                    @if($institution->description)
                      <p class="text-xs text-gray-500 line-clamp-1 mt-0.5">
                        {!! strip_tags($institution->description) !!}
                      </p>
                    @endif
                  </td>
                  {{-- Category --}}
                  <td class="px-4 py-3.5 whitespace-nowrap">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-emerald-50 text-[#0b4622] text-xs font-semibold rounded-md border border-emerald-200">
                      {{ $category->name }}
                    </span>
                  </td>
                  {{-- Location --}}
                  <td class="px-4 py-3.5 text-gray-600">
                    @if($institution->location)
                      <span class="flex items-center gap-1 text-xs">
                        <i class="ri-map-pin-line text-[#0b4622] shrink-0"></i>
                        <span>{{ $institution->location }}</span>
                      </span>
                    @else
                      <span class="text-gray-400 text-xs">—</span>
                    @endif
                  </td>
                  {{-- Members Count --}}
                  <td class="px-4 py-3.5 text-center whitespace-nowrap">
                    @php $memberCount = $institution->members instanceof \Illuminate\Database\Eloquent\Collection ? $institution->members->count() : 0; @endphp
                    @if($memberCount > 0)
                      <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded-full">
                        <i class="ri-team-line text-[#0b4622]"></i> {{ toBnCatNum($memberCount) }} জন
                      </span>
                    @else
                      <span class="text-gray-400 text-xs">—</span>
                    @endif
                  </td>
                  {{-- Action --}}
                  <td class="px-4 py-3.5 text-right whitespace-nowrap">
                    <a href="{{ route('institutions.detail', [$category->slug, $institution->slug]) }}"
                       class="inline-flex items-center gap-1 px-3 py-1.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-lg transition shadow-2xs">
                      <span>বিস্তারিত</span>
                      <i class="ri-arrow-right-line"></i>
                    </a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

  @endif

</div>
@endsection

@push('scripts')
<script>
  // Function to switch between Grid and List view
  function setViewMode(mode) {
    const gridEl = document.getElementById('institutions-grid-view');
    const listEl = document.getElementById('institutions-list-view');
    const btnGrid = document.getElementById('btn-grid-view');
    const btnList = document.getElementById('btn-list-view');

    if (!gridEl || !listEl) return;

    if (mode === 'list') {
      gridEl.classList.add('hidden');
      listEl.classList.remove('hidden');

      // Update button styles
      btnList.className = 'view-toggle-btn inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 bg-[#0b4622] text-white shadow-xs';
      btnGrid.className = 'view-toggle-btn inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 text-gray-600 hover:text-gray-900';
    } else {
      listEl.classList.add('hidden');
      gridEl.classList.remove('hidden');

      // Update button styles
      btnGrid.className = 'view-toggle-btn inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 bg-[#0b4622] text-white shadow-xs';
      btnList.className = 'view-toggle-btn inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 text-gray-600 hover:text-gray-900';
    }

    // Save preference to localStorage without touching DB
    try {
      localStorage.setItem('institution_view_mode', mode);
    } catch(e) {}
  }

  // Initialize view mode from user preference (default: 'grid')
  document.addEventListener('DOMContentLoaded', function() {
    let savedMode = 'grid';
    try {
      savedMode = localStorage.getItem('institution_view_mode') || 'grid';
    } catch(e) {}

    // Check if URL query parameter overrides (e.g. ?view=list)
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('view')) {
      savedMode = urlParams.get('view');
    }

    setViewMode(savedMode === 'list' ? 'list' : 'grid');
  });
</script>
@endpush
