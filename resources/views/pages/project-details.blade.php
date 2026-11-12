@extends('layouts.website.website-layout')

@section('title', $project->title . ' — উন্নয়ন প্রকল্প বিস্তারিত | আগামীর শৈলকুপা')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-8">

  <!-- Breadcrumb -->
  <nav class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 bg-white px-4 py-2.5 rounded-xl border border-gray-100 shadow-2xs">
    <a href="{{ route('home') }}" class="hover:text-[#0b4622] flex items-center gap-1 transition">
      <i class="ri-home-4-line"></i>
      <span>হোম</span>
    </a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <a href="{{ route('projects.index') }}" class="hover:text-[#0b4622] transition">উন্নয়ন প্রকল্পসমূহ</a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <span class="text-[#0b4622] font-semibold truncate max-w-xs">{{ $project->title }}</span>
  </nav>

  @php
    $badge = $project->status_badge;
    $allImages = collect();
    if ($project->thumbnail) {
        $allImages->push(['url' => $project->thumbnail_url, 'caption' => $project->title . ' (কভার ছবি)']);
    }
    foreach ($project->photos as $p) {
        if ($p->image_url !== $project->thumbnail_url) {
            $allImages->push(['url' => $p->image_url, 'caption' => $p->caption ?? $project->title]);
        }
    }
    if ($allImages->isEmpty()) {
        $allImages->push(['url' => asset('assets/images/project-road.jpg'), 'caption' => $project->title]);
    }
  @endphp

  <!-- Main Card -->
  <article class="bg-white rounded-3xl border border-gray-200/80 shadow-xs overflow-hidden">
    
    <!-- Top Header & Badges -->
    <div class="p-6 sm:p-8 border-b border-gray-100 space-y-3">
      <div class="flex flex-wrap items-center gap-2.5">
        <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-xl text-xs font-black shadow-xs {{ $badge['bg'] }} {{ $badge['text_color'] }}">
          <i class="{{ $badge['icon'] }}"></i>
          <span>{{ $badge['text'] }}</span>
        </span>

        <span class="text-xs text-gray-400 flex items-center gap-1">
          <i class="ri-calendar-line text-[#0b4622]"></i>
          <span>যোগ হয়েছে: {{ $project->created_at->format('d M, Y') }}</span>
        </span>
      </div>

      <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-gray-900 leading-tight">
        {{ $project->title }}
      </h1>
    </div>

    <!-- Image Carousel Slider Section -->
    <div class="p-6 sm:p-8 bg-gray-50/50 border-b border-gray-100">
      <div class="relative max-w-4xl mx-auto rounded-3xl overflow-hidden shadow-lg bg-black aspect-[16/9] sm:aspect-[16/8.5] group select-none">
        
        <!-- Slider Images Container -->
        <div id="project-slider-track" class="w-full h-full relative">
          @foreach($allImages as $index => $img)
            <div
              class="project-slide absolute inset-0 transition-opacity duration-500 ease-in-out {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none' }}"
              data-index="{{ $index }}"
            >
              <img
                src="{{ $img['url'] }}"
                alt="{{ $img['caption'] }}"
                class="w-full h-full object-cover"
                onerror="this.src='https://placehold.co/1200x600/0b4622/ffffff?text={{ urlencode($project->title) }}'"
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
            onclick="prevProjectSlide()"
            class="absolute left-3 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-black/50 hover:bg-black/80 text-white flex items-center justify-center backdrop-blur-xs transition group-hover:scale-105 cursor-pointer"
            aria-label="Previous image"
          >
            <i class="ri-arrow-left-s-line text-2xl"></i>
          </button>

          <!-- Right Arrow Button -->
          <button
            type="button"
            onclick="nextProjectSlide()"
            class="absolute right-3 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-black/50 hover:bg-black/80 text-white flex items-center justify-center backdrop-blur-xs transition group-hover:scale-105 cursor-pointer"
            aria-label="Next image"
          >
            <i class="ri-arrow-right-s-line text-2xl"></i>
          </button>

          <!-- Slide Counter Badge -->
          <div class="absolute top-3 right-3 z-20 px-3 py-1 rounded-full bg-black/60 backdrop-blur-md text-white text-xs font-bold">
            <span id="current-slide-num">1</span> / {{ $allImages->count() }}
          </div>
        @endif
      </div>

      <!-- Thumbnails Strip (if multiple) -->
      @if($allImages->count() > 1)
        <div class="flex items-center justify-center gap-2.5 mt-4 overflow-x-auto py-2">
          @foreach($allImages as $index => $img)
            <button
              type="button"
              onclick="goToProjectSlide({{ $index }})"
              class="project-thumb-btn w-16 h-12 rounded-xl overflow-hidden border-2 transition cursor-pointer shrink-0 {{ $index === 0 ? 'border-[#0b4622] scale-105' : 'border-transparent opacity-60 hover:opacity-100' }}"
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
        <h2 class="text-lg sm:text-xl font-black text-gray-900">প্রকল্পের বিস্তারিত বিবরণ</h2>
      </div>

      <div class="prose max-w-none text-gray-700 leading-relaxed text-sm sm:text-base space-y-4">
        @if($project->description)
          {!! $project->description !!}
        @else
          <p class="text-gray-400 italic">এই প্রকল্পের জন্য কোনো বিস্তারিত বিবরণ প্রদান করা হয়নি।</p>
        @endif
      </div>
    </div>

  </article>

  <!-- Other Projects Section -->
  @if($otherProjects->count() > 0)
    <div class="space-y-4 pt-6">
      <div class="flex items-center justify-between border-b border-gray-200 pb-3">
        <h3 class="text-lg sm:text-xl font-bold text-gray-900 flex items-center gap-2">
          <i class="ri-stack-line text-[#0b4622]"></i>
          <span>অন্যান্য উন্নয়ন প্রকল্পসমূহ</span>
        </h3>
        <a href="{{ route('projects.index') }}" class="text-xs sm:text-sm font-bold text-[#c8102e] hover:underline flex items-center gap-1">
          <span>সব দেখুন</span>
          <i class="ri-arrow-right-line"></i>
        </a>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($otherProjects as $other)
          <a
            href="{{ route('projects.details', $other->id) }}"
            class="bg-white rounded-2xl border border-gray-200/80 p-3.5 shadow-2xs hover:shadow-lg hover:border-[#0b4622]/40 transition group flex flex-col justify-between"
          >
            <div>
              <div class="aspect-video rounded-xl overflow-hidden bg-gray-100 mb-3">
                <img src="{{ $other->thumbnail_url }}" alt="{{ $other->title }}" class="w-full h-full object-cover group-hover:scale-105 transition">
              </div>
              <h4 class="text-xs sm:text-sm font-extrabold text-gray-900 group-hover:text-[#0b4622] transition line-clamp-2">
                {{ $other->title }}
              </h4>
            </div>
            <div class="mt-2.5 pt-2 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-500 font-semibold">
              <span class="text-[#0b4622] font-bold">বিস্তারিত →</span>
              <span>{{ $other->status_badge['text'] }}</span>
            </div>
          </a>
        @endforeach
      </div>
    </div>
  @endif

  <!-- Back to All Projects Navigation -->
  <div class="pt-6 text-center border-t border-gray-100">
    <a
      href="{{ route('projects.index') }}"
      class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-bold rounded-xl transition cursor-pointer"
    >
      <i class="ri-arrow-left-line"></i>
      <span>সকল উন্নয়ন প্রকল্পে ফিরে যান</span>
    </a>
  </div>

</div>

<!-- Project Carousel JavaScript -->
<script>
let currentSlide = 0;
const totalSlides = {{ $allImages->count() }};

function showSlide(index) {
  if (totalSlides <= 1) return;
  if (index >= totalSlides) currentSlide = 0;
  else if (index < 0) currentSlide = totalSlides - 1;
  else currentSlide = index;

  const slides = document.querySelectorAll('.project-slide');
  const thumbs = document.querySelectorAll('.project-thumb-btn');
  const counter = document.getElementById('current-slide-num');

  slides.forEach((s, idx) => {
    if (idx === currentSlide) {
      s.classList.remove('opacity-0', 'z-0', 'pointer-events-none');
      s.classList.add('opacity-100', 'z-10');
    } else {
      s.classList.remove('opacity-100', 'z-10');
      s.classList.add('opacity-0', 'z-0', 'pointer-events-none');
    }
  });

  thumbs.forEach((t, idx) => {
    if (idx === currentSlide) {
      t.className = 'project-thumb-btn w-16 h-12 rounded-xl overflow-hidden border-2 transition cursor-pointer shrink-0 border-[#0b4622] scale-105';
    } else {
      t.className = 'project-thumb-btn w-16 h-12 rounded-xl overflow-hidden border-2 transition cursor-pointer shrink-0 border-transparent opacity-60 hover:opacity-100';
    }
  });

  if (counter) counter.innerText = currentSlide + 1;
}

function nextProjectSlide() {
  showSlide(currentSlide + 1);
}

function prevProjectSlide() {
  showSlide(currentSlide - 1);
}

function goToProjectSlide(index) {
  showSlide(index);
}

// Auto play slide every 5 seconds if multiple
@if($allImages->count() > 1)
  let slideTimer = setInterval(nextProjectSlide, 5000);
  const sliderElem = document.getElementById('project-slider-track');
  if (sliderElem) {
    sliderElem.addEventListener('mouseenter', () => clearInterval(slideTimer));
    sliderElem.addEventListener('mouseleave', () => {
      clearInterval(slideTimer);
      slideTimer = setInterval(nextProjectSlide, 5000);
    });
  }
@endif
</script>
@endsection

