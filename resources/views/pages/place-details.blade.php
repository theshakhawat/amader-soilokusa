@extends('layouts.website.website-layout')

@section('title', $place->title . ' — দর্শনীয় স্থান বিস্তারিত | আগামীর শৈলকুপা')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-8">

  <!-- Breadcrumb -->
  <nav class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 bg-white px-4 py-2.5 rounded-xl border border-gray-100 shadow-2xs">
    <a href="{{ route('home') }}" class="hover:text-[#0b4622] flex items-center gap-1 transition">
      <i class="ri-home-4-line"></i>
      <span>হোম</span>
    </a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <a href="{{ route('places.index') }}" class="hover:text-[#0b4622] transition">দর্শনীয় স্থানসমূহ</a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <span class="text-[#0b4622] font-semibold truncate max-w-xs">{{ $place->title }}</span>
  </nav>

  @php
    $allImages = collect();
    if ($place->thumbnail) {
        $allImages->push(['url' => $place->thumbnail_url, 'caption' => $place->title . ' (কভার ছবি)']);
    }
    foreach ($place->photos as $p) {
        $allImages->push(['url' => $p->image_url, 'caption' => $place->title]);
    }
    if ($allImages->isEmpty()) {
        $allImages->push(['url' => asset('assets/images/place-default.jpg'), 'caption' => $place->title]);
    }
  @endphp

  <!-- Main Card -->
  <article class="bg-white rounded-3xl border border-gray-200/80 shadow-xs overflow-hidden">

    <!-- Top Header & Badges -->
    <div class="p-6 sm:p-8 border-b border-gray-100 space-y-3">
      <div class="flex flex-wrap items-center gap-2.5">
        <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-xl text-xs font-black shadow-xs bg-[#0b4622] text-white">
          <i class="ri-landscape-line"></i>
          <span>দর্শনীয় স্থান</span>
        </span>

        @if($place->location)
          <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-xl text-xs font-semibold bg-emerald-50 text-[#0b4622] border border-emerald-200">
            <i class="ri-map-pin-2-line"></i>
            <span>{{ $place->location }}</span>
          </span>
        @endif

        <span class="text-xs text-gray-400 flex items-center gap-1">
          <i class="ri-calendar-line text-[#0b4622]"></i>
          <span>যোগ হয়েছে: {{ $place->created_at->format('d M, Y') }}</span>
        </span>
      </div>

      <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-gray-900 leading-tight">
        {{ $place->title }}
      </h1>
      @if($place->subtitle)
        <p class="text-sm sm:text-base text-gray-500 font-medium">{{ $place->subtitle }}</p>
      @endif
    </div>

    <!-- Image Carousel Slider Section -->
    <div class="p-6 sm:p-8 bg-gray-50/50 border-b border-gray-100">
      <div class="relative max-w-4xl mx-auto rounded-3xl overflow-hidden shadow-lg bg-black aspect-[16/9] sm:aspect-[16/8.5] group select-none">

        <!-- Slider Images Container -->
        <div id="place-slider-track" class="w-full h-full relative">
          @foreach($allImages as $index => $img)
            <div
              class="place-slide absolute inset-0 transition-opacity duration-500 ease-in-out {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none' }}"
              data-index="{{ $index }}"
            >
              <img
                src="{{ $img['url'] }}"
                alt="{{ $img['caption'] }}"
                class="w-full h-full object-cover"
                onerror="this.src='https://placehold.co/1200x600/0b4622/ffffff?text={{ urlencode($place->title) }}'"
              >
              <!-- Caption Gradient Overlay -->
              <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-4 sm:p-6 text-white">
                <p class="text-xs sm:text-sm font-semibold truncate">{{ $img['caption'] }}</p>
              </div>
            </div>
          @endforeach
        </div>

        @if($allImages->count() > 1)
          <!-- Left Arrow Button -->
          <button
            type="button"
            onclick="prevPlaceSlide()"
            class="absolute left-3 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-black/50 hover:bg-black/80 text-white flex items-center justify-center backdrop-blur-xs transition group-hover:scale-105 cursor-pointer"
            aria-label="Previous image"
          >
            <i class="ri-arrow-left-s-line text-2xl"></i>
          </button>

          <!-- Right Arrow Button -->
          <button
            type="button"
            onclick="nextPlaceSlide()"
            class="absolute right-3 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-black/50 hover:bg-black/80 text-white flex items-center justify-center backdrop-blur-xs transition group-hover:scale-105 cursor-pointer"
            aria-label="Next image"
          >
            <i class="ri-arrow-right-s-line text-2xl"></i>
          </button>

          <!-- Slide Counter Badge -->
          <div class="absolute top-3 right-3 z-20 px-3 py-1 rounded-full bg-black/60 backdrop-blur-md text-white text-xs font-bold">
            <span id="place-slide-num">1</span> / {{ $allImages->count() }}
          </div>
        @endif
      </div>

      <!-- Thumbnails Strip (if multiple) -->
      @if($allImages->count() > 1)
        <div class="flex items-center justify-center gap-2.5 mt-4 overflow-x-auto py-2">
          @foreach($allImages as $index => $img)
            <button
              type="button"
              onclick="goToPlaceSlide({{ $index }})"
              class="place-thumb-btn w-16 h-12 rounded-xl overflow-hidden border-2 transition cursor-pointer shrink-0 {{ $index === 0 ? 'border-[#0b4622] scale-105' : 'border-transparent opacity-60 hover:opacity-100' }}"
              data-thumb-index="{{ $index }}"
            >
              <img src="{{ $img['url'] }}" alt="thumb" class="w-full h-full object-cover">
            </button>
          @endforeach
        </div>
      @endif
    </div>

    <!-- Rich Text Description Content -->
    <div class="p-6 sm:p-10 lg:p-12 space-y-6">
      <div class="flex items-center gap-2 pb-3 border-b border-gray-100">
        <i class="ri-article-line text-xl text-[#0b4622]"></i>
        <h2 class="text-lg sm:text-xl font-black text-gray-900">স্থানের বিস্তারিত বিবরণ</h2>
      </div>

      <div class="prose max-w-none text-gray-700 leading-relaxed text-sm sm:text-base space-y-4">
        @if($place->descriptions)
          {!! $place->descriptions !!}
        @else
          <p class="text-gray-400 italic">এই স্থানের জন্য কোনো বিস্তারিত বিবরণ প্রদান করা হয়নি।</p>
        @endif
      </div>
    </div>

  </article>

  <!-- Other Places Section -->
  @if($otherPlaces->count() > 0)
    <div class="space-y-4 pt-6">
      <div class="flex items-center justify-between border-b border-gray-200 pb-3">
        <h3 class="text-lg sm:text-xl font-bold text-gray-900 flex items-center gap-2">
          <i class="ri-map-pin-2-line text-[#0b4622]"></i>
          <span>অন্যান্য দর্শনীয় স্থানসমূহ</span>
        </h3>
        <a href="{{ route('places.index') }}" class="text-xs sm:text-sm font-bold text-[#c8102e] hover:underline flex items-center gap-1">
          <span>সব দেখুন</span>
          <i class="ri-arrow-right-line"></i>
        </a>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($otherPlaces as $other)
          <a
            href="{{ route('places.details', $other->id) }}"
            class="bg-white rounded-2xl border border-gray-200/80 p-3.5 shadow-2xs hover:shadow-lg hover:border-[#0b4622]/40 transition group flex flex-col justify-between"
          >
            <div>
              <div class="aspect-video rounded-xl overflow-hidden bg-gray-100 mb-3">
                <img src="{{ $other->thumbnail_url }}" alt="{{ $other->title }}" class="w-full h-full object-cover group-hover:scale-105 transition">
              </div>
              <h4 class="text-xs sm:text-sm font-extrabold text-gray-900 group-hover:text-[#0b4622] transition line-clamp-2">
                {{ $other->title }}
              </h4>
              @if($other->subtitle)
                <p class="text-[11px] text-gray-500 mt-0.5 line-clamp-1">{{ $other->subtitle }}</p>
              @endif
            </div>
            <div class="mt-2.5 pt-2 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-500 font-semibold">
              <span class="text-[#0b4622] font-bold">বিস্তারিত →</span>
              @if($other->location)
                <span class="flex items-center gap-0.5"><i class="ri-map-pin-line"></i>{{ Str::limit($other->location, 15) }}</span>
              @endif
            </div>
          </a>
        @endforeach
      </div>
    </div>
  @endif

  <!-- Back to All Places Navigation -->
  <div class="pt-6 text-center border-t border-gray-100">
    <a
      href="{{ route('places.index') }}"
      class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-bold rounded-xl transition cursor-pointer"
    >
      <i class="ri-arrow-left-line"></i>
      <span>সকল দর্শনীয় স্থানে ফিরে যান</span>
    </a>
  </div>

</div>

<!-- Place Carousel JavaScript -->
<script>
let currentPlaceSlide = 0;
const totalPlaceSlides = {{ $allImages->count() }};

function showPlaceSlide(index) {
  if (totalPlaceSlides <= 1) return;
  if (index >= totalPlaceSlides) currentPlaceSlide = 0;
  else if (index < 0) currentPlaceSlide = totalPlaceSlides - 1;
  else currentPlaceSlide = index;

  const slides = document.querySelectorAll('.place-slide');
  const thumbs = document.querySelectorAll('.place-thumb-btn');
  const counter = document.getElementById('place-slide-num');

  slides.forEach((s, idx) => {
    if (idx === currentPlaceSlide) {
      s.classList.remove('opacity-0', 'z-0', 'pointer-events-none');
      s.classList.add('opacity-100', 'z-10');
    } else {
      s.classList.remove('opacity-100', 'z-10');
      s.classList.add('opacity-0', 'z-0', 'pointer-events-none');
    }
  });

  thumbs.forEach((t, idx) => {
    if (idx === currentPlaceSlide) {
      t.className = 'place-thumb-btn w-16 h-12 rounded-xl overflow-hidden border-2 transition cursor-pointer shrink-0 border-[#0b4622] scale-105';
    } else {
      t.className = 'place-thumb-btn w-16 h-12 rounded-xl overflow-hidden border-2 transition cursor-pointer shrink-0 border-transparent opacity-60 hover:opacity-100';
    }
  });

  if (counter) counter.innerText = currentPlaceSlide + 1;
}

function nextPlaceSlide() {
  showPlaceSlide(currentPlaceSlide + 1);
}

function prevPlaceSlide() {
  showPlaceSlide(currentPlaceSlide - 1);
}

function goToPlaceSlide(index) {
  showPlaceSlide(index);
}

// Auto play slide every 5 seconds if multiple
@if($allImages->count() > 1)
  let placeSlideTimer = setInterval(nextPlaceSlide, 5000);
  const placeSliderElem = document.getElementById('place-slider-track');
  if (placeSliderElem) {
    placeSliderElem.addEventListener('mouseenter', () => clearInterval(placeSlideTimer));
    placeSliderElem.addEventListener('mouseleave', () => {
      clearInterval(placeSlideTimer);
      placeSlideTimer = setInterval(nextPlaceSlide, 5000);
    });
  }
@endif
</script>
@endsection

