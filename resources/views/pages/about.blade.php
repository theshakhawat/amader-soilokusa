@extends("layouts.website.website-layout")

@section('title', ($about->title ?? 'আমাদের সম্পর্কে') . ' — আগামীর শৈলকুপা')

@section('content')
<div class="bg-gray-50/60 min-h-screen py-8 sm:py-12">
  <div class="max-w-[1100px] mx-auto px-4 sm:px-6 space-y-8">

    <!-- Breadcrumb & Top Header -->
    <div class="space-y-3">
      <nav class="flex items-center gap-2 text-xs font-medium text-gray-500">
        <a href="{{ route('home') }}" class="hover:text-[#0b4622] transition flex items-center gap-1">
          <i class="ri-home-4-line text-sm"></i>
          <span>হোম</span>
        </a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <span class="text-[#0b4622] font-semibold">{{ $about->title ?? 'আমাদের সম্পর্কে' }}</span>
      </nav>

      <div class="border-b border-gray-200/80 pb-4">
        <h1 class="text-2xl sm:text-4xl font-black text-[#0b4622] tracking-tight leading-snug">
          {{ $about->title ?? 'আমাদের সম্পর্কে' }}
        </h1>
        @if(!empty($about->subtitle))
          <p class="text-sm sm:text-base text-gray-600 font-medium mt-1">
            {{ $about->subtitle }}
          </p>
        @endif
      </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-3xl border border-gray-200/70 shadow-sm overflow-hidden p-6 sm:p-10 space-y-8">
      
      <!-- Feature Photo Banner -->
      <div class="relative w-full h-64 sm:h-96 rounded-2xl overflow-hidden bg-gray-100 border border-gray-100 shadow-inner">
        <img
          src="{{ $about->image_url }}"
          alt="{{ $about->title }}"
          class="w-full h-full object-cover object-center transition duration-500 hover:scale-105"
        />
        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
        <div class="absolute bottom-4 left-5 sm:bottom-6 sm:left-8 text-white">
          <span class="px-3 py-1 bg-[#c8102e] text-xs font-bold rounded-full uppercase tracking-wider shadow-sm">
            পরিচিতি ও উদ্যোগ
          </span>
        </div>
      </div>

      <!-- Short Summary Highlight Box -->
      @if(!empty($about->short_description))
        <div class="p-5 sm:p-6 rounded-2xl bg-[#0b4622]/5 border-l-4 border-[#0b4622] text-sm sm:text-base font-semibold text-gray-800 leading-relaxed shadow-2xs">
          {{ $about->short_description }}
        </div>
      @endif

      <!-- Full Rich Text / HTML Description -->
      <div class="rich-text-content prose max-w-none text-gray-700 leading-relaxed text-sm sm:text-[15.5px]">
        @if(!empty($about->description))
          {!! $about->description !!}
        @else
          <p class="text-gray-500">শীঘ্রই আরও বিস্তারিত তথ্য যুক্ত করা হবে।</p>
        @endif
      </div>

      <!-- Back to Home Action -->
      <div class="pt-6 border-t border-gray-100 flex items-center justify-between">
        <a
          href="{{ route('home') }}"
          class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-bold rounded-xl transition"
        >
          <i class="ri-arrow-left-line"></i>
          <span>হোমপেজে ফিরে যান</span>
        </a>

        <a
          href="{{ route('home') }}#contact-section"
          class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs sm:text-sm font-bold rounded-xl shadow-sm transition"
        >
          <i class="ri-mail-send-line"></i>
          <span>আমাদের সাথে যোগাযোগ করুন</span>
        </a>
      </div>

    </div>

  </div>
</div>
@endsection

