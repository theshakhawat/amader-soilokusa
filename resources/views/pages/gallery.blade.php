@extends('layouts.website.website-layout')

@section('title', 'গ্যালারি — ছবি ও ভিডিও আর্কাইভ | আগামীর শৈলকুপা')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-8">
  
  <!-- Breadcrumb -->
  <nav class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 bg-white px-4 py-2.5 rounded-xl border border-gray-100 shadow-2xs">
    <a href="{{ route('home') }}" class="hover:text-[#0b4622] flex items-center gap-1 transition">
      <i class="ri-home-4-line"></i>
      <span>হোম</span>
    </a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <span class="text-[#0b4622] font-semibold">গ্যালারি</span>
  </nav>

  <!-- Page Header & Tab Controls -->
  <div class="bg-white rounded-3xl border border-gray-100 shadow-xs p-6 sm:p-8 flex flex-col md:flex-row md:items-center md:justify-between gap-5">
    <div>
      <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-[#0b4622] border border-emerald-200 mb-2">
        <i class="ri-gallery-line"></i>
        মিডিয়া ও স্মৃতি আর্কাইভ
      </span>
      <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
        ফটো ও ভিডিও গ্যালারি
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-1">
        আগামীর শৈলকুপার বিভিন্ন সামাজিক উদ্যোগ, সেবামূলক ক্যাম্প ও ঐতিহাসিক মুহূর্তের সংগ্রহ।
      </p>
    </div>

    <!-- Tab Switcher (Photo / Video) -->
    <div class="flex items-center bg-[#f8fafc] p-1.5 rounded-2xl border border-gray-200/80 shrink-0">
      <button
        type="button"
        onclick="switchGalleryTab('photo')"
        id="tab-btn-photo"
        class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition {{ $activeTab === 'photo' ? 'bg-[#0b4622] text-white shadow-xs' : 'text-gray-600 hover:text-gray-900' }}"
      >
        <i class="ri-image-line text-base"></i>
        <span>ফটো গ্যালারি ({{ $photos->count() }})</span>
      </button>

      <button
        type="button"
        onclick="switchGalleryTab('video')"
        id="tab-btn-video"
        class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition {{ $activeTab === 'video' ? 'bg-[#0b4622] text-white shadow-xs' : 'text-gray-600 hover:text-gray-900' }}"
      >
        <i class="ri-video-line text-base"></i>
        <span>ভিডিও গ্যালারি ({{ $videos->count() }})</span>
      </button>
    </div>
  </div>

  <!-- =========================================================================
       TAB 1: PHOTO GALLERY
       ========================================================================= -->
  <div id="gallery-photo-content" class="{{ $activeTab === 'photo' ? '' : 'hidden' }}">
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
      @forelse($photos as $index => $photo)
        <div
          onclick="openPhotoLightbox({{ $index }})"
          class="group relative aspect-[4/3] rounded-2xl overflow-hidden bg-gray-100 border border-gray-200/80 shadow-2xs hover:shadow-lg transition duration-300 cursor-pointer"
        >
          <img
            src="{{ $photo->image_url }}"
            alt="{{ $photo->title }}"
            class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
            loading="lazy"
          >
          <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col justify-between p-4">
            <span class="self-end w-8 h-8 rounded-full bg-white/90 text-[#0b4622] flex items-center justify-center shadow">
              <i class="ri-fullscreen-line text-sm"></i>
            </span>
            <h4 class="text-xs sm:text-sm font-bold text-white line-clamp-2">
              {{ $photo->title }}
            </h4>
          </div>
        </div>
      @empty
        <div class="col-span-full py-16 bg-white rounded-3xl border border-gray-100 text-center text-gray-400">
          <i class="ri-image-line text-4xl text-gray-300 block mb-2"></i>
          বর্তমানে ফটো গ্যালারিতে কোনো ছবি যুক্ত করা হয়নি।
        </div>
      @endforelse
    </div>
  </div>

  <!-- =========================================================================
       TAB 2: VIDEO GALLERY
       ========================================================================= -->
  <div id="gallery-video-content" class="{{ $activeTab === 'video' ? '' : 'hidden' }}">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @forelse($videos as $videoIndex => $video)
        <div
          onclick="openGalleryVideoModal('{{ addslashes($video->title) }}', '{{ $video->embed_url }}', {{ $video->is_local_video ? 'true' : 'false' }})"
          class="bg-white rounded-2xl border border-gray-200/80 overflow-hidden shadow-2xs hover:shadow-lg hover:border-[#0b4622]/40 transition duration-300 group cursor-pointer flex flex-col justify-between"
        >
          <div class="relative aspect-video bg-black overflow-hidden">
            <img
              src="{{ $video->video_thumbnail }}"
              alt="{{ $video->title }}"
              class="w-full h-full object-cover group-hover:scale-105 transition duration-300 opacity-90 group-hover:opacity-100"
            >
            <!-- Play Button Overlay -->
            <div class="absolute inset-0 flex items-center justify-center">
              <span class="w-14 h-14 rounded-full bg-[#c8102e] text-white flex items-center justify-center shadow-xl group-hover:scale-110 transition duration-300">
                <i class="ri-play-fill text-2xl ml-0.5"></i>
              </span>
            </div>
            <span class="absolute bottom-2.5 right-2.5 px-2 py-0.5 bg-black/80 text-white rounded text-[10px] font-bold">
              VIDEO
            </span>
          </div>

          <div class="p-4 space-y-1">
            <h4 class="text-sm sm:text-base font-extrabold text-gray-900 group-hover:text-[#0b4622] transition line-clamp-2">
              {{ $video->title }}
            </h4>
            <p class="text-xs text-gray-400 flex items-center gap-1 pt-1">
              <i class="ri-play-circle-line text-[#c8102e]"></i>
              <span>ভিডিও দেখতে ক্লিক করুন</span>
            </p>
          </div>
        </div>
      @empty
        <div class="col-span-full py-16 bg-white rounded-3xl border border-gray-100 text-center text-gray-400">
          <i class="ri-video-line text-4xl text-gray-300 block mb-2"></i>
          বর্তমানে ভিডিও গ্যালারিতে কোনো ভিডিও যুক্ত করা হয়নি।
        </div>
      @endforelse
    </div>
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

<!-- =========================================================================
     FULLSCREEN PHOTO LIGHTBOX WITH PREV/NEXT
     ========================================================================= -->
<div
  id="photo-lightbox"
  class="fixed inset-0 z-50 hidden bg-black/95 backdrop-blur-md flex flex-col justify-between transition-opacity duration-300"
  role="dialog"
  aria-modal="true"
>
  <!-- Top Bar -->
  <div class="flex items-center justify-between px-6 py-4 text-white z-20">
    <div class="flex items-center gap-3">
      <span class="text-xs sm:text-sm font-bold bg-white/10 px-3 py-1 rounded-full text-white/90" id="photo-counter">
        ১ / ১
      </span>
      <h3 class="text-xs sm:text-sm font-bold text-white/90 truncate max-w-sm sm:max-w-md" id="photo-title"></h3>
    </div>

    <div class="flex items-center gap-3">
      <button
        type="button"
        onclick="downloadPhoto()"
        class="p-2 text-white/80 hover:text-white hover:bg-white/10 rounded-full transition cursor-pointer"
        title="ছবি ডাউনলোড করুন"
      >
        <i class="ri-download-2-line text-lg"></i>
      </button>

      <button
        type="button"
        onclick="closePhotoLightbox()"
        class="p-2 text-white/80 hover:text-white hover:bg-white/10 rounded-full transition cursor-pointer"
        title="বন্ধ করুন (Esc)"
      >
        <i class="ri-close-large-line text-xl"></i>
      </button>
    </div>
  </div>

  <!-- Center Stage with Prev / Next -->
  <div class="relative flex-1 flex items-center justify-center px-4 sm:px-16 overflow-hidden">
    <button
      type="button"
      onclick="prevPhoto()"
      class="absolute left-3 sm:left-6 z-20 p-3 sm:p-4 rounded-full bg-black/40 hover:bg-black/80 text-white border border-white/10 transition backdrop-blur-xs cursor-pointer"
      title="পূর্ববর্তী (Left Arrow)"
    >
      <i class="ri-arrow-left-s-line text-2xl"></i>
    </button>

    <div class="max-w-5xl max-h-[75vh] flex items-center justify-center p-2">
      <img
        id="lightbox-main-img"
        src=""
        alt="Gallery Photo Fullscreen"
        class="max-w-full max-h-[75vh] object-contain rounded-xl shadow-2xl transition duration-300 select-none"
      >
    </div>

    <button
      type="button"
      onclick="nextPhoto()"
      class="absolute right-3 sm:right-6 z-20 p-3 sm:p-4 rounded-full bg-black/40 hover:bg-black/80 text-white border border-white/10 transition backdrop-blur-xs cursor-pointer"
      title="পরবর্তী (Right Arrow)"
    >
      <i class="ri-arrow-right-s-line text-2xl"></i>
    </button>
  </div>

  <!-- Bottom Thumbnails -->
  <div class="px-6 py-4 bg-black/40 border-t border-white/10 overflow-x-auto flex items-center justify-center gap-2 custom-scrollbar z-20">
    <div id="photo-thumbs-wrapper" class="flex items-center gap-2"></div>
  </div>
</div>

<!-- =========================================================================
     VIDEO PLAYER POPUP MODAL
     ========================================================================= -->
<div
  id="video-player-modal"
  class="fixed inset-0 z-50 hidden bg-black/90 backdrop-blur-md flex items-center justify-center p-4 sm:p-6"
  role="dialog"
  aria-modal="true"
>
  <div class="bg-gray-950 rounded-3xl max-w-4xl w-full border border-gray-800 shadow-2xl overflow-hidden space-y-3 p-4 sm:p-6">
    <div class="flex items-center justify-between text-white border-b border-gray-800 pb-3">
      <h3 id="video-modal-title" class="text-sm sm:text-base font-bold truncate max-w-lg"></h3>
      <button
        type="button"
        onclick="closeGalleryVideoModal()"
        class="text-gray-400 hover:text-white p-1 rounded-lg hover:bg-white/10 cursor-pointer"
      >
        <i class="ri-close-line text-2xl"></i>
      </button>
    </div>

    <!-- 16:9 Video Player Container -->
    <div class="relative w-full aspect-video rounded-2xl overflow-hidden bg-black flex items-center justify-center">
      <!-- YouTube / External Iframe -->
      <iframe
        id="video-iframe"
        src=""
        class="w-full h-full hidden"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        allowfullscreen
      ></iframe>

      <!-- HTML5 Direct Video Player for Uploaded Videos -->
      <video
        id="video-html5-player"
        controls
        autoplay
        class="w-full h-full object-contain hidden"
      >
        <source id="video-html5-source" src="" type="video/mp4">
        আপনার ব্রাউজার ভিডিওটি সমর্থন করে না।
      </video>
    </div>
  </div>
</div>

<script>
// Tab Switching
function switchGalleryTab(tab) {
  const photoContent = document.getElementById('gallery-photo-content');
  const videoContent = document.getElementById('gallery-video-content');
  const btnPhoto = document.getElementById('tab-btn-photo');
  const btnVideo = document.getElementById('tab-btn-video');

  if (tab === 'photo') {
    photoContent.classList.remove('hidden');
    videoContent.classList.add('hidden');
    btnPhoto.className = 'flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition bg-[#0b4622] text-white shadow-xs';
    btnVideo.className = 'flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition text-gray-600 hover:text-gray-900';
  } else {
    photoContent.classList.add('hidden');
    videoContent.classList.remove('hidden');
    btnVideo.className = 'flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition bg-[#0b4622] text-white shadow-xs';
    btnPhoto.className = 'flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition text-gray-600 hover:text-gray-900';
  }
}

// Photo Lightbox logic
const photoItems = [
  @foreach($photos as $p)
    {
      src: "{{ $p->image_url }}",
      title: "{{ addslashes($p->title) }}"
    },
  @endforeach
];

let curPhotoIndex = 0;

function openPhotoLightbox(index) {
  if (!photoItems || photoItems.length === 0) return;
  curPhotoIndex = index;
  document.getElementById('photo-lightbox').classList.remove('hidden');
  document.body.style.overflow = 'hidden';

  renderPhotoThumbs();
  updatePhotoView();
}

function closePhotoLightbox() {
  document.getElementById('photo-lightbox').classList.add('hidden');
  document.body.style.overflow = '';
}

function updatePhotoView() {
  if (curPhotoIndex < 0) curPhotoIndex = photoItems.length - 1;
  if (curPhotoIndex >= photoItems.length) curPhotoIndex = 0;

  const mainImg = document.getElementById('lightbox-main-img');
  mainImg.style.opacity = '0';
  mainImg.style.transform = 'scale(0.97)';

  setTimeout(() => {
    mainImg.src = photoItems[curPhotoIndex].src;
    document.getElementById('photo-title').innerText = photoItems[curPhotoIndex].title;
    mainImg.style.opacity = '1';
    mainImg.style.transform = 'scale(1)';
  }, 100);

  // Bangla counter
  const bnDigits = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
  const curBn = (curPhotoIndex + 1).toString().split('').map(d => bnDigits[d] || d).join('');
  const totalBn = photoItems.length.toString().split('').map(d => bnDigits[d] || d).join('');
  document.getElementById('photo-counter').innerText = `${curBn} / ${totalBn}`;

  // Highlight thumb
  const thumbs = document.querySelectorAll('.gallery-thumb-btn');
  thumbs.forEach((th, idx) => {
    if (idx === curPhotoIndex) {
      th.classList.add('ring-2', 'ring-[#0b4622]', 'opacity-100', 'scale-105');
      th.classList.remove('opacity-40');
    } else {
      th.classList.remove('ring-2', 'ring-[#0b4622]', 'scale-105');
      th.classList.add('opacity-40');
    }
  });
}

function prevPhoto() {
  curPhotoIndex--;
  updatePhotoView();
}

function nextPhoto() {
  curPhotoIndex++;
  updatePhotoView();
}

function renderPhotoThumbs() {
  const wrapper = document.getElementById('photo-thumbs-wrapper');
  wrapper.innerHTML = '';
  photoItems.forEach((item, idx) => {
    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'gallery-thumb-btn w-14 h-11 rounded-lg overflow-hidden border border-white/20 transition cursor-pointer shrink-0 opacity-40 hover:opacity-100';
    btn.innerHTML = `<img src="${item.src}" class="w-full h-full object-cover">`;
    btn.onclick = () => {
      curPhotoIndex = idx;
      updatePhotoView();
    };
    wrapper.appendChild(btn);
  });
}

function downloadPhoto() {
  if (photoItems[curPhotoIndex]) {
    const a = document.createElement('a');
    a.href = photoItems[curPhotoIndex].src;
    a.download = `gallery-photo-${curPhotoIndex + 1}.jpg`;
    a.target = '_blank';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
  }
}

// Video Player Modal logic
function openGalleryVideoModal(title, videoUrl, isLocal) {
  document.getElementById('video-modal-title').innerText = title;
  const iframe = document.getElementById('video-iframe');
  const videoPlayer = document.getElementById('video-html5-player');
  const videoSource = document.getElementById('video-html5-source');

  if (isLocal) {
    iframe.classList.add('hidden');
    iframe.src = '';
    videoPlayer.classList.remove('hidden');
    videoSource.src = videoUrl;
    videoPlayer.load();
    videoPlayer.play().catch(e => console.log('Autoplay blocked:', e));
  } else {
    videoPlayer.classList.add('hidden');
    videoPlayer.pause();
    videoSource.src = '';
    iframe.classList.remove('hidden');
    iframe.src = videoUrl;
  }

  document.getElementById('video-player-modal').classList.remove('hidden');
  document.body.style.overflow = 'hidden';
}

function closeGalleryVideoModal() {
  const iframe = document.getElementById('video-iframe');
  const videoPlayer = document.getElementById('video-html5-player');
  const videoSource = document.getElementById('video-html5-source');

  if (iframe) iframe.src = '';
  if (videoPlayer) {
    videoPlayer.pause();
    if (videoSource) videoSource.src = '';
    videoPlayer.load();
  }

  document.getElementById('video-player-modal').classList.add('hidden');
  document.body.style.overflow = '';
}

// Global Key Listeners
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closePhotoLightbox();
    closeGalleryVideoModal();
  } else if (e.key === 'ArrowLeft') {
    const photoBox = document.getElementById('photo-lightbox');
    if (photoBox && !photoBox.classList.contains('hidden')) prevPhoto();
  } else if (e.key === 'ArrowRight') {
    const photoBox = document.getElementById('photo-lightbox');
    if (photoBox && !photoBox.classList.contains('hidden')) nextPhoto();
  }
});
</script>
@endsection

