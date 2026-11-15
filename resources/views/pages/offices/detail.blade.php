@extends('layouts.website.website-layout')

@section('title', $office->name . ' — শৈলকূপা প্রশাসন | আগামীর শৈলকুপা')

@push('styles')
<style>
  /* Quill content styling */
  .office-description h1,.office-description h2,.office-description h3 { font-weight: 700; color: #111827; margin: 1.25rem 0 .5rem; }
  .office-description h1 { font-size: 1.6rem; }
  .office-description h2 { font-size: 1.3rem; }
  .office-description h3 { font-size: 1.15rem; }
  .office-description p { margin: .6rem 0; line-height: 1.8; color: #374151; font-size: 0.95rem; }
  .office-description ul,.office-description ol { padding-left: 1.75rem; margin: .6rem 0; }
  .office-description li { margin: .3rem 0; color: #374151; }
  .office-description blockquote { border-left: 4px solid #0b4622; background: #f0fdf4; padding: 1rem 1.25rem; margin: 1.25rem 0; border-radius: 0 .5rem .5rem 0; font-style: italic; color: #166534; }
  .office-description strong { color: #111827; font-weight: 700; }
  .office-description a { color: #0b4622; text-decoration: underline; font-weight: 600; }
</style>
@endpush

@php
  function toBnOfcNum($number) {
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
    <a href="{{ route('offices.index') }}" class="hover:text-[#0b4622] transition">অফিস সমূহ</a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <span class="text-[#0b4622] font-semibold">{{ $office->name }}</span>
  </nav>

  {{-- 1. FULL WIDTH OFFICE IMAGE BANNER --}}
  <div class="w-full">
    <div class="w-full h-64 sm:h-80 lg:h-[440px] rounded-2xl overflow-hidden shadow-md bg-gray-100 border border-gray-200">
      <img src="{{ $office->image_url }}" alt="{{ $office->name }}" class="w-full h-full object-cover">
    </div>
  </div>

  {{-- 2. OFFICE TITLE & LOCATION HEADER --}}
  <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 sm:p-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <div class="flex flex-wrap items-center gap-2 mb-2">
          <span class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-50 text-[#0b4622] text-xs font-bold rounded-full border border-emerald-200">
            <i class="ri-government-line"></i> সরকারি ও প্রশাসনিক দপ্তর
          </span>
          @if($office->location)
            <span class="inline-flex items-center gap-1 px-3 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded-full border border-gray-200">
              <i class="ri-map-pin-2-line text-[#0b4622]"></i> {{ $office->location }}
            </span>
          @endif
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-gray-900 tracking-tight leading-tight">
          {{ $office->name }}
        </h1>
        @if($office->location)
          <p class="text-xs sm:text-sm text-gray-500 mt-1.5 flex items-center gap-1.5">
            <i class="ri-map-pin-line text-red-500 text-base"></i>
            <span><strong>অবস্থান / ঠিকানা:</strong> {{ $office->location }}</span>
          </p>
        @endif
      </div>
      <div class="flex items-center gap-2 shrink-0 self-start md:self-center">
        <a href="{{ route('offices.index') }}"
           class="inline-flex items-center gap-1.5 px-4 py-2 border border-gray-300 rounded-xl text-xs font-bold text-gray-700 bg-white hover:bg-gray-50 transition shadow-2xs">
          <i class="ri-arrow-left-line"></i> সকল অফিস
        </a>
      </div>
    </div>
  </div>

  {{-- 3. MEMBERS / OFFICERS SECTION (CLEAN TABLE FORMAT) --}}
  <div class="space-y-4">
    <div class="flex items-center justify-between">
      <h2 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
        <i class="ri-team-line text-[#0b4622]"></i>
        <span>অফিসের দায়িত্বপ্রাপ্ত ব্যক্তিবর্গ ও কর্মকর্তাবৃন্দ</span>
        <span class="text-xs font-bold bg-[#0b4622]/10 text-[#0b4622] px-2.5 py-0.5 rounded-full ml-1">
          {{ toBnOfcNum($office->members->count()) }} জন
        </span>
      </h2>
    </div>

    @if($office->members->count() > 0)
      @php
        $hasQualification = $office->members->contains(fn($m) => !empty(trim((string)$m->qualification)));
        $hasPhone = $office->members->contains(fn($m) => !empty(trim((string)$m->phone)));
        $hasEmail = $office->members->contains(fn($m) => !empty(trim((string)$m->email)));
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
              @foreach($office->members as $idx => $member)
                <tr class="hover:bg-emerald-50/30 transition align-middle">
                  {{-- SL --}}
                  <td class="px-4 py-3 text-center font-bold text-gray-600 border-r border-gray-200 align-middle">
                    {{ toBnOfcNum($idx + 1) }}
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
        @foreach($office->members as $idx => $member)
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

  {{-- 4. OFFICE DESCRIPTION --}}
  @if($office->description && strip_tags($office->description) !== '')
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 sm:p-8 space-y-4">
      <h2 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2 pb-3 border-b border-gray-100">
        <i class="ri-article-line text-[#0b4622]"></i>
        <span>অফিসের বিবরণ ও সিটিজেন চার্টার</span>
      </h2>
      <div class="office-description prose max-w-none text-gray-700">
        {!! $office->description !!}
      </div>
    </div>
  @endif

</div>
@endsection

