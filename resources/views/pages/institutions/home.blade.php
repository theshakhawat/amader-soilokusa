@extends('layouts.website.website-layout')

@section('title', 'প্রতিষ্ঠান সমূহ — শৈলকূপার শিক্ষা ও সামাজিক প্রতিষ্ঠানসমূহ | আগামীর শৈলকুপা')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-8">

  {{-- Breadcrumb --}}
  <nav class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 bg-white px-4 py-2.5 rounded-xl border border-gray-100 shadow-2xs">
    <a href="{{ route('home') }}" class="hover:text-[#0b4622] flex items-center gap-1 transition">
      <i class="ri-home-4-line"></i><span>হোম</span>
    </a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <span class="text-[#0b4622] font-semibold">প্রতিষ্ঠান সমূহ</span>
  </nav>

  {{-- Header --}}
  <div class="bg-gradient-to-br from-[#0b4622] to-[#1a7a3e] rounded-3xl p-8 sm:p-12 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
      <div class="absolute top-0 right-0 w-72 h-72 bg-white rounded-full -translate-y-1/2 translate-x-1/2"></div>
      <div class="absolute bottom-0 left-0 w-48 h-48 bg-white rounded-full translate-y-1/2 -translate-x-1/2"></div>
    </div>
    <div class="relative z-10">
      <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/20 text-white rounded-full text-xs font-bold mb-4 backdrop-blur-sm">
        <i class="ri-building-2-line"></i> শৈলকূপার প্রতিষ্ঠানসমূহ
      </span>
      <h1 class="text-3xl sm:text-4xl font-black tracking-tight mb-3">প্রতিষ্ঠান সমূহ</h1>
      <p class="text-white/80 text-sm sm:text-base max-w-2xl">
        শৈলকূপার বিভিন্ন শিক্ষা প্রতিষ্ঠান, মসজিদ-মাদ্রাসা ও সামাজিক প্রতিষ্ঠানসমূহ সম্পর্কে জানুন।
        ক্যাটাগরি বেছে নিয়ে আপনার কাঙ্ক্ষিত প্রতিষ্ঠানটি খুঁজুন।
      </p>
    </div>
  </div>

  {{-- Category Cards Grid --}}
  @if($categories->isEmpty())
    <div class="text-center py-20 bg-white rounded-3xl border border-gray-100">
      <i class="ri-building-2-line text-6xl text-gray-200 block mb-4"></i>
      <h3 class="text-lg font-bold text-gray-500">এখনো কোনো ক্যাটাগরি যুক্ত হয়নি</h3>
      <p class="text-sm text-gray-400 mt-1">শীঘ্রই আপডেট করা হবে।</p>
    </div>
  @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
      @foreach($categories as $category)
        <a href="{{ route('institutions.by-category', $category->slug) }}"
           class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg hover:border-[#0b4622]/20 transition-all duration-300 overflow-hidden">
          <div class="h-28 bg-gradient-to-br from-[#0b4622]/10 to-[#0b4622]/20 flex items-center justify-center group-hover:from-[#0b4622]/20 group-hover:to-[#0b4622]/30 transition-all duration-300">
            <i class="ri-building-2-line text-5xl text-[#0b4622]/50 group-hover:text-[#0b4622]/70 group-hover:scale-110 transition-all duration-300"></i>
          </div>
          <div class="p-5">
            <h3 class="font-bold text-gray-800 text-base group-hover:text-[#0b4622] transition leading-snug">{{ $category->name }}</h3>
            <div class="flex items-center justify-between mt-3">
              <span class="text-xs text-gray-500 font-semibold">
                <i class="ri-building-line mr-1"></i>{{ $category->institutions_count }}টি প্রতিষ্ঠান
              </span>
              <span class="inline-flex items-center gap-1 text-xs font-bold text-[#0b4622] group-hover:gap-2 transition-all">
                দেখুন <i class="ri-arrow-right-line"></i>
              </span>
            </div>
          </div>
        </a>
      @endforeach
    </div>
  @endif

</div>
@endsection

