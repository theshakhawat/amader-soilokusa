@extends("layouts.website.website-layout")

@section('title', 'আগামীর শৈলকুপা — শৈলকুপার উন্নয়নে আমরা এক পরিবার')

@section('content')

  <!-- =====================================================================
       3. HERO BANNER CAROUSEL SLIDER (Auto-scrolls every 5s & Shows Controls on Hover)
       ===================================================================== -->
  @php
    $hasBanners = isset($heroBanners) && $heroBanners->count() > 0;
  @endphp

  @if($hasBanners)
  <section id="hero-section" class="relative w-full overflow-hidden bg-[#06381a] select-none group">
    <!-- Carousel Background Images (Smooth Multi-Slide Fade) -->
    <div class="relative min-h-[380px] sm:min-h-[440px] md:min-h-[480px] flex items-center">
      <div id="hero-slider-images" class="absolute inset-0 w-full h-full overflow-hidden">
        @foreach($heroBanners as $idx => $banner)
          <div class="hero-slide-item absolute inset-0 w-full h-full {{ $idx === 0 ? 'opacity-100 z-10' : 'opacity-0 pointer-events-none z-0' }} transition-opacity duration-1000 ease-in-out">
            <img
              src="{{ $banner->image_url }}"
              alt="{{ $banner->title }}"
              class="w-full h-full object-cover object-center"
            />
          </div>
        @endforeach
      </div>

      <!-- Deep Forest Green Gradient Overlay -->
      <div class="hero-overlay absolute inset-0 z-10 pointer-events-none"></div>

      <!-- Slider Arrows (Show only if more than 1 banner) -->
      @if($heroBanners->count() > 1)
        <!-- Slider Left Arrow -->
        <button
          type="button"
          onclick="prevHeroSlide()"
          aria-label="Previous Slide"
          class="absolute left-2 sm:left-5 top-1/2 -translate-y-1/2 z-30 w-8 h-8 sm:w-11 sm:h-11 rounded-full bg-white/90 hover:bg-white text-[#c8102e] shadow-xl flex items-center justify-center opacity-100 sm:opacity-0 sm:group-hover:opacity-100 sm:-translate-x-3 sm:group-hover:translate-x-0 transition-all duration-300 hover:scale-110 active:scale-95 cursor-pointer"
        >
          <i class="ri-arrow-left-s-line text-lg sm:text-2xl font-bold"></i>
        </button>

        <!-- Slider Right Arrow -->
        <button
          type="button"
          onclick="nextHeroSlide()"
          aria-label="Next Slide"
          class="absolute right-2 sm:right-5 top-1/2 -translate-y-1/2 z-30 w-8 h-8 sm:w-11 sm:h-11 rounded-full bg-white/90 hover:bg-white text-[#c8102e] shadow-xl flex items-center justify-center opacity-100 sm:opacity-0 sm:group-hover:opacity-100 sm:translate-x-3 sm:group-hover:translate-x-0 transition-all duration-300 hover:scale-110 active:scale-95 cursor-pointer"
        >
          <i class="ri-arrow-right-s-line text-lg sm:text-2xl font-bold"></i>
        </button>
      @endif

      <!-- Hero Content -->
      <div class="relative z-20 max-w-[1220px] mx-auto w-full px-7 sm:px-14 md:px-20 py-8 sm:py-12">
        <div id="hero-content-box" class="max-w-xl transition-all duration-300 ease-out">
          <h1 id="hero-title" class="text-white text-2xl sm:text-3xl md:text-[44px] font-extrabold tracking-tight leading-tight drop-shadow-[0_2px_8px_rgba(0,0,0,0.5)]">
            {{ $heroBanners->first()->title }}
          </h1>
          @if($heroBanners->first()->subtitle)
            <p id="hero-subtitle" class="text-white/95 text-xs sm:text-base md:text-[20px] font-medium leading-relaxed mt-2.5 sm:mt-4 drop-shadow-[0_1px_4px_rgba(0,0,0,0.4)]">
              {{ $heroBanners->first()->subtitle }}
            </p>
          @else
            <p id="hero-subtitle" class="text-white/95 text-xs sm:text-base md:text-[20px] font-medium leading-relaxed mt-2.5 sm:mt-4 drop-shadow-[0_1px_4px_rgba(0,0,0,0.4)] hidden"></p>
          @endif

          <!-- Hero Action Buttons -->
          <div class="mt-5 sm:mt-7 flex flex-wrap items-center gap-2.5 sm:gap-3.5">
            <a
              id="hero-primary-btn"
              href="{{ $heroBanners->first()->primary_button_link ?? '#about-section' }}"
              class="bg-[#c8102e] hover:bg-[#a30b24] text-white text-xs sm:text-sm md:text-[15px] font-semibold px-4 sm:px-6 py-2.5 rounded-full shadow-md inline-flex items-center gap-1.5 sm:gap-2 hover:shadow-lg transition cursor-pointer"
            >
              <span id="hero-primary-btn-text">{{ $heroBanners->first()->primary_button_text }}</span>
              <i class="ri-arrow-right-line text-sm sm:text-base"></i>
            </a>

            @if($heroBanners->first()->secondary_button_text)
              <a
                id="hero-secondary-btn"
                href="{{ $heroBanners->first()->secondary_button_link ?? '#video' }}"
                class="border border-white/85 bg-[#06381a]/55 hover:bg-white/20 text-white text-xs sm:text-sm md:text-[15px] font-semibold px-3.5 sm:px-5 py-2.5 rounded-full inline-flex items-center gap-1.5 sm:gap-2 backdrop-blur-[2px] transition cursor-pointer"
              >
                <span class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-white text-[#c8102e] flex items-center justify-center">
                  <i class="fa-solid fa-play text-[8px] sm:text-[9px] ml-0.5"></i>
                </span>
                <span id="hero-secondary-btn-text">{{ $heroBanners->first()->secondary_button_text }}</span>
              </a>
            @else
              <a
                id="hero-secondary-btn"
                href="#"
                class="hidden border border-white/85 bg-[#06381a]/55 hover:bg-white/20 text-white text-xs sm:text-sm md:text-[15px] font-semibold px-3.5 sm:px-5 py-2.5 rounded-full inline-flex items-center gap-1.5 sm:gap-2 backdrop-blur-[2px] transition cursor-pointer"
              >
                <span class="w-4 h-4 sm:w-5 sm:h-5 rounded-full bg-white text-[#c8102e] flex items-center justify-center">
                  <i class="fa-solid fa-play text-[8px] sm:text-[9px] ml-0.5"></i>
                </span>
                <span id="hero-secondary-btn-text"></span>
              </a>
            @endif
          </div>
        </div>
      </div>

      <!-- Slider Dots (Show only if more than 1 banner) -->
      @if($heroBanners->count() > 1)
        <div id="hero-dots-container" class="absolute bottom-3 sm:bottom-4 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2">
          @foreach($heroBanners as $idx => $banner)
            <button type="button" onclick="goToHeroSlide({{ $idx }})" aria-label="Slide {{ $idx + 1 }}" class="hero-dot h-2 sm:h-2.5 rounded-full transition-all duration-300 {{ $idx === 0 ? 'w-7 bg-[#c8102e]' : 'w-2.5 bg-white/80 hover:bg-white' }} cursor-pointer"></button>
          @endforeach
        </div>
      @endif

      <!-- Pass Dynamic Hero Slides Data to JavaScript -->
      <script>
        window.dynamicHeroSlides = {!! json_encode($heroSlidesData, JSON_UNESCAPED_UNICODE) !!};
      </script>

      <!-- Exact Bottom Red & Green Wave Sweeps -->
      <svg class="absolute bottom-0 left-0 w-full h-5 sm:h-10 pointer-events-none z-20" viewBox="0 0 1440 54" fill="none" preserveAspectRatio="none">
        <!-- Left Red Corner Sweep -->
        <path d="M0 10 C 95 28, 195 46, 310 54 L 0 54 Z" fill="#c8102e" />
        <!-- Right Red & Green Ribbon Sweep -->
        <path d="M1110 54 C 1235 42, 1345 20, 1440 0 L 1440 54 Z" fill="#c8102e" />
        <path d="M1230 54 C 1320 44, 1385 30, 1440 18 L 1440 54 Z" fill="#116a2f" />
      </svg>
    </div>
  </section>
  @else
  <script>
    window.dynamicHeroSlides = [];
  </script>
  @endif

  <!-- =====================================================================
       MAIN CONTENT CONTAINER
       ===================================================================== -->
  <main class="max-w-[1220px] mx-auto px-3 sm:px-6 py-6 sm:py-10 space-y-7 sm:space-y-11 overflow-hidden">

    <!-- ===================================================================
         4. STATS COUNTER BAR (DYNAMIC RESPONSIVE)
         =================================================================== -->
    @php
      $activeStats = isset($statCounters) && $statCounters->count() > 0 ? $statCounters : null;
    @endphp
    <section aria-label="পরিসংখ্যান" class="ui-card px-3 sm:px-6 py-4 sm:py-6">
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-{{ $activeStats ? min($activeStats->count(), 5) : 5 }} gap-y-5 gap-x-3 lg:gap-x-0 lg:divide-x lg:divide-gray-200/80">
        @if($activeStats)
          @foreach($activeStats as $stat)
            <div class="flex items-center justify-center gap-2.5 sm:gap-3.5 px-1 sm:px-2">
              <div class="text-[#c8102e] text-2xl sm:text-[34px] shrink-0">
                @if(str_starts_with($stat->icon, 'fa'))
                  <i class="{{ $stat->icon }}"></i>
                @elseif(str_starts_with($stat->icon, 'ri-'))
                  <i class="{{ $stat->icon }}"></i>
                @else
                  <i class="ri-numbers-line"></i>
                @endif
              </div>
              <div>
                <div class="text-lg sm:text-2xl font-extrabold text-gray-900 leading-none">{{ $stat->count }}</div>
                <div class="text-[11px] sm:text-[13.5px] font-medium text-gray-600 mt-1">{{ $stat->title }}</div>
              </div>
            </div>
          @endforeach
        @else
          <!-- Fallback Static Stats if DB empty -->
          <div class="flex items-center justify-center gap-2.5 sm:gap-3.5 px-1 sm:px-2">
            <div class="text-[#c8102e] text-2xl sm:text-[34px] shrink-0">
              <i class="fa-solid fa-people-group"></i>
            </div>
            <div>
              <div class="text-lg sm:text-2xl font-extrabold text-gray-900 leading-none">৫০০+</div>
              <div class="text-[11px] sm:text-[13.5px] font-medium text-gray-600 mt-1">সক্রিয় সদস্য</div>
            </div>
          </div>
          <div class="flex items-center justify-center gap-2.5 sm:gap-3.5 px-1 sm:px-2">
            <div class="text-[#c8102e] text-2xl sm:text-[32px] shrink-0">
              <i class="ri-book-open-line"></i>
            </div>
            <div>
              <div class="text-lg sm:text-2xl font-extrabold text-gray-900 leading-none">২৫+</div>
              <div class="text-[11px] sm:text-[13.5px] font-medium text-gray-600 mt-1">শিক্ষা প্রতিষ্ঠান</div>
            </div>
          </div>
          <div class="flex items-center justify-center gap-2.5 sm:gap-3.5 px-1 sm:px-2">
            <div class="text-[#c8102e] text-2xl sm:text-[32px] shrink-0">
              <i class="ri-stack-line"></i>
            </div>
            <div>
              <div class="text-lg sm:text-2xl font-extrabold text-gray-900 leading-none">৩০+</div>
              <div class="text-[11px] sm:text-[13.5px] font-medium text-gray-600 mt-1">উন্নয়ন প্রকল্প</div>
            </div>
          </div>
          <div class="flex items-center justify-center gap-2.5 sm:gap-3.5 px-1 sm:px-2">
            <div class="text-[#c8102e] text-2xl sm:text-[32px] shrink-0">
              <i class="ri-map-pin-line"></i>
            </div>
            <div>
              <div class="text-lg sm:text-2xl font-extrabold text-gray-900 leading-none">২০+</div>
              <div class="text-[11px] sm:text-[13.5px] font-medium text-gray-600 mt-1">দর্শনীয় স্থান</div>
            </div>
          </div>
          <div class="col-span-2 sm:col-span-1 flex items-center justify-center gap-2.5 sm:gap-3.5 px-1 sm:px-2">
            <div class="text-[#c8102e] text-2xl sm:text-[32px] shrink-0">
              <i class="ri-calendar-todo-line"></i>
            </div>
            <div>
              <div class="text-lg sm:text-2xl font-extrabold text-gray-900 leading-none">৫০+</div>
              <div class="text-[11px] sm:text-[13.5px] font-medium text-gray-600 mt-1">আয়োজিত অনুষ্ঠান</div>
            </div>
          </div>
        @endif
      </div>
    </section>

    <!-- ===================================================================
         5. ROW 1: আমাদের সম্পর্কে (LEFT) & সভাপতির বাণী (RIGHT)
         =================================================================== -->
    <section id="about-section" class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-8 items-stretch">
      <!-- Left: আমাদের সম্পর্কে -->
      <div class="lg:col-span-7 ui-card p-4 sm:p-7 flex flex-col md:flex-row items-center gap-5 sm:gap-6 relative overflow-hidden">
        <div class="w-full md:w-[52%] flex flex-col justify-between z-10">
          <div>
            <h2 class="text-xl sm:text-[25px] font-extrabold text-[#0b4622] leading-snug">
              {{ $about->title ?? 'আমাদের সম্পর্কে' }}
            </h2>
            <div class="section-underline"></div>
            <p class="text-gray-700 text-xs sm:text-[15px] leading-relaxed font-medium">
              {{ $about->short_description ?? 'আগামীর শৈলকুপা একটি অরাজনৈতিক সামাজিক উদ্যোগ, যা শৈলকুপার সার্বিক উন্নয়ন, শিক্ষা, স্বাস্থ্য, সামাজিক কল্যাণ ও ঐতিহ্য সংরক্ষণে কাজ করে যাচ্ছে।' }}
            </p>
          </div>

          <div class="mt-4 sm:mt-5">
            <a
              href="{{ route('about.us') }}"
              class="bg-[#c8102e] hover:bg-[#a30b24] text-white text-xs sm:text-sm font-semibold px-4 sm:px-5 py-2 sm:py-2.5 rounded-lg inline-flex items-center gap-1.5 shadow-sm transition cursor-pointer"
            >
              <span>{{ $about->button_text ?? 'বিস্তারিত পড়ুন' }}</span>
              <i class="ri-arrow-right-line text-sm sm:text-base"></i>
            </a>
          </div>
        </div>

        <!-- Right Photo: Shaheed Minar / About Image -->
        <div class="w-full md:w-[48%] shrink-0">
          <div class="rounded-xl overflow-hidden shadow-sm border border-gray-100 aspect-[16/10] sm:aspect-[16/11]">
            <img
              src="{{ isset($about) ? $about->image_url : asset('assets/images/about-shaheed-minar.jpg') }}"
              alt="{{ $about->title ?? 'আমাদের সম্পর্কে' }}"
              class="w-full h-full object-cover hover:scale-105 transition duration-500"
            />
          </div>
        </div>
      </div>

      <!-- Right: সভাপতির বাণী -->
      <a
        id="president-section"
        href="{{ route('chairman.message') }}"
        class="lg:col-span-5 president-card-bg rounded-2xl p-4 sm:p-7 shadow-[0_3px_14px_rgba(15,23,42,0.045)] flex flex-col sm:flex-row items-center gap-4 sm:gap-5 text-center sm:text-left transition-all duration-300 hover:shadow-lg hover:-translate-y-1 block cursor-pointer group"
      >
        <!-- President Circular Portrait -->
        <div class="shrink-0">
          <div class="w-24 h-24 sm:w-[120px] sm:h-[120px] rounded-full overflow-hidden border-4 border-white shadow-md bg-gray-100 group-hover:scale-105 transition duration-300">
            <img
              src="{{ isset($president) ? $president->image_url : asset('assets/images/president.jpg') }}"
              alt="{{ $president->name ?? 'মোঃ আব্দুল করিম' }} — {{ $president->designation ?? 'সভাপতি, আগামীর শৈলকুপা' }}"
              class="w-full h-full object-cover"
            />
          </div>
        </div>

        <!-- Quote & Designation -->
        <div class="flex-1">
          <div class="flex items-center justify-between">
            <h2 class="text-xl sm:text-[24px] font-extrabold text-[#0b4622] leading-snug group-hover:text-[#07381b] transition">
              {{ $president->title ?? 'সভাপতির বাণী' }}
            </h2>
            <span class="text-xs text-[#0b4622] font-semibold opacity-0 group-hover:opacity-100 transition hidden sm:inline-flex items-center gap-1">
              <span>বিস্তারিত</span> <i class="ri-arrow-right-line"></i>
            </span>
          </div>
          <div class="section-underline mx-auto sm:mx-0"></div>

          <div class="relative mt-1">
            <i class="fa-solid fa-quote-left text-[#c8102e] text-base sm:text-xl mr-1 align-top"></i>
            <span class="text-gray-800 text-xs sm:text-[14px] font-semibold italic leading-relaxed">
              "{{ $president->quote ?? 'শৈলকুপাকে একটি আধুনিক, শিক্ষিত, সমৃদ্ধ ও মানবিক জনপদে রূপ দিতে আমরা সবাই একসাথে কাজ করছি।' }}"
            </span>
            <div class="text-right -mt-1">
              <i class="fa-solid fa-quote-right text-[#c8102e] text-base sm:text-xl"></i>
            </div>
          </div>

          <div class="mt-2 pt-1 flex items-center justify-between">
            <div>
              <h3 class="text-sm sm:text-[15.5px] font-extrabold text-gray-900">{{ $president->name ?? 'মোঃ আব্দুল করিম' }}</h3>
              <p class="text-[11px] sm:text-xs font-medium text-gray-600">{{ $president->designation ?? 'সভাপতি, আগামীর শৈলকুপা' }}</p>
            </div>
            <span class="text-xs font-bold text-[#c8102e] sm:hidden inline-flex items-center gap-1">
              বিস্তারিত <i class="ri-arrow-right-line"></i>
            </span>
          </div>
        </div>
      </a>
    </section>

    <!-- ===================================================================
         6. ROW 2: আসন্ন ও চলমান কার্যক্রম (LEFT) & নোটিশ (RIGHT)
         =================================================================== -->
    <section id="events-section" class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-8 items-stretch">
      <!-- Left: আসন্ন ও চলমান কার্যক্রম (8 Cols) -->
      <div class="lg:col-span-8 ui-card p-4 sm:p-6 flex flex-col justify-between">
        <!-- Section Header -->
        <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4 sm:mb-5">
          <div class="flex items-center gap-2">
            <span class="text-[#c8102e] text-lg sm:text-xl flex items-center">
              <i class="ri-calendar-check-line"></i>
            </span>
            <h2 class="text-base sm:text-[20px] font-extrabold text-gray-900">আসন্ন ও চলমান কার্যক্রম</h2>
          </div>
          <a
            href="{{ route('events.index') }}"
            class="text-[#c8102e] hover:text-[#a30b24] text-xs sm:text-[13.5px] font-bold inline-flex items-center gap-1 transition"
          >
            <span>সব দেখুন</span>
            <i class="ri-arrow-right-line"></i>
          </a>
        </div>

        <!-- Event Cards Grid (Dynamic from DB) -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 sm:gap-5">
          @forelse($events as $eventItem)
            <a
              href="{{ route('events.details', $eventItem->id) }}"
              class="sub-card-hover bg-white rounded-xl border border-gray-200/80 overflow-hidden flex flex-col group cursor-pointer"
            >
              <div class="relative aspect-[16/10] bg-gray-100 overflow-hidden">
                <img
                  src="{{ $eventItem->thumbnail_url }}"
                  alt="{{ $eventItem->title }}"
                  class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                  onerror="this.src='{{ asset('assets/images/event-1.jpg') }}'"
                />
                <!-- Red Date Badge -->
                @if($eventItem->date)
                  <div class="absolute top-2 left-2 bg-[#c8102e] text-white rounded-lg px-2 py-0.5 sm:py-1 text-center leading-tight shadow">
                    <span class="block text-xs sm:text-sm font-extrabold">{{ $eventItem->bangla_day }}</span>
                    <span class="block text-[9px] sm:text-[10px] font-medium">{{ $eventItem->bangla_month }}</span>
                  </div>
                @endif
              </div>
              <div class="p-3 sm:p-3.5 flex-1 flex flex-col justify-between">
                <div>
                  <h3 class="text-sm sm:text-[15px] font-extrabold text-gray-900 group-hover:text-[#c8102e] transition line-clamp-1">
                    {{ $eventItem->title }}
                  </h3>
                  @if($eventItem->location)
                    <p class="text-xs text-gray-600 mt-0.5 sm:mt-1 truncate">{{ $eventItem->location }}</p>
                  @endif
                </div>
                @if($eventItem->time)
                  <div class="mt-2 pt-2 border-t border-gray-100 flex items-center gap-1 text-[11px] sm:text-xs text-gray-600 font-medium">
                    <i class="ri-time-line text-[#c8102e]"></i>
                    <span>{{ $eventItem->time }}</span>
                  </div>
                @endif
              </div>
            </a>
          @empty
            <div class="col-span-full py-8 text-center text-gray-500 text-xs">
              <i class="ri-calendar-line text-2xl text-gray-300 block mb-1"></i>
              বর্তমানে কোনো সক্রিয় ইভেন্ট বা কার্যক্রম নেই।
            </div>
          @endforelse
        </div>
      </div>

      <!-- Right: নোটিশ (4 Cols) -->
      <div id="notice-section" class="lg:col-span-4 ui-card p-4 sm:p-6 flex flex-col justify-between">
        <div>
          <!-- Card Header -->
          <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-3 sm:mb-4">
            <div class="flex items-center gap-2">
              <span class="text-[#c8102e] text-lg sm:text-xl flex items-center">
                <i class="fa-solid fa-bullhorn"></i>
              </span>
              <h2 class="text-base sm:text-[20px] font-extrabold text-gray-900">নোটিশ</h2>
            </div>
            <a
              href="{{ route('notices.index') }}"
              class="text-[#c8102e] hover:text-[#a30b24] text-xs sm:text-[13.5px] font-bold inline-flex items-center gap-1 transition"
            >
              <span>সব দেখুন</span>
              <i class="ri-arrow-right-line"></i>
            </a>
          </div>

          <!-- Notice Items List (Dynamic from DB) -->
          <div class="divide-y divide-gray-100">
            @forelse($notices as $noticeItem)
              <a
                href="{{ route('notices.details', $noticeItem->id) }}"
                class="py-2.5 sm:py-3 first:pt-1 last:pb-1 flex items-start gap-3 group transition"
              >
                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-red-50 border border-red-100 text-[#c8102e] flex items-center justify-center shrink-0 mt-0.5 group-hover:bg-[#c8102e] group-hover:text-white transition">
                  <i class="ri-file-text-line text-base sm:text-lg"></i>
                </div>
                <div class="min-w-0 flex-1">
                  <div class="flex items-center gap-1.5">
                    @if($noticeItem->status === 'pinned')
                      <span class="text-[10px] font-bold text-red-600 bg-red-50 px-1.5 py-0.5 rounded border border-red-200 shrink-0">
                        জরুরি
                      </span>
                    @endif
                    <h3 class="text-xs sm:text-[14.5px] font-extrabold text-gray-900 group-hover:text-[#c8102e] transition truncate">
                      {{ $noticeItem->title }}
                    </h3>
                  </div>
                  @if($noticeItem->date)
                    <p class="text-[11px] sm:text-xs text-gray-500 mt-0.5 flex items-center gap-1">
                      <i class="ri-time-line text-[#c8102e]"></i>
                      <span>{{ $noticeItem->bangla_formatted_date }}</span>
                    </p>
                  @endif
                </div>
              </a>
            @empty
              <div class="py-6 text-center text-xs text-gray-400">
                <i class="ri-notification-badge-line text-2xl text-gray-300 block mb-1"></i>
                বর্তমানে কোনো প্রকাশিত নোটিশ নেই।
              </div>
            @endforelse
          </div>
        </div>
      </div>
    </section>

    <!-- ===================================================================
         7. ROW 3: কৃতি সন্তান (LEFT) & কমিটি (RIGHT)
         =================================================================== -->
    <section id="personalities-section" class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-8 items-stretch">
      <!-- Left: কৃতি সন্তান (7 Cols) -->
      <div class="lg:col-span-7 ui-card p-4 sm:p-6 flex flex-col justify-between">
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4 sm:mb-5">
          <div class="flex items-center gap-2">
            <span class="text-[#c8102e] text-lg sm:text-xl flex items-center">
              <i class="ri-award-fill"></i>
            </span>
            <h2 class="text-base sm:text-[20px] font-extrabold text-gray-900">কৃতি সন্তান</h2>
          </div>
          <a
            href="{{ route('our.pride') }}"
            class="text-[#c8102e] hover:text-[#a30b24] text-xs sm:text-[13.5px] font-bold inline-flex items-center gap-1 transition"
          >
            <span>সবাই দেখুন</span>
            <i class="ri-arrow-right-line"></i>
          </a>
        </div>

        <!-- 4 Prides Grid (Dynamic from DB) -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-2 sm:divide-x sm:divide-gray-100">
          @forelse($prides as $prideItem)
            <a
              href="{{ route('our.pride.details', $prideItem->id) }}"
              class="flex flex-col items-center text-center px-1 sm:px-2 group cursor-pointer block hover:no-underline"
            >
              <div class="w-20 h-20 sm:w-24 sm:h-24 md:w-[96px] md:h-[96px] rounded-2xl overflow-hidden bg-gray-100 border border-gray-200 shadow-2xs mb-2 group-hover:border-[#0b4622]/60 group-hover:shadow-md transition duration-300">
                <img
                  src="{{ $prideItem->photo_url }}"
                  alt="{{ $prideItem->name }}"
                  class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                  onerror="this.src='https://placehold.co/400x400/0b4622/ffffff?text={{ urlencode($prideItem->name) }}'"
                />
              </div>
              <h3 class="text-xs sm:text-[14px] font-extrabold text-gray-900 leading-snug group-hover:text-[#0b4622] transition line-clamp-1">
                {{ $prideItem->name }}
              </h3>
              <p class="text-[10px] sm:text-[11.5px] text-gray-600 mt-0.5 line-clamp-2">
                {{ $prideItem->designation }}
              </p>
            </a>
          @empty
            <div class="col-span-full py-6 text-center text-xs text-gray-400">
              কোনো কৃতি সন্তানের তথ্য পাওয়া যায়নি।
            </div>
          @endforelse
        </div>
      </div>

      <!-- Right: কমিটি (5 Cols) -->
      @php
        $committeeName = $committee ? $committee->name : 'কার্যনির্বাহী কমিটি';
        $committeeSession = $committee ? $committee->session_duration : '২০২৬-২০২৮';
        $committeeSubtitle = $committee && $committee->subtitle ? $committee->subtitle : 'আগামীর শৈলকুপা';
        $committeeImg = $committee ? $committee->image_url : asset('assets/images/committee.jpg');
        $committeeDesc = $committee && $committee->description ? $committee->description : "সভাপতি: মোঃ আব্দুল করিম\nসহ-প্রতিষ্ঠাতা: নিটুল ইসলাম\nসাধারণ সম্পাদক ও অন্যান্য সম্পাদকমণ্ডলীর পূর্ণাঙ্গ তালিকা অফিসে সংরক্ষিত রয়েছে।";
        $committeeTitleFull = $committeeName . ' (' . $committeeSession . ')';
      @endphp
      <div id="committee-section" class="lg:col-span-5 ui-card p-4 sm:p-6 flex flex-col justify-between">
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-3 sm:mb-4">
          <div class="flex items-center gap-2">
            <span class="text-[#c8102e] text-lg sm:text-xl flex items-center">
              <i class="fa-solid fa-users"></i>
            </span>
            <h2 class="text-base sm:text-[20px] font-extrabold text-gray-900">কমিটি</h2>
          </div>
          <a
            href="{{ route('committee.index') }}"
            class="text-[#c8102e] hover:text-[#a30b24] text-xs sm:text-[13.5px] font-bold inline-flex items-center gap-1 transition cursor-pointer"
          >
            <span>সবাই দেখুন</span>
            <i class="ri-arrow-right-line"></i>
          </a>
        </div>

        <!-- Committee Photo & Caption -->
        <a
          href="{{ route('committee.index') }}"
          class="flex flex-col items-center text-center cursor-pointer group block"
        >
          <div class="w-full rounded-xl overflow-hidden border border-gray-200 shadow-sm aspect-[16/8] sm:aspect-[16/6.2] bg-gray-100">
            <img src="{{ $committeeImg }}" alt="{{ $committeeTitleFull }}" class="w-full h-full object-cover group-hover:scale-102 transition duration-300" />
          </div>
          <h3 class="text-sm sm:text-base font-extrabold text-gray-900 group-hover:text-[#c8102e] transition mt-2.5 sm:mt-3">
            {{ $committeeTitleFull }}
          </h3>
          <p class="text-[11px] sm:text-xs font-medium text-gray-600 mt-0.5">
            {{ $committeeSubtitle }}
          </p>
        </a>
      </div>
    </section>

    <!-- ===================================================================
         8. ROW 4: THREE FEATURE CARDS (উন্নয়ন প্রকল্পসমূহ, দর্শনীয় স্থান, গ্যালারি)
         =================================================================== -->
    <section id="projects-section" class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-7">
      <!-- Feature Card 1: উন্নয়ন প্রকল্পসমূহ -->
      <a
        href="{{ route('projects.index') }}"
        class="ui-card feature-card-watermark p-3.5 sm:p-5 flex items-center gap-3.5 sm:gap-4 sub-card-hover block cursor-pointer group"
      >
        <div class="w-20 h-20 sm:w-24 sm:h-24 md:w-[100px] md:h-[100px] rounded-xl overflow-hidden shrink-0 border border-gray-100 shadow-sm">
          <img src="{{ asset('assets/images/project-road.jpg') }}" alt="উন্নয়ন প্রকল্পসমূহ" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" />
        </div>
        <div class="flex-1 min-w-0">
          <div class="flex items-center gap-1.5 sm:gap-2">
            <i class="ri-stack-line text-[#c8102e] text-base sm:text-lg"></i>
            <h3 class="text-base sm:text-[18px] font-extrabold text-[#0b4622] group-hover:text-[#c8102e] transition truncate">উন্নয়ন প্রকল্পসমূহ</h3>
          </div>
          <p class="text-xs sm:text-[13px] text-gray-600 leading-relaxed mt-1 line-clamp-2">
            শৈলকুপার অবকাঠামো, শিক্ষা, স্বাস্থ্য ও সামাজিক উন্নয়নের চলমান প্রকল্পসমূহ।
          </p>
          <div
            class="mt-1.5 sm:mt-2 text-xs sm:text-[13px] font-extrabold text-gray-900 group-hover:text-[#c8102e] inline-flex items-center gap-1 transition"
          >
            <span>বিস্তারিত দেখুন</span>
            <i class="ri-arrow-right-line text-[#c8102e] group-hover:translate-x-1 transition-transform"></i>
          </div>
        </div>
      </a>

      <!-- Feature Card 2: দর্শনীয় স্থান -->
      <a
        href="{{ route('places.index') }}"
        class="ui-card feature-card-watermark p-3.5 sm:p-5 flex items-center gap-3.5 sm:gap-4 sub-card-hover block cursor-pointer group"
      >
        <div class="w-20 h-20 sm:w-24 sm:h-24 md:w-[100px] md:h-[100px] rounded-xl overflow-hidden shrink-0 border border-gray-100 shadow-sm">
          <img src="{{ asset('assets/images/place-mosque.jpg') }}" alt="দর্শনীয় স্থান" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" />
        </div>
        <div class="flex-1 min-w-0">
          <div class="flex items-center gap-1.5 sm:gap-2">
            <i class="ri-map-pin-line text-[#c8102e] text-base sm:text-lg"></i>
            <h3 class="text-base sm:text-[18px] font-extrabold text-[#0b4622] group-hover:text-[#c8102e] transition truncate">দর্শনীয় স্থান</h3>
          </div>
          <p class="text-xs sm:text-[13px] text-gray-600 leading-relaxed mt-1 line-clamp-2">
            শৈলকুপার ঐতিহাসিক, প্রাকৃতিক ও সাংস্কৃতিক দর্শনীয় স্থানসমূহ।
          </p>
          <div
            class="mt-1.5 sm:mt-2 text-xs sm:text-[13px] font-extrabold text-gray-900 group-hover:text-[#c8102e] inline-flex items-center gap-1 transition"
          >
            <span>বিস্তারিত দেখুন</span>
            <i class="ri-arrow-right-line text-[#c8102e] group-hover:translate-x-1 transition-transform"></i>
          </div>
        </div>
      </a>

      <!-- Feature Card 3: গ্যালারি -->
      <a
        href="{{ route('gallery') }}"
        id="gallery-section"
        class="ui-card feature-card-watermark p-3.5 sm:p-5 flex items-center gap-3.5 sm:gap-4 sub-card-hover block cursor-pointer group"
      >
        <div class="w-20 h-20 sm:w-24 sm:h-24 md:w-[100px] md:h-[100px] rounded-xl overflow-hidden shrink-0 border border-gray-100 shadow-sm">
          <img src="{{ asset('assets/images/gallery-event.jpg') }}" alt="গ্যালারি" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" />
        </div>
        <div class="flex-1 min-w-0">
          <div class="flex items-center gap-1.5 sm:gap-2">
            <i class="ri-image-line text-[#c8102e] text-base sm:text-lg"></i>
            <h3 class="text-base sm:text-[18px] font-extrabold text-[#0b4622] group-hover:text-[#c8102e] transition truncate">গ্যালারি</h3>
          </div>
          <p class="text-xs sm:text-[13px] text-gray-600 leading-relaxed mt-1 line-clamp-2">
            আমাদের বিভিন্ন কার্যক্রম, অনুষ্ঠান ও মুহূর্তের ছবিসমূহ।
          </p>
          <div
            class="mt-1.5 sm:mt-2 text-xs sm:text-[13px] font-extrabold text-gray-900 group-hover:text-[#c8102e] inline-flex items-center gap-1 transition"
          >
            <span>গ্যালারি দেখুন</span>
            <i class="ri-arrow-right-line text-[#c8102e] group-hover:translate-x-1 transition-transform"></i>
          </div>
        </div>
      </a>
    </section>

    <!-- ===================================================================
         9. ROW 5: ব্লগ ও আপডেট (LEFT) & DONATION BANNER (RIGHT)
         =================================================================== -->
    <section id="blog-section" class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-8 items-stretch">
      <!-- Left: ব্লগ ও আপডেট (7 Cols) -->
      <div class="lg:col-span-7 ui-card p-4 sm:p-6 flex flex-col justify-between">
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4 sm:mb-5">
          <div class="flex items-center gap-2">
            <span class="text-[#c8102e] text-lg sm:text-xl flex items-center">
              <i class="ri-article-line"></i>
            </span>
            <h2 class="text-base sm:text-[20px] font-extrabold text-gray-900">ব্লগ ও আপডেট</h2>
          </div>
          <a
            href="{{ route('blogs.index') }}"
            class="text-[#c8102e] hover:text-[#a30b24] text-xs sm:text-[13.5px] font-bold inline-flex items-center gap-1 transition cursor-pointer"
          >
            <span>সব দেখুন</span>
            <i class="ri-arrow-right-line"></i>
          </a>
        </div>

        <!-- 3 Blog Cards Grid (Dynamic from Database) -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 sm:gap-4">
          @forelse($latestPosts ?? [] as $postItem)
            <a
              href="{{ route('blogs.details', $postItem->slug) }}"
              class="sub-card-hover cursor-pointer bg-white rounded-xl border border-gray-200/80 overflow-hidden flex flex-col group justify-between"
            >
              <div>
                <!-- Thumbnail -->
                <div class="aspect-[16/10] bg-gray-100 overflow-hidden">
                  <img
                    src="{{ $postItem->thumbnail_url }}"
                    alt="{{ $postItem->title }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                    onerror="this.src='https://placehold.co/400x250/0b4622/ffffff?text={{ urlencode($postItem->title) }}'"
                  />
                </div>
                <!-- Content -->
                <div class="p-3">
                  <h3 class="text-xs sm:text-[14px] font-extrabold text-gray-900 group-hover:text-[#c8102e] leading-snug transition line-clamp-2">
                    {{ $postItem->title }}
                  </h3>
                </div>
              </div>

              <!-- Category & Date below title -->
              <div class="px-3 pb-3 pt-0 space-y-1.5 border-t border-gray-50 mt-1">
                @if($postItem->category)
                  <div class="text-[11px] font-bold text-[#0b4622] flex items-center gap-1">
                    <i class="ri-price-tag-3-line text-[10px]"></i>
                    <span class="truncate">{{ $postItem->category->name }}</span>
                  </div>
                @endif
                <p class="text-[11px] text-gray-500 flex items-center gap-1">
                  <i class="ri-time-line text-[#c8102e]"></i>
                  <span>{{ $postItem->published ? $postItem->published->format('d M, Y') : $postItem->created_at->format('d M, Y') }}</span>
                </p>
              </div>
            </a>
          @empty
            <div class="col-span-3 py-8 text-center text-xs text-gray-400">
              বর্তমানে কোনো ব্লগ আপডেট নেই।
            </div>
          @endforelse
        </div>
      </div>

      <!-- Right: Donation CTA Banner (Fully Responsive & Admin Controlled) -->
      @php
        $donationBanner = $donation ?? \App\Models\DonationSetting::first();
      @endphp
      @if(!$donationBanner || $donationBanner->status)
        <div
          class="lg:col-span-5 rounded-2xl overflow-hidden shadow-md relative flex flex-col sm:flex-row items-center justify-between p-5 sm:p-7 gap-5 sm:gap-4 transition-all duration-300"
          style="background: {{ ($donationBanner && $donationBanner->background_gradient) ? $donationBanner->background_gradient : 'radial-gradient(circle at 78% 45%, #d92638 0%, #7d0615 100%)' }}; color: {{ ($donationBanner && $donationBanner->text_color) ? $donationBanner->text_color : '#ffffff' }};"
        >
          <!-- Left Text & Button -->
          <div class="relative z-10 w-full sm:max-w-[62%] text-center sm:text-left flex flex-col items-center sm:items-start">
            <div class="flex items-center sm:items-start gap-2.5 sm:gap-3">
              <div class="text-2xl sm:text-4xl shrink-0 mt-0.5">
                <i class="{{ ($donationBanner && $donationBanner->icon) ? $donationBanner->icon : 'fa-solid fa-hand-holding-heart' }}"></i>
              </div>
              <h2 class="text-lg sm:text-[24px] font-extrabold leading-tight">
                {!! nl2br(e($donationBanner->title ?? "শৈলকুপার উন্নয়নে\nআপনিও অংশ নিন")) !!}
              </h2>
            </div>

            <p class="text-xs sm:text-[13.5px] leading-relaxed mt-2.5 sm:mt-3.5 font-medium opacity-90">
              {{ $donationBanner->description ?? 'শিক্ষা, স্বাস্থ্য, সামাজিক উন্নয়ন ও মানবকল্যাণমূলক কার্যক্রমে আপনার অনুদান আমাদের প্রেরণা।' }}
            </p>

            @php
              $btnBg = ($donationBanner && $donationBanner->button_bg_color) ? $donationBanner->button_bg_color : '#ffffff';
              $btnTextColor = ($donationBanner && $donationBanner->button_text_color) ? $donationBanner->button_text_color : '#111827';
              $btnIconColor = ($donationBanner && $donationBanner->bg_color_start) ? $donationBanner->bg_color_start : '#c8102e';
            @endphp

            @if($donationBanner && !empty($donationBanner->button_link) && $donationBanner->button_link !== '#')
              <a
                href="{{ $donationBanner->button_link }}"
                class="mt-4 sm:mt-5 text-xs sm:text-sm font-extrabold px-5 py-2.5 rounded-full shadow inline-flex items-center gap-2 transition cursor-pointer hover:opacity-95"
                style="background-color: {{ $btnBg }}; color: {{ $btnTextColor }};"
              >
                <span>{{ $donationBanner->button_text ?? 'অনুদান দিন এখনই' }}</span>
                <i class="ri-arrow-right-line font-bold" style="color: {{ $btnIconColor }};"></i>
              </a>
            @else
              <button
                type="button"
                onclick="openDonateModal()"
                class="mt-4 sm:mt-5 text-xs sm:text-sm font-extrabold px-5 py-2.5 rounded-full shadow inline-flex items-center gap-2 transition cursor-pointer hover:opacity-95"
                style="background-color: {{ $btnBg }}; color: {{ $btnTextColor }};"
              >
                <span>{{ $donationBanner->button_text ?? 'অনুদান দিন এখনই' }}</span>
                <i class="ri-arrow-right-line font-bold" style="color: {{ $btnIconColor }};"></i>
              </button>
            @endif
          </div>

          <!-- Right Sapling Image -->
          <div class="w-32 sm:w-36 md:w-44 h-32 sm:h-40 md:h-48 flex items-center justify-center shrink-0">
            <img
              src="{{ $donationBanner ? $donationBanner->image_url : asset('assets/images/donate-sapling.jpg') }}"
              alt="অনুদান প্রতীক"
              class="w-full h-full object-cover rounded-xl"
            />
          </div>
        </div>
      @endif
    </section>

  </main>

@endsection
