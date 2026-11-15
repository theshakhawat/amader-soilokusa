@extends('layouts.website.website-layout')

@section('title', 'অফিস সমূহ — শৈলকূপার প্রশাসনিক ও সরকারি দপ্তর | আগামীর শৈলকুপা')

@php
if (!function_exists('toBnOfficeNum')) {
    function toBnOfficeNum($number) {
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
    <span class="text-[#0b4622] font-semibold">অফিস সমূহ</span>
  </nav>

  {{-- Banner / Header --}}
  <div class="bg-gradient-to-br from-[#0b4622] to-[#12592d] rounded-3xl p-8 sm:p-12 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
      <div class="absolute top-0 right-0 w-80 h-80 bg-white rounded-full -translate-y-1/2 translate-x-1/2"></div>
      <div class="absolute bottom-0 left-0 w-56 h-56 bg-white rounded-full translate-y-1/2 -translate-x-1/2"></div>
    </div>
    <div class="relative z-10">
      <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/20 text-white rounded-full text-xs font-bold mb-4 backdrop-blur-sm">
        <i class="ri-government-line"></i> শৈলকূপা প্রশাসন ও জনসেবা
      </span>
      <h1 class="text-3xl sm:text-4xl font-black tracking-tight mb-3">সরকারি ও প্রশাসনিক অফিস সমূহ</h1>
      <p class="text-white/80 text-sm sm:text-base max-w-2xl">
        শৈলকূপা উপজেলার বিভিন্ন সরকারি ও প্রশাসনিক দপ্তর, তাদের দায়িত্বপ্রাপ্ত কর্মকর্তা এবং নাগরিক সেবা সংক্রান্ত তথ্য এক নজরে জানুন।
      </p>
    </div>
  </div>

  {{-- Grid of Offices --}}
  @if($offices->isEmpty())
    <div class="text-center py-20 bg-white rounded-3xl border border-gray-100">
      <i class="ri-government-line text-6xl text-gray-200 block mb-4"></i>
      <h3 class="text-lg font-bold text-gray-500">এখনো কোনো অফিসের তথ্য যুক্ত করা হয়নি</h3>
      <p class="text-sm text-gray-400 mt-1">শীঘ্রই সকল প্রশাসনিক অফিসের তথ্য হালনাগাদ করা হবে।</p>
    </div>
  @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($offices as $office)
        <a href="{{ route('offices.detail', $office->slug) }}"
           class="group bg-white rounded-2xl border border-gray-200/80 shadow-2xs hover:shadow-xl hover:border-[#0b4622]/30 transition-all duration-300 overflow-hidden flex flex-col">
          {{-- Office Image --}}
          <div class="relative h-52 bg-gray-100 overflow-hidden">
            <img src="{{ $office->image_url }}"
                 alt="{{ $office->name }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            @if($office->location)
              <div class="absolute top-3 left-3">
                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-white/95 text-[#0b4622] text-xs font-bold rounded-full backdrop-blur-sm shadow-sm">
                  <i class="ri-map-pin-line"></i> {{ $office->location }}
                </span>
              </div>
            @endif
          </div>

          {{-- Content --}}
          <div class="p-5 flex flex-col flex-1">
            <h3 class="font-bold text-gray-900 text-base sm:text-lg leading-snug group-hover:text-[#0b4622] transition mb-2">
              {{ $office->name }}
            </h3>

            @if($office->description)
              <p class="text-xs text-gray-500 leading-relaxed line-clamp-2 flex-1 mb-3">
                {!! strip_tags($office->description) !!}
              </p>
            @endif

            <div class="flex items-center justify-between mt-auto pt-3 border-t border-gray-100">
              <span class="flex items-center gap-1 text-xs text-gray-600 font-medium">
                <i class="ri-team-line text-[#0b4622]"></i>
                {{ toBnOfficeNum($office->members_count) }} জন কর্মকর্তা
              </span>
              <span class="inline-flex items-center gap-1 text-xs font-bold text-[#0b4622] bg-[#0b4622]/10 px-3 py-1 rounded-full group-hover:bg-[#0b4622] group-hover:text-white transition">
                বিস্তারিত <i class="ri-arrow-right-line"></i>
              </span>
            </div>
          </div>
        </a>
      @endforeach
    </div>
  @endif

</div>
@endsection

