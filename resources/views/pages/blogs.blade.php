@extends('layouts.website.website-layout')

@section('title', 'ব্লগ ও আপডেট — শৈলকুপার উন্নয়ন ভাবনা, সংবাদ ও নিবন্ধ | আগামীর শৈলকুপা')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-8">

  <!-- Breadcrumb -->
  <nav class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 bg-white px-4 py-2.5 rounded-xl border border-gray-100 shadow-2xs">
    <a href="{{ route('home') }}" class="hover:text-[#0b4622] flex items-center gap-1 transition">
      <i class="ri-home-4-line"></i>
      <span>হোম</span>
    </a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <span class="text-[#0b4622] font-semibold">ব্লগ ও আপডেট</span>
  </nav>

  <!-- Page Header -->
  <div class="bg-white rounded-3xl border border-gray-100 shadow-xs p-6 sm:p-8 flex flex-col md:flex-row md:items-center md:justify-between gap-5">
    <div>
      <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-[#c8102e] border border-red-200 mb-2">
        <i class="ri-article-line"></i>
        প্রবন্ধ, সংবাদ ও উন্নয়ন ভাবনা
      </span>
      <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
        ব্লগ ও আপডেট
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-1 max-w-2xl">
        শৈলকুপার সার্বিক উন্নয়ন, শিক্ষা, কৃষি, স্বাস্থ্য ও মানবকল্যাণ বিষয়ক সর্বশেষ নিবন্ধ, মতামত ও আপডেট।
      </p>
    </div>

    <!-- Category filter pills -->
    <div class="flex flex-wrap items-center gap-1.5 shrink-0">
      <a
        href="{{ route('blogs.index') }}"
        class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ !request()->filled('category') ? 'bg-[#0b4622] text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
      >
        সকল
      </a>
      @foreach($categories as $cat)
        <a
          href="{{ route('blogs.index', ['category' => $cat->slug]) }}"
          class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('category') === $cat->slug ? 'bg-[#0b4622] text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
        >
          <span>{{ $cat->name }}</span>
          <span class="text-[10px] ml-1 opacity-70">({{ $cat->posts_count }})</span>
        </a>
      @endforeach
    </div>
  </div>

  <!-- Main Grid with Sidebar -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

    <!-- Left: Posts Grid (8 Cols) -->
    <div class="lg:col-span-8 space-y-6">
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        @forelse($posts as $post)
          <article class="bg-white rounded-2xl border border-gray-200/80 overflow-hidden shadow-2xs hover:shadow-xl hover:border-[#0b4622]/40 transition duration-300 flex flex-col justify-between group">
            <div>
              <!-- Thumbnail -->
              <a href="{{ route('blogs.details', $post->slug) }}" class="block aspect-[16/10] overflow-hidden bg-gray-100 relative">
                <img
                  src="{{ $post->thumbnail_url }}"
                  alt="{{ $post->title }}"
                  class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                  onerror="this.src='https://placehold.co/600x400/0b4622/ffffff?text={{ urlencode($post->title) }}'"
                >
                @if($post->category)
                  <span class="absolute top-3 left-3 px-2.5 py-1 rounded-lg text-[11px] font-extrabold bg-[#0b4622] text-white shadow">
                    {{ $post->category->name }}
                  </span>
                @endif
              </a>

              <!-- Content -->
              <div class="p-5 space-y-2.5">
                <h3 class="text-base font-extrabold text-gray-900 group-hover:text-[#c8102e] transition leading-snug line-clamp-2">
                  <a href="{{ route('blogs.details', $post->slug) }}">
                    {{ $post->title }}
                  </a>
                </h3>

                <p class="text-xs text-gray-500 line-clamp-3 leading-relaxed">
                  {!! strip_tags($post->content) !!}
                </p>
              </div>
            </div>

            <!-- Footer Card -->
            <div class="px-5 pb-5 pt-2 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
              <span class="flex items-center gap-1 font-medium">
                <i class="ri-time-line text-[#c8102e]"></i>
                <span>{{ $post->published ? $post->published->format('d M, Y') : $post->created_at->format('d M, Y') }}</span>
              </span>

              <a
                href="{{ route('blogs.details', $post->slug) }}"
                class="font-extrabold text-[#0b4622] hover:text-[#c8102e] inline-flex items-center gap-1 transition"
              >
                <span>পড়ুন</span>
                <i class="ri-arrow-right-line"></i>
              </a>
            </div>
          </article>
        @empty
          <div class="col-span-full py-16 bg-white rounded-3xl border border-gray-100 text-center text-gray-400">
            <i class="ri-article-line text-4xl text-gray-300 block mb-2"></i>
            বর্তমানে কোনো ব্লগ পোস্ট পাওয়া যায়নি।
          </div>
        @endforelse
      </div>

      <!-- Pagination -->
      @if($posts->hasPages())
        <div class="pt-4 flex justify-center">
          {{ $posts->links() }}
        </div>
      @endif
    </div>

    <!-- Right Sidebar (4 Cols) -->
    <aside class="lg:col-span-4 space-y-6">

      <!-- Search Box -->
      <div class="bg-white rounded-2xl border border-gray-100 shadow-2xs p-5 space-y-3">
        <h4 class="text-sm font-extrabold text-gray-900 flex items-center gap-2">
          <i class="ri-search-line text-[#0b4622]"></i>
          <span>ব্লগ খুঁজুন</span>
        </h4>
        <form method="GET" action="{{ route('blogs.index') }}" class="relative">
          @if(request()->filled('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
          @endif
          <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="বিষয় বা শিরোনাম লিখুন..."
            class="w-full pl-9 pr-3.5 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
          >
          <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
        </form>
      </div>

      <!-- Categories Widget -->
      <div class="bg-white rounded-2xl border border-gray-100 shadow-2xs p-5 space-y-3">
        <h4 class="text-sm font-extrabold text-gray-900 flex items-center gap-2 border-b border-gray-100 pb-2.5">
          <i class="ri-price-tag-3-line text-[#0b4622]"></i>
          <span>ক্যাটাগরি সমূহ</span>
        </h4>
        <div class="space-y-1.5">
          @foreach($categories as $cat)
            <a
              href="{{ route('blogs.index', ['category' => $cat->slug]) }}"
              class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold text-gray-700 hover:bg-emerald-50/60 hover:text-[#0b4622] transition"
            >
              <span>{{ $cat->name }}</span>
              <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-600">{{ $cat->posts_count }}</span>
            </a>
          @endforeach
        </div>
      </div>

      <!-- Recent Posts Widget -->
      @if($recentPosts->count() > 0)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-2xs p-5 space-y-3">
          <h4 class="text-sm font-extrabold text-gray-900 flex items-center gap-2 border-b border-gray-100 pb-2.5">
            <i class="ri-time-line text-[#0b4622]"></i>
            <span>সাম্প্রতিক পোস্ট</span>
          </h4>
          <div class="space-y-3">
            @foreach($recentPosts as $rPost)
              <a href="{{ route('blogs.details', $rPost->slug) }}" class="flex items-center gap-3 group">
                <div class="w-14 h-14 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                  <img src="{{ $rPost->thumbnail_url }}" alt="{{ $rPost->title }}" class="w-full h-full object-cover group-hover:scale-105 transition">
                </div>
                <div class="flex-1 min-w-0">
                  <h5 class="text-xs font-extrabold text-gray-800 group-hover:text-[#c8102e] transition line-clamp-2 leading-snug">
                    {{ $rPost->title }}
                  </h5>
                  <span class="text-[11px] text-gray-400 mt-1 block">
                    {{ $rPost->published ? $rPost->published->format('d M, Y') : $rPost->created_at->format('d M, Y') }}
                  </span>
                </div>
              </a>
            @endforeach
          </div>
        </div>
      @endif

    </aside>

  </div>

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

