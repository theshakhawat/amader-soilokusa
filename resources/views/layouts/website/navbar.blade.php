<!-- =====================================================================
     2. MAIN NAVIGATION BAR (Responsive Mobile + Desktop)
     ===================================================================== -->
<header class="bg-white sticky top-0 z-40 shadow-[0_2px_10px_rgba(0,0,0,0.06)]">
  <div class="max-w-[1220px] mx-auto px-3 sm:px-6 h-[64px] sm:h-[76px] flex items-center justify-between gap-2 sm:gap-4">
    @php
      $navBranding = \App\Models\SiteSetting::first();
      $navLogo = $navBranding ? $navBranding->header_logo_url : asset('assets/images/logo-icon.png');
      $navTitle = $navBranding ? $navBranding->site_title : 'আগামীর শৈলকুপা';
      $navTagline = $navBranding ? $navBranding->site_tagline : 'শৈলকুপার উন্নয়নে আমরা এক পরিবার';
    @endphp
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="flex items-center gap-2 sm:gap-3 group shrink-0 py-1">
      <img src="{{ $navLogo }}" alt="{{ $navTitle }} লোগো" class="w-9 h-9 sm:w-12 sm:h-12 object-contain shrink-0" />
      <div class="flex flex-col justify-center py-0.5">
        <span class="block text-[19px] sm:text-[23px] md:text-[26px] font-extrabold text-[#b91c1c] tracking-normal leading-[1.3] pt-0.5">
          {{ $navTitle }}
        </span>
        @if($navTagline)
          <span class="hidden sm:block text-[11px] sm:text-[12.5px] font-semibold text-[#0b4622] leading-tight mt-0.5">
            {{ $navTagline }}
          </span>
        @endif
      </div>
    </a>

    <!-- Desktop Menu -->
    <nav class="hidden lg:flex items-center gap-1 xl:gap-2 text-[15px] font-semibold text-gray-800">
      <a href="{{ route('home') }}" class="bg-[#c8102e] text-white px-4 py-1.5 rounded-[6px] shadow-sm hover:bg-[#a30b24] transition">
        হোম
      </a>

      <!-- Dropdown Menu Item -->
      <div class="relative group">
        <button type="button" onclick="document.getElementById('about-section')?.scrollIntoView({behavior:'smooth'})" class="px-3.5 py-1.5 rounded-[6px] hover:text-[#c8102e] inline-flex items-center gap-1 transition">
          <span>আমাদের সম্পর্কে</span>
          <i class="ri-arrow-down-s-line text-[#c8102e] text-base transition-transform group-hover:rotate-180"></i>
        </button>
        <div class="absolute left-0 top-full pt-2 w-52 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
          <div class="bg-white rounded-xl shadow-lg border border-gray-100 py-2 text-sm">
            <a href="{{ route('home') }}#about-section" class="block px-4 py-2 hover:bg-red-50 hover:text-[#c8102e] transition">আমাদের লক্ষ্য ও উদ্দেশ্য</a>
            <a href="{{ route('home') }}#president-section" class="block px-4 py-2 hover:bg-red-50 hover:text-[#c8102e] transition">সভাপতির বাণী</a>
            <a href="{{ route('home') }}#personalities-section" class="block px-4 py-2 hover:bg-red-50 hover:text-[#c8102e] transition">সম্মানিত ব্যক্তিবর্গ</a>
            <a href="{{ route('home') }}#committee-section" class="block px-4 py-2 hover:bg-red-50 hover:text-[#c8102e] transition">কার্যনির্বাহী কমিটি</a>
          </div>
        </div>
      </div>

      <a href="{{ route('home') }}#notice-section" class="px-3.5 py-1.5 rounded-[6px] hover:text-[#c8102e] transition">
        নোটিশ
      </a>
      <a href="{{ route('home') }}#gallery-section" class="px-3.5 py-1.5 rounded-[6px] hover:text-[#c8102e] transition">
        গ্যালারি
      </a>
      <a href="{{ route('home') }}#events-section" class="px-3.5 py-1.5 rounded-[6px] hover:text-[#c8102e] transition">
        কার্যক্রম
      </a>
      <a href="{{ route('contact.index') }}" class="px-3.5 py-1.5 rounded-[6px] hover:text-[#c8102e] transition {{ request()->routeIs('contact*') ? 'text-[#c8102e] font-extrabold' : '' }}">
        যোগাযোগ
      </a>
    </nav>

    <!-- Right Action Buttons (Donate + Login + Mobile Toggle) -->
    <div class="flex items-center gap-2 sm:gap-3 shrink-0">
      <!-- Donate Button -->
      <button type="button" onclick="openDonateModal()" class="inline-flex items-center bg-[#146c32] hover:bg-[#0f5426] text-white rounded-full p-0.5 pr-3 sm:pr-4 shadow-sm transition group cursor-pointer">
        <span class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-[#c8102e] flex items-center justify-center shadow-inner group-hover:scale-105 transition">
          <i class="fa-solid fa-heart text-white text-[11px] sm:text-xs"></i>
        </span>
        <span class="pl-1.5 sm:pl-2.5 text-xs sm:text-sm font-bold tracking-wide">অনুদান</span>
      </button>

      <!-- Desktop Login Link / User Dropdown Avatar -->
      @guest
        <a href="{{ route('login') }}" class="hidden lg:inline-flex items-center gap-1.5 border border-[#c8102e] text-[#c8102e] hover:bg-[#c8102e] hover:text-white text-xs sm:text-sm font-bold px-3.5 py-1.5 rounded-full shadow-xs transition">
          <i class="fa-regular fa-user text-xs"></i>
          <span>লগইন</span>
        </a>
      @else
        <!-- Desktop User Dropdown Avatar (Only user image & dropdown arrow) -->
        <div class="hidden lg:block relative" id="desktop-user-dropdown-container">
          <button
            type="button"
            id="desktop-user-menu-btn"
            onclick="toggleDesktopUserDropdown(event)"
            class="flex items-center gap-1.5 p-1 rounded-full border border-gray-200 hover:border-[#0b4622] transition focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 cursor-pointer bg-white"
            aria-expanded="false"
            aria-haspopup="true"
          >
            @if(Auth::user()->photo)
              <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="{{ Auth::user()->name }}" class="w-9 h-9 rounded-full object-cover shadow-xs border border-gray-100" />
            @else
              <div class="w-9 h-9 rounded-full bg-[#0b4622] text-white flex items-center justify-center font-bold text-sm shadow-xs">
                {{ mb_substr(Auth::user()->name, 0, 1) }}
              </div>
            @endif
            <i class="ri-arrow-down-s-line text-gray-500 text-sm pr-1"></i>
          </button>

          <!-- Dropdown Menu -->
          <div
            id="desktop-user-dropdown-menu"
            class="hidden absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50 text-sm animate-fadeIn"
          >
            <!-- User Info Header -->
            <div class="px-4 py-2.5 border-b border-gray-100 bg-gray-50/60 rounded-t-2xl">
              <p class="font-extrabold text-gray-900 truncate leading-tight">{{ Auth::user()->name }}</p>
              <p class="text-xs text-gray-500 truncate mt-0.5">{{ Auth::user()->email }}</p>
            </div>

            <div class="py-1">
              <!-- আমার প্রোফাইল -->
              <a href="{{ route('home') }}" class="flex items-center gap-2.5 px-4 py-2 text-gray-700 hover:bg-emerald-50 hover:text-[#0b4622] font-semibold transition">
                <i class="fa-regular fa-circle-user text-base text-gray-400"></i>
                <span>আমার প্রোফাইল</span>
              </a>

              <!-- পাসওয়ার্ড পরিবর্তন -->
              <a href="{{ route('home') }}" class="flex items-center gap-2.5 px-4 py-2 text-gray-700 hover:bg-emerald-50 hover:text-[#0b4622] font-semibold transition">
                <i class="fa-solid fa-key text-base text-gray-400"></i>
                <span>পাসওয়ার্ড পরিবর্তন</span>
              </a>

              <!-- ড্যাশবোর্ডে যান -->
              <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2 text-gray-700 hover:bg-emerald-50 hover:text-[#0b4622] font-semibold transition">
                <i class="fa-solid fa-gauge text-base text-gray-400"></i>
                <span>ড্যাশবোর্ডে যান</span>
              </a>
            </div>

            <div class="border-t border-gray-100 pt-1">
              <!-- লগআউট -->
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left flex items-center gap-2.5 px-4 py-2 text-[#c8102e] hover:bg-red-50 font-bold transition cursor-pointer">
                  <i class="fa-solid fa-arrow-right-from-bracket text-base"></i>
                  <span>লগআউট করুন</span>
                </button>
              </form>
            </div>
          </div>
        </div>
      @endguest

      <!-- Mobile Menu Button (Hamburger toggle - always visible on mobile/tablet) -->
      <button type="button" onclick="toggleMobileMenu()" aria-label="Toggle Menu" class="lg:hidden w-9 h-9 sm:w-10 sm:h-10 rounded-lg border border-gray-200 flex items-center justify-center text-gray-700 hover:bg-gray-50 hover:text-[#c8102e] transition cursor-pointer">
        <i id="mobile-menu-icon" class="ri-menu-3-line text-lg sm:text-xl"></i>
      </button>
    </div>
  </div>

  <!-- Mobile Responsive Navigation Drawer -->
  <div id="mobile-menu" class="hidden lg:hidden bg-white border-t border-gray-100 px-4 pt-3 pb-6 shadow-xl max-h-[calc(100vh-70px)] overflow-y-auto">
    <!-- Nav Links List (Home to Contact) -->
    <div class="flex flex-col space-y-1.5 text-[15px] font-semibold">
      <a href="{{ route('home') }}" class="mobile-nav-link bg-[#c8102e] text-white px-4 py-2.5 rounded-lg">হোম</a>
      <div>
        <button type="button" onclick="toggleMobileSubmenu()" class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-gray-800 hover:bg-gray-50">
          <span>আমাদের সম্পর্কে</span>
          <i id="mobile-submenu-arrow" class="ri-arrow-down-s-line text-[#c8102e] text-lg transition-transform"></i>
        </button>
        <div id="mobile-about-submenu" class="hidden pl-6 pr-2 py-1 space-y-1 text-sm text-gray-600 border-l-2 border-red-200 ml-4 mt-1">
          <a href="{{ route('home') }}#about-section" class="mobile-nav-link block py-1.5 hover:text-[#c8102e]">আমাদের লক্ষ্য ও উদ্দেশ্য</a>
          <a href="{{ route('home') }}#president-section" class="mobile-nav-link block py-1.5 hover:text-[#c8102e]">সভাপতির বাণী</a>
          <a href="{{ route('home') }}#personalities-section" class="mobile-nav-link block py-1.5 hover:text-[#c8102e]">সম্মানিত ব্যক্তিবর্গ</a>
          <a href="{{ route('home') }}#committee-section" class="mobile-nav-link block py-1.5 hover:text-[#c8102e]">কার্যনির্বাহী কমিটি</a>
        </div>
      </div>
      <a href="{{ route('home') }}#notice-section" class="mobile-nav-link px-4 py-2.5 rounded-lg hover:bg-gray-50">নোটিশ</a>
      <a href="{{ route('home') }}#gallery-section" class="mobile-nav-link px-4 py-2.5 rounded-lg hover:bg-gray-50">গ্যালারি</a>
      <a href="{{ route('home') }}#events-section" class="mobile-nav-link px-4 py-2.5 rounded-lg hover:bg-gray-50">কার্যক্রম</a>
      <a href="{{ route('contact.index') }}" class="mobile-nav-link px-4 py-2.5 rounded-lg hover:bg-gray-50 {{ request()->routeIs('contact*') ? 'text-[#c8102e] font-extrabold bg-red-50/50' : '' }}">যোগাযোগ</a>
    </div>

    <!-- Mobile Auth Section: Always Placed Below 'যোগাযোগ' (Contact) -->
    <div class="mt-4 pt-4 border-t border-gray-100">
      @guest
        <div class="grid grid-cols-2 gap-2">
          <a href="{{ route('login') }}" class="flex items-center justify-center gap-1.5 bg-[#c8102e] text-white py-2.5 px-3 rounded-xl text-xs sm:text-sm font-bold shadow-xs hover:bg-[#a30b24] transition">
            <i class="fa-solid fa-arrow-right-to-bracket text-xs"></i>
            <span>লগইন</span>
          </a>
          <a href="{{ route('register') }}" class="flex items-center justify-center gap-1.5 border border-[#0b4622] text-[#0b4622] hover:bg-[#0b4622] hover:text-white py-2.5 px-3 rounded-xl text-xs sm:text-sm font-bold transition">
            <i class="fa-solid fa-user-plus text-xs"></i>
            <span>রেজিস্টার</span>
          </a>
        </div>
      @else
        <!-- Mobile User Accordion Dropdown -->
        <div class="bg-gray-50/80 rounded-xl border border-gray-200/80 overflow-hidden">
          <button
            type="button"
            onclick="toggleMobileUserDropdown()"
            class="w-full flex items-center justify-between p-3 text-left focus:outline-none cursor-pointer"
          >
            <div class="flex items-center gap-2.5 min-w-0">
              @if(Auth::user()->photo)
                <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="{{ Auth::user()->name }}" class="w-9 h-9 rounded-full object-cover shrink-0 border border-gray-200" />
              @else
                <div class="w-9 h-9 rounded-full bg-[#0b4622] text-white flex items-center justify-center text-xs font-bold shrink-0">
                  {{ mb_substr(Auth::user()->name, 0, 1) }}
                </div>
              @endif
              <div class="min-w-0">
                <span class="block text-xs sm:text-sm font-bold text-gray-900 leading-tight truncate">{{ Auth::user()->name }}</span>
                <span class="block text-[10px] sm:text-xs text-gray-500 truncate">{{ Auth::user()->email }}</span>
              </div>
            </div>
            <i id="mobile-user-dropdown-arrow" class="ri-arrow-down-s-line text-lg text-gray-500 transition-transform"></i>
          </button>

          <!-- Mobile Dropdown Links -->
          <div id="mobile-user-dropdown-links" class="hidden border-t border-gray-200/70 bg-white py-1">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs sm:text-sm font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#0b4622] transition">
              <i class="fa-regular fa-circle-user text-[#0b4622] text-sm"></i>
              <span>আমার প্রোফাইল</span>
            </a>
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs sm:text-sm font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#0b4622] transition">
              <i class="fa-solid fa-key text-[#0b4622] text-sm"></i>
              <span>পাসওয়ার্ড পরিবর্তন</span>
            </a>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs sm:text-sm font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#0b4622] transition">
              <i class="fa-solid fa-gauge text-[#0b4622] text-sm"></i>
              <span>ড্যাশবোর্ডে যান</span>
            </a>
            <div class="border-t border-gray-100 pt-1 mt-1">
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left flex items-center gap-2.5 px-4 py-2.5 text-xs sm:text-sm font-bold text-[#c8102e] hover:bg-red-50 transition cursor-pointer">
                  <i class="fa-solid fa-arrow-right-from-bracket text-sm"></i>
                  <span>লগআউট করুন</span>
                </button>
              </form>
            </div>
          </div>
        </div>
      @endguest
    </div>
  </div>
</header>
