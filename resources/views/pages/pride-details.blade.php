@extends('layouts.website.website-layout')

@section('title', $pride->name . ' — শৈলকুপার কৃতি সন্তান | আগামীর শৈলকুপা')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
  
  <!-- Breadcrumb -->
  <nav class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 mb-6 bg-white px-4 py-2.5 rounded-xl border border-gray-100 shadow-2xs">
    <a href="{{ route('home') }}" class="hover:text-[#0b4622] flex items-center gap-1 transition">
      <i class="ri-home-4-line"></i>
      <span>হোম</span>
    </a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <a href="{{ route('our.pride') }}" class="hover:text-[#0b4622] transition">কৃতি সন্তান</a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <span class="text-[#0b4622] font-semibold truncate">{{ $pride->name }}</span>
  </nav>

  <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    
    <!-- Main Content Left (8 Cols) -->
    <div class="lg:col-span-8 bg-white rounded-3xl border border-gray-100 shadow-xs overflow-hidden p-6 sm:p-10 space-y-8">
      
      <!-- Profile Header (Image, Name & Designation) -->
      <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 border-b border-gray-100 pb-8 text-center sm:text-left">
        <!-- Photo -->
        <div class="w-36 h-36 sm:w-44 sm:h-44 rounded-3xl overflow-hidden bg-gray-100 border-4 border-white shadow-xl ring-4 ring-[#0b4622]/15 shrink-0">
          <img
            src="{{ $pride->photo_url }}"
            alt="{{ $pride->name }}"
            class="w-full h-full object-cover"
            onerror="this.src='https://placehold.co/400x400/0b4622/ffffff?text={{ urlencode($pride->name) }}'"
          >
        </div>

        <!-- Info -->
        <div class="space-y-3">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-[#0b4622] border border-emerald-200">
            <i class="ri-award-fill"></i> শৈলকুপার কৃতি সন্তান
          </span>
          <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
            {{ $pride->name }}
          </h1>
          <p class="text-xs sm:text-sm font-bold text-[#c8102e] bg-red-50/70 inline-block px-3 py-1 rounded-xl border border-red-100">
            {{ $pride->designation }}
          </p>
        </div>
      </div>

      <!-- Description / Biography (Quill Rich Text Content) -->
      <div class="space-y-4">
        <h2 class="text-lg sm:text-xl font-bold text-[#0b4622] border-b border-gray-100 pb-2 flex items-center gap-2">
          <i class="ri-article-line text-[#c8102e]"></i>
          <span>সংক্ষিপ্ত জীবনী ও অবদান</span>
        </h2>

        <div class="rich-text-content prose max-w-none text-gray-700 leading-relaxed text-sm sm:text-[15.5px]">
          @if(!empty($pride->description))
            {!! $pride->description !!}
          @else
            <p class="text-gray-500 italic">তাঁর বিস্তারিত জীবনী ও কর্মপ্রচেষ্টার বিবরণ শীঘ্রই হালনাগাদ করা হবে।</p>
          @endif
        </div>
      </div>

      <!-- Actions -->
      <div class="pt-6 border-t border-gray-100 flex flex-wrap items-center justify-between gap-3">
        <a
          href="{{ route('our.pride') }}"
          class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-bold rounded-xl transition"
        >
          <i class="ri-arrow-left-line"></i>
          <span>সকল কৃতি সন্তান দেখুন</span>
        </a>

        <a
          href="{{ route('home') }}"
          class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs sm:text-sm font-bold rounded-xl shadow-sm transition"
        >
          <i class="ri-home-4-line"></i>
          <span>হোমপেজে যান</span>
        </a>
      </div>

    </div>

    <!-- Right Sidebar (4 Cols) -->
    <div class="lg:col-span-4 space-y-6">
      <!-- Other Prides -->
      <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-5 sm:p-6 space-y-4">
        <h3 class="text-base font-extrabold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
          <i class="ri-user-star-line text-[#0b4622]"></i>
          <span>অন্যান্য কৃতি ব্যক্তিবর্গ</span>
        </h3>

        <div class="space-y-3.5">
          @forelse($recentPrides as $other)
            <a
              href="{{ route('our.pride.details', $other->id) }}"
              class="flex items-center gap-3 group p-2 rounded-xl hover:bg-gray-50 transition border border-transparent hover:border-gray-100"
            >
              <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-100 shrink-0 border border-gray-200">
                <img
                  src="{{ $other->photo_url }}"
                  alt="{{ $other->name }}"
                  class="w-full h-full object-cover group-hover:scale-105 transition"
                  onerror="this.src='https://placehold.co/100x100/0b4622/ffffff?text={{ urlencode($other->name) }}'"
                >
              </div>
              <div class="flex-1 min-w-0">
                <h4 class="text-xs sm:text-sm font-bold text-gray-800 group-hover:text-[#0b4622] truncate transition">
                  {{ $other->name }}
                </h4>
                <p class="text-[11px] text-gray-500 truncate mt-0.5">
                  {{ $other->designation }}
                </p>
              </div>
            </a>
          @empty
            <p class="text-xs text-gray-400 py-2">অন্য কোনো তথ্য নেই।</p>
          @endforelse
        </div>
      </div>

      <!-- Tribute Card -->
      <div class="bg-gradient-to-br from-[#0b4622] to-[#08351a] rounded-2xl p-6 text-white space-y-3 shadow-sm">
        <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-lg text-white">
          <i class="ri-award-line"></i>
        </div>
        <h4 class="text-base font-extrabold">শৈলকুপার গৌরব</h4>
        <p class="text-xs text-white/80 leading-relaxed">
          যে সকল কৃতী ব্যক্তিত্ব তাঁদের মেধা ও কর্ম দিয়ে আমাদের এলাকাকে সমৃদ্ধ করেছেন, তাঁদের প্রতি আমাদের বিনম্র শ্রদ্ধা।
        </p>
      </div>
    </div>

  </div>

</div>
@endsection

