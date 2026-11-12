<!-- Modern, Clean White Top Navbar -->
<header class="sticky top-0 z-30 bg-white border-b border-gray-100 h-16 sm:h-[72px]">
  <div class="h-full px-4 sm:px-8 flex items-center justify-between gap-4">
    
    <!-- Left Section: Title & Breadcrumb + Search -->
    <div class="flex items-center gap-3 sm:gap-6 min-w-0">
      <!-- Mobile Sidebar Toggle -->
      <button
        type="button"
        onclick="toggleAdminSidebar()"
        class="lg:hidden w-9 h-9 rounded-xl border border-gray-200 text-gray-700 hover:text-[#0b4622] hover:bg-gray-50 flex items-center justify-center transition cursor-pointer"
        aria-label="Toggle Sidebar"
      >
        <i class="ri-menu-2-line text-lg"></i>
      </button>

      <!-- Page Title & Tag -->
      <div class="flex items-center gap-2 sm:gap-3">
        <h2 class="text-base sm:text-lg font-extrabold text-gray-900 tracking-tight leading-tight">
          অ্যাডমিন কনসোল
        </h2>
        <span class="hidden sm:inline-flex items-center text-[11px] font-bold text-[#0b4622] bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-100">
          ADMIN
        </span>
      </div>

      <!-- Quick Search Input (Clean rounded-xl pill) -->
      <div class="hidden md:block relative w-60 lg:w-72">
        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
          <i class="ri-search-line text-sm"></i>
        </span>
        <input
          type="text"
          placeholder="অনুসন্ধান করুন..."
          class="w-full pl-9 pr-9 py-2 rounded-xl border border-gray-200 bg-gray-50/70 text-xs sm:text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#0b4622] focus:bg-white transition"
        />
        <span class="absolute inset-y-0 right-0 pr-2.5 flex items-center pointer-events-none text-[10px] text-gray-400 font-mono">
          Ctrl+K
        </span>
      </div>
    </div>

    <!-- Right Section: Live Site, Refresh Button, Notifications & User Dropdown Only -->
    <div class="flex items-center gap-2.5 sm:gap-3.5 shrink-0">
      
      <!-- Live Site Quick Link -->
      <a
        href="{{ route('home') }}"
        target="_blank"
        class="hidden sm:inline-flex items-center gap-1.5 text-xs font-bold text-gray-600 hover:text-[#0b4622] px-3 py-1.5 rounded-lg hover:bg-gray-50 transition"
      >
        <span>লাইভ সাইট</span>
        <i class="ri-external-link-line text-xs"></i>
      </a>

      <!-- Quick Cache & System Refresh AJAX Button -->
      <div class="relative">
        <button
          type="button"
          id="btn-cache-refresh"
          onclick="runCacheRefresh()"
          title="ক্যাশ, ভিউ, রাউট ও স্টোরেজ রিফ্রেশ করুন"
          class="relative w-9 h-9 sm:w-10 sm:h-10 rounded-full border border-gray-200 text-gray-600 hover:text-[#0b4622] hover:bg-emerald-50/70 hover:border-emerald-200 flex items-center justify-center transition cursor-pointer focus:outline-none group"
          aria-label="Refresh Cache & Routes"
        >
          <i id="btn-cache-refresh-icon" class="ri-refresh-line text-lg group-hover:rotate-180 transition-transform duration-500"></i>
        </button>
      </div>

      <!-- Notification Bell -->
      <div class="relative" id="admin-notification-container">
        <button
          type="button"
          onclick="toggleAdminNotification(event)"
          class="relative w-9 h-9 sm:w-10 sm:h-10 rounded-full border border-gray-200 text-gray-600 hover:text-[#0b4622] hover:bg-gray-50 flex items-center justify-center transition cursor-pointer focus:outline-none"
          aria-label="Notifications"
        >
          <i class="ri-notification-3-line text-base"></i>
          <!-- Small Red Indicator Dot -->
          <span class="absolute top-2 right-2 w-2 h-2 bg-[#c8102e] rounded-full ring-2 ring-white"></span>
        </button>

        <!-- Notification Popover -->
        <div
          id="admin-notification-menu"
          class="hidden absolute right-0 mt-2 w-72 sm:w-80 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50 animate-fadeIn"
        >
          <div class="px-4 py-2.5 border-b border-gray-100 flex items-center justify-between">
            <h4 class="text-xs font-extrabold text-gray-800">বিজ্ঞপ্তি (Notifications)</h4>
            <span class="text-[10px] bg-red-50 text-[#c8102e] px-2 py-0.5 rounded-full font-bold">২টি নতুন</span>
          </div>
          <div class="divide-y divide-gray-50 text-xs max-h-60 overflow-y-auto custom-scrollbar">
            <a href="#" class="block px-4 py-2.5 hover:bg-gray-50 transition">
              <p class="font-bold text-gray-800 truncate">নতুন সদস্য নিবন্ধন</p>
              <p class="text-[11px] text-gray-500 mt-0.5">নতুন সদস্য রেজিস্ট্রেশন করেছেন।</p>
              <span class="text-[10px] text-gray-400 mt-1 block">১০ মিনিট আগে</span>
            </a>
            <a href="#" class="block px-4 py-2.5 hover:bg-gray-50 transition">
              <p class="font-bold text-gray-800 truncate">অনুদানের ভাউচার তৈরি</p>
              <p class="text-[11px] text-gray-500 mt-0.5">বিকাশ ট্রান্সফার কনফার্ম হয়েছে।</p>
              <span class="text-[10px] text-gray-400 mt-1 block">১ ঘণ্টা আগে</span>
            </a>
          </div>
        </div>
      </div>

      <!-- User Avatar & Dropdown (Clean, Only this remains) -->
      <div class="relative" id="admin-user-dropdown-container">
        <button
          type="button"
          onclick="toggleAdminUserDropdown(event)"
          class="flex items-center gap-1.5 p-1 rounded-full border border-gray-200 hover:border-gray-300 transition cursor-pointer bg-white focus:outline-none"
        >
          @if(Auth::check() && Auth::user()->photo)
            <img
              src="{{ asset('storage/' . Auth::user()->photo) }}"
              alt="{{ Auth::user()->name }}"
              class="w-8 h-8 sm:w-9 sm:h-9 rounded-full object-cover"
            />
          @else
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#0b4622] text-white flex items-center justify-center font-bold text-xs sm:text-sm">
              {{ Auth::check() ? mb_substr(Auth::user()->name, 0, 1) : 'স' }}
            </div>
          @endif
          <i class="ri-arrow-down-s-line text-gray-400 text-sm pr-1"></i>
        </button>

        <!-- User Dropdown Menu -->
        <div
          id="admin-user-dropdown-menu"
          class="hidden absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50 text-sm animate-fadeIn"
        >
          <div class="px-4 py-2.5 border-b border-gray-100 bg-gray-50/60 rounded-t-2xl">
            <p class="font-extrabold text-gray-900 truncate leading-tight">
              {{ Auth::check() ? Auth::user()->name : 'সুপার অ্যাডমিন' }}
            </p>
            <p class="text-[11px] text-gray-500 truncate mt-0.5">
              {{ Auth::check() ? Auth::user()->email : 'admin@agamirshailkupa.org' }}
            </p>
          </div>

          <div class="py-1">
            <!-- আমার প্রোফাইল -->
            <a
              href="{{ route('admin.profile') }}"
              class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#0b4622] transition"
            >
              <i class="ri-user-line text-sm text-gray-400"></i>
              <span>আমার প্রোফাইল</span>
            </a>

            <!-- পাসওয়ার্ড পরিবর্তন -->
            <a
              href="{{ route('admin.profile.password') }}"
              class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#0b4622] transition"
            >
              <i class="ri-lock-password-line text-sm text-gray-400"></i>
              <span>পাসওয়ার্ড পরিবর্তন</span>
            </a>
          </div>

          <div class="border-t border-gray-100 pt-1">
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button
                type="submit"
                class="w-full text-left flex items-center gap-2.5 px-4 py-2 text-xs font-bold text-[#c8102e] hover:bg-red-50 transition cursor-pointer"
              >
                <i class="ri-logout-box-r-line text-sm"></i>
                <span>লগআউট করুন</span>
              </button>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
</header>
