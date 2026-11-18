@extends('layouts.website.website-layout')

@section('title', 'গঠনতন্ত্র ও বিধিমালা — ' . ($siteSetting?->site_title ?? 'আগামীর শৈলকুপা'))

@section('content')
<main class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

  <!-- Breadcrumb -->
  <nav class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 mb-6 sm:mb-8">
    <a href="{{ route('home') }}" class="hover:text-[#0b4622] flex items-center gap-1 transition">
      <i class="ri-home-4-line text-[#0b4622]"></i>
      <span>হোম</span>
    </a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <span class="text-[#0b4622] font-semibold">গঠনতন্ত্র ও বিধিমালা</span>
  </nav>

  <!-- Page Banner / Header Card -->
  <div class="ui-card p-6 sm:p-10 mb-8 sm:mb-10 bg-gradient-to-r from-emerald-950 via-[#0b4622] to-emerald-900 text-white relative overflow-hidden rounded-3xl shadow-md">
    <div class="relative z-10 max-w-3xl">
      <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-white/15 text-emerald-200 border border-white/20 mb-3 backdrop-blur-xs">
        <i class="ri-scales-3-line"></i> অফিসিয়াল নীতিমালা
      </span>
      <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight leading-tight">
        গঠনতন্ত্র ও কার্যপ্রণালী বিধিমালা
      </h1>
      <p class="text-sm sm:text-base text-emerald-100/90 mt-2.5 leading-relaxed font-light">
        “আগামীর শৈলকুপা” একটি অরাজনৈতিক, অলাভজনক ও সামাজিক কল্যাণমূলক সংগঠন। সংগঠনের সুষ্ঠু ও সুশৃঙ্খল পরিচালনার লক্ষ্যে প্রণীত মৌলিক নীতিমালা ও গঠনতান্ত্রিক নিয়মাবলী।
      </p>

      <div class="mt-6 flex flex-wrap items-center gap-3">
        <button
          type="button"
          onclick="window.print()"
          class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white text-[#0b4622] hover:bg-emerald-50 text-xs font-extrabold shadow transition cursor-pointer"
        >
          <i class="ri-printer-line text-sm"></i>
          <span>বিধিমালা প্রিন্ট করুন</span>
        </button>

        <span class="text-xs text-emerald-200/80">
          সর্বমোট খণ্ড/ভাগ: <strong class="text-white">{{ $rules->count() }}টি</strong>
        </span>
      </div>
    </div>

    <!-- Decorative Watermark Icon -->
    <div class="absolute -right-8 -bottom-10 text-white/5 text-[180px] sm:text-[240px] pointer-events-none select-none">
      <i class="ri-book-read-line"></i>
    </div>
  </div>

  @if($rules->isEmpty())
    <div class="ui-card p-12 text-center text-gray-500">
      <i class="ri-file-text-line text-4xl text-gray-300 block mb-3"></i>
      বর্তমানে কোনো বিধিমালা প্রকাশিত নেই। খুব শীঘ্রই গঠনতন্ত্রের ধারাগুলো আপডেট করা হবে।
    </div>
  @else
    <!-- Main Interactive Two-Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 items-start">
      
      <!-- Left Column: Parts Navigation Sidebar (4 Cols) -->
      <aside class="lg:col-span-4 lg:sticky lg:top-24 space-y-4">
        
        <div class="ui-card p-4 sm:p-5">
          <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-3">
            <h2 class="text-xs font-black uppercase tracking-wider text-gray-800 flex items-center gap-2">
              <i class="ri-list-check-2 text-[#0b4622]"></i>
              <span>সূচিপত্র / অধ্যায়সমূহ</span>
            </h2>
            <span class="text-[11px] font-bold text-[#c8102e]">{{ $rules->count() }}টি ভাগ</span>
          </div>

          <!-- Vertical Tabs List -->
          <div class="space-y-1.5" id="rulesTabList">
            @foreach($rules as $index => $item)
              <button
                type="button"
                id="tab-btn-{{ $item->slug }}"
                onclick="showRulePart('{{ $item->slug }}')"
                class="rule-tab-btn w-full text-left p-3 rounded-xl transition-all duration-200 flex items-center justify-between group cursor-pointer border {{ $index === 0 ? 'bg-[#0b4622] text-white border-[#0b4622] shadow-xs active-tab' : 'bg-white hover:bg-gray-50 text-gray-700 border-gray-100' }}"
              >
                <div class="flex items-start gap-2.5 min-w-0">
                  <span class="w-6 h-6 rounded-lg text-xs font-bold flex items-center justify-center shrink-0 mt-0.5 {{ $index === 0 ? 'bg-white/20 text-white' : 'bg-gray-100 text-[#0b4622] group-hover:bg-emerald-50' }}">
                    {{ $index + 1 }}
                  </span>
                  <div class="min-w-0">
                    <span class="block text-[11px] font-extrabold uppercase tracking-wide opacity-80">
                      {{ $item->part_no }}
                    </span>
                    <span class="block text-xs sm:text-[13px] font-bold truncate leading-tight mt-0.5">
                      {{ $item->title }}
                    </span>
                  </div>
                </div>
                <i class="ri-arrow-right-s-line text-base shrink-0 ml-1 transition-transform group-hover:translate-x-0.5 {{ $index === 0 ? 'text-white' : 'text-gray-400' }}"></i>
              </button>
            @endforeach
          </div>
        </div>

        <!-- Quick Help / Contact Box -->
        <div class="ui-card p-4 bg-emerald-50/50 border-emerald-100 text-xs text-gray-700">
          <div class="flex items-center gap-2 text-[#0b4622] font-bold mb-1">
            <i class="ri-information-line text-sm"></i>
            <span>গঠনতন্ত্র সম্পর্কে প্রশ্ন?</span>
          </div>
          <p class="text-[11px] text-gray-600 leading-relaxed">
            বিধিমালা বা ধারা সংক্রান্ত কোনো জিজ্ঞাসা থাকলে আমাদের পরিচালনা পরিষদের সাথে যোগাযোগ করতে পারেন।
          </p>
          <a href="{{ route('contact.index') }}" class="mt-2 inline-flex items-center gap-1 font-bold text-[#c8102e] hover:underline">
            যোগাযোগ পেজ দেখুন <i class="ri-arrow-right-line"></i>
          </a>
        </div>

      </aside>

      <!-- Right Column: Active Part Content Display (8 Cols) -->
      <section class="lg:col-span-8 space-y-6" id="ruleContentContainer">
        @foreach($rules as $index => $item)
          <article
            id="rule-content-{{ $item->slug }}"
            class="rule-content-pane ui-card p-6 sm:p-9 transition-all duration-300 {{ $index === 0 ? 'block' : 'hidden' }}"
          >
            <!-- Part Header -->
            <div class="border-b border-gray-100 pb-4 mb-6">
              <div class="flex items-center justify-between gap-3 mb-2">
                <span class="inline-block px-3 py-1 rounded-lg text-xs font-black bg-emerald-50 text-[#0b4622] border border-emerald-200">
                  {{ $item->part_no }}
                </span>
                <span class="text-xs text-gray-400 font-mono">অংশ #{{ $item->order }}</span>
              </div>
              <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 leading-snug">
                {{ $item->title }}
              </h2>
              @if($item->summary)
                <p class="text-xs sm:text-sm text-gray-500 mt-2 leading-relaxed bg-gray-50 p-3 rounded-xl border border-gray-100">
                  {{ $item->summary }}
                </p>
              @endif
            </div>

            <!-- Rich Text Body Rendering -->
            <div class="rules-article-body text-gray-800 text-sm sm:text-[15px] leading-relaxed space-y-4">
              {!! $item->content !!}
            </div>

            <!-- Bottom Navigation Between Parts -->
            <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-between gap-3">
              @if($index > 0)
                <button
                  type="button"
                  onclick="showRulePart('{{ $rules[$index - 1]->slug }}')"
                  class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border border-gray-200 hover:border-emerald-300 hover:bg-emerald-50 text-xs font-bold text-gray-700 hover:text-[#0b4622] transition cursor-pointer"
                >
                  <i class="ri-arrow-left-line"></i>
                  <span>পূর্ববর্তী: {{ $rules[$index - 1]->part_no }}</span>
                </button>
              @else
                <div></div>
              @endif

              @if($index < $rules->count() - 1)
                <button
                  type="button"
                  onclick="showRulePart('{{ $rules[$index + 1]->slug }}')"
                  class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#0b4622] hover:bg-[#146c32] text-white text-xs font-bold shadow-xs transition cursor-pointer ml-auto"
                >
                  <span>পরবর্তী: {{ $rules[$index + 1]->part_no }}</span>
                  <i class="ri-arrow-right-line"></i>
                </button>
              @endif
            </div>
          </article>
        @endforeach
      </section>

    </div>
  @endif

</main>

<style>
  /* Custom Article Typography for Rules */
  .rules-article-body h3 {
    font-size: 1.15rem;
    font-weight: 800;
    color: #0b4622;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
    border-bottom: 1px dashed rgba(11, 70, 34, 0.15);
    padding-bottom: 0.4rem;
  }
  .rules-article-body h4 {
    font-size: 1.05rem;
    font-weight: 700;
    color: #1f2937;
    margin-top: 1rem;
    margin-bottom: 0.5rem;
  }
  .rules-article-body ul {
    list-style-type: disc;
    margin-left: 1.25rem;
    margin-top: 0.5rem;
    margin-bottom: 0.75rem;
  }
  .rules-article-body ol {
    list-style-type: decimal;
    margin-left: 1.25rem;
    margin-top: 0.5rem;
    margin-bottom: 0.75rem;
  }
  .rules-article-body li {
    margin-bottom: 0.35rem;
  }

  @media print {
    aside, nav, header, footer, button, .no-print {
      display: none !important;
    }
    .rule-content-pane {
      display: block !important;
      page-break-after: always;
      box-shadow: none !important;
      border: none !important;
      padding: 0 !important;
    }
  }
</style>

<script>
function showRulePart(slug) {
  // 1. Hide all content panes
  document.querySelectorAll('.rule-content-pane').forEach(el => {
    el.classList.add('hidden');
    el.classList.remove('block');
  });

  // 2. Show target content pane
  const targetPane = document.getElementById('rule-content-' + slug);
  if (targetPane) {
    targetPane.classList.remove('hidden');
    targetPane.classList.add('block');
  }

  // 3. Update tab buttons active styling
  document.querySelectorAll('.rule-tab-btn').forEach(btn => {
    btn.classList.remove('bg-[#0b4622]', 'text-white', 'border-[#0b4622]', 'shadow-xs', 'active-tab');
    btn.classList.add('bg-white', 'hover:bg-gray-50', 'text-gray-700', 'border-gray-100');

    // Reset number box
    const numBadge = btn.querySelector('span:first-child');
    if (numBadge) {
      numBadge.classList.remove('bg-white/20', 'text-white');
      numBadge.classList.add('bg-gray-100', 'text-[#0b4622]');
    }

    // Reset arrow icon
    const arrow = btn.querySelector('.ri-arrow-right-s-line');
    if (arrow) {
      arrow.classList.remove('text-white');
      arrow.classList.add('text-gray-400');
    }
  });

  const activeBtn = document.getElementById('tab-btn-' + slug);
  if (activeBtn) {
    activeBtn.classList.add('bg-[#0b4622]', 'text-white', 'border-[#0b4622]', 'shadow-xs', 'active-tab');
    activeBtn.classList.remove('bg-white', 'hover:bg-gray-50', 'text-gray-700', 'border-gray-100');

    const numBadge = activeBtn.querySelector('span:first-child');
    if (numBadge) {
      numBadge.classList.add('bg-white/20', 'text-white');
      numBadge.classList.remove('bg-gray-100', 'text-[#0b4622]');
    }

    const arrow = activeBtn.querySelector('.ri-arrow-right-s-line');
    if (arrow) {
      arrow.classList.add('text-white');
      arrow.classList.remove('text-gray-400');
    }
  }

  // 4. Update browser URL hash without jump
  if (history.pushState) {
    history.pushState(null, null, '#' + slug);
  } else {
    location.hash = '#' + slug;
  }

  // On mobile screens, scroll to content
  if (window.innerWidth < 1024) {
    const container = document.getElementById('ruleContentContainer');
    if (container) {
      container.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  }
}

// Auto open hash on page load
document.addEventListener('DOMContentLoaded', function () {
  const hash = window.location.hash.replace('#', '');
  if (hash) {
    const target = document.getElementById('rule-content-' + hash);
    if (target) {
      showRulePart(hash);
    }
  }
});
</script>
@endsection
