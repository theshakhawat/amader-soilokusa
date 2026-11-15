@extends('layouts.website.website-layout')

@section('title', ($committee ? $committee->name : 'কমিটি তালিকা') . ' — আগামীর শৈলকুপা')

@section('content')
<main class="py-6 sm:py-12 bg-gray-50/50 min-h-screen">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 sm:space-y-10">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs font-semibold text-gray-500 bg-white px-4 py-2.5 rounded-xl border border-gray-200/80 shadow-2xs">
      <a href="{{ route('home') }}" class="hover:text-[#0b4622] flex items-center gap-1 transition">
        <i class="ri-home-4-line text-sm"></i>
        <span>হোম</span>
      </a>
      <i class="ri-arrow-right-s-line text-gray-400"></i>
      <a href="{{ route('committee.index') }}" class="hover:text-[#0b4622] transition">কমিটি সমূহ</a>
      <i class="ri-arrow-right-s-line text-gray-400"></i>
      <span class="text-[#0b4622] font-bold">{{ $committee ? $committee->name : 'কমিটি' }}</span>
    </nav>

    {{-- Header Banner --}}
    <div class="text-center max-w-3xl mx-auto space-y-3">
      @if($committee && $committee->session_duration)
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-50 text-[#0b4622] text-xs sm:text-sm font-extrabold border border-emerald-100 shadow-2xs">
          <i class="ri-calendar-line text-base"></i>
          <span>{{ $committee->session_duration }} সেশন</span>
        </div>
      @endif

      <h1 class="text-2xl sm:text-4xl font-black text-gray-900 tracking-tight">
        {{ $committee ? $committee->name : 'কমিটি তালিকা' }}
        @if($committee && $committee->session_duration)
          <span class="text-[#c8102e]">({{ $committee->session_duration }})</span>
        @endif
      </h1>

      @if($committee && $committee->subtitle)
        <p class="text-xs sm:text-base text-gray-600 font-medium">
          {{ $committee->subtitle }}
        </p>
      @endif
    </div>

    {{-- Committee Members Hierarchy Layout --}}
    <div class="space-y-8 sm:space-y-12">

      {{-- ==========================================
           ROW 1: সভাপতি (Single Centered Large Card)
           ========================================== --}}
      @if($president)
        <div>
          <div class="text-center mb-5">
            <span class="inline-block text-[11px] font-extrabold uppercase tracking-wider text-emerald-800 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200 shadow-2xs">
              <i class="ri-vip-crown-fill text-amber-500 mr-1"></i> কমিটি প্রধান
            </span>
          </div>

          <div class="flex justify-center">
            <div class="w-full max-w-sm bg-white rounded-3xl p-6 sm:p-7 border-2 border-emerald-600/30 shadow-lg hover:shadow-2xl transition-all duration-300 text-center relative group">
              <!-- Top Badge -->
              <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-[#0b4622] text-white px-4 py-1 rounded-full text-xs font-black shadow-xs flex items-center gap-1.5 whitespace-nowrap">
                <i class="ri-vip-crown-fill text-amber-300 text-sm"></i>
                <span>{{ $president->title }}</span>
              </div>

              <!-- Avatar -->
              <div class="w-28 h-28 sm:w-36 sm:h-36 rounded-full overflow-hidden mx-auto mt-2 border-4 border-emerald-100 shadow-sm group-hover:scale-105 transition-transform duration-300 bg-gray-100">
                <img src="{{ $president->photo_url }}" alt="{{ $president->name }}" class="w-full h-full object-cover" />
              </div>

              <!-- Details -->
              <h2 class="text-lg sm:text-xl font-black text-gray-900 mt-4 group-hover:text-[#0b4622] transition">
                {{ $president->name }}
              </h2>
              <p class="text-xs sm:text-sm font-bold text-[#c8102e] mt-1">
                {{ $president->title }}
              </p>

              <!-- Phone Link -->
              @if(!empty($president->phone))
                <div class="mt-4 pt-3 border-t border-gray-100 flex justify-center">
                  <a href="tel:{{ $president->phone }}"
                     class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-emerald-50 hover:bg-[#0b4622] text-[#0b4622] hover:text-white font-mono text-xs font-bold transition shadow-2xs">
                    <i class="ri-phone-fill text-sm"></i>
                    <span>{{ $president->phone }}</span>
                  </a>
                </div>
              @endif
            </div>
          </div>
        </div>
      @endif


      {{-- ==========================================
           ROW 2: শীর্ষ নেতৃত্ব (Second Row Members - Dynamically Centered)
           ========================================== --}}
      @if($secondRowMembers->isNotEmpty())
        <div>
          <div class="text-center mb-5">
            <span class="inline-block text-[11px] font-extrabold uppercase tracking-wider text-gray-500 bg-white px-3 py-1 rounded-full border border-gray-200 shadow-2xs">
              কার্যনির্বাহী নেতৃত্ব
            </span>
          </div>

          @php
            $secCount = $secondRowMembers->count();
            // Container width and card width classes based on number of cards
            $cardWidthClass = match($secCount) {
              1 => 'w-full max-w-sm',
              2 => 'w-full sm:w-[calc(50%-14px)] max-w-sm',
              3 => 'w-full sm:w-[calc(33.333%-16px)] max-w-xs',
              default => 'w-full sm:w-[calc(50%-14px)] md:w-[calc(25%-16px)] max-w-xs',
            };
          @endphp

          <div class="flex flex-wrap justify-center gap-5 sm:gap-7 max-w-5xl mx-auto">
            @foreach($secondRowMembers as $m)
              <div class="{{ $cardWidthClass }} bg-white rounded-2xl p-5 border border-gray-200/80 shadow-sm hover:shadow-xl transition-all duration-300 text-center flex flex-col justify-between group">
                <div>
                  <!-- Avatar -->
                  <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden mx-auto border-3 border-emerald-50 shadow-2xs group-hover:scale-105 transition-transform duration-300 bg-gray-100">
                    <img src="{{ $m->photo_url }}" alt="{{ $m->name }}" class="w-full h-full object-cover" />
                  </div>

                  <!-- Details -->
                  <h3 class="text-base sm:text-lg font-black text-gray-900 mt-3.5 group-hover:text-[#0b4622] transition line-clamp-1">
                    {{ $m->name }}
                  </h3>
                  <span class="inline-block mt-1.5 px-3 py-1 rounded-full bg-emerald-50 text-[#0b4622] font-bold text-xs border border-emerald-100">
                    {{ $m->title }}
                  </span>
                </div>

                <!-- Phone Link -->
                @if(!empty($m->phone))
                  <div class="mt-4 pt-3 border-t border-gray-100 flex justify-center">
                    <a href="tel:{{ $m->phone }}"
                       class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-50 hover:bg-[#0b4622] text-gray-700 hover:text-white font-mono text-[11px] font-bold transition">
                      <i class="ri-phone-fill text-xs"></i>
                      <span>{{ $m->phone }}</span>
                    </a>
                  </div>
                @endif
              </div>
            @endforeach
          </div>
        </div>
      @endif


      {{-- ==========================================
           ROW 3+: অন্যান্য সদস্যবৃন্দ (Other Members Grid)
           ========================================== --}}
      @if($otherMembers->isNotEmpty())
        <div>
          <div class="text-center mb-6">
            <span class="inline-block text-[11px] font-extrabold uppercase tracking-wider text-gray-500 bg-white px-3 py-1 rounded-full border border-gray-200 shadow-2xs">
              কমিটির অন্যান্য সদস্যবৃন্দ
            </span>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($otherMembers as $m)
              <div class="bg-white rounded-2xl p-4 sm:p-5 border border-gray-200/80 shadow-xs hover:shadow-md transition-all duration-300 text-center flex flex-col justify-between items-center group">
                <div class="w-full flex flex-col items-center">
                  <!-- Avatar -->
                  <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full overflow-hidden border-2 border-gray-100 shadow-2xs group-hover:scale-105 transition-transform duration-300 bg-gray-50">
                    <img src="{{ $m->photo_url }}" alt="{{ $m->name }}" class="w-full h-full object-cover" />
                  </div>

                  <!-- Name & Title -->
                  <h4 class="text-sm sm:text-base font-extrabold text-gray-900 mt-3 group-hover:text-[#0b4622] transition line-clamp-1">
                    {{ $m->name }}
                  </h4>
                  <p class="text-xs font-bold text-[#c8102e] mt-1 line-clamp-1">
                    {{ $m->title }}
                  </p>
                </div>

                <!-- Phone Link -->
                @if(!empty($m->phone))
                  <div class="mt-3 pt-2.5 border-t border-gray-100 w-full flex justify-center">
                    <a href="tel:{{ $m->phone }}"
                       class="inline-flex items-center gap-1 text-[11px] text-gray-600 hover:text-[#0b4622] font-mono font-semibold transition">
                      <i class="ri-phone-line text-xs text-[#0b4622]"></i>
                      <span>{{ $m->phone }}</span>
                    </a>
                  </div>
                @endif
              </div>
            @endforeach
          </div>
        </div>
      @endif

      @if(!$president && $secondRowMembers->isEmpty() && $otherMembers->isEmpty())
        <div class="text-center py-16 bg-white rounded-2xl border border-gray-100 p-8">
          <i class="ri-team-line text-5xl text-gray-300 block mb-3"></i>
          <h3 class="text-lg font-bold text-gray-700">বর্তমানে এই কমিটিতে কোনো সদস্যের তথ্য যুক্ত করা নেই</h3>
          <p class="text-xs sm:text-sm text-gray-500 mt-1">অ্যাডমিন প্যানেল থেকে খুব শীঘ্রই পূর্ণাঙ্গ সদস্য তালিকা প্রকাশ করা হবে।</p>
        </div>
      @endif

    </div>

  </div>
</main>
@endsection
