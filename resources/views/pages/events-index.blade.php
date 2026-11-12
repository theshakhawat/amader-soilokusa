@extends('layouts.website.website-layout')

@section('title', 'কার্যক্রম ও ইভেন্টসমূহ — আগামীর শৈলকুপা')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

  <!-- Breadcrumb -->
  <nav class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 mb-6 bg-white px-4 py-2.5 rounded-xl border border-gray-100 shadow-2xs">
    <a href="{{ route('home') }}" class="hover:text-[#0b4622] flex items-center gap-1 transition">
      <i class="ri-home-4-line"></i>
      <span>হোম</span>
    </a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <span class="text-[#0b4622] font-semibold">কার্যক্রম ও ইভেন্টসমূহ</span>
  </nav>

  <!-- Page Header Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6 sm:p-8 mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-5">
    <div>
      <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-[#0b4622] border border-emerald-200 mb-2">
        <i class="ri-calendar-event-line"></i>
        ইভেন্ট ও অ্যাক্টিভিটি ক্যালেন্ডার
      </span>
      <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
        কার্যক্রম ও ইভেন্টসমূহ
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-1">
        শৈলকুপার শিক্ষা, স্বাস্থ্য, পরিবেশ ও সামাজিক উন্নয়নে আমাদের সকল চলমান, আসন্ন ও সম্পন্ন হওয়া কার্যক্রম।
      </p>
    </div>

    <!-- Filter Buttons (All, Upcoming, Past) -->
    <div class="flex items-center gap-2 bg-[#f8fafc] p-1.5 rounded-xl border border-gray-200/80 shrink-0">
      <a
        href="{{ route('events.index') }}"
        class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ !request()->filled('type') ? 'bg-[#0b4622] text-white shadow-xs' : 'text-gray-600 hover:text-gray-900 hover:bg-white' }}"
      >
        সকল ইভেন্ট
      </a>
      <a
        href="{{ route('events.index', ['type' => 'upcoming']) }}"
        class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ request('type') === 'upcoming' ? 'bg-[#0b4622] text-white shadow-xs' : 'text-gray-600 hover:text-gray-900 hover:bg-white' }}"
      >
        আসন্ন ও চলমান
      </a>
      <a
        href="{{ route('events.index', ['type' => 'past']) }}"
        class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ request('type') === 'past' ? 'bg-gray-600 text-white shadow-xs' : 'text-gray-600 hover:text-gray-900 hover:bg-white' }}"
      >
        সম্পন্ন ইভেন্ট
      </a>
    </div>
  </div>

  @php
    $today = now()->startOfDay()->toDateString();
  @endphp

  <!-- Events Grid -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($events as $event)
      @php
        $isPast = ($event->status === 'completed') || ($event->date && $event->date->format('Y-m-d') < $today);
      @endphp

      <article class="bg-white rounded-2xl border {{ $isPast ? 'border-gray-200/70 bg-gray-50/40 opacity-90' : 'border-gray-200 shadow-2xs hover:shadow-md hover:border-[#0b4622]/40' }} overflow-hidden flex flex-col justify-between transition group">

        <div>
          <!-- Feature Thumbnail with Overlay Status -->
          <div class="relative aspect-[16/10] bg-gray-100 overflow-hidden">
            <img
              src="{{ $event->thumbnail_url }}"
              alt="{{ $event->title }}"
              class="w-full h-full object-cover {{ $isPast ? 'grayscale-[35%] group-hover:grayscale-0' : 'group-hover:scale-105' }} transition duration-300"
              onerror="this.src='{{ asset('assets/images/event-1.jpg') }}'"
            >

            <!-- Date Badge -->
            @if($event->date)
              <div class="absolute top-3 left-3 {{ $isPast ? 'bg-gray-700/90' : 'bg-[#c8102e]' }} text-white rounded-xl px-2.5 py-1 text-center leading-tight shadow-md">
                <span class="block text-sm font-extrabold">{{ $event->bangla_day }}</span>
                <span class="block text-[10px] font-medium">{{ $event->bangla_month }}</span>
              </div>
            @endif

            <!-- Event Status Badge Top Right -->
            <div class="absolute top-3 right-3">
              @if($isPast)
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-gray-900/80 backdrop-blur-xs text-gray-200 border border-white/20 shadow-xs">
                  <i class="ri-checkbox-circle-fill text-gray-400"></i>
                  ইভেন্টটি সম্পন্ন হয়েছে
                </span>
              @elseif($event->status === 'ongoing')
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-amber-500/90 backdrop-blur-xs text-white shadow-xs">
                  <span class="w-2 h-2 rounded-full bg-white animate-ping"></span>
                  চলমান কার্যক্রম
                </span>
              @else
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-emerald-700/90 backdrop-blur-xs text-white shadow-xs">
                  <i class="ri-flashlight-line"></i>
                  আসন্ন ইভেন্ট
                </span>
              @endif
            </div>
          </div>

          <!-- Card Content Body -->
          <div class="p-4 sm:p-5 space-y-3">
            <h3 class="text-base sm:text-lg font-black text-gray-900 {{ $isPast ? 'text-gray-700 group-hover:text-gray-900' : 'group-hover:text-[#0b4622]' }} transition line-clamp-2">
              <a href="{{ route('events.details', $event->id) }}">
                {{ $event->title }}
              </a>
            </h3>

            <!-- Location & Time -->
            <div class="space-y-1.5 text-xs text-gray-600">
              @if($event->location)
                <div class="flex items-center gap-2">
                  <i class="ri-map-pin-line {{ $isPast ? 'text-gray-400' : 'text-[#0b4622]' }} text-sm"></i>
                  <span class="truncate font-medium">{{ $event->location }}</span>
                </div>
              @endif

              @if($event->time)
                <div class="flex items-center gap-2">
                  <i class="ri-time-line {{ $isPast ? 'text-gray-400' : 'text-[#c8102e]' }} text-sm"></i>
                  <span>{{ $event->time }}</span>
                </div>
              @endif
            </div>

            <!-- Short Text Excerpt -->
            @if($event->description)
              <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed pt-1">
                {{ strip_tags($event->description) }}
              </p>
            @endif
          </div>
        </div>

        <!-- Card Footer -->
        <div class="p-4 sm:p-5 pt-3 border-t border-gray-100/90 flex items-center justify-between">
          <span class="inline-flex items-center gap-1.5 text-xs text-gray-500 font-medium">
            <i class="ri-calendar-line text-[#c8102e]"></i>
            <span>{{ $event->bangla_formatted_date ?: 'তারিখ অনির্ধারিত' }}</span>
          </span>

          <a
            href="{{ route('events.details', $event->id) }}"
            class="inline-flex items-center gap-1 text-xs font-bold {{ $isPast ? 'text-gray-600 hover:text-gray-900' : 'text-[#0b4622] hover:text-[#08351a]' }} transition"
          >
            <span>বিস্তারিত দেখুন</span>
            <i class="ri-arrow-right-line"></i>
          </a>
        </div>

      </article>
    @empty
      <div class="col-span-full bg-white rounded-2xl border border-gray-100 p-12 text-center text-gray-400">
        <i class="ri-calendar-line text-4xl text-gray-300 block mb-2"></i>
        বর্তমানে এই বিভাগে কোনো কার্যক্রম বা ইভেন্ট পাওয়া যায়নি।
      </div>
    @endforelse
  </div>

  <!-- Cursor Pagination Navigation (Next / Previous) -->
  @if($events->hasPages())
    <div class="mt-10 flex items-center justify-between bg-white px-6 py-4 rounded-2xl border border-gray-100 shadow-2xs">
      <div>
        @if($events->onFirstPage())
          <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-gray-400 bg-gray-50 border border-gray-100 cursor-not-allowed">
            <i class="ri-arrow-left-s-line text-sm"></i>
            <span>পূর্ববর্তী পৃষ্ঠা</span>
          </span>
        @else
          <a
            href="{{ $events->previousPageUrl() }}"
            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-gray-700 bg-white hover:bg-gray-50 border border-gray-200 transition shadow-2xs cursor-pointer"
          >
            <i class="ri-arrow-left-s-line text-sm text-[#0b4622]"></i>
            <span>পূর্ববর্তী পৃষ্ঠা</span>
          </a>
        @endif
      </div>

      <span class="text-xs text-gray-500 font-semibold">
        প্রতি পৃষ্ঠায় ৯টি ইভেন্ট
      </span>

      <div>
        @if($events->hasMorePages())
          <a
            href="{{ $events->nextPageUrl() }}"
            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-white bg-[#0b4622] hover:bg-[#08351a] transition shadow-xs cursor-pointer"
          >
            <span>পরবর্তী পৃষ্ঠা</span>
            <i class="ri-arrow-right-s-line text-sm"></i>
          </a>
        @else
          <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-gray-400 bg-gray-50 border border-gray-100 cursor-not-allowed">
            <span>পরবর্তী পৃষ্ঠা</span>
            <i class="ri-arrow-right-s-line text-sm"></i>
          </span>
        @endif
      </div>
    </div>
  @endif

</div>
@endsection
