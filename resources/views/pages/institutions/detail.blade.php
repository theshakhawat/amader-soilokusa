@extends('layouts.website.website-layout')

@section('title', $institution->name . ' — ' . $category->name . ' | আগামীর শৈলকুপা')

@push('styles')
<style>
  /* Full-width Slider */
  .slider-wrapper { position: relative; overflow: hidden; border-radius: 1.25rem; width: 100%; }
  .slider-track { display: flex; transition: transform 0.6s cubic-bezier(.4,0,.2,1); width: 100%; }
  .slider-slide { flex-shrink: 0; width: 100%; height: 320px; }
  @media (min-width: 640px) { .slider-slide { height: 420px; } }
  @media (min-width: 1024px) { .slider-slide { height: 500px; } }
  .slider-slide img { width: 100%; height: 100%; object-fit: cover; }
  .slider-btn { position: absolute; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.92); border: none; border-radius: 50%; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 14px rgba(0,0,0,.15); z-index: 10; transition: all .2s; }
  .slider-btn:hover { background: #fff; transform: translateY(-50%) scale(1.06); }
  .slider-dots { display: flex; gap: 8px; justify-content: center; margin-top: 14px; }
  .slider-dot { width: 10px; height: 10px; border-radius: 50%; background: #d1d5db; cursor: pointer; transition: all .25s; }
  .slider-dot.active { background: #0b4622; width: 28px; border-radius: 6px; }

  /* Table styling matching Bangladesh National Portal / BRTC reference */
  .member-table th { background-color: #f8fafc; font-weight: 600; color: #475569; }
  .member-table td, .member-table th { border: 1px solid #e2e8f0; padding: 7px 12px; }

  /* Quill content styling */
  .institution-description h1,.institution-description h2,.institution-description h3 { font-weight: 700; color: #111827; margin: 1.25rem 0 .5rem; }
  .institution-description h1 { font-size: 1.6rem; }
  .institution-description h2 { font-size: 1.3rem; }
  .institution-description h3 { font-size: 1.15rem; }
  .institution-description p { margin: .6rem 0; line-height: 1.8; color: #374151; font-size: 0.95rem; }
  .institution-description ul,.institution-description ol { padding-left: 1.75rem; margin: .6rem 0; }
  .institution-description li { margin: .3rem 0; color: #374151; }
  .institution-description blockquote { border-left: 4px solid #0b4622; background: #f0fdf4; padding: 1rem 1.25rem; margin: 1.25rem 0; border-radius: 0 .5rem .5rem 0; font-style: italic; color: #166534; }
  .institution-description strong { color: #111827; font-weight: 700; }
  .institution-description a { color: #0b4622; text-decoration: underline; font-weight: 600; }
</style>
@endpush

@php
  function toBnNum($number) {
      $bn = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
      return str_replace(range(0, 9), $bn, (string)$number);
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
    <a href="{{ route('institutions.home') }}" class="hover:text-[#0b4622] transition">প্রতিষ্ঠান সমূহ</a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <a href="{{ route('institutions.by-category', $category->slug) }}" class="hover:text-[#0b4622] transition">{{ $category->name }}</a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <span class="text-[#0b4622] font-semibold">{{ $institution->name }}</span>
  </nav>

  {{-- 1. FULL WIDTH BANNER / IMAGE SLIDER --}}
  <div class="w-full">
    @if($institution->images->count() > 0)
      <div class="slider-wrapper bg-gray-100 shadow-md">
        <div class="slider-track" id="sliderTrack">
          @foreach($institution->images as $img)
            <div class="slider-slide">
              <img src="{{ $img->url }}" alt="{{ $institution->name }}">
            </div>
          @endforeach
        </div>
        @if($institution->images->count() > 1)
          <button class="slider-btn left-4" onclick="slideMove(-1)" aria-label="Previous Slide">
            <i class="ri-arrow-left-s-line text-2xl text-gray-800"></i>
          </button>
          <button class="slider-btn right-4" onclick="slideMove(1)" aria-label="Next Slide">
            <i class="ri-arrow-right-s-line text-2xl text-gray-800"></i>
          </button>
        @endif
      </div>
      @if($institution->images->count() > 1)
        <div class="slider-dots" id="sliderDots">
          @foreach($institution->images as $i => $img)
            <div class="slider-dot {{ $i === 0 ? 'active' : '' }}" onclick="goToSlide({{ $i }})"></div>
          @endforeach
        </div>
      @endif
    @else
      <div class="w-full h-56 sm:h-72 lg:h-80 bg-gradient-to-br from-[#0b4622]/15 via-[#0b4622]/10 to-emerald-50 rounded-2xl flex flex-col items-center justify-center border border-gray-100">
        <i class="ri-building-2-line text-7xl text-[#0b4622]/30 mb-2"></i>
        <span class="text-sm font-semibold text-gray-400">{{ $institution->name }}</span>
      </div>
    @endif
  </div>

  {{-- 2. INSTITUTION TITLE, LOCATION & CATEGORY HEADER --}}
  <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 sm:p-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <div class="flex flex-wrap items-center gap-2 mb-2">
          <span class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-50 text-[#0b4622] text-xs font-bold rounded-full border border-emerald-200">
            <i class="ri-price-tag-3-line"></i> {{ $category->name }}
          </span>
          @if($institution->location)
            <span class="inline-flex items-center gap-1 px-3 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded-full border border-gray-200">
              <i class="ri-map-pin-2-line text-[#0b4622]"></i> {{ $institution->location }}
            </span>
          @endif
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-gray-900 tracking-tight leading-tight">
          {{ $institution->name }}
        </h1>
        @if($institution->location)
          <p class="text-xs sm:text-sm text-gray-500 mt-1.5 flex items-center gap-1.5">
            <i class="ri-map-pin-line text-red-500 text-base"></i>
            <span><strong>অবস্থান / ঠিকানা:</strong> {{ $institution->location }}</span>
          </p>
        @endif
      </div>
      <div class="flex items-center gap-2 shrink-0 self-start md:self-center">
        <a href="{{ route('institutions.by-category', $category->slug) }}"
           class="inline-flex items-center gap-1.5 px-4 py-2 border border-gray-300 rounded-xl text-xs font-bold text-gray-700 bg-white hover:bg-gray-50 transition shadow-2xs">
          <i class="ri-arrow-left-line"></i> সকল {{ $category->name }}
        </a>
      </div>
    </div>
  </div>

  {{-- 3. MEMBERS SECTION (JUST TABLE: PHOTO, NAME, DESIGNATION, QUALIFICATION, PHONE, EMAIL) --}}
  <div class="space-y-4">
    <div class="flex items-center justify-between">
      <h2 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
        <i class="ri-team-line text-[#0b4622]"></i>
        <span>প্রতিষ্ঠানের ব্যক্তিবর্গ</span>
        <span class="text-xs font-bold bg-[#0b4622]/10 text-[#0b4622] px-2.5 py-0.5 rounded-full ml-1">
          {{ toBnNum($institution->members->count()) }} জন
        </span>
      </h2>
    </div>

    @if($institution->members->count() > 0)
      @php
        $hasQualification = $institution->members->contains(fn($m) => !empty(trim((string)$m->qualification)));
        $hasPhone = $institution->members->contains(fn($m) => !empty(trim((string)$m->phone)));
        $hasEmail = $institution->members->contains(fn($m) => !empty(trim((string)$m->email)));
      @endphp

      {{-- Desktop View (Full Wide Table) --}}
      <div class="hidden md:block bg-white rounded-2xl border border-gray-300 overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse text-xs sm:text-sm">
            <thead class="bg-gray-50 border-b border-gray-300 text-gray-700 text-xs font-bold uppercase tracking-wider">
              <tr>
                <th class="px-4 py-3 text-center w-12 border-r border-gray-200">ক্র.</th>
                <th class="px-3 py-3 w-36 border-r border-gray-200 text-center">ছবি</th>
                <th class="px-4 py-3 border-r border-gray-200">নাম</th>
                <th class="px-4 py-3 border-r border-gray-200">পদবি</th>
                @if($hasQualification)
                  <th class="px-4 py-3 border-r border-gray-200">শিক্ষাগত যোগ্যতা</th>
                @endif
                @if($hasPhone)
                  <th class="px-4 py-3 border-r border-gray-200">ফোন / মোবাইল</th>
                @endif
                @if($hasEmail)
                  <th class="px-4 py-3">ইমেইল</th>
                @endif
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              @foreach($institution->members as $idx => $member)
                <tr class="hover:bg-emerald-50/30 transition align-middle">
                  {{-- SL --}}
                  <td class="px-4 py-3 text-center font-bold text-gray-600 border-r border-gray-200 align-middle">
                    {{ toBnNum($idx + 1) }}
                  </td>
                  {{-- Photo --}}
                  <td class="px-3 py-3 border-r border-gray-200 text-center align-middle">
                    <img src="{{ $member->photo_url }}"
                         alt="{{ $member->name }}"
                         class="w-24 h-32 md:w-28 md:h-36 object-cover rounded-xl border border-gray-300 mx-auto shadow-2xs">
                  </td>
                  {{-- Name --}}
                  <td class="px-4 py-3 font-bold text-gray-900 border-r border-gray-200 whitespace-nowrap align-middle">
                    {{ $member->name }}
                  </td>
                  {{-- Designation --}}
                  <td class="px-4 py-3 font-semibold text-[#0b4622] border-r border-gray-200 whitespace-nowrap align-middle">
                    {{ $member->designation }}
                  </td>
                  {{-- Qualification --}}
                  @if($hasQualification)
                    <td class="px-4 py-3 text-gray-700 border-r border-gray-200 align-middle">
                      {{ $member->qualification ?: '—' }}
                    </td>
                  @endif
                  {{-- Phone --}}
                  @if($hasPhone)
                    <td class="px-4 py-3 text-gray-700 border-r border-gray-200 whitespace-nowrap align-middle">
                      @if($member->phone)
                        <a href="tel:{{ $member->phone }}" class="text-[#0b4622] hover:underline font-semibold">
                          {{ $member->phone }}
                        </a>
                      @else
                        <span class="text-gray-400">—</span>
                      @endif
                    </td>
                  @endif
                  {{-- Email --}}
                  @if($hasEmail)
                    <td class="px-4 py-3 text-gray-700 whitespace-nowrap align-middle">
                      @if($member->email)
                        <a href="mailto:{{ $member->email }}" class="text-blue-600 hover:underline">
                          {{ $member->email }}
                        </a>
                      @else
                        <span class="text-gray-400">—</span>
                      @endif
                    </td>
                  @endif
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      {{-- Mobile View (Responsive 2-Column Attribute Table per Member with Colspan 2 Image) --}}
      <div class="block md:hidden space-y-4">
        @foreach($institution->members as $idx => $member)
          <div class="border border-gray-300 rounded-xl overflow-hidden bg-white shadow-2xs">
            <table class="w-full text-xs sm:text-sm border-collapse">
              <tbody>
                {{-- Row 1: Image centered across 2 columns --}}
                <tr class="bg-gray-50 border-b border-gray-200">
                  <td colspan="2" class="p-5 text-center">
                    <img src="{{ $member->photo_url }}"
                         alt="{{ $member->name }}"
                         class="w-32 h-40 sm:w-36 sm:h-44 object-cover rounded-xl border border-gray-300 shadow-xs mx-auto">
                  </td>
                </tr>

                {{-- Name --}}
                <tr class="border-b border-gray-200">
                  <th class="w-28 sm:w-32 bg-gray-50/80 px-3.5 py-2.5 text-left font-semibold text-gray-700 border-r border-gray-200">নাম</th>
                  <td class="px-3.5 py-2.5 font-bold text-gray-900">{{ $member->name }}</td>
                </tr>

                {{-- Designation --}}
                <tr class="border-b border-gray-200">
                  <th class="bg-gray-50/80 px-3.5 py-2.5 text-left font-semibold text-gray-700 border-r border-gray-200">পদবি</th>
                  <td class="px-3.5 py-2.5 font-semibold text-[#0b4622]">{{ $member->designation }}</td>
                </tr>

                {{-- Qualification (if present) --}}
                @if(!empty(trim((string)$member->qualification)))
                  <tr class="border-b border-gray-200">
                    <th class="bg-gray-50/80 px-3.5 py-2.5 text-left font-semibold text-gray-700 border-r border-gray-200">শিক্ষাগত যোগ্যতা</th>
                    <td class="px-3.5 py-2.5 text-gray-700">{{ $member->qualification }}</td>
                  </tr>
                @endif

                {{-- Phone / Mobile (if present) --}}
                @if(!empty(trim((string)$member->phone)))
                  <tr class="border-b border-gray-200">
                    <th class="bg-gray-50/80 px-3.5 py-2.5 text-left font-semibold text-gray-700 border-r border-gray-200">ফোন / মোবাইল</th>
                    <td class="px-3.5 py-2.5 text-gray-700">
                      <a href="tel:{{ $member->phone }}" class="text-[#0b4622] font-semibold hover:underline">
                        {{ $member->phone }}
                      </a>
                    </td>
                  </tr>
                @endif

                {{-- Email (if present) --}}
                @if(!empty(trim((string)$member->email)))
                  <tr>
                    <th class="bg-gray-50/80 px-3.5 py-2.5 text-left font-semibold text-gray-700 border-r border-gray-200">ইমেইল</th>
                    <td class="px-3.5 py-2.5 text-gray-700">
                      <a href="mailto:{{ $member->email }}" class="text-blue-600 hover:underline break-all">
                        {{ $member->email }}
                      </a>
                    </td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
        @endforeach
      </div>
    @else
      <div class="bg-white rounded-2xl border border-gray-200 p-8 text-center text-gray-400">
        <i class="ri-user-search-line text-4xl block mb-2 text-gray-300"></i>
        <p class="text-sm font-semibold">কোনো কর্মকর্তার তথ্য যুক্ত করা হয়নি।</p>
      </div>
    @endif
  </div>

  {{-- 4. INSTITUTION DESCRIPTION (AT THE BOTTOM AS REQUESTED) --}}
  @if($institution->description && strip_tags($institution->description) !== '')
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 sm:p-8 space-y-4">
      <h2 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2 pb-3 border-b border-gray-100">
        <i class="ri-article-line text-[#0b4622]"></i>
        <span>প্রতিষ্ঠানের বিবরণ</span>
      </h2>
      <div class="institution-description prose max-w-none text-gray-700">
        {!! $institution->description !!}
      </div>
    </div>
  @endif

</div>
@endsection

@push('scripts')
<script>
  let currentSlide = 0;
  const totalSlides = {{ $institution->images->count() }};

  function goToSlide(index) {
    if (totalSlides <= 0) return;
    currentSlide = Math.max(0, Math.min(index, totalSlides - 1));
    const track = document.getElementById('sliderTrack');
    if (track) {
      track.style.transform = `translateX(-${currentSlide * 100}%)`;
    }
    document.querySelectorAll('.slider-dot').forEach((d, i) => {
      d.classList.toggle('active', i === currentSlide);
    });
  }

  function slideMove(dir) {
    if (totalSlides <= 1) return;
    goToSlide((currentSlide + dir + totalSlides) % totalSlides);
  }

  // Auto slide every 5 seconds
  @if($institution->images->count() > 1)
    setInterval(() => slideMove(1), 5000);
  @endif
</script>
@endpush
