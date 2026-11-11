<!-- =====================================================================
     2. MAIN NAVIGATION BAR (Responsive Mobile + Desktop)
     ===================================================================== -->
<header class="bg-white sticky top-0 z-40 shadow-[0_2px_10px_rgba(0,0,0,0.06)]">
  <div class="max-w-[1220px] mx-auto px-3 sm:px-6 h-[64px] sm:h-[76px] flex items-center justify-between gap-2 sm:gap-4">
    <!-- Brand Logo -->
    <a href="#hero-section" class="flex items-center gap-2 sm:gap-3 group shrink-0 py-1">
      <img src="{{ asset('assets/images/logo-icon.png') }}" alt="আগামীর শৈলকুপা লোগো" class="w-9 h-9 sm:w-12 sm:h-12 object-contain shrink-0" />
      <div class="flex flex-col justify-center py-0.5">
        <span class="block text-[19px] sm:text-[23px] md:text-[26px] font-extrabold text-[#b91c1c] tracking-normal leading-[1.3] pt-0.5">
          আগামীর শৈলকুপা
        </span>
        <span class="hidden sm:block text-[11px] sm:text-[12.5px] font-semibold text-[#0b4622] leading-tight mt-0.5">
          শৈলকুপার উন্নয়নে আমরা এক পরিবার
        </span>
      </div>
    </a>

    <!-- Desktop Menu -->
    <nav class="hidden lg:flex items-center gap-1 xl:gap-2 text-[15px] font-semibold text-gray-800">
      <a href="#hero-section" class="bg-[#c8102e] text-white px-4 py-1.5 rounded-[6px] shadow-sm hover:bg-[#a30b24] transition">
        হোম
      </a>

      <!-- Dropdown Menu Item -->
      <div class="relative group">
        <button type="button" onclick="document.getElementById('about-section').scrollIntoView({behavior:'smooth'})" class="px-3.5 py-1.5 rounded-[6px] hover:text-[#c8102e] inline-flex items-center gap-1 transition">
          <span>আমাদের সম্পর্কে</span>
          <i class="ri-arrow-down-s-line text-[#c8102e] text-base transition-transform group-hover:rotate-180"></i>
        </button>
        <div class="absolute left-0 top-full pt-2 w-52 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
          <div class="bg-white rounded-xl shadow-lg border border-gray-100 py-2 text-sm">
            <a href="#about-section" class="block px-4 py-2 hover:bg-red-50 hover:text-[#c8102e] transition">আমাদের লক্ষ্য ও উদ্দেশ্য</a>
            <a href="#president-section" class="block px-4 py-2 hover:bg-red-50 hover:text-[#c8102e] transition">সভাপতির বাণী</a>
            <a href="#personalities-section" class="block px-4 py-2 hover:bg-red-50 hover:text-[#c8102e] transition">সম্মানিত ব্যক্তিবর্গ</a>
            <a href="#committee-section" class="block px-4 py-2 hover:bg-red-50 hover:text-[#c8102e] transition">কার্যনির্বাহী কমিটি</a>
          </div>
        </div>
      </div>

      <a href="#notice-section" class="px-3.5 py-1.5 rounded-[6px] hover:text-[#c8102e] transition">
        নোটিশ
      </a>
      <a href="#gallery-section" class="px-3.5 py-1.5 rounded-[6px] hover:text-[#c8102e] transition">
        গ্যালারি
      </a>
      <a href="#events-section" class="px-3.5 py-1.5 rounded-[6px] hover:text-[#c8102e] transition">
        কার্যক্রম
      </a>
      <a href="#footer-section" class="px-3.5 py-1.5 rounded-[6px] hover:text-[#c8102e] transition">
        যোগাযোগ
      </a>
    </nav>

    <!-- Right Donate Button & Mobile Hamburger -->
    <div class="flex items-center gap-2 sm:gap-3 shrink-0">
      <button type="button" onclick="openDonateModal()" class="inline-flex items-center bg-[#146c32] hover:bg-[#0f5426] text-white rounded-full p-0.5 pr-3 sm:pr-4 shadow-sm transition group">
        <span class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-[#c8102e] flex items-center justify-center shadow-inner group-hover:scale-105 transition">
          <i class="fa-solid fa-heart text-white text-[11px] sm:text-xs"></i>
        </span>
        <span class="pl-1.5 sm:pl-2.5 text-xs sm:text-sm font-bold tracking-wide">অনুদান</span>
      </button>

      <!-- Mobile Menu Button -->
      <button type="button" onclick="toggleMobileMenu()" aria-label="Toggle Menu" class="lg:hidden w-9 h-9 sm:w-10 sm:h-10 rounded-lg border border-gray-200 flex items-center justify-center text-gray-700 hover:bg-gray-50 hover:text-[#c8102e] transition">
        <i id="mobile-menu-icon" class="ri-menu-3-line text-lg sm:text-xl"></i>
      </button>
    </div>
  </div>

  <!-- Mobile Responsive Navigation Drawer -->
  <div id="mobile-menu" class="hidden lg:hidden bg-white border-t border-gray-100 px-4 pt-3 pb-5 shadow-lg max-h-[calc(100vh-70px)] overflow-y-auto">
    <div class="flex flex-col space-y-1.5 text-[15px] font-semibold">
      <a href="#hero-section" class="mobile-nav-link bg-[#c8102e] text-white px-4 py-2.5 rounded-lg">হোম</a>
      <div>
        <button type="button" onclick="toggleMobileSubmenu()" class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-gray-800 hover:bg-gray-50">
          <span>আমাদের সম্পর্কে</span>
          <i id="mobile-submenu-arrow" class="ri-arrow-down-s-line text-[#c8102e] text-lg transition-transform"></i>
        </button>
        <div id="mobile-about-submenu" class="hidden pl-6 pr-2 py-1 space-y-1 text-sm text-gray-600 border-l-2 border-red-200 ml-4 mt-1">
          <a href="#about-section" class="mobile-nav-link block py-1.5 hover:text-[#c8102e]">আমাদের লক্ষ্য ও উদ্দেশ্য</a>
          <a href="#president-section" class="mobile-nav-link block py-1.5 hover:text-[#c8102e]">সভাপতির বাণী</a>
          <a href="#personalities-section" class="mobile-nav-link block py-1.5 hover:text-[#c8102e]">সম্মানিত ব্যক্তিবর্গ</a>
          <a href="#committee-section" class="mobile-nav-link block py-1.5 hover:text-[#c8102e]">কার্যনির্বাহী কমিটি</a>
        </div>
      </div>
      <a href="#notice-section" class="mobile-nav-link px-4 py-2.5 rounded-lg hover:bg-gray-50">নোটিশ</a>
      <a href="#gallery-section" class="mobile-nav-link px-4 py-2.5 rounded-lg hover:bg-gray-50">গ্যালারি</a>
      <a href="#events-section" class="mobile-nav-link px-4 py-2.5 rounded-lg hover:bg-gray-50">কার্যক্রম</a>
      <a href="#footer-section" class="mobile-nav-link px-4 py-2.5 rounded-lg hover:bg-gray-50">যোগাযোগ</a>
    </div>
  </div>
</header>
