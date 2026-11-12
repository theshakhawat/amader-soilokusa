@extends('layouts.website.website-layout')

@section('title', 'কমিটি তালিকা - আগামীর শৈলকুপা')

@section('content')
<main class="py-8 sm:py-12 bg-gray-50/50 min-h-screen">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Page Header & Active Committee Banner -->
    <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-14">
      <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-50 text-[#0b4622] text-xs sm:text-sm font-extrabold mb-3 border border-emerald-100 shadow-2xs">
        <i class="ri-team-line text-base"></i>
        <span>{{ $activeCommittee ? $activeCommittee->session_duration : '২০২৬-২০২৮' }} সেশন</span>
      </div>

      <h1 class="text-2xl sm:text-4xl font-black text-gray-900 tracking-tight">
        {{ $activeCommittee ? $activeCommittee->name : 'কার্যনির্বাহী কমিটি' }}
        <span class="text-[#c8102e]">({{ $activeCommittee ? $activeCommittee->session_duration : '২০২৬-২০২৮' }})</span>
      </h1>

      <p class="text-xs sm:text-base text-gray-600 mt-2 font-medium">
        {{ $activeCommittee && $activeCommittee->subtitle ? $activeCommittee->subtitle : 'আগামীর শৈলকুপা কেন্দ্রীয় কার্যনির্বাহী পরিষদ' }}
      </p>
    </div>

    <!-- Committee Members Hierarchy Layout -->
    <div class="space-y-8 sm:space-y-12">

      <!-- ==========================================
           ROW 1: সভাপতি (Order = 1) - Single Centered Card
           ========================================== -->
      @if($president)
        <div>
          <div class="text-center mb-4">
            <span class="inline-block text-[11px] font-extrabold uppercase tracking-wider text-gray-400 border-b-2 border-emerald-600/40 pb-0.5">
              কমিটি প্রধান
            </span>
          </div>

          <div class="flex justify-center">
            <div class="w-full max-w-sm bg-white rounded-2xl p-6 border-2 border-emerald-600/30 shadow-md hover:shadow-xl transition-all duration-300 text-center relative group">
              <!-- Crown / Chief badge -->
              <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-[#0b4622] text-white px-4 py-1 rounded-full text-xs font-black shadow-xs flex items-center gap-1.5">
                <i class="ri-vip-crown-fill text-amber-300 text-sm"></i>
                <span>{{ $president->title }}</span>
              </div>

              <!-- Avatar -->
              <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-full overflow-hidden mx-auto mt-2 border-4 border-emerald-100 shadow-sm group-hover:scale-105 transition-transform duration-300 bg-gray-100">
                <img src="{{ $president->photo_url }}" alt="{{ $president->name }}" class="w-full h-full object-cover" />
              </div>

              <!-- Details -->
              <h2 class="text-lg sm:text-xl font-black text-gray-900 mt-4 group-hover:text-[#0b4622] transition">
                {{ $president->name }}
              </h2>
              <p class="text-xs sm:text-sm font-bold text-[#c8102e] mt-1">
                {{ $president->title }}
              </p>
              <div class="mt-3 pt-3 border-t border-gray-100 text-[11px] font-medium text-gray-500">
                আগামীর শৈলকুপা
              </div>
            </div>
          </div>
        </div>
      @endif


      <!-- ==========================================
           ROW 2: সহ-সভাপতি ও সাধারণ সম্পাদক (Order = 2, 3) - 2 Cards
           ========================================== -->
      @if($secondRowMembers->isNotEmpty())
        <div>
          <div class="text-center mb-4">
            <span class="inline-block text-[11px] font-extrabold uppercase tracking-wider text-gray-400 border-b border-gray-200 pb-0.5">
              কার্যনির্বাহী নেতৃত্ব
            </span>
          </div>

          <div class="flex flex-wrap justify-center gap-5 sm:gap-7 max-w-3xl mx-auto">
            @foreach($secondRowMembers as $m)
              <div class="w-full sm:w-[calc(50%-14px)] bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 text-center group">
                <!-- Avatar -->
                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden mx-auto border-3 border-emerald-50 shadow-2xs group-hover:scale-105 transition-transform duration-300 bg-gray-100">
                  <img src="{{ $m->photo_url }}" alt="{{ $m->name }}" class="w-full h-full object-cover" />
                </div>

                <!-- Details -->
                <h3 class="text-base sm:text-lg font-black text-gray-900 mt-3.5 group-hover:text-[#0b4622] transition">
                  {{ $m->name }}
                </h3>
                <span class="inline-block mt-1 px-3 py-1 rounded-full bg-emerald-50 text-[#0b4622] font-bold text-xs border border-emerald-100">
                  {{ $m->title }}
                </span>
                <p class="text-[11px] text-gray-400 mt-2 font-medium">
                  আগামীর শৈলকুপা
                </p>
              </div>
            @endforeach
          </div>
        </div>
      @endif


      <!-- ==========================================
           ROW 3+: অন্যান্য সদস্যবৃন্দ (Order >= 4) - 4 Cards Per Row
           ========================================== -->
      @if($otherMembers->isNotEmpty())
        <div>
          <div class="text-center mb-6">
            <span class="inline-block text-[11px] font-extrabold uppercase tracking-wider text-gray-400 border-b border-gray-200 pb-0.5">
              সম্পাদকমণ্ডলী ও কার্যকরী সদস্যবৃন্দ
            </span>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($otherMembers as $m)
              <div class="bg-white rounded-2xl p-4 sm:p-5 border border-gray-100 shadow-xs hover:shadow-md transition-all duration-300 text-center flex flex-col items-center group">
                <!-- Avatar -->
                <div class="w-20 h-20 sm:w-22 sm:h-22 rounded-full overflow-hidden border-2 border-gray-100 shadow-2xs group-hover:scale-105 transition-transform duration-300 bg-gray-50">
                  <img src="{{ $m->photo_url }}" alt="{{ $m->name }}" class="w-full h-full object-cover" />
                </div>

                <!-- Name & Title -->
                <h4 class="text-sm sm:text-base font-extrabold text-gray-900 mt-3 group-hover:text-[#0b4622] transition line-clamp-1">
                  {{ $m->name }}
                </h4>
                <p class="text-xs font-bold text-[#c8102e] mt-1 line-clamp-1">
                  {{ $m->title }}
                </p>
                <div class="mt-2 text-[11px] text-gray-400 font-medium">
                  সদস্য
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif

      @if(!$president && $secondRowMembers->isEmpty() && $otherMembers->isEmpty())
        <div class="text-center py-16 bg-white rounded-2xl border border-gray-100 p-8">
          <i class="ri-team-line text-5xl text-gray-300 block mb-3"></i>
          <h3 class="text-lg font-bold text-gray-700">বর্তমানে কোনো সদস্যের তথ্য যুক্ত করা নেই</h3>
          <p class="text-xs sm:text-sm text-gray-500 mt-1">অ্যাডমিন প্যানেল থেকে খুব শীঘ্রই পূর্ণাঙ্গ কমিটি তালিকা প্রকাশ করা হবে।</p>
        </div>
      @endif

    </div>

  </div>
</main>
@endsection

