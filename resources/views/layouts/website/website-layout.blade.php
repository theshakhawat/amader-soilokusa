<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
  @php
    $siteSetting = \App\Models\SiteSetting::first();
    $defaultTitle = ($siteSetting && $siteSetting->site_title) ? ($siteSetting->site_title . ' — ' . ($siteSetting->site_tagline ?? 'শৈলকুপার উন্নয়নে আমরা এক পরিবার')) : 'আগামীর শৈলকুপা — শৈলকুপার উন্নয়নে আমরা এক পরিবার';
  @endphp
  <title>@yield('title', $defaultTitle)</title>

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ $siteSetting ? $siteSetting->favicon_url : asset('assets/images/logo-icon.png') }}" />
  <link rel="shortcut icon" href="{{ $siteSetting ? $siteSetting->favicon_url : asset('assets/images/logo-icon.png') }}" />

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
<body class="bg-[#f4f5f7] text-gray-800 antialiased selection:bg-[#c8102e] selection:text-white w-full">

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
  <div id="info-modal" class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/60 p-3 sm:p-4 backdrop-blur-xs">
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

  <!-- 2. Donate Modal (ডিজি পে / DGePay কাস্টম অ্যামাউন্ট অনুদান ফরম) -->
  <div id="donate-modal" class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/60 p-3 sm:p-4 backdrop-blur-xs">
    <div class="bg-white rounded-2xl max-w-md w-full p-4 sm:p-6 shadow-2xl border border-gray-100 max-h-[92vh] overflow-y-auto">
      <div class="flex items-center justify-between border-b border-gray-100 pb-3">
        <div class="flex items-center gap-2 text-[#c8102e] font-extrabold text-base sm:text-lg">
          <i class="fa-solid fa-hand-holding-heart"></i>
          <span>অনুদান ফরম</span>
        </div>
        <button type="button" onclick="closeDonateModal()" aria-label="Close Donate Modal" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-red-50 hover:text-[#c8102e] flex items-center justify-center transition cursor-pointer">
          <i class="ri-close-line text-lg"></i>
        </button>
      </div>

      <form action="{{ route('donations.initiate') }}" method="POST" id="donation-checkout-form" onsubmit="handleDonationSubmit(event)" class="mt-4 space-y-4">
        @csrf

        {{-- Custom Amount Field (Default 1,000 Tk) --}}
        <div>
          <label for="donate-amount-input" class="block text-xs font-bold text-gray-700 mb-1.5">
            অনুদানের পরিমাণ (টাকা) <span class="text-red-500">*</span>
          </label>
          <div class="relative">
            <span class="absolute left-3.5 top-2.5 text-gray-500 font-bold text-base">৳</span>
            <input id="donate-amount-input"
                   name="amount"
                   type="number"
                   min="10"
                   step="any"
                   value="1000"
                   required
                   class="w-full pl-8 pr-3.5 py-2.5 rounded-xl border border-gray-300 text-sm font-black text-gray-900 focus:outline-none focus:border-[#c8102e] shadow-2xs"
                   placeholder="অনুদানের পরিমাণ লিখুন (উদাঃ ১০০০)" />
          </div>
          <p class="text-[11px] text-gray-400 mt-1">আপনি আপনার সুবিধামতো যেকোনো পরিমাণ অনুদান প্রদান করতে পারেন।</p>
        </div>

        {{-- Donor Name --}}
        <div>
          <label for="donor-name" class="block text-xs font-bold text-gray-700 mb-1.5">
            আপনার নাম <span class="text-red-500">*</span>
          </label>
          <input id="donor-name"
                 name="name"
                 type="text"
                 required
                 class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-xs sm:text-sm focus:outline-none focus:border-[#c8102e] shadow-2xs"
                 placeholder="আপনার পূর্ণ নাম লিখুন" />
        </div>

        {{-- Donor Mobile Number --}}
        <div>
          <label for="donor-phone" class="block text-xs font-bold text-gray-700 mb-1.5">
            মোবাইল নম্বর <span class="text-red-500">*</span>
          </label>
          <input id="donor-phone"
                 name="phone"
                 type="tel"
                 required
                 class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-xs sm:text-sm focus:outline-none focus:border-[#c8102e] shadow-2xs"
                 placeholder="017XXXXXXXX" />
        </div>

        <div class="pt-1">
          <button type="submit"
                  id="donation-submit-btn"
                  class="w-full bg-[#c8102e] hover:bg-[#a30b24] text-white text-sm font-bold py-3 rounded-xl shadow-md hover:shadow-lg transition flex items-center justify-center gap-2 cursor-pointer">
            <i class="ri-secure-payment-line text-lg" id="donation-btn-icon"></i>
            <span id="donation-btn-text">অনুদান নিশ্চিত করুন</span>
          </button>
        </div>

        <p class="text-[11px] text-gray-400 text-center flex items-center justify-center gap-1">
          <i class="ri-shield-check-line text-emerald-600"></i>
          <span>ডিজি পে (DGePay) সিকিউর পেমেন্ট গেটওয়ের মাধ্যমে পরিচালিত</span>
        </p>
      </form>
    </div>
  </div>

  {{-- 2.1 Donation Result Feedback Modal (Success or Failed Popup) --}}
  @if(session('donation_result'))
    <div id="donation-result-modal" class="fixed inset-0 z-[999] flex items-center justify-center bg-black/70 p-3 sm:p-4 backdrop-blur-xs animate-fadeIn">
      <div class="bg-white rounded-2xl max-w-md w-full p-6 sm:p-7 shadow-2xl border border-gray-100 text-center relative overflow-hidden">
        @if(session('donation_result') === 'success')
          {{-- Top accent bar --}}
          <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-emerald-500 to-green-600"></div>

          <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-3xl mx-auto mb-4 border border-emerald-100 shadow-xs">
            <i class="ri-checkbox-circle-fill"></i>
          </div>

          <h3 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight">ধন্যবাদ!</h3>
          <p class="text-sm font-bold text-emerald-700 mt-1">আপনার অনুদান সফলভাবে সম্পন্ন হয়েছে</p>
          <p class="text-xs text-gray-500 mt-1">আগামীর শৈলকুপার উন্নয়নমূলক কার্যক্রমে আপনার অনুদান অত্যন্ত মূল্যবান।</p>

          @if(session('donation_data'))
            <div class="bg-gray-50 rounded-xl p-4 my-4 border border-gray-100 text-left text-xs space-y-2">
              <div class="flex justify-between border-b border-gray-200/60 pb-1.5">
                <span class="text-gray-500 font-medium">দাতার নাম:</span>
                <span class="font-bold text-gray-900">{{ session('donation_data.donor_name') }}</span>
              </div>
              <div class="flex justify-between border-b border-gray-200/60 pb-1.5">
                <span class="text-gray-500 font-medium">মোবাইল নম্বর:</span>
                <span class="font-semibold text-gray-800">{{ session('donation_data.donor_phone') }}</span>
              </div>
              <div class="flex justify-between border-b border-gray-200/60 pb-1.5">
                <span class="text-gray-500 font-medium">অনুদানের পরিমাণ:</span>
                <span class="font-black text-[#0b4622] text-sm">৳{{ number_format(session('donation_data.amount'), 2) }}</span>
              </div>
              <div class="flex justify-between border-b border-gray-200/60 pb-1.5">
                <span class="text-gray-500 font-medium">ট্রানজ্যাকশন আইডি:</span>
                <span class="font-mono font-bold text-gray-800">{{ session('donation_data.trx_id') }}</span>
              </div>
              @if(!empty(session('donation_data.gateway_trx_id')))
                <div class="flex justify-between border-b border-gray-200/60 pb-1.5">
                  <span class="text-gray-500 font-medium">গেটওয়ে Trx ID:</span>
                  <span class="font-mono text-gray-700">{{ session('donation_data.gateway_trx_id') }}</span>
                </div>
              @endif
              <div class="flex justify-between pt-0.5">
                <span class="text-gray-500 font-medium">তারিখ ও সময়:</span>
                <span class="text-gray-700">{{ session('donation_data.date') }}</span>
              </div>
            </div>
          @endif

          <button type="button"
                  onclick="closeDonationResultModal()"
                  class="w-full bg-[#0b4622] hover:bg-[#08351a] text-white text-xs sm:text-sm font-bold py-2.5 rounded-xl shadow-xs transition cursor-pointer">
            ঠিক আছে
          </button>
        @else
          {{-- Failed / Cancelled --}}
          <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-red-500 to-rose-600"></div>

          <div class="w-16 h-16 rounded-full bg-red-50 text-red-600 flex items-center justify-center text-3xl mx-auto mb-4 border border-red-100 shadow-xs">
            <i class="ri-error-warning-fill"></i>
          </div>

          <h3 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight">দুঃখিত!</h3>
          <p class="text-sm font-bold text-red-600 mt-1">অনুদানটি সম্পন্ন করা সম্ভব হয়নি</p>
          <p class="text-xs text-gray-600 mt-2 bg-red-50/50 p-3 rounded-xl border border-red-100">
            {{ session('donation_message') ?? 'পেমেন্ট গেটওয়েতে লেনদেন বাতিল বা ব্যর্থ হয়েছে।' }}
          </p>

          <div class="flex items-center gap-2 mt-5">
            <button type="button"
                    onclick="closeDonationResultModal()"
                    class="w-1/2 px-4 py-2.5 border border-gray-300 text-gray-700 text-xs sm:text-sm font-bold rounded-xl hover:bg-gray-50 transition cursor-pointer">
              বন্ধ করুন
            </button>
            <button type="button"
                    onclick="retryDonation()"
                    class="w-1/2 bg-[#c8102e] hover:bg-[#a30b24] text-white text-xs sm:text-sm font-bold py-2.5 rounded-xl shadow-xs transition cursor-pointer">
              পুনরায় চেষ্টা করুন
            </button>
          </div>
        @endif
      </div>
    </div>
  @endif

  <!-- 3. Video Preview Modal (Responsive Video Pop-up with Live Player) -->
  <div id="video-modal" class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/80 p-3 sm:p-5 backdrop-blur-sm animate-fadeIn">
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
