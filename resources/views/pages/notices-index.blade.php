@extends('layouts.website.website-layout')

@section('title', 'সকল নোটিশ ও বিজ্ঞপ্তি — আগামীর শৈলকুপা')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
  
  <!-- Breadcrumb -->
  <nav class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 mb-6 bg-white px-4 py-2.5 rounded-xl border border-gray-100 shadow-2xs">
    <a href="{{ route('home') }}" class="hover:text-[#0b4622] flex items-center gap-1 transition">
      <i class="ri-home-4-line"></i>
      <span>হোম</span>
    </a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <span class="text-[#0b4622] font-semibold">সকল নোটিশ ও বিজ্ঞপ্তি</span>
  </nav>

  <!-- Page Header Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6 sm:p-8 mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-[#c8102e] border border-red-200 mb-2">
        <i class="ri-megaphone-line"></i>
        অফিসিয়াল নোটিশ বোর্ড
      </span>
      <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
        সকল নোটিশ ও বিজ্ঞপ্তি
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-1">
        আগামীর শৈলকুপা সংগঠনের সকল প্রাতিষ্ঠানিক নোটিশ, জরুরি বিজ্ঞপ্তি ও অফিসিয়াল সার্কুলার আর্কাইভ।
      </p>
    </div>

    <div class="text-xs font-bold text-gray-500 bg-gray-50 px-4 py-2 rounded-xl border border-gray-100">
      মোট নোটিশ: <span class="text-[#0b4622] font-black text-sm">{{ $notices->total() }}</span> টি
    </div>
  </div>

  <!-- Notice Table Container Card -->
  <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-[#f8fafc] border-b border-gray-200 text-xs font-black text-gray-600 uppercase tracking-wider">
            <th class="py-4 px-5 text-center w-16">ক্রম</th>
            <th class="py-4 px-5 min-w-[280px]">নোটিশের শিরোনাম</th>
            <th class="py-4 px-5 text-center whitespace-nowrap">প্রকাশের তারিখ</th>
            <th class="py-4 px-5 text-center whitespace-nowrap">সংযুক্ত ফাইল</th>
            <th class="py-4 px-5 text-right whitespace-nowrap">পদক্ষেপ</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-xs sm:text-sm text-gray-700">
          @forelse($notices as $index => $notice)
            @php
              // Calculate continuous serial number across pages
              $serial = ($notices->currentPage() - 1) * $notices->perPage() + $index + 1;
              $bnDigits = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
              $serialBn = str_replace(range(0, 9), $bnDigits, str_pad($serial, 2, '0', STR_PAD_LEFT));
            @endphp
            <tr class="hover:bg-emerald-50/30 transition group">
              <!-- Serial Number (ক্রম) -->
              <td class="py-4 px-5 text-center font-bold text-gray-400 group-hover:text-[#0b4622]">
                {{ $serialBn }}
              </td>

              <!-- Notice Title -->
              <td class="py-4 px-5">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-lg bg-red-50 text-[#c8102e] flex items-center justify-center shrink-0 group-hover:bg-[#c8102e] group-hover:text-white transition">
                    <i class="ri-file-text-line text-base"></i>
                  </div>
                  <div class="min-w-0">
                    <a
                      href="{{ route('notices.details', $notice->id) }}"
                      class="font-extrabold text-gray-900 group-hover:text-[#0b4622] transition line-clamp-1 text-sm sm:text-[15px]"
                    >
                      {{ $notice->title }}
                    </a>
                    @if($notice->status === 'pinned')
                      <span class="inline-flex items-center gap-1 text-[10px] font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded-full border border-red-200 mt-1">
                        <i class="ri-pushpin-fill"></i> জরুরি নোটিশ
                      </span>
                    @endif
                  </div>
                </div>
              </td>

              <!-- Date (প্রকাশের তারিখ) -->
              <td class="py-4 px-5 text-center whitespace-nowrap font-semibold text-gray-600 text-xs">
                @if($notice->date)
                  <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-50 border border-gray-100">
                    <i class="ri-calendar-line text-[#c8102e]"></i>
                    {{ $notice->bangla_formatted_date }}
                  </span>
                @else
                  <span class="text-gray-400 italic">—</span>
                @endif
              </td>

              <!-- Attached File indicator (ফাইল আছে কিনা) -->
              <td class="py-4 px-5 text-center whitespace-nowrap">
                @if($notice->files->count() > 0)
                  <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                    <i class="ri-attachment-line"></i>
                    {{ $notice->files->count() }}টি ফাইল সংযুক্ত
                  </span>
                @else
                  <span class="inline-flex items-center gap-1 text-gray-400 text-xs">
                    <i class="ri-close-circle-line"></i> নেই
                  </span>
                @endif
              </td>

              <!-- Hyperlink: বিস্তারিত -->
              <td class="py-4 px-5 text-right whitespace-nowrap">
                <a
                  href="{{ route('notices.details', $notice->id) }}"
                  class="inline-flex items-center gap-1 px-4 py-1.5 rounded-lg text-xs font-bold text-white bg-[#0b4622] hover:bg-[#08351a] shadow-2xs hover:shadow transition"
                >
                  <span>বিস্তারিত</span>
                  <i class="ri-arrow-right-line"></i>
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="py-16 text-center text-gray-400">
                <i class="ri-inbox-line text-4xl text-gray-300 block mb-2"></i>
                বর্তমানে কোনো সক্রিয় নোটিশ প্রকাশিত হয়নি।
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination (20 items per page) -->
    @if($notices->hasPages())
      <div class="p-5 border-t border-gray-100 bg-gray-50/50 flex items-center justify-between">
        {{ $notices->links() }}
      </div>
    @endif
  </div>

</div>
@endsection
