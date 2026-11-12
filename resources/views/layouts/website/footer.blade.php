<!-- =====================================================================
     10. FOOTER SECTION (Fully Responsive & Dynamic from Admin Settings)
     ===================================================================== -->
@php
  $footerSetting = \App\Models\FooterSetting::first();
  $footerContact = \App\Models\ContactSetting::first();
  $footerSocialLinks = \App\Models\SocialLink::where('is_active', true)->orderBy('order')->orderBy('id')->get();

  $brandTitle = $footerSetting->brand_title ?? 'আগামীর শৈলকুপা';
  $brandSubtitle = $footerSetting->brand_subtitle ?? 'শৈলকুপার উন্নয়নে আমরা এক পরিবার';
  $aboutText = $footerSetting->about_text ?? 'শৈলকুপার সার্বিক উন্নয়ন, ঐতিহ্য সংরক্ষণ ও মানুষের কল্যাণে নিবেদিত একটি সামাজিক উদ্যোগ।';
  $showSocialLinks = $footerSetting ? $footerSetting->show_social_links : true;

  $quickLinksTitle = $footerSetting->quick_links_title ?? 'দ্রুত লিংক';
  $quickLinks = $footerSetting->quick_links ?? [
    ['label' => 'হোম', 'url' => '#hero-section'],
    ['label' => 'আমাদের সম্পর্কে', 'url' => '/page/aboutus'],
    ['label' => 'নোটিশ', 'url' => '#notice-section'],
    ['label' => 'কার্যক্রম', 'url' => '#events-section'],
    ['label' => 'গ্যালারি', 'url' => '#gallery-section'],
  ];

  $importantLinksTitle = $footerSetting->important_links_title ?? 'গুরুত্বপূর্ণ লিংক';
  $importantLinks = $footerSetting->important_links ?? [
    ['label' => 'কমিটি', 'url' => '#committee-section'],
    ['label' => 'উন্নয়ন প্রকল্পসমূহ', 'url' => '#projects-section'],
    ['label' => 'দর্শনীয় স্থান', 'url' => '#projects-section'],
    ['label' => 'ব্লগ', 'url' => '#blog-section'],
    ['label' => 'যোগাযোগ', 'url' => '#contact-section'],
  ];

  $contactTitle = $footerSetting->contact_title ?? 'যোগাযোগ';
  $copyrightText = $footerSetting->copyright_text ?? '© ২০২৬ আগামীর শৈলকুপা। সর্বস্বত্ব সংরক্ষিত।';
  $privacyPolicyText = $footerSetting->privacy_policy_text ?? 'গোপনীয়তা নীতি';
  $privacyPolicyLink = $footerSetting->privacy_policy_link ?? '#';
  $termsText = $footerSetting->terms_text ?? 'ব্যবহারের শর্তাবলী';
  $termsLink = $footerSetting->terms_link ?? '#';
@endphp
<footer id="footer-section" class="bg-[#07381b] text-white relative overflow-hidden mt-6">
  <!-- Subtle Decorative Tree Silhouette Watermark on Right -->
  <div class="max-w-[1220px] mx-auto px-4 sm:px-6 pt-8 pb-7 sm:pt-11 sm:pb-8 relative z-10">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-6 sm:gap-8">

      <!-- Col 1: Brand Info (4 Cols) -->
      <div class="lg:col-span-4">
        <a href="#hero-section" class="flex items-center gap-2.5 sm:gap-3 py-1">
          <!-- White Emblem SVG matching Logo -->
          <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-white/10 border border-white/20 flex items-center justify-center shrink-0">
            <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" viewBox="0 0 64 64" fill="currentColor">
              <circle cx="32" cy="14" r="6" />
              <path d="M32 22 C24 22, 18 28, 18 36 C23 36, 28 32, 32 26 C36 32, 41 36, 46 36 C46 28, 40 22, 32 22 Z" />
              <path d="M10 34 C10 46, 20 54, 32 54 C44 54, 54 46, 54 34 C48 38, 40 42, 32 42 C24 42, 16 38, 10 34 Z" />
            </svg>
          </div>
          <div class="flex flex-col justify-center">
            <span class="block text-lg sm:text-[23px] font-extrabold text-white leading-normal pt-0.5">
              {{ $brandTitle }}
            </span>
            @if(!empty($brandSubtitle))
            <span class="block text-[11px] sm:text-[11.5px] text-emerald-200/90 mt-0.5">
              {{ $brandSubtitle }}
            </span>
            @endif
          </div>
        </a>

        @if(!empty($aboutText))
        <p class="text-white/80 text-xs sm:text-[13.5px] leading-relaxed mt-3.5 max-w-sm">
          {{ $aboutText }}
        </p>
        @endif

        <!-- Footer Social Links -->
        @if($showSocialLinks && $footerSocialLinks->count() > 0)
        <div class="flex items-center gap-2 mt-4 sm:mt-5">
          @foreach($footerSocialLinks as $social)
            <a
              href="{{ $social->url }}"
              target="{{ $social->target }}"
              aria-label="{{ $social->platform }}"
              class="w-7 h-7 rounded-[6px] bg-white text-[#07381b] flex items-center justify-center hover:bg-emerald-50 hover:scale-105 transition shadow-2xs"
            >
              <i class="{{ $social->icon }} text-xs"></i>
            </a>
          @endforeach
        </div>
        @endif
      </div>

      <!-- Col 2: দ্রুত লিংক -->
      <div class="lg:col-span-2">
        <h3 class="text-sm sm:text-[16px] font-extrabold text-white mb-2.5 sm:mb-3.5">{{ $quickLinksTitle }}</h3>
        <ul class="space-y-1.5 sm:space-y-2 text-xs sm:text-[13.5px] text-white/85">
          @foreach($quickLinks as $link)
            @if(!empty($link['label']))
            <li>
              <a href="{{ $link['url'] ?? '#' }}" class="hover:text-white inline-flex items-center gap-1.5 transition">
                <i class="ri-arrow-right-s-line text-emerald-300"></i>
                <span>{{ $link['label'] }}</span>
              </a>
            </li>
            @endif
          @endforeach
        </ul>
      </div>

      <!-- Col 3: গুরুত্বপূর্ণ লিংক -->
      <div class="lg:col-span-3">
        <h3 class="text-sm sm:text-[16px] font-extrabold text-white mb-2.5 sm:mb-3.5">{{ $importantLinksTitle }}</h3>
        <ul class="space-y-1.5 sm:space-y-2 text-xs sm:text-[13.5px] text-white/85">
          @foreach($importantLinks as $link)
            @if(!empty($link['label']))
            <li>
              <a href="{{ $link['url'] ?? '#' }}" class="hover:text-white inline-flex items-center gap-1.5 transition">
                <i class="ri-arrow-right-s-line text-emerald-300"></i>
                <span>{{ $link['label'] }}</span>
              </a>
            </li>
            @endif
          @endforeach
        </ul>
      </div>

      <!-- Col 4: যোগাযোগ -->
      <div class="lg:col-span-3">
        <h3 class="text-sm sm:text-[16px] font-extrabold text-white mb-2.5 sm:mb-3.5">{{ $contactTitle }}</h3>
        <ul class="space-y-2 text-xs sm:text-[13.5px] text-white/85">
          @if(!empty($footerContact->location))
          <li class="flex items-start gap-2">
            <i class="fa-solid fa-location-dot text-white mt-0.5"></i>
            <span>{{ $footerContact->location }}</span>
          </li>
          @endif

          @if(!empty($footerContact->phone))
          <li class="flex items-center gap-2">
            <i class="fa-solid fa-phone text-white"></i>
            <a href="tel:{{ $footerContact->phone }}" class="font-sans hover:text-white transition">{{ $footerContact->phone }}</a>
          </li>
          @endif

          @if(!empty($footerContact->email))
          <li class="flex items-center gap-2">
            <i class="fa-solid fa-envelope text-white"></i>
            <a href="mailto:{{ $footerContact->email }}" class="font-sans hover:text-white transition">{{ $footerContact->email }}</a>
          </li>
          @endif
        </ul>
      </div>

    </div>
  </div>

  <!-- Bottom Copyright Bar -->
  <div class="bg-[#052913] border-t border-white/10 py-3 text-[11px] sm:text-xs text-white/75">
    <div class="max-w-[1220px] mx-auto px-4 sm:px-6 flex flex-col sm:flex-row items-center justify-between gap-2 text-center sm:text-left">
      <p>{{ $copyrightText }}</p>
      <div class="flex items-center gap-2.5 sm:gap-3">
        @if(!empty($privacyPolicyText))
          <a href="{{ $privacyPolicyLink }}" class="hover:text-white transition">{{ $privacyPolicyText }}</a>
        @endif
        @if(!empty($privacyPolicyText) && !empty($termsText))
          <span>|</span>
        @endif
        @if(!empty($termsText))
          <a href="{{ $termsLink }}" class="hover:text-white transition">{{ $termsText }}</a>
        @endif
      </div>
    </div>
  </div>
</footer>
