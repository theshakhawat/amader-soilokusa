@extends('layouts.website.website-layout')

@section('title', 'শৈলকুপার কৃতি সন্তান — আগামীর শৈলকুপা')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-10">
  
  <!-- Breadcrumb -->
  <nav class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 bg-white px-4 py-2.5 rounded-xl border border-gray-100 shadow-2xs">
    <a href="{{ route('home') }}" class="hover:text-[#0b4622] flex items-center gap-1 transition">
      <i class="ri-home-4-line"></i>
      <span>হোম</span>
    </a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <span class="text-[#0b4622] font-semibold">কৃতি সন্তান</span>
  </nav>

  <!-- Page Header -->
  <div class="text-center max-w-3xl mx-auto space-y-3">
    <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-[#0b4622] border border-emerald-200">
      <i class="ri-award-fill"></i>
      আমাদের গর্ব ও প্রেরণা
    </span>
    <h1 class="text-3xl sm:text-4xl font-black text-gray-900 tracking-tight">
      শৈলকুপার কৃতি সন্তান
    </h1>
    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
      শৈলকুপার যে সকল মহান ব্যক্তিবর্গ তাঁদের কর্ম, নেতৃত্ব, প্রজ্ঞা ও মেধা দিয়ে দেশ ও জাতির কল্যাণে অনন্য অবদান রেখে শৈলকুপাকে আলোকিত করেছেন।
    </p>
  </div>

  <!-- =========================================================================
       1. Top Featured Pride Card (Order Index = 1) -> Centered Image, Name, Designation
       ========================================================================= -->
  @if($topPride)
    <div class="flex justify-center">
      <a
        href="{{ route('our.pride.details', $topPride->id) }}"
        class="w-full max-w-md bg-white rounded-3xl border-2 border-[#0b4622]/20 p-6 sm:p-8 shadow-md hover:shadow-xl hover:border-[#0b4622] transition duration-300 flex flex-col items-center text-center group cursor-pointer"
      >
        <!-- Top Crown Badge -->
        <div class="mb-4">
          <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-[#0b4622] text-white text-[11px] font-bold shadow-xs">
            <i class="ri-vip-crown-fill text-amber-300"></i>
            জাতীয় পর্যায়ের গৌরবোজ্জ্বল কৃতি সন্তান
          </span>
        </div>

        <!-- Big Portrait Image Centered -->
        <div class="w-40 h-40 sm:w-48 sm:h-48 rounded-3xl overflow-hidden bg-gray-100 border-4 border-white shadow-lg ring-4 ring-[#0b4622]/15 mb-4 group-hover:scale-105 transition duration-300">
          <img
            src="{{ $topPride->photo_url }}"
            alt="{{ $topPride->name }}"
            class="w-full h-full object-cover"
            onerror="this.src='https://placehold.co/400x400/0b4622/ffffff?text={{ urlencode($topPride->name) }}'"
          >
        </div>

        <!-- Name -->
        <h2 class="text-xl sm:text-2xl font-black text-gray-900 group-hover:text-[#0b4622] transition">
          {{ $topPride->name }}
        </h2>

        <!-- Designation -->
        <div class="mt-2 inline-block px-3.5 py-1 rounded-xl bg-[#c8102e]/10 text-[#c8102e] text-xs sm:text-sm font-bold border border-[#c8102e]/20">
          {{ $topPride->designation }}
        </div>

        <!-- Click Hint -->
        <div class="mt-4 pt-3 border-t border-gray-100 w-full flex items-center justify-center gap-1 text-xs font-bold text-[#0b4622] group-hover:underline">
          <span>বিস্তারিত জীবনী পড়ুন</span>
          <i class="ri-arrow-right-line"></i>
        </div>
      </a>
    </div>
  @endif

  <!-- =========================================================================
       2. Other Prides Grid: 4 Cards per Row
       ========================================================================= -->
  @if($otherPrides->count() > 0)
    <div class="space-y-6 pt-4">
      <div class="border-b border-gray-200 pb-3 flex items-center justify-between">
        <h3 class="text-lg sm:text-xl font-bold text-gray-800 flex items-center gap-2">
          <i class="ri-user-star-line text-[#0b4622]"></i>
          <span>অন্যান্য কৃতি ব্যক্তিবর্গ</span>
        </h3>
        <span class="text-xs text-gray-500 font-semibold">{{ $otherPrides->count() }} জন কৃতি সন্তান</span>
      </div>

      <!-- 4 Cards per Row Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
        @foreach($otherPrides as $pride)
          <a
            href="{{ route('our.pride.details', $pride->id) }}"
            class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-2xs hover:shadow-lg hover:border-[#0b4622]/40 transition duration-300 flex flex-col items-center text-center group cursor-pointer"
          >
            <!-- Photo (Square Rounded) -->
            <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-2xl overflow-hidden bg-gray-100 border border-gray-200 shadow-xs mb-3.5 group-hover:scale-105 transition duration-300">
              <img
                src="{{ $pride->photo_url }}"
                alt="{{ $pride->name }}"
                class="w-full h-full object-cover"
                onerror="this.src='https://placehold.co/400x400/0b4622/ffffff?text={{ urlencode($pride->name) }}'"
              >
            </div>

            <!-- Name -->
            <h4 class="text-sm sm:text-base font-extrabold text-gray-900 group-hover:text-[#0b4622] transition line-clamp-1">
              {{ $pride->name }}
            </h4>

            <!-- Designation -->
            <p class="text-xs text-gray-600 mt-1 line-clamp-2 leading-relaxed font-medium">
              {{ $pride->designation }}
            </p>
          </a>
        @endforeach
      </div>
    </div>
  @endif

  <!-- Back to Home -->
  <div class="pt-8 text-center border-t border-gray-100">
    <a
      href="{{ route('home') }}"
      class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-bold rounded-xl transition"
    >
      <i class="ri-arrow-left-line"></i>
      <span>হোমপেজে ফিরে যান</span>
    </a>
  </div>

</div>
@endsection
