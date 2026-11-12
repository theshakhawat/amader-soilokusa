@extends('layouts.website.website-layout')

@section('title', $post->title . ' — ব্লগ ও আপডেট | আগামীর শৈলকুপা')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-8">

  <!-- Breadcrumb -->
  <nav class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 bg-white px-4 py-2.5 rounded-xl border border-gray-100 shadow-2xs">
    <a href="{{ route('home') }}" class="hover:text-[#0b4622] flex items-center gap-1 transition">
      <i class="ri-home-4-line"></i>
      <span>হোম</span>
    </a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <a href="{{ route('blogs.index') }}" class="hover:text-[#0b4622] transition">ব্লগ ও আপডেট</a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <span class="text-[#0b4622] font-semibold truncate max-w-xs">{{ $post->title }}</span>
  </nav>

  <!-- Main Article Card -->
  <article class="bg-white rounded-3xl border border-gray-200/80 shadow-xs overflow-hidden">
    
    <!-- Header -->
    <div class="p-6 sm:p-10 border-b border-gray-100 space-y-4">
      <div class="flex flex-wrap items-center gap-2.5 text-xs">
        @if($post->category)
          <a
            href="{{ route('blogs.index', ['category' => $post->category->slug]) }}"
            class="inline-flex items-center gap-1 px-3 py-1 rounded-xl font-bold bg-emerald-50 text-[#0b4622] border border-emerald-200 hover:bg-[#0b4622] hover:text-white transition"
          >
            <i class="ri-price-tag-3-line"></i>
            <span>{{ $post->category->name }}</span>
          </a>
        @endif

        <span class="text-gray-400 flex items-center gap-1">
          <i class="ri-time-line text-[#c8102e]"></i>
          <span>প্রকাশিতঃ {{ $post->published ? $post->published->format('d M, Y') : $post->created_at->format('d M, Y') }}</span>
        </span>
      </div>

      <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-gray-900 leading-tight">
        {{ $post->title }}
      </h1>
    </div>

    <!-- Featured Thumbnail Image -->
    @if($post->thumbnail)
      <div class="aspect-[16/9] sm:aspect-[21/9] w-full bg-gray-100 overflow-hidden">
        <img
          src="{{ $post->thumbnail_url }}"
          alt="{{ $post->title }}"
          class="w-full h-full object-cover"
          onerror="this.src='https://placehold.co/1200x500/0b4622/ffffff?text={{ urlencode($post->title) }}'"
        >
      </div>
    @endif

    <!-- Content Body -->
    <div class="p-6 sm:p-10 lg:p-12 space-y-6">
      <div class="prose max-w-none text-gray-700 leading-relaxed text-sm sm:text-base space-y-4">
        @if($post->content)
          {!! $post->content !!}
        @else
          <p class="text-gray-400 italic">এই পোস্টের কোনো বিস্তারিত বিবরণ দেওয়া হয়নি।</p>
        @endif
      </div>
    </div>

  </article>

  <!-- Related Posts -->
  @if($relatedPosts->count() > 0)
    <div class="space-y-4 pt-6">
      <div class="flex items-center justify-between border-b border-gray-200 pb-3">
        <h3 class="text-lg sm:text-xl font-bold text-gray-900 flex items-center gap-2">
          <i class="ri-article-line text-[#0b4622]"></i>
          <span>সম্পর্কিত আরও পোস্ট</span>
        </h3>
        <a href="{{ route('blogs.index') }}" class="text-xs sm:text-sm font-bold text-[#c8102e] hover:underline flex items-center gap-1">
          <span>সব দেখুন</span>
          <i class="ri-arrow-right-line"></i>
        </a>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($relatedPosts as $rel)
          <a
            href="{{ route('blogs.details', $rel->slug) }}"
            class="bg-white rounded-2xl border border-gray-200/80 p-3.5 shadow-2xs hover:shadow-lg hover:border-[#0b4622]/40 transition group flex flex-col justify-between"
          >
            <div>
              <div class="aspect-[16/10] rounded-xl overflow-hidden bg-gray-100 mb-3">
                <img src="{{ $rel->thumbnail_url }}" alt="{{ $rel->title }}" class="w-full h-full object-cover group-hover:scale-105 transition">
              </div>
              <h4 class="text-xs sm:text-sm font-extrabold text-gray-900 group-hover:text-[#c8102e] transition line-clamp-2 leading-snug">
                {{ $rel->title }}
              </h4>
            </div>
            <div class="mt-2.5 pt-2 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-500 font-semibold">
              <span class="text-[#0b4622] font-bold">পড়ুন →</span>
              <span>{{ $rel->published ? $rel->published->format('d M, Y') : $rel->created_at->format('d M, Y') }}</span>
            </div>
          </a>
        @endforeach
      </div>
    </div>
  @endif

  <!-- Back to All Blogs Navigation -->
  <div class="pt-6 text-center border-t border-gray-100">
    <a
      href="{{ route('blogs.index') }}"
      class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-bold rounded-xl transition cursor-pointer"
    >
      <i class="ri-arrow-left-line"></i>
      <span>সকল ব্লগে ফিরে যান</span>
    </a>
  </div>

</div>
@endsection

