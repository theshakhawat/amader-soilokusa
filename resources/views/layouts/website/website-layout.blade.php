<!DOCTYPE html>
<html lang="bn" class="overflow-x-hidden">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
  <title>@yield('title', 'আগামীর শৈলকুপা — শৈলকুপার উন্নয়নে আমরা এক পরিবার')</title>

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>


  {{-- Dev --}}
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

  <!-- Font Awesome 6 Free CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

  <!-- Remix Icon CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" />

  <!-- Google Fonts: Hind Siliguri & Noto Sans Bengali -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Noto+Sans+Bengali:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <!-- Custom Stylesheet & Bangla @font-face -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v={{ file_exists(public_path('assets/css/style.css')) ? filemtime(public_path('assets/css/style.css')) : time() }}" />
  @stack('styles')
</head>
<body class="bg-[#f4f5f7] text-gray-800 antialiased selection:bg-[#c8102e] selection:text-white overflow-x-hidden w-full">

  {{-- Top Header Bar --}}
  @include('layouts.website.topnav')

  {{-- Main Navigation Bar --}}
  @include('layouts.website.navbar')

  {{-- Main Content Section --}}
  @yield('content')

  {{-- Footer Section --}}
  @include('layouts.website.footer')

  <!-- =====================================================================
       INTERACTIVE MODALS (RESPONSIVE FOR MOBILE & DESKTOP)
       ===================================================================== -->
  <!-- 1. Universal Details Modal -->
  <div id="info-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-3 sm:p-4 backdrop-blur-xs">
    <div class="bg-white rounded-2xl max-w-lg w-full p-4 sm:p-6 shadow-2xl border border-gray-100 animate-fadeIn max-h-[90vh] overflow-y-auto">
      <div class="flex items-center justify-between border-b border-gray-100 pb-3">
        <span id="modal-category" class="text-xs font-bold bg-red-50 text-[#c8102e] px-3 py-1 rounded-full">বিস্তারিত</span>
        <button type="button" onclick="closeInfoModal()" aria-label="Close Modal" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-red-50 hover:text-[#c8102e] flex items-center justify-center transition">
          <i class="ri-close-line text-lg"></i>
        </button>
      </div>
      <h3 id="modal-title" class="text-lg sm:text-xl font-extrabold text-[#0b4622] mt-3 sm:mt-4">শিরোনাম</h3>
      <p id="modal-meta" class="text-xs text-gray-500 mt-1 font-medium"></p>
      <p id="modal-description" class="text-xs sm:text-sm text-gray-700 leading-relaxed mt-3 whitespace-pre-line"></p>
      <div class="mt-5 sm:mt-6 text-right">
        <button type="button" onclick="closeInfoModal()" class="bg-[#c8102e] hover:bg-[#a30b24] text-white text-xs sm:text-sm font-semibold px-4 sm:px-5 py-2 rounded-lg transition">
          বন্ধ করুন
        </button>
      </div>
    </div>
  </div>

  <!-- 2. Donate Modal -->
  <div id="donate-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-3 sm:p-4 backdrop-blur-xs">
    <div class="bg-white rounded-2xl max-w-md w-full p-4 sm:p-6 shadow-2xl border border-gray-100 max-h-[92vh] overflow-y-auto">
      <div class="flex items-center justify-between border-b border-gray-100 pb-3">
        <div class="flex items-center gap-2 text-[#c8102e] font-extrabold text-base sm:text-lg">
          <i class="fa-solid fa-hand-holding-heart"></i>
          <span>অনুদান ফরম</span>
        </div>
        <button type="button" onclick="closeDonateModal()" aria-label="Close Donate Modal" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-red-50 hover:text-[#c8102e] flex items-center justify-center transition">
          <i class="ri-close-line text-lg"></i>
        </button>
      </div>

      <form onsubmit="submitDonationForm(event)" class="mt-4 space-y-3 sm:space-y-4">
        <div>
          <label class="block text-xs font-bold text-gray-700 mb-1.5">অনুদানের পরিমাণ নির্বাচন করুন (টাকা)</label>
          <div class="grid grid-cols-4 gap-1.5 sm:gap-2 mb-2">
            <button type="button" onclick="selectDonateAmount('৫০০', this)" class="donate-preset-btn py-1.5 text-xs font-bold rounded-lg border border-gray-200 bg-gray-50 text-gray-700">৳৫০০</button>
            <button type="button" onclick="selectDonateAmount('১০০০', this)" class="donate-preset-btn py-1.5 text-xs font-bold rounded-lg border border-[#c8102e] bg-[#c8102e] text-white">৳১০০০</button>
            <button type="button" onclick="selectDonateAmount('২৫০০', this)" class="donate-preset-btn py-1.5 text-xs font-bold rounded-lg border border-gray-200 bg-gray-50 text-gray-700">৳২৫০০</button>
            <button type="button" onclick="selectDonateAmount('৫০০০', this)" class="donate-preset-btn py-1.5 text-xs font-bold rounded-lg border border-gray-200 bg-gray-50 text-gray-700">৳৫০০০</button>
          </div>
          <input id="donate-amount-input" type="text" value="১০০০" required class="w-full px-3 py-2 rounded-lg border border-gray-300 text-xs sm:text-sm focus:outline-none focus:border-[#c8102e]" placeholder="অন্য পরিমাণ লিখুন" />
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-700 mb-1">আপনার নাম</label>
          <input id="donor-name" type="text" required class="w-full px-3 py-2 rounded-lg border border-gray-300 text-xs sm:text-sm focus:outline-none focus:border-[#c8102e]" placeholder="আপনার পূর্ণ নাম লিখুন" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div>
            <label class="block text-xs font-bold text-gray-700 mb-1">মোবাইল নম্বর</label>
            <input type="tel" required class="w-full px-3 py-2 rounded-lg border border-gray-300 text-xs sm:text-sm focus:outline-none focus:border-[#c8102e]" placeholder="017XXXXXXXX" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-700 mb-1">মাধ্যম</label>
            <select id="donate-method" class="w-full px-3 py-2 rounded-lg border border-gray-300 text-xs sm:text-sm focus:outline-none focus:border-[#c8102e]">
              <option value="bKash">বিকাশ (bKash)</option>
              <option value="Nagad">নগদ (Nagad)</option>
              <option value="Bank">ব্যাংক ট্রান্সফার</option>
            </select>
          </div>
        </div>

        <div id="donate-feedback" class="hidden p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold"></div>

        <button type="submit" class="w-full bg-[#c8102e] hover:bg-[#a30b24] text-white text-sm font-bold py-2.5 rounded-lg shadow transition">
          অনুদান নিশ্চিত করুন
        </button>
      </form>
    </div>
  </div>

  <!-- 3. Video Preview Modal (Responsive Video Pop-up with Live Player) -->
  <div id="video-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 p-3 sm:p-5 backdrop-blur-sm animate-fadeIn">
    <div class="bg-white rounded-2xl max-w-3xl w-full overflow-hidden shadow-2xl border border-gray-100 flex flex-col">
      <!-- Modal Header -->
      <div class="flex items-center justify-between px-4 sm:px-6 py-3.5 border-b border-gray-100 bg-gray-50/80">
        <h3 class="text-sm sm:text-base font-extrabold text-[#0b4622] flex items-center gap-2">
          <i class="fa-solid fa-circle-play text-[#c8102e] text-lg"></i>
          <span>আগামীর শৈলকুপা — প্রামাণ্যচিত্র</span>
        </h3>
        <button type="button" onclick="closeVideoModal()" aria-label="Close Video Modal" class="w-8 h-8 rounded-full bg-gray-200/80 hover:bg-red-50 hover:text-[#c8102e] flex items-center justify-center transition cursor-pointer">
          <i class="ri-close-line text-xl"></i>
        </button>
      </div>

      <!-- Responsive Video Player Container (16:9 Aspect Ratio) -->
      <div class="relative w-full aspect-video bg-black">
        <iframe
          id="video-modal-iframe"
          class="w-full h-full"
          src=""
          data-src="https://www.youtube-nocookie.com/embed/hbcHJKGnXRk?autoplay=1&rel=0&modestbranding=1"
          title="আগামীর শৈলকুপা প্রামাণ্যচিত্র"
          frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
          allowfullscreen
        ></iframe>
      </div>

      <!-- Modal Footer -->
      <div class="px-4 sm:px-6 py-3 bg-gray-50 flex flex-col sm:flex-row items-center justify-between gap-2 border-t border-gray-100">
        <p class="text-xs text-gray-600 font-medium">ঐতিহাসিক শৈলকুপা শাহী মসজিদ ও ঐতিহ্যবাহী শৈলকুপার প্রামাণ্য তথ্যচিত্র</p>
        <button type="button" onclick="closeVideoModal()" class="bg-[#c8102e] hover:bg-[#a30b24] text-white text-xs font-bold px-4 py-1.5 rounded-lg transition cursor-pointer">
          বন্ধ করুন
        </button>
      </div>
    </div>
  </div>

  <!-- Main Script with Auto-Cache Busting -->
  <script src="{{ asset('assets/js/main.js') }}?v={{ file_exists(public_path('assets/js/main.js')) ? filemtime(public_path('assets/js/main.js')) : time() }}"></script>
  @stack('scripts')
</body>
</html>
