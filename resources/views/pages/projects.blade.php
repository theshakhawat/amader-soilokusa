@extends('layouts.website.website-layout')

@section('title', 'উন্নয়ন প্রকল্পসমূহ — শৈলকুপার টেকসই উন্নয়ন উদ্যোগ | আগামীর শৈলকুপা')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-8">

  <!-- Breadcrumb -->
  <nav class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 bg-white px-4 py-2.5 rounded-xl border border-gray-100 shadow-2xs">
    <a href="{{ route('home') }}" class="hover:text-[#0b4622] flex items-center gap-1 transition">
      <i class="ri-home-4-line"></i>
      <span>হোম</span>
    </a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <span class="text-[#0b4622] font-semibold">উন্নয়ন প্রকল্পসমূহ</span>
  </nav>

  <!-- Page Header Banner & Filters -->
  <div class="bg-white rounded-3xl border border-gray-100 shadow-xs p-6 sm:p-8 flex flex-col md:flex-row md:items-center md:justify-between gap-5">
    <div>
      <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-[#0b4622] border border-emerald-200 mb-2">
        <i class="ri-stack-line"></i>
        চলমান ও সম্পন্ন উন্নয়ন কর্মপরিকল্পনা
      </span>
      <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
        উন্নয়ন প্রকল্পসমূহ
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-1 max-w-2xl">
        শৈলকুপার অবকাঠামো, স্বাস্থ্য, শিক্ষা, বিশুদ্ধ পানি ও সামাজিক উন্নয়নের জন্য আগামীর শৈলকুপা বাস্তবায়িত এবং চলমান সকল উদ্যোগ।
      </p>
    </div>

    <!-- Filter Buttons (All, Running, Completed, Upcoming) -->
    <div class="flex flex-wrap items-center bg-[#f8fafc] p-1.5 rounded-2xl border border-gray-200/80 gap-1 shrink-0">
      <a
        href="{{ route('projects.index') }}"
        class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition {{ empty($statusFilter) ? 'bg-[#0b4622] text-white shadow-xs' : 'text-gray-600 hover:text-gray-900' }}"
      >
        <span>সকল প্রকল্প</span>
        <span class="text-[11px] px-1.5 py-0.2 rounded-full {{ empty($statusFilter) ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700' }}">{{ $totalCount }}</span>
      </a>

      <a
        href="{{ route('projects.index', ['status' => 'running']) }}"
        class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition {{ $statusFilter === 'running' ? 'bg-[#0b4622] text-white shadow-xs' : 'text-gray-600 hover:text-gray-900' }}"
      >
        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
        <span>চলমান</span>
        <span class="text-[11px] px-1.5 py-0.2 rounded-full {{ $statusFilter === 'running' ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700' }}">{{ $runningCount }}</span>
      </a>

      <a
        href="{{ route('projects.index', ['status' => 'completed']) }}"
        class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition {{ $statusFilter === 'completed' ? 'bg-[#0b4622] text-white shadow-xs' : 'text-gray-600 hover:text-gray-900' }}"
      >
        <i class="ri-checkbox-circle-fill text-blue-500 text-sm"></i>
        <span>সম্পন্ন</span>
        <span class="text-[11px] px-1.5 py-0.2 rounded-full {{ $statusFilter === 'completed' ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700' }}">{{ $completedCount }}</span>
      </a>
    </div>
  </div>

  <!-- Projects Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-7">
    @forelse($projects as $project)
      @php $badge = $project->status_badge; @endphp
      <div class="bg-white rounded-3xl border border-gray-200/80 overflow-hidden shadow-2xs hover:shadow-xl hover:border-[#0b4622]/40 transition duration-300 flex flex-col justify-between group">
        
        <div>
          <!-- Thumbnail & Status Badge -->
          <div class="relative aspect-[16/10] overflow-hidden bg-gray-100">
            <img
              src="{{ $project->thumbnail_url }}"
              alt="{{ $project->title }}"
              class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
              onerror="this.src='https://placehold.co/600x400/0b4622/ffffff?text={{ urlencode($project->title) }}'"
            >
            <!-- Running/Completed Badge -->
            <div class="absolute top-3.5 left-3.5">
              <span class="inline-flex items-center gap-1 px-3 py-1 rounded-xl text-[11px] font-extrabold shadow-md {{ $badge['bg'] }} {{ $badge['text_color'] }}">
                <i class="{{ $badge['icon'] }} {{ $project->project_status === 'running' ? 'animate-spin' : '' }}"></i>
                <span>{{ $badge['text'] }}</span>
              </span>
            </div>

            @if($project->photos->count() > 0)
              <div class="absolute bottom-3 right-3 px-2.5 py-1 rounded-lg bg-black/70 backdrop-blur-xs text-white text-[11px] font-bold flex items-center gap-1">
                <i class="ri-image-line"></i>
                <span>{{ $project->photos->count() }} ছবি</span>
              </div>
            @endif
          </div>

          <!-- Content Body -->
          <div class="p-5 sm:p-6 space-y-2.5">
            <h3 class="text-base sm:text-lg font-black text-gray-900 group-hover:text-[#0b4622] transition line-clamp-2 leading-snug">
              {{ $project->title }}
            </h3>
            
            <div class="text-xs text-gray-500 line-clamp-3 leading-relaxed">
              {!! strip_tags($project->description) !!}
            </div>
          </div>
        </div>

        <!-- Footer Card Button -->
        <div class="p-5 sm:p-6 pt-0">
          <a
            href="{{ route('projects.details', $project->id) }}"
            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gray-50 hover:bg-[#0b4622] text-gray-800 hover:text-white text-xs sm:text-sm font-extrabold rounded-xl border border-gray-200 group-hover:border-[#0b4622] transition duration-200 cursor-pointer"
          >
            <span>বিস্তারিত দেখুন</span>
            <i class="ri-arrow-right-line text-[#c8102e] group-hover:text-white transition"></i>
          </a>
        </div>

      </div>
    @empty
      <div class="col-span-full py-16 bg-white rounded-3xl border border-gray-100 text-center text-gray-400">
        <i class="ri-folder-info-line text-4xl text-gray-300 block mb-2"></i>
        বর্তমানে কোনো উন্নয়ন প্রকল্প তথ্য পাওয়া যায়নি।
      </div>
    @endforelse
  </div>

  <!-- Pagination -->
  @if($projects->hasPages())
    <div class="pt-4 flex justify-center">
      {{ $projects->links() }}
    </div>
  @endif

  <!-- Back to Home Button -->
  <div class="pt-6 text-center border-t border-gray-100">
    <a
      href="{{ route('home') }}"
      class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-bold rounded-xl transition"
    >
      <i class="ri-arrow-left-line"></i>
      <span>হোমপেজে ফিরে যান</span>
    </a>
  </div>

</div>
@endsection

