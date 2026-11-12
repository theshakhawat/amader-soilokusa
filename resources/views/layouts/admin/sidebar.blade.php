<!-- Clean, Modern White Admin Sidebar -->
<aside
  id="admin-sidebar"
  class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-100 flex flex-col transition-transform duration-300 ease-in-out lg:translate-x-0 -translate-x-full shadow-[2px_0_12px_rgba(0,0,0,0.02)]"
>
  <!-- Sidebar Header / Logo -->
  <div class="h-16 sm:h-[72px] flex items-center justify-between px-5 border-b border-gray-100 bg-white">
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 group">
      <img
        src="{{ asset('assets/images/logo-icon.png') }}"
        alt="আগামীর শৈলকুপা"
        class="w-9 h-9 object-contain shrink-0 group-hover:scale-105 transition"
      />
      <div class="flex flex-col">
        <span class="text-[17px] font-extrabold tracking-tight text-[#b91c1c] leading-tight">
          আগামীর শৈলকুপা
        </span>
        <span class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">
          অ্যাডমিন প্যানেল
        </span>
      </div>
    </a>

    <!-- Close button for mobile -->
    <button
      type="button"
      onclick="toggleAdminSidebar()"
      class="lg:hidden text-gray-400 hover:text-gray-700 p-1.5 rounded-lg hover:bg-gray-100 transition"
      aria-label="Close Sidebar"
    >
      <i class="ri-close-line text-xl"></i>
    </button>
  </div>

  <!-- Navigation Menu List with Custom Scrollbar -->
  <nav class="flex-1 overflow-y-auto px-3.5 py-4 space-y-1.5 text-sm custom-scrollbar">

    <div class="px-3 pt-1 pb-1.5">
      <span class="text-[10px] font-extrabold uppercase tracking-wider text-gray-400">ওভারভিউ / Overview</span>
    </div>

    <!-- ড্যাশবোর্ড -->
    <a
      href="{{ route('admin.dashboard') }}"
      class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-bold transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#0b4622] text-white shadow-sm' : 'text-gray-700 hover:bg-gray-50 hover:text-[#0b4622]' }}"
    >
      <div class="flex items-center gap-3">
        <i class="ri-dashboard-3-line text-base w-5 text-center {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-500' }}"></i>
        <span>ড্যাশবোর্ড</span>
      </div>
      <i class="ri-arrow-right-s-line text-sm {{ request()->routeIs('admin.dashboard') ? 'text-white/80' : 'text-gray-400' }}"></i>
    </a>

    <!-- আমার প্রোফাইল -->
    @php
      $isProfileActive = request()->routeIs('admin.profile*');
    @endphp
    <div class="sidebar-dropdown-group">
      <button
        type="button"
        onclick="toggleSidebarDropdown('menu-my-profile', this)"
        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium transition cursor-pointer focus:outline-none {{ $isProfileActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
      >
        <div class="flex items-center gap-3">
          <i class="ri-user-smile-line text-base w-5 text-center {{ $isProfileActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
          <span>আমার প্রোফাইল</span>
        </div>
        <i class="ri-arrow-down-s-line text-sm transition-transform duration-300 dropdown-arrow {{ $isProfileActive ? 'rotate-180 text-[#0b4622]' : 'text-gray-400' }}"></i>
      </button>

      <!-- Submenu container with distinct Off-White background -->
      <div
        id="menu-my-profile"
        class="sidebar-submenu overflow-hidden transition-all duration-300 ease-in-out {{ $isProfileActive ? 'max-h-96 opacity-100 mt-1.5' : 'max-h-0 opacity-0' }}"
      >
        <div class="bg-[#f8fafc] border border-gray-100/90 rounded-xl p-1.5 space-y-1 ml-2 border-l-2 border-l-[#0b4622]/30 shadow-2xs">
          <!-- প্রোফাইল আপডেট -->
          <a
            href="{{ route('admin.profile') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.profile') ? 'bg-[#0b4622] text-white shadow-xs font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}"
          >
            <i class="ri-user-settings-line text-sm {{ request()->routeIs('admin.profile') ? 'text-white' : 'text-gray-400' }}"></i>
            <span>প্রোফাইল আপডেট</span>
          </a>

          <!-- পাসওয়ার্ড পরিবর্তন -->
          <a
            href="{{ route('admin.profile.password') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.profile.password') ? 'bg-[#0b4622] text-white shadow-xs font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}"
          >
            <i class="ri-lock-password-line text-sm {{ request()->routeIs('admin.profile.password') ? 'text-white' : 'text-gray-400' }}"></i>
            <span>পাসওয়ার্ড পরিবর্তন</span>
          </a>

          <!-- লগআউট -->
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button
              type="submit"
              class="w-full flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-bold text-[#c8102e] hover:bg-red-50 transition cursor-pointer"
            >
              <i class="ri-logout-box-r-line text-sm"></i>
              <span>লগআউট করুন</span>
            </button>
          </form>
        </div>
      </div>
    </div>

    <div class="px-3 pt-3 pb-1.5">
      <span class="text-[10px] font-extrabold uppercase tracking-wider text-gray-400">কাস্টমাইজেশন ও সেটিংস</span>
    </div>

    <!-- কাস্টমাইজেশন (Customization Dropdown) -->
    @php
      $isCustomizationActive = request()->routeIs('admin.social-media*') || request()->routeIs('admin.customization*') || request()->routeIs('admin.hero-banners*') || request()->routeIs('admin.stat-counters*');
    @endphp
    <div class="sidebar-dropdown-group">
      <button
        type="button"
        onclick="toggleSidebarDropdown('menu-customization', this)"
        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium transition cursor-pointer focus:outline-none {{ $isCustomizationActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
      >
        <div class="flex items-center gap-3">
          <i class="ri-brush-3-line text-base w-5 text-center {{ $isCustomizationActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
          <span>কাস্টমাইজেশন</span>
        </div>
        <i class="ri-arrow-down-s-line text-sm transition-transform duration-300 dropdown-arrow {{ $isCustomizationActive ? 'rotate-180 text-[#0b4622]' : 'text-gray-400' }}"></i>
      </button>

      <div
        id="menu-customization"
        class="sidebar-submenu overflow-hidden transition-all duration-300 ease-in-out {{ $isCustomizationActive ? 'max-h-[1000px] opacity-100 mt-1.5' : 'max-h-0 opacity-0' }}"
      >
        <div class="bg-[#f8fafc] border border-gray-100/90 rounded-xl p-1.5 space-y-1 ml-2 border-l-2 border-l-[#0b4622]/40 shadow-2xs">
          <!-- যোগাযোগ (Contact Information: Location, Phone, Email) -->
          <a
            href="{{ route('admin.customization.contact') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.customization.contact*') ? 'bg-[#0b4622] text-white shadow-xs font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}"
          >
            <i class="ri-contacts-book-line text-sm {{ request()->routeIs('admin.customization.contact*') ? 'text-white' : 'text-gray-400' }}"></i>
            <span>যোগাযোগ (Contact Info)</span>
          </a>

          <!-- সোশ্যাল মিডিয়া লিংক (Active Link) -->
          <a
            href="{{ route('admin.social-media.index') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.social-media*') ? 'bg-[#0b4622] text-white shadow-xs font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}"
          >
            <i class="ri-share-line text-sm {{ request()->routeIs('admin.social-media*') ? 'text-white' : 'text-gray-400' }}"></i>
            <span>সোশ্যাল মিডিয়া লিংক</span>
          </a>

          <!-- টপবার হেডার -->
          <a
            href="{{ route('admin.customization.topbar') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.customization.topbar*') ? 'bg-[#0b4622] text-white shadow-xs font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}"
          >
            <i class="ri-layout-top-2-line text-sm {{ request()->routeIs('admin.customization.topbar*') ? 'text-white' : 'text-gray-400' }}"></i>
            <span>টপবার হেডার (Top Header)</span>
          </a>

          <!-- লোগো ও ব্র্যান্ডিং -->
          <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold text-gray-600 hover:bg-white hover:text-[#0b4622] transition">
            <i class="ri-pantone-line text-sm text-gray-400"></i>
            <span>লোগো ও ব্র্যান্ডিং</span>
          </a>

          <!-- থিম ও কালার স্কিম -->
          <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold text-gray-600 hover:bg-white hover:text-[#0b4622] transition">
            <i class="ri-palette-line text-sm text-gray-400"></i>
            <span>থিম ও কালার প্যালেট</span>
          </a>

          <!-- হোম স্লাইডার ও ব্যানার -->
          <a
            href="{{ route('admin.hero-banners.index') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.hero-banners*') ? 'bg-[#0b4622] text-white shadow-xs font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}"
          >
            <i class="ri-slideshow-3-line text-sm {{ request()->routeIs('admin.hero-banners*') ? 'text-white' : 'text-gray-400' }}"></i>
            <span>হোম হিরো স্লাইডার</span>
          </a>

          <!-- হোম পরিসংখ্যান কাউন্টার (Stat Counter Bar) -->
          <a
            href="{{ route('admin.stat-counters.index') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.stat-counters*') ? 'bg-[#0b4622] text-white shadow-xs font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}"
          >
            <i class="ri-bar-chart-box-line text-sm {{ request()->routeIs('admin.stat-counters*') ? 'text-white' : 'text-gray-400' }}"></i>
            <span>পরিসংখ্যান কাউন্টার বার</span>
          </a>

          <!-- আমাদের সম্পর্কে (About Us) -->
          <a
            href="{{ route('admin.customization.about') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.customization.about*') ? 'bg-[#0b4622] text-white shadow-xs font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}"
          >
            <i class="ri-information-line text-sm {{ request()->routeIs('admin.customization.about*') ? 'text-white' : 'text-gray-400' }}"></i>
            <span>আমাদের সম্পর্কে (About Us)</span>
          </a>

          <!-- সভাপতির বাণী (President's Message) -->
          <a
            href="{{ route('admin.customization.president') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.customization.president*') ? 'bg-[#0b4622] text-white shadow-xs font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}"
          >
            <i class="ri-user-voice-line text-sm {{ request()->routeIs('admin.customization.president*') ? 'text-white' : 'text-gray-400' }}"></i>
            <span>সভাপতির বাণী</span>
          </a>

          <!-- ফুটার কাস্টমাইজেশন -->
          <a
            href="{{ route('admin.customization.footer') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.customization.footer*') ? 'bg-[#0b4622] text-white shadow-xs font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}"
          >
            <i class="ri-layout-bottom-2-line text-sm {{ request()->routeIs('admin.customization.footer*') ? 'text-white' : 'text-gray-400' }}"></i>
            <span>ফুটার কন্টেন্ট ও কপিরাইট</span>
          </a>
        </div>
      </div>
    </div>

    <div class="px-3 pt-3 pb-1.5">
      <span class="text-[10px] font-extrabold uppercase tracking-wider text-gray-400">কন্টেন্ট ও ব্যবস্থাপনা</span>
    </div>

    <!-- 1. ব্যবহারকারী তালিকা -->
    <div class="sidebar-dropdown-group">
      <button
        type="button"
        onclick="toggleSidebarDropdown('menu-users', this)"
        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition font-medium group cursor-pointer focus:outline-none"
      >
        <div class="flex items-center gap-3">
          <i class="ri-user-settings-line text-base w-5 text-center text-gray-400 group-hover:text-[#0b4622] transition"></i>
          <span>ব্যবহারকারী তালিকা</span>
        </div>
        <i class="ri-arrow-down-s-line text-sm text-gray-400 transition-transform duration-300 dropdown-arrow"></i>
      </button>
      <div id="menu-users" class="sidebar-submenu overflow-hidden max-h-0 opacity-0 transition-all duration-300 ease-in-out">
        <div class="bg-[#f8fafc] border border-gray-100/90 rounded-xl p-1.5 space-y-1 ml-2 border-l-2 border-l-emerald-600/30 shadow-2xs mt-1.5">
          <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold text-gray-600 hover:bg-white hover:text-[#0b4622] transition">
            <i class="ri-team-line text-sm text-gray-400"></i>
            <span>সকল ব্যবহারকারী</span>
          </a>
          <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold text-gray-600 hover:bg-white hover:text-[#0b4622] transition">
            <i class="ri-user-follow-line text-sm text-gray-400"></i>
            <span>সক্রিয় সদস্য</span>
          </a>
          <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold text-gray-600 hover:bg-white hover:text-[#0b4622] transition">
            <i class="ri-user-shared-line text-sm text-gray-400"></i>
            <span>অপেক্ষমাণ আবেদন</span>
          </a>
          <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold text-gray-600 hover:bg-white hover:text-[#0b4622] transition">
            <i class="ri-shield-user-line text-sm text-gray-400"></i>
            <span>ভূমিকা ও পারমিশন</span>
          </a>
        </div>
      </div>
    </div>

    <!-- 2. অনুদান সংগ্রহ -->
    <div class="sidebar-dropdown-group">
      <button
        type="button"
        onclick="toggleSidebarDropdown('menu-donations', this)"
        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition font-medium group cursor-pointer focus:outline-none"
      >
        <div class="flex items-center gap-3">
          <i class="ri-heart-3-line text-base w-5 text-center text-gray-400 group-hover:text-[#c8102e] transition"></i>
          <span>অনুদান সংগ্রহ</span>
        </div>
        <i class="ri-arrow-down-s-line text-sm text-gray-400 transition-transform duration-300 dropdown-arrow"></i>
      </button>
      <div id="menu-donations" class="sidebar-submenu overflow-hidden max-h-0 opacity-0 transition-all duration-300 ease-in-out">
        <div class="bg-[#f8fafc] border border-gray-100/90 rounded-xl p-1.5 space-y-1 ml-2 border-l-2 border-l-red-500/30 shadow-2xs mt-1.5">
          <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold text-gray-600 hover:bg-white hover:text-[#0b4622] transition">
            <i class="ri-file-list-3-line text-sm text-gray-400"></i>
            <span>অনুদানের তালিকা</span>
          </a>
          <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold text-gray-600 hover:bg-white hover:text-[#0b4622] transition">
            <i class="ri-add-circle-line text-sm text-gray-400"></i>
            <span>নতুন অনুদান এন্ট্রি</span>
          </a>
          <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold text-gray-600 hover:bg-white hover:text-[#0b4622] transition">
            <i class="ri-bank-card-line text-sm text-gray-400"></i>
            <span>পেমেন্ট গেটওয়ে সেটিংস</span>
          </a>
        </div>
      </div>
    </div>

    <!-- 3. নোটিশ ও বিজ্ঞপ্তি -->
    @php
      $isNoticesActive = request()->routeIs('admin.notices*');
    @endphp
    <div class="sidebar-dropdown-group">
      <button
        type="button"
        onclick="toggleSidebarDropdown('menu-notices', this)"
        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium transition cursor-pointer focus:outline-none {{ $isNoticesActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
      >
        <div class="flex items-center gap-3">
          <i class="ri-notification-badge-line text-base w-5 text-center {{ $isNoticesActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
          <span>নোটিশ ও বিজ্ঞপ্তি</span>
        </div>
        <i class="ri-arrow-down-s-line text-sm transition-transform duration-300 dropdown-arrow {{ $isNoticesActive ? 'rotate-180 text-[#0b4622]' : 'text-gray-400' }}"></i>
      </button>
      <div
        id="menu-notices"
        class="sidebar-submenu overflow-hidden transition-all duration-300 ease-in-out {{ $isNoticesActive ? 'max-h-[500px] opacity-100 mt-1.5' : 'max-h-0 opacity-0' }}"
      >
        <div class="bg-[#f8fafc] border border-gray-100/90 rounded-xl p-1.5 space-y-1 ml-2 border-l-2 border-l-[#0b4622]/40 shadow-2xs">
          <!-- সকল নোটিশ / All Notices -->
          <a
            href="{{ route('admin.notices.index') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.notices.index') ? 'bg-[#0b4622] text-white shadow-xs font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}"
          >
            <i class="ri-file-list-3-line text-sm {{ request()->routeIs('admin.notices.index') ? 'text-white' : 'text-gray-400' }}"></i>
            <span>সকল নোটিশ (All Notices)</span>
          </a>

          <!-- নতুন নোটিশ তৈরি / Add Notice -->
          <a
            href="{{ route('admin.notices.create') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.notices.create') ? 'bg-[#0b4622] text-white shadow-xs font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}"
          >
            <i class="ri-file-add-line text-sm {{ request()->routeIs('admin.notices.create') ? 'text-white' : 'text-gray-400' }}"></i>
            <span>নোটিশ যুক্ত করুন (Add Notice)</span>
          </a>
        </div>
      </div>
    </div>

    <!-- 4. কার্যক্রম ও ইভেন্ট -->
    @php
      $isEventsActive = request()->routeIs('admin.events*');
    @endphp
    <div class="sidebar-dropdown-group">
      <button
        type="button"
        onclick="toggleSidebarDropdown('menu-events', this)"
        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium transition cursor-pointer focus:outline-none {{ $isEventsActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
      >
        <div class="flex items-center gap-3">
          <i class="ri-calendar-event-line text-base w-5 text-center {{ $isEventsActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
          <span>কার্যক্রম ও ইভেন্ট</span>
        </div>
        <i class="ri-arrow-down-s-line text-sm transition-transform duration-300 dropdown-arrow {{ $isEventsActive ? 'rotate-180 text-[#0b4622]' : 'text-gray-400' }}"></i>
      </button>
      <div
        id="menu-events"
        class="sidebar-submenu overflow-hidden transition-all duration-300 ease-in-out {{ $isEventsActive ? 'max-h-[500px] opacity-100 mt-1.5' : 'max-h-0 opacity-0' }}"
      >
        <div class="bg-[#f8fafc] border border-gray-100/90 rounded-xl p-1.5 space-y-1 ml-2 border-l-2 border-l-[#0b4622]/40 shadow-2xs">
          <!-- ইভেন্ট দেখুন / All Events -->
          <a
            href="{{ route('admin.events.index') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.events.index') ? 'bg-[#0b4622] text-white shadow-xs font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}"
          >
            <i class="ri-calendar-check-line text-sm {{ request()->routeIs('admin.events.index') ? 'text-white' : 'text-gray-400' }}"></i>
            <span>ইভেন্টসমূহ দেখুন (All Events)</span>
          </a>

          <!-- নতুন ইভেন্ট যোগ করুন / Add Event -->
          <a
            href="{{ route('admin.events.create') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.events.create') ? 'bg-[#0b4622] text-white shadow-xs font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}"
          >
            <i class="ri-calendar-todo-line text-sm {{ request()->routeIs('admin.events.create') ? 'text-white' : 'text-gray-400' }}"></i>
            <span>ইভেন্ট যুক্ত করুন (Add Event)</span>
          </a>
        </div>
      </div>
    </div>

    <!-- 5. কৃতি সন্তান (Our Pride) -->
    @php
      $isPridesActive = request()->routeIs('admin.prides*');
    @endphp
    <div class="sidebar-dropdown-group">
      <button
        type="button"
        onclick="toggleSidebarDropdown('menu-prides', this)"
        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium transition cursor-pointer focus:outline-none {{ $isPridesActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
      >
        <div class="flex items-center gap-3">
          <i class="ri-award-line text-base w-5 text-center {{ $isPridesActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
          <span>কৃতি সন্তান (Our Pride)</span>
        </div>
        <i class="ri-arrow-down-s-line text-sm transition-transform duration-300 dropdown-arrow {{ $isPridesActive ? 'rotate-180 text-[#0b4622]' : 'text-gray-400' }}"></i>
      </button>
      <div
        id="menu-prides"
        class="sidebar-submenu overflow-hidden transition-all duration-300 ease-in-out {{ $isPridesActive ? 'max-h-[500px] opacity-100 mt-1.5' : 'max-h-0 opacity-0' }}"
      >
        <div class="bg-[#f8fafc] border border-gray-100/90 rounded-xl p-1.5 space-y-1 ml-2 border-l-2 border-l-[#0b4622]/40 shadow-2xs">
          <!-- কৃতি সন্তান তালিকা -->
          <a
            href="{{ route('admin.prides.index') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.prides.index') ? 'bg-[#0b4622] text-white shadow-xs font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}"
          >
            <i class="ri-list-check-3 text-sm {{ request()->routeIs('admin.prides.index') ? 'text-white' : 'text-gray-400' }}"></i>
            <span>সকল কৃতি সন্তান</span>
          </a>

          <!-- নতুন যোগ করুন -->
          <a
            href="{{ route('admin.prides.create') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.prides.create') ? 'bg-[#0b4622] text-white shadow-xs font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}"
          >
            <i class="ri-user-add-line text-sm {{ request()->routeIs('admin.prides.create') ? 'text-white' : 'text-gray-400' }}"></i>
            <span>কৃতি সন্তান যুক্ত করুন</span>
          </a>
        </div>
      </div>
    </div>

    <!-- 6. গ্যালারি (Gallery Management) -->
    @php
      $isGalleryActive = request()->routeIs('admin.gallery*');
    @endphp
    <div class="sidebar-dropdown-group">
      <button
        type="button"
        onclick="toggleSidebarDropdown('menu-gallery', this)"
        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium transition cursor-pointer focus:outline-none {{ $isGalleryActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
      >
        <div class="flex items-center gap-3">
          <i class="ri-image-2-line text-base w-5 text-center {{ $isGalleryActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
          <span>গ্যালারি (Gallery)</span>
        </div>
        <i class="ri-arrow-down-s-line text-sm transition-transform duration-300 dropdown-arrow {{ $isGalleryActive ? 'rotate-180 text-[#0b4622]' : 'text-gray-400' }}"></i>
      </button>
      <div
        id="menu-gallery"
        class="sidebar-submenu overflow-hidden transition-all duration-300 ease-in-out {{ $isGalleryActive ? 'max-h-[500px] opacity-100 mt-1.5' : 'max-h-0 opacity-0' }}"
      >
        <div class="bg-[#f8fafc] border border-gray-100/90 rounded-xl p-1.5 space-y-1 ml-2 border-l-2 border-l-[#0b4622]/40 shadow-2xs">
          <!-- ফটো অ্যালবাম -->
          <a
            href="{{ route('admin.gallery.index', ['type' => 'photo']) }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.gallery.index') && request('type') === 'photo' ? 'bg-[#0b4622] text-white shadow-xs font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}"
          >
            <i class="ri-image-line text-sm {{ request()->routeIs('admin.gallery.index') && request('type') === 'photo' ? 'text-white' : 'text-gray-400' }}"></i>
            <span>ফটো অ্যালবাম</span>
          </a>

          <!-- ভিডিও গ্যালারি -->
          <a
            href="{{ route('admin.gallery.index', ['type' => 'video']) }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.gallery.index') && request('type') === 'video' ? 'bg-[#0b4622] text-white shadow-xs font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}"
          >
            <i class="ri-video-line text-sm {{ request()->routeIs('admin.gallery.index') && request('type') === 'video' ? 'text-white' : 'text-gray-400' }}"></i>
            <span>ভিডিও গ্যালারি</span>
          </a>

          <!-- নতুন মিডিয়া যুক্ত করুন -->
          <a
            href="{{ route('admin.gallery.create') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.gallery.create') ? 'bg-[#0b4622] text-white shadow-xs font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}"
          >
            <i class="ri-image-add-line text-sm {{ request()->routeIs('admin.gallery.create') ? 'text-white' : 'text-gray-400' }}"></i>
            <span>ছবি বা ভিডিও আপলোড</span>
          </a>
        </div>
      </div>
    </div>

    <!-- 7. উন্নয়ন প্রকল্পসমূহ (Projects Management) -->
    @php
      $isProjectsActive = request()->routeIs('admin.projects*');
    @endphp
    <div class="sidebar-dropdown-group">
      <button
        type="button"
        onclick="toggleSidebarDropdown('menu-projects', this)"
        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium transition cursor-pointer focus:outline-none {{ $isProjectsActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
      >
        <div class="flex items-center gap-3">
          <i class="ri-stack-line text-base w-5 text-center {{ $isProjectsActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
          <span>উন্নয়ন প্রকল্পসমূহ</span>
        </div>
        <i class="ri-arrow-down-s-line text-sm transition-transform duration-300 dropdown-arrow {{ $isProjectsActive ? 'rotate-180 text-[#0b4622]' : 'text-gray-400' }}"></i>
      </button>
      <div
        id="menu-projects"
        class="sidebar-submenu overflow-hidden transition-all duration-300 ease-in-out {{ $isProjectsActive ? 'max-h-[500px] opacity-100 mt-1.5' : 'max-h-0 opacity-0' }}"
      >
        <div class="bg-[#f8fafc] border border-gray-100/90 rounded-xl p-1.5 space-y-1 ml-2 border-l-2 border-l-[#0b4622]/40 shadow-2xs">
          <!-- সকল প্রকল্প -->
          <a
            href="{{ route('admin.projects.index') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.projects.index') && !request()->filled('project_status') ? 'bg-[#0b4622] text-white shadow-xs font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}"
          >
            <i class="ri-list-check-2 text-sm {{ request()->routeIs('admin.projects.index') && !request()->filled('project_status') ? 'text-white' : 'text-gray-400' }}"></i>
            <span>সকল উন্নয়ন প্রকল্প</span>
          </a>

          <!-- চলমান প্রকল্প -->
          <a
            href="{{ route('admin.projects.index', ['project_status' => 'running']) }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request('project_status') === 'running' ? 'bg-[#0b4622] text-white shadow-xs font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}"
          >
            <i class="ri-loader-4-line text-sm {{ request('project_status') === 'running' ? 'text-white' : 'text-emerald-600' }}"></i>
            <span>চলমান প্রকল্পসমূহ</span>
          </a>

          <!-- নতুন প্রকল্প যোগ করুন -->
          <a
            href="{{ route('admin.projects.create') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.projects.create') ? 'bg-[#0b4622] text-white shadow-xs font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}"
          >
            <i class="ri-add-line text-sm {{ request()->routeIs('admin.projects.create') ? 'text-white' : 'text-gray-400' }}"></i>
            <span>নতুন প্রকল্প যোগ করুন</span>
          </a>
        </div>
      </div>
    </div>

    <!-- 6. সাধারণ সেটিংস -->
    <div class="sidebar-dropdown-group">
      <button
        type="button"
        onclick="toggleSidebarDropdown('menu-settings', this)"
        class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition font-medium group cursor-pointer focus:outline-none"
      >
        <div class="flex items-center gap-3">
          <i class="ri-settings-4-line text-base w-5 text-center text-gray-400 group-hover:text-gray-800 transition"></i>
          <span>সাধারণ সেটিংস</span>
        </div>
        <i class="ri-arrow-down-s-line text-sm text-gray-400 transition-transform duration-300 dropdown-arrow"></i>
      </button>
      <div id="menu-settings" class="sidebar-submenu overflow-hidden max-h-0 opacity-0 transition-all duration-300 ease-in-out">
        <div class="bg-[#f8fafc] border border-gray-100/90 rounded-xl p-1.5 space-y-1 ml-2 border-l-2 border-l-gray-400/30 shadow-2xs mt-1.5">
          <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold text-gray-600 hover:bg-white hover:text-[#0b4622] transition">
            <i class="ri-global-line text-sm text-gray-400"></i>
            <span>ওয়েবসাইট সেটিংস</span>
          </a>
          <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold text-gray-600 hover:bg-white hover:text-[#0b4622] transition">
            <i class="ri-layout-top-line text-sm text-gray-400"></i>
            <span>হেডার ও ফুটার</span>
          </a>
          <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold text-gray-600 hover:bg-white hover:text-[#0b4622] transition">
            <i class="ri-mail-settings-line text-sm text-gray-400"></i>
            <span>ইমেইল কনফিগারেশন</span>
          </a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Sidebar Footer: Visit Live Website Button -->
  <div class="p-3 border-t border-gray-100 bg-white">
    <a
      href="{{ route('home') }}"
      target="_blank"
      class="w-full flex items-center justify-center gap-2 px-3.5 py-2.5 rounded-xl border border-gray-200 text-gray-700 hover:text-[#0b4622] hover:border-emerald-300 hover:bg-emerald-50/50 text-xs font-bold transition"
    >
      <i class="ri-external-link-line text-sm text-[#0b4622]"></i>
      <span>মূল ওয়েবসাইট দেখুন</span>
    </a>
  </div>
</aside>

<!-- Mobile Overlay Backdrop -->
<div
  id="admin-sidebar-backdrop"
  onclick="toggleAdminSidebar()"
  class="fixed inset-0 bg-black/40 z-40 lg:hidden hidden backdrop-blur-2xs transition-opacity"
></div>
