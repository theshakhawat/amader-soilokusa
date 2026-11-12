@extends('layouts.website.website-layout')

@section('title', $notice->title . ' — নোটিশ বোর্ড | আগামীর শৈলকুপা')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
  
  <!-- Breadcrumb -->
  <nav class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 mb-6 bg-white px-4 py-2.5 rounded-xl border border-gray-100 shadow-2xs">
    <a href="{{ route('home') }}" class="hover:text-[#0b4622] flex items-center gap-1 transition">
      <i class="ri-home-4-line"></i>
      <span>হোম</span>
    </a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <a href="{{ route('notices.index') }}" class="hover:text-[#0b4622] transition">নোটিশ বোর্ড</a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <span class="text-[#0b4622] font-semibold truncate">{{ $notice->title }}</span>
  </nav>

  <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    
    <!-- Main Content Left (8 Cols) -->
    <div class="lg:col-span-8 bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden p-6 sm:p-8 space-y-6">
      
      <!-- Notice Header -->
      <div class="space-y-3 border-b border-gray-100 pb-5">
        <div class="flex flex-wrap items-center gap-2">
          @if($notice->status === 'pinned')
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-[#c8102e] border border-red-200">
              <i class="ri-pushpin-fill"></i>
              জরুরি বিজ্ঞপ্তি
            </span>
          @else
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-[#0b4622] border border-emerald-200">
              অফিসিয়াল নোটিশ
            </span>
          @endif

          @if($notice->date)
            <span class="inline-flex items-center gap-1 text-xs text-gray-500 bg-gray-50 px-3 py-1 rounded-full border border-gray-100">
              <i class="ri-calendar-line text-[#c8102e]"></i>
              প্রকাশের তারিখ: {{ $notice->bangla_formatted_date }}
            </span>
          @endif
        </div>

        <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight leading-snug">
          {{ $notice->title }}
        </h1>
      </div>

      <!-- Description / Body -->
      <div class="rich-text-content prose max-w-none text-gray-700 leading-relaxed text-sm sm:text-[15.5px]">
        @if(!empty($notice->description))
          {!! $notice->description !!}
        @else
          <p class="text-gray-500 italic">এই নোটিশের কোনো অতিরিক্ত বিবরণ নেই।</p>
        @endif
      </div>

      <!-- Attached Files / Documents Section -->
      @if($notice->files->count() > 0)
        <div class="space-y-3 pt-6 border-t border-gray-100">
          <h2 class="text-base sm:text-lg font-bold text-[#0b4622] flex items-center gap-2">
            <i class="ri-attachment-line text-[#c8102e]"></i>
            <span>সংযুক্ত ফাইল ও ডকুমেন্ট ({{ $notice->files->count() }}টি)</span>
          </h2>

          <div class="space-y-2.5">
            @foreach($notice->files as $file)
              <div class="flex items-center justify-between p-3.5 bg-gray-50/80 hover:bg-emerald-50/40 border border-gray-200/80 rounded-xl transition">
                <div class="flex items-center gap-3 min-w-0">
                  <div class="w-10 h-10 rounded-lg bg-red-50 text-[#c8102e] flex items-center justify-center shrink-0">
                    <i class="ri-file-text-line text-lg"></i>
                  </div>
                  <div class="min-w-0">
                    <h4 class="text-xs sm:text-sm font-bold text-gray-800 truncate">{{ $file->file_name ?? 'ডকুমেন্ট ফাইল' }}</h4>
                    <span class="text-[11px] text-gray-400 uppercase font-semibold">
                      {{ $file->file_type ?? 'FILE' }} • {{ $file->readable_size }}
                    </span>
                  </div>
                </div>

                <a
                  href="{{ $file->file_url }}"
                  target="_blank"
                  download
                  class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-lg shadow-2xs transition shrink-0"
                >
                  <i class="ri-download-2-line"></i>
                  <span>ডাউনলোড</span>
                </a>
              </div>
            @endforeach
          </div>
        </div>
      @endif

      <!-- Navigation & Action Buttons -->
      <div class="pt-6 border-t border-gray-100 flex flex-wrap items-center justify-between gap-3">
        <a
          href="{{ route('home') }}#notice-section"
          class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-bold rounded-xl transition cursor-pointer"
        >
          <i class="ri-arrow-left-line"></i>
          <span>হোমপেজে ফিরে যান</span>
        </a>

        <a
          href="{{ route('notices.index') }}"
          class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs sm:text-sm font-bold rounded-xl shadow-sm transition cursor-pointer"
        >
          <i class="ri-list-check-2"></i>
          <span>সকল নোটিশ দেখুন</span>
        </a>
      </div>

    </div>

    <!-- Right Sidebar (4 Cols) -->
    <div class="lg:col-span-4 space-y-6">
      
      <!-- Recent Notices List -->
      <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-5 sm:p-6 space-y-4">
        <h3 class="text-base font-extrabold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
          <i class="ri-history-line text-[#c8102e]"></i>
          <span>সাম্প্রতিক অন্যান্য নোটিশ</span>
        </h3>

        <div class="divide-y divide-gray-100">
          @forelse($recentNotices as $otherNotice)
            <a
              href="{{ route('notices.details', $otherNotice->id) }}"
              class="py-3 first:pt-1 last:pb-1 flex items-start gap-3 group transition"
            >
              <div class="w-8 h-8 rounded-lg bg-red-50 text-[#c8102e] flex items-center justify-center shrink-0 mt-0.5 group-hover:bg-[#c8102e] group-hover:text-white transition">
                <i class="ri-file-text-line text-sm"></i>
              </div>
              <div class="min-w-0 flex-1">
                <h4 class="text-xs sm:text-sm font-bold text-gray-800 group-hover:text-[#0b4622] truncate transition">
                  {{ $otherNotice->title }}
                </h4>
                <p class="text-[11px] text-gray-500 mt-0.5">
                  {{ $otherNotice->bangla_formatted_date }}
                </p>
              </div>
            </a>
          @empty
            <p class="text-xs text-gray-400 py-2">অন্য কোনো নোটিশ পাওয়া যায়নি।</p>
          @endforelse
        </div>
      </div>

      <!-- Notice Board Helpline Card -->
      <div class="bg-gradient-to-br from-[#0b4622] to-[#08351a] rounded-2xl p-6 text-white space-y-3 shadow-sm">
        <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-lg text-white">
          <i class="ri-question-line"></i>
        </div>
        <h4 class="text-base font-extrabold">কোনো জিজ্ঞাসা আছে?</h4>
        <p class="text-xs text-white/80 leading-relaxed">
          যেকোনো নোটিশ বা বিজ্ঞপ্তি সম্পর্কে অতিরিক্ত তথ্যের জন্য অফিসিয়াল যোগাযোগ পেইজে গিয়ে আমাদের সাথে যোগাযোগ করুন।
        </p>
        <a
          href="{{ route('home') }}#contact-section"
          class="inline-flex items-center gap-2 px-4 py-2 bg-white text-[#0b4622] hover:bg-gray-100 text-xs font-bold rounded-xl transition"
        >
          <span>যোগাযোগ পাতা</span>
          <i class="ri-arrow-right-line"></i>
        </a>
      </div>

    </div>

  </div>

</div>
@endsection

