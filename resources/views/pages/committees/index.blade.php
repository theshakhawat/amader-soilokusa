@extends('layouts.website.website-layout')

@section('title', 'আমাদের সকল কমিটি সমূহ — আগামীর শৈলকুপা')

@php
  if (!function_exists('toBnNum')) {
      function toBnNum($number) {
          $bn = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
          return str_replace(range(0, 9), $bn, (string)$number);
      }
  }
@endphp

@section('content')
<main class="min-h-screen bg-gray-50/50 py-6 sm:py-10">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs font-semibold text-gray-500 bg-white px-4 py-2.5 rounded-xl border border-gray-200/80 shadow-2xs">
      <a href="{{ route('home') }}" class="hover:text-[#0b4622] flex items-center gap-1 transition">
        <i class="ri-home-4-line text-sm"></i>
        <span>হোম</span>
      </a>
      <i class="ri-arrow-right-s-line text-gray-400"></i>
      <span class="text-[#0b4622] font-bold">কমিটি সমূহ</span>
    </nav>

    {{-- Header Banner --}}
    <div class="bg-gradient-to-r from-[#0b4622] via-[#0d592b] to-[#08351a] rounded-3xl p-6 sm:p-10 text-white shadow-xl relative overflow-hidden">
      <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
      <div class="relative z-10 max-w-3xl space-y-3">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-emerald-200 text-xs font-bold tracking-wide">
          <i class="ri-team-line text-sm"></i>
          <span>আগামীর শৈলকুপা পরিচালনা পরিষদ</span>
        </div>
        <h1 class="text-2xl sm:text-4xl font-black tracking-tight text-white">
          আমাদের কমিটি সমূহ
        </h1>
        <p class="text-xs sm:text-sm text-emerald-100/90 leading-relaxed">
          আগামীর শৈলকুপার সার্বিক কল্যাণ, সামাজিক উন্নয়ন, শিক্ষা, স্বাস্থ্য ও কৃষি খাতের কার্যক্রম সুষ্ঠুভাবে পরিচালনার জন্য গঠিত বিভিন্ন পরিষদ ও উপকমিটিসমূহ।
        </p>

        {{-- Top Badges --}}
        <div class="flex flex-wrap items-center gap-2.5 pt-2 text-xs font-bold text-white">
          <span class="px-3 py-1 rounded-lg bg-white/15 backdrop-blur-xs flex items-center gap-1.5">
            <i class="ri-community-line text-emerald-300"></i> {{ toBnNum($committees->count()) }}টি সক্রিয় কমিটি
          </span>
          <span class="px-3 py-1 rounded-lg bg-white/15 backdrop-blur-xs flex items-center gap-1.5">
            <i class="ri-user-star-line text-emerald-300"></i> দক্ষ ও নিবেদিত নেতৃত্ব
          </span>
          <span class="px-3 py-1 rounded-lg bg-white/15 backdrop-blur-xs flex items-center gap-1.5">
            <i class="ri-shake-hands-line text-emerald-300"></i> শৈলকুপার উন্নয়ন প্রয়াস
          </span>
        </div>
      </div>
    </div>

    {{-- Committees Grid --}}
    @if($committees->isEmpty())
      <div class="text-center py-20 bg-white rounded-3xl border border-gray-200/80 shadow-2xs space-y-3">
        <div class="w-16 h-16 rounded-full bg-emerald-50 text-[#0b4622] flex items-center justify-center mx-auto text-3xl">
          <i class="ri-team-line"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-800">এখনো কোনো সক্রিয় কমিটি পাওয়া যায়নি</h3>
        <p class="text-xs sm:text-sm text-gray-500">অ্যাডমিন প্যানেল থেকে কমিটি যুক্ত ও সক্রিয় করা হলে এখানে প্রদর্শিত হবে।</p>
      </div>
    @else
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        @foreach($committees as $comm)
          @php
            $pres = $comm->members->first(function ($m) {
                return $m->order == 1;
            }) ?? $comm->members->first(function ($m) {
                return str_contains($m->title, 'সভাপতি') || str_contains($m->title, 'আহ্বায়ক');
            }) ?? $comm->members->first();
          @endphp

          <a href="{{ route('committee.show', $comm->slug ?: $comm->id) }}"
             class="group bg-white rounded-2xl border border-gray-200/90 shadow-2xs hover:shadow-xl hover:border-emerald-400 transition-all duration-300 flex flex-col overflow-hidden">

            {{-- Card Image / Header --}}
            <div class="relative aspect-16/9 bg-gradient-to-br from-emerald-950 to-gray-900 overflow-hidden">
              <img src="{{ $comm->image_url }}"
                   alt="{{ $comm->name }}"
                   class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
              <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/35 to-transparent"></div>

              {{-- Badges --}}
              <div class="absolute top-3 left-3 right-3 flex items-center justify-between gap-2">
                @if($comm->session_duration)
                  <span class="px-2.5 py-1 rounded-lg bg-[#0b4622]/90 backdrop-blur-xs text-white text-[11px] font-bold shadow-xs flex items-center gap-1">
                    <i class="ri-calendar-line"></i>
                    <span>{{ $comm->session_duration }}</span>
                  </span>
                @else
                  <span></span>
                @endif

                <span class="px-2.5 py-1 rounded-lg bg-white/95 backdrop-blur-xs text-gray-800 text-[11px] font-bold shadow-xs flex items-center gap-1">
                  <i class="ri-team-line text-[#0b4622]"></i>
                  <span>{{ toBnNum($comm->members_count) }} জন সদস্য</span>
                </span>
              </div>

              {{-- Title over image --}}
              <div class="absolute bottom-3 left-3 right-3 text-white">
                <h3 class="text-lg sm:text-xl font-black tracking-tight drop-shadow-md group-hover:text-emerald-300 transition-colors">
                  {{ $comm->name }}
                </h3>
              </div>
            </div>

            {{-- Card Body --}}
            <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between space-y-4">
              <div class="space-y-2.5">
                @if($comm->subtitle)
                  <p class="text-xs font-bold text-[#0b4622] flex items-center gap-1 line-clamp-1">
                    <i class="ri-information-line shrink-0"></i>
                    <span>{{ $comm->subtitle }}</span>
                  </p>
                @endif

                @if($comm->description)
                  <p class="text-xs text-gray-600 line-clamp-2 leading-relaxed">
                    {{ strip_tags($comm->description) }}
                  </p>
                @endif

                {{-- President / Leadership Snippet --}}
                @if($pres)
                  <div class="mt-3 pt-3 border-t border-gray-100 flex items-center gap-3 bg-gray-50/70 p-2.5 rounded-xl border border-gray-100">
                    <div class="w-10 h-10 rounded-full overflow-hidden bg-white border border-emerald-200 shrink-0 shadow-2xs">
                      @if($pres->photo)
                        <img src="{{ $pres->photo_url }}" alt="{{ $pres->name }}" class="w-full h-full object-cover">
                      @else
                        <div class="w-full h-full flex items-center justify-center bg-emerald-50 text-[#0b4622] font-black text-sm">
                          {{ mb_substr($pres->name, 0, 1) }}
                        </div>
                      @endif
                    </div>
                    <div class="min-w-0 flex-1">
                      <span class="text-[10px] text-gray-500 font-bold block truncate">
                        {{ $pres->title }}
                      </span>
                      <h4 class="text-xs font-black text-gray-900 truncate">
                        {{ $pres->name }}
                      </h4>
                    </div>
                  </div>
                @endif
              </div>

              {{-- Button CTA --}}
              <div class="pt-3 border-t border-gray-100 flex items-center justify-between text-xs font-bold text-[#0b4622]">
                <span class="group-hover:translate-x-0.5 transition-transform">কমিটি বিস্তারিত ও সদস্যবৃন্দ</span>
                <span class="w-7 h-7 rounded-lg bg-emerald-50 group-hover:bg-[#0b4622] group-hover:text-white transition flex items-center justify-center">
                  <i class="ri-arrow-right-line"></i>
                </span>
              </div>
            </div>

          </a>
        @endforeach
      </div>
    @endif

  </div>
</main>
@endsection

