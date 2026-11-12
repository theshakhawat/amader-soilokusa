@extends('layouts.website.website-layout')

@section('title', $event->title . ' — আগামীর শৈলকুপা')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
  
  <!-- Breadcrumb Navigation -->
  <nav class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 mb-6 bg-white px-4 py-2.5 rounded-xl border border-gray-100 shadow-2xs">
    <a href="{{ route('home') }}" class="hover:text-[#0b4622] flex items-center gap-1 transition">
      <i class="ri-home-4-line"></i>
      <span>হোম</span>
    </a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <a href="{{ route('events.index') }}" class="hover:text-[#0b4622] transition">কার্যক্রম ও ইভেন্ট</a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <span class="text-[#0b4622] font-semibold truncate">{{ $event->title }}</span>
  </nav>

  <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    
    <!-- Main Content Left (8 Cols) -->
    <div class="lg:col-span-8 bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden p-6 sm:p-8 space-y-6">
      
      <!-- Event Header -->
      <div class="space-y-3">
        <div class="flex flex-wrap items-center gap-2">
          @if($event->status === 'active' || $event->status === 'upcoming')
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-[#0b4622] border border-emerald-200">
              <span class="w-2 h-2 rounded-full bg-[#0b4622] animate-pulse"></span>
              আসন্ন কার্যক্রম
            </span>
          @elseif($event->status === 'ongoing')
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
              <span class="w-2 h-2 rounded-full bg-amber-600 animate-ping"></span>
              চলমান কার্যক্রম
            </span>
          @elseif($event->status === 'completed')
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">
              সম্পন্ন
            </span>
          @endif

          @if($event->date)
            <span class="inline-flex items-center gap-1 text-xs text-gray-500 bg-gray-50 px-3 py-1 rounded-full border border-gray-100">
              <i class="ri-calendar-line text-[#c8102e]"></i>
              {{ $event->bangla_formatted_date }}
            </span>
          @endif
        </div>

        <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight leading-snug">
          {{ $event->title }}
        </h1>
      </div>

      <!-- Feature Image Banner -->
      <div class="relative w-full aspect-[16/9] rounded-2xl overflow-hidden bg-gray-100 shadow-sm border border-gray-100">
        <img
          src="{{ $event->thumbnail_url }}"
          alt="{{ $event->title }}"
          class="w-full h-full object-cover"
          onerror="this.src='{{ asset('assets/images/event-1.jpg') }}'"
        >
        @if($event->date)
          <div class="absolute top-4 left-4 bg-[#c8102e] text-white rounded-xl px-3.5 py-1.5 text-center leading-tight shadow-md">
            <span class="block text-base sm:text-lg font-black">{{ $event->bangla_day }}</span>
            <span class="block text-[10px] sm:text-xs font-semibold">{{ $event->bangla_month }}</span>
          </div>
        @endif
      </div>

      <!-- Quick Info Meta Bar -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-4 rounded-xl bg-[#f8fafc] border border-gray-100 text-xs sm:text-sm text-gray-700">
        @if($event->location)
          <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-[#0b4622] flex items-center justify-center shrink-0">
              <i class="ri-map-pin-line text-base"></i>
            </div>
            <div>
              <span class="block text-[11px] text-gray-400 font-medium">স্থান / লোকেশন</span>
              <span class="font-bold text-gray-800">{{ $event->location }}</span>
            </div>
          </div>
        @endif

        @if($event->time)
          <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-red-50 text-[#c8102e] flex items-center justify-center shrink-0">
              <i class="ri-time-line text-base"></i>
            </div>
            <div>
              <span class="block text-[11px] text-gray-400 font-medium">সময়সূচী</span>
              <span class="font-bold text-gray-800">{{ $event->time }}</span>
            </div>
          </div>
        @endif
      </div>

      <!-- Detailed Description (Quill.js Rich Text Content) -->
      <div class="space-y-4 pt-2">
        <h2 class="text-lg sm:text-xl font-bold text-[#0b4622] border-b border-gray-100 pb-2 flex items-center gap-2">
          <i class="ri-article-line text-[#c8102e]"></i>
          <span>কার্যক্রমের বিস্তারিত বিবরণ</span>
        </h2>

        <div class="rich-text-content prose max-w-none text-gray-700 leading-relaxed text-sm sm:text-[15.5px]">
          @if(!empty($event->description))
            {!! $event->description !!}
          @else
            <p class="text-gray-500 italic">এই ইভেন্টের বিস্তারিত বিবরণ শীঘ্রই যোগ করা হবে।</p>
          @endif
        </div>
      </div>

      <!-- Multiple Photos Gallery Section -->
      @if($event->photos->count() > 0)
        <div class="space-y-4 pt-6 border-t border-gray-100">
          <div class="flex items-center justify-between">
            <h2 class="text-lg sm:text-xl font-bold text-[#0b4622] flex items-center gap-2">
              <i class="ri-gallery-line text-[#0b4622]"></i>
              <span>ইভেন্ট ফটো গ্যালারি ({{ $event->photos->count() }}টি ছবি)</span>
            </h2>
            <span class="text-xs text-gray-400">ছবিতে ক্লিক করে ফুলস্ক্রিনে ব্রাউজ করুন</span>
          </div>

          <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 sm:gap-4">
            @foreach($event->photos as $index => $photo)
              <div
                onclick="openGalleryLightbox({{ $index }})"
                class="group relative aspect-[4/3] rounded-2xl overflow-hidden bg-gray-100 border border-gray-200/80 shadow-2xs cursor-pointer hover:shadow-md transition"
              >
                <img
                  src="{{ $photo->photo_url }}"
                  alt="{{ $event->title }}"
                  class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                  loading="lazy"
                >
                <div class="absolute inset-0 bg-black/35 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                  <span class="w-10 h-10 rounded-full bg-white/90 text-gray-800 flex items-center justify-center shadow-lg transform scale-90 group-hover:scale-100 transition">
                    <i class="ri-fullscreen-line text-lg text-[#0b4622]"></i>
                  </span>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif

      <!-- Navigation & Action Buttons -->
      <div class="pt-6 border-t border-gray-100 flex flex-wrap items-center justify-between gap-3">
        <a
          href="{{ route('home') }}#events-section"
          class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-bold rounded-xl transition"
        >
          <i class="ri-arrow-left-line"></i>
          <span>হোমপেজে ফিরে যান</span>
        </a>

        <a
          href="{{ route('home') }}#contact-section"
          class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs sm:text-sm font-bold rounded-xl shadow-sm transition"
        >
          <i class="ri-mail-send-line"></i>
          <span>আমাদের সাথে যোগাযোগ করুন</span>
        </a>
      </div>

    </div>

    <!-- Right Sidebar (4 Cols) -->
    <div class="lg:col-span-4 space-y-6">
      
      <!-- Recent / Other Events -->
      <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-5 sm:p-6 space-y-4">
        <h3 class="text-base font-extrabold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
          <i class="ri-calendar-todo-line text-[#c8102e]"></i>
          <span>অন্যান্য কার্যক্রম</span>
        </h3>

        <div class="space-y-3.5">
          @forelse($recentEvents as $otherEvent)
            <a
              href="{{ route('events.details', $otherEvent->id) }}"
              class="flex items-center gap-3 group p-2 rounded-xl hover:bg-gray-50 transition border border-transparent hover:border-gray-100"
            >
              <div class="w-16 h-14 rounded-lg overflow-hidden bg-gray-100 shrink-0">
                <img
                  src="{{ $otherEvent->thumbnail_url }}"
                  alt="{{ $otherEvent->title }}"
                  class="w-full h-full object-cover group-hover:scale-105 transition"
                >
              </div>
              <div class="flex-1 min-w-0">
                <h4 class="text-xs sm:text-sm font-bold text-gray-800 group-hover:text-[#0b4622] truncate transition">
                  {{ $otherEvent->title }}
                </h4>
                <div class="flex items-center gap-2 text-[11px] text-gray-500 mt-1">
                  @if($otherEvent->date)
                    <span><i class="ri-calendar-line text-[#c8102e]"></i> {{ $otherEvent->bangla_day }} {{ $otherEvent->bangla_month }}</span>
                  @endif
                  @if($otherEvent->time)
                    <span>&bull; {{ $otherEvent->time }}</span>
                  @endif
                </div>
              </div>
            </a>
          @empty
            <p class="text-xs text-gray-400 py-2">অন্য কোনো ইভেন্ট পাওয়া যায়নি।</p>
          @endforelse
        </div>
      </div>

      <!-- Quick Contact Box -->
      <div class="bg-gradient-to-br from-[#0b4622] to-[#08351a] rounded-2xl p-6 text-white space-y-4 shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-xl text-white">
          <i class="ri-hand-heart-line"></i>
        </div>
        <div>
          <h4 class="text-base font-extrabold">আপনিও অংশ নিন!</h4>
          <p class="text-xs text-white/80 mt-1 leading-relaxed">
            আগামীর শৈলকুপার যেকোনো সামাজিক কার্যক্রম ও ইভেন্টে স্বেচ্ছাসেবক হিসেবে যুক্ত হতে আমাদের সাথে সরাসরি যোগাযোগ করুন।
          </p>
        </div>
        <a
          href="{{ route('home') }}#contact-section"
          class="inline-flex items-center justify-center gap-2 w-full py-2.5 px-4 bg-white hover:bg-gray-100 text-[#0b4622] text-xs font-bold rounded-xl transition"
        >
          <span>যোগাযোগ করুন</span>
          <i class="ri-arrow-right-line"></i>
        </a>
      </div>

    </div>

  </div>

</div>

<!-- Fullscreen Gallery Lightbox Modal -->
<div
  id="gallery-lightbox"
  class="fixed inset-0 z-50 hidden bg-black/95 backdrop-blur-md flex flex-col justify-between transition-opacity duration-300"
  role="dialog"
  aria-modal="true"
>
  <!-- Top Bar: Counter & Controls -->
  <div class="flex items-center justify-between px-6 py-4 text-white z-20">
    <div class="flex items-center gap-3">
      <span class="text-xs sm:text-sm font-bold bg-white/10 px-3 py-1 rounded-full text-white/90" id="lightbox-counter">
        ১ / ১
      </span>
      <span class="text-xs text-white/60 hidden sm:inline truncate max-w-sm">
        {{ $event->title }}
      </span>
    </div>

    <div class="flex items-center gap-3">
      <button
        type="button"
        onclick="downloadCurrentImage()"
        class="p-2 text-white/80 hover:text-white hover:bg-white/10 rounded-full transition cursor-pointer"
        title="ছবি ডাউনলোড করুন"
      >
        <i class="ri-download-2-line text-lg"></i>
      </button>

      <button
        type="button"
        onclick="closeGalleryLightbox()"
        class="p-2 text-white/80 hover:text-white hover:bg-white/10 rounded-full transition cursor-pointer"
        title="বন্ধ করুন (Esc)"
      >
        <i class="ri-close-large-line text-xl"></i>
      </button>
    </div>
  </div>

  <!-- Center: Main Image with Prev / Next Buttons -->
  <div class="relative flex-1 flex items-center justify-center px-4 sm:px-16 overflow-hidden">
    <!-- Prev Button -->
    <button
      type="button"
      onclick="prevGalleryImage()"
      class="absolute left-3 sm:left-6 z-20 p-3 sm:p-4 rounded-full bg-black/40 hover:bg-black/80 text-white/90 hover:text-white border border-white/10 transition backdrop-blur-xs cursor-pointer"
      title="পূর্ববর্তী ছবি (Left Arrow)"
    >
      <i class="ri-arrow-left-s-line text-2xl"></i>
    </button>

    <!-- Main Active Image -->
    <div class="max-w-5xl max-h-[75vh] flex items-center justify-center p-2">
      <img
        id="lightbox-active-img"
        src=""
        alt="Event Photo Fullscreen"
        class="max-w-full max-h-[75vh] object-contain rounded-xl shadow-2xl transition duration-300 transform select-none"
      >
    </div>

    <!-- Next Button -->
    <button
      type="button"
      onclick="nextGalleryImage()"
      class="absolute right-3 sm:right-6 z-20 p-3 sm:p-4 rounded-full bg-black/40 hover:bg-black/80 text-white/90 hover:text-white border border-white/10 transition backdrop-blur-xs cursor-pointer"
      title="পরবর্তী ছবি (Right Arrow)"
    >
      <i class="ri-arrow-right-s-line text-2xl"></i>
    </button>
  </div>

  <!-- Bottom: Thumbnails Carousel -->
  <div class="px-6 py-4 bg-black/40 border-t border-white/10 overflow-x-auto flex items-center justify-center gap-2 custom-scrollbar z-20">
    <div id="lightbox-thumbnails-wrapper" class="flex items-center gap-2"></div>
  </div>
</div>

<script>
const galleryImages = [
  @foreach($event->photos as $p)
    {
      src: "{{ $p->photo_url }}",
      alt: "{{ $event->title }}"
    },
  @endforeach
];

let currentImageIndex = 0;

function openGalleryLightbox(index) {
  if (!galleryImages || galleryImages.length === 0) return;
  currentImageIndex = index;

  const modal = document.getElementById('gallery-lightbox');
  modal.classList.remove('hidden');
  document.body.style.overflow = 'hidden';

  renderLightboxThumbs();
  updateLightboxView();
}

function closeGalleryLightbox() {
  const modal = document.getElementById('gallery-lightbox');
  modal.classList.add('hidden');
  document.body.style.overflow = '';
}

function updateLightboxView() {
  if (currentImageIndex < 0) currentImageIndex = galleryImages.length - 1;
  if (currentImageIndex >= galleryImages.length) currentImageIndex = 0;

  const activeImg = document.getElementById('lightbox-active-img');
  activeImg.style.opacity = '0';
  activeImg.style.transform = 'scale(0.97)';

  setTimeout(() => {
    activeImg.src = galleryImages[currentImageIndex].src;
    activeImg.style.opacity = '1';
    activeImg.style.transform = 'scale(1)';
  }, 100);

  // Update counter in Bangla
  const bnDigits = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
  const curBn = (currentImageIndex + 1).toString().split('').map(d => bnDigits[d] || d).join('');
  const totalBn = galleryImages.length.toString().split('').map(d => bnDigits[d] || d).join('');
  document.getElementById('lightbox-counter').innerText = `${curBn} / ${totalBn}`;

  // Highlight active thumbnail
  const thumbs = document.querySelectorAll('.lightbox-thumb');
  thumbs.forEach((th, idx) => {
    if (idx === currentImageIndex) {
      th.classList.add('ring-2', 'ring-[#0b4622]', 'opacity-100', 'scale-105');
      th.classList.remove('opacity-40');
    } else {
      th.classList.remove('ring-2', 'ring-[#0b4622]', 'scale-105');
      th.classList.add('opacity-40');
    }
  });
}

function prevGalleryImage() {
  currentImageIndex--;
  updateLightboxView();
}

function nextGalleryImage() {
  currentImageIndex++;
  updateLightboxView();
}

function renderLightboxThumbs() {
  const wrapper = document.getElementById('lightbox-thumbnails-wrapper');
  wrapper.innerHTML = '';
  galleryImages.forEach((img, idx) => {
    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'lightbox-thumb w-14 h-11 rounded-lg overflow-hidden border border-white/20 transition cursor-pointer shrink-0 opacity-40 hover:opacity-100';
    btn.innerHTML = `<img src="${img.src}" class="w-full h-full object-cover">`;
    btn.onclick = () => {
      currentImageIndex = idx;
      updateLightboxView();
    };
    wrapper.appendChild(btn);
  });
}

function downloadCurrentImage() {
  if (galleryImages[currentImageIndex]) {
    const a = document.createElement('a');
    a.href = galleryImages[currentImageIndex].src;
    a.download = `event-photo-${currentImageIndex + 1}.jpg`;
    a.target = '_blank';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
  }
}

// Keyboard shortcuts (Escape, Left, Right Arrow)
document.addEventListener('keydown', function(e) {
  const modal = document.getElementById('gallery-lightbox');
  if (!modal || modal.classList.contains('hidden')) return;

  if (e.key === 'Escape') {
    closeGalleryLightbox();
  } else if (e.key === 'ArrowLeft') {
    prevGalleryImage();
  } else if (e.key === 'ArrowRight') {
    nextGalleryImage();
  }
});
</script>
@endsection
