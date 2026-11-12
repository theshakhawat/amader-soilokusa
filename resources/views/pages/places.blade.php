@extends('layouts.website.website-layout')

@section('title', 'দর্শনীয় স্থানসমূহ — শৈলকুপার প্রাকৃতিক ও ঐতিহাসিক স্থান | আগামীর শৈলকুপা')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-8">

  <!-- Breadcrumb -->
  <nav class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 bg-white px-4 py-2.5 rounded-xl border border-gray-100 shadow-2xs">
    <a href="{{ route('home') }}" class="hover:text-[#0b4622] flex items-center gap-1 transition">
      <i class="ri-home-4-line"></i>
      <span>হোম</span>
    </a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <span class="text-[#0b4622] font-semibold">দর্শনীয় স্থানসমূহ</span>
  </nav>

  <!-- Page Header -->
  <div class="bg-white rounded-3xl border border-gray-100 shadow-xs p-6 sm:p-8 flex flex-col md:flex-row md:items-center md:justify-between gap-5">
    <div>
      <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-[#0b4622] border border-emerald-200 mb-2">
        <i class="ri-map-pin-2-line"></i>
        শৈলকুপার আকর্ষণীয় দর্শনীয় স্থানসমূহ
      </span>
      <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
        দর্শনীয় স্থানসমূহ
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-1 max-w-2xl">
        শৈলকুপার প্রাকৃতিক সৌন্দর্য, ঐতিহাসিক স্থান ও পর্যটন আকর্ষণসমূহ আবিষ্কার করুন।
      </p>
    </div>
    <div class="flex items-center gap-2 shrink-0">
      <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold bg-gray-50 border border-gray-200 text-gray-700">
        <i class="ri-landscape-line text-[#0b4622]"></i>
        মোট {{ $totalCount }} টি স্থান
      </span>
    </div>
  </div>

  <!-- Places Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-7">
    @forelse($places as $place)
      <div class="bg-white rounded-3xl border border-gray-200/80 overflow-hidden shadow-2xs hover:shadow-xl hover:border-[#0b4622]/40 transition duration-300 flex flex-col justify-between group">

        <div>
          <!-- Thumbnail -->
          <div class="relative aspect-[16/10] overflow-hidden bg-gray-100">
            <img
              src="{{ $place->thumbnail_url }}"
              alt="{{ $place->title }}"
              class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
              onerror="this.src='https://placehold.co/600x400/0b4622/ffffff?text={{ urlencode($place->title) }}'"
            >
            <!-- Location Badge -->
            @if($place->location)
              <div class="absolute top-3.5 left-3.5">
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-xl text-[11px] font-extrabold shadow-md bg-[#0b4622] text-white">
                  <i class="ri-map-pin-line"></i>
                  <span class="truncate max-w-[140px]">{{ $place->location }}</span>
                </span>
              </div>
            @endif

            @if($place->photos->count() > 0)
              <div class="absolute bottom-3 right-3 px-2.5 py-1 rounded-lg bg-black/70 backdrop-blur-xs text-white text-[11px] font-bold flex items-center gap-1">
                <i class="ri-image-line"></i>
                <span>{{ $place->photos->count() }} ছবি</span>
              </div>
            @endif
          </div>

          <!-- Content Body -->
          <div class="p-5 sm:p-6 space-y-2.5">
            <h3 class="text-base sm:text-lg font-black text-gray-900 group-hover:text-[#0b4622] transition line-clamp-2 leading-snug">
              {{ $place->title }}
            </h3>
            @if($place->subtitle)
              <p class="text-xs text-gray-500 font-medium line-clamp-1">{{ $place->subtitle }}</p>
            @endif
            <div class="text-xs text-gray-500 line-clamp-3 leading-relaxed">
              {!! strip_tags($place->descriptions) !!}
            </div>
          </div>
        </div>

        <!-- Footer Card Button -->
        <div class="p-5 sm:p-6 pt-0">
          <a
            href="{{ route('places.details', $place->id) }}"
            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gray-50 hover:bg-[#0b4622] text-gray-800 hover:text-white text-xs sm:text-sm font-extrabold rounded-xl border border-gray-200 group-hover:border-[#0b4622] transition duration-200 cursor-pointer"
          >
            <span>বিস্তারিত দেখুন</span>
            <i class="ri-arrow-right-line text-[#c8102e] group-hover:text-white transition"></i>
          </a>
        </div>

      </div>
    @empty
      <div class="col-span-full py-16 bg-white rounded-3xl border border-gray-100 text-center text-gray-400">
        <i class="ri-map-pin-line text-4xl text-gray-300 block mb-2"></i>
        বর্তমানে কোনো দর্শনীয় স্থানের তথ্য পাওয়া যায়নি।
      </div>
    @endforelse
  </div>

  <!-- Pagination -->
  @if($places->hasPages())
    <div class="pt-4 flex justify-center">
      {{ $places->links() }}
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

