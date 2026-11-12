@extends("layouts.website.website-layout")

@section('title', ($president->title ?? 'সভাপতির বাণী') . ' — আগামীর শৈলকুপা')

@section('content')
<div class="bg-gray-50/60 min-h-screen py-8 sm:py-12">
  <div class="max-w-[1050px] mx-auto px-4 sm:px-6 space-y-8">

    <!-- Breadcrumb & Top Header -->
    <div class="space-y-3">
      <nav class="flex items-center gap-2 text-xs font-medium text-gray-500">
        <a href="{{ route('home') }}" class="hover:text-[#0b4622] transition flex items-center gap-1">
          <i class="ri-home-4-line text-sm"></i>
          <span>হোম</span>
        </a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <span class="text-[#0b4622] font-semibold">{{ $president->title ?? 'সভাপতির বাণী' }}</span>
      </nav>

      <div class="border-b border-gray-200/80 pb-4">
        <h1 class="text-2xl sm:text-4xl font-black text-[#0b4622] tracking-tight leading-snug">
          {{ $president->title ?? 'সভাপতির বাণী' }}
        </h1>
        <p class="text-sm sm:text-base text-gray-600 font-medium mt-1">
          {{ $president->name }} — {{ $president->designation }}
        </p>
      </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-3xl border border-gray-200/70 shadow-sm overflow-hidden p-6 sm:p-10 space-y-8">
      
      <!-- President Profile Header Banner (Warm Cream Surface) -->
      <div class="president-card-bg rounded-2xl p-6 sm:p-8 flex flex-col sm:flex-row items-center gap-6 sm:gap-8 border border-[#e9e1cf]">
        <!-- Circular Portrait with Elegant Border -->
        <div class="shrink-0">
          <div class="w-32 h-32 sm:w-40 sm:h-40 rounded-full overflow-hidden border-4 border-white shadow-xl bg-gray-100">
            <img
              src="{{ $president->image_url }}"
              alt="{{ $president->name }}"
              class="w-full h-full object-cover transition duration-500 hover:scale-105"
            />
          </div>
        </div>

        <!-- Identity & Quote -->
        <div class="flex-1 text-center sm:text-left space-y-3">
          <div>
            <h2 class="text-xl sm:text-2xl font-black text-gray-900 leading-tight">
              {{ $president->name }}
            </h2>
            <p class="text-xs sm:text-sm font-semibold text-[#0b4622] mt-0.5">
              {{ $president->designation }}
            </p>
          </div>

          <!-- Highlighted Quote with Quote Icons -->
          <div class="relative bg-white/70 backdrop-blur-xs p-4 sm:p-5 rounded-2xl border border-gray-200/60 shadow-2xs">
            <i class="fa-solid fa-quote-left text-[#c8102e] text-lg sm:text-xl mr-1.5 align-top"></i>
            <span class="text-gray-800 text-xs sm:text-[15px] font-semibold italic leading-relaxed">
              {{ $president->quote }}
            </span>
            <div class="text-right -mt-1">
              <i class="fa-solid fa-quote-right text-[#c8102e] text-lg sm:text-xl"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Detailed Message Body (Rich Text / HTML from Quill.js) -->
      <div class="space-y-4 pt-2">
        <h3 class="text-lg sm:text-xl font-bold text-[#0b4622] border-b border-gray-100 pb-2 flex items-center gap-2">
          <i class="ri-message-3-line text-[#c8102e]"></i>
          <span>বিস্তারিত বার্তা ও বক্তব্য</span>
        </h3>

        <div class="rich-text-content prose max-w-none text-gray-700 leading-relaxed text-sm sm:text-[15.5px]">
          @if(!empty($president->message))
            {!! $president->message !!}
          @else
            <p class="text-gray-500 italic">সভাপতির বিস্তারিত বক্তব্য শীঘ্রই আপডেট করা হবে।</p>
          @endif
        </div>
      </div>

      <!-- Navigation & Action Buttons -->
      <div class="pt-6 border-t border-gray-100 flex flex-wrap items-center justify-between gap-3">
        <a
          href="{{ route('home') }}"
          class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-bold rounded-xl transition cursor-pointer"
        >
          <i class="ri-arrow-left-line"></i>
          <span>হোমপেজে ফিরে যান</span>
        </a>

        <div class="flex items-center gap-2.5">
          <a
            href="{{ route('about.us') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs sm:text-sm font-bold rounded-xl transition"
          >
            <i class="ri-information-line"></i>
            <span>আমাদের সম্পর্কে</span>
          </a>

          <a
            href="{{ route('home') }}#contact-section"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs sm:text-sm font-bold rounded-xl shadow-sm transition"
          >
            <i class="ri-mail-send-line"></i>
            <span>যোগাযোগ করুন</span>
          </a>
        </div>
      </div>

    </div>

  </div>
</div>
@endsection

