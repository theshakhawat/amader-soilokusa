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

      <!-- Page Title (Admin badge removed as requested) -->
      <div class="flex items-center gap-2 sm:gap-3">
        <h2 class="text-base sm:text-lg font-extrabold text-gray-900 tracking-tight leading-tight">
          অ্যাডমিন কনসোল
        </h2>
      </div>

      <!-- Quick Search Input (With dynamic live suggestion dropdown) -->
      <div class="hidden md:block relative w-60 sm:w-72 lg:w-96" id="adminGlobalSearchContainer">
        <div class="relative">
          <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
            <i class="ri-search-line text-sm" id="adminSearchIcon"></i>
            <i class="ri-loader-4-line text-sm animate-spin text-[#0b4622] hidden" id="adminSearchSpinner"></i>
          </span>
          <input
            type="text"
            id="adminGlobalSearchInput"
            placeholder="অনুসন্ধান করুন... (উদা: নোটিশ, মেম্বার)"
            autocomplete="off"
            class="w-full pl-9 pr-14 py-2 rounded-xl border border-gray-200 bg-gray-50/70 text-xs sm:text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#0b4622] focus:bg-white focus:ring-2 focus:ring-[#0b4622]/10 transition shadow-2xs"
            onfocus="openAdminSearchDropdown()"
            onclick="openAdminSearchDropdown()"
            oninput="handleAdminSearchInput(event)"
            onkeydown="handleAdminSearchKeydown(event)"
          />
          <span class="absolute inset-y-0 right-0 pr-2.5 flex items-center pointer-events-none text-[10px] text-gray-400 font-mono">
            <kbd class="px-1.5 py-0.5 rounded bg-gray-200/80 text-gray-600 border border-gray-300 text-[10px] shadow-3xs">Ctrl+K</kbd>
          </span>
        </div>

        <!-- Search Suggestions Dropdown Menu -->
        <div
          id="adminSearchDropdownMenu"
          class="hidden absolute left-0 lg:left-0 w-[340px] sm:w-[440px] lg:w-[480px] mt-2 bg-white rounded-2xl shadow-2xl border border-gray-100 py-2.5 z-50 animate-fadeIn text-xs"
        >
          {{-- Popover Header --}}
          <div class="px-4 py-2 border-b border-gray-100 flex items-center justify-between text-gray-500 font-bold text-[11px]">
            <span id="adminSearchDropdownTitle" class="flex items-center gap-1.5 text-[#0b4622]">
              <i class="ri-flashlight-line text-base text-emerald-600"></i>
              <span>দ্রুত অনুসন্ধান ও অ্যাকশন</span>
            </span>
            <span class="text-[10px] text-gray-400 font-mono bg-gray-100 px-1.5 py-0.5 rounded">
              ESC বন্ধ করতে
            </span>
          </div>

          {{-- Dynamic Search Results List --}}
          <div id="adminSearchResultsList" class="max-h-[380px] overflow-y-auto divide-y divide-gray-50 custom-scrollbar">
            {{-- Content injected dynamically via AJAX --}}
          </div>

          {{-- Popover Footer --}}
          <div class="px-4 py-2 bg-gray-50/70 border-t border-gray-100 flex items-center justify-between text-[10px] text-gray-400">
            <span class="flex items-center gap-2">
              <span><kbd class="px-1 py-0.5 rounded bg-white border border-gray-200 font-mono text-[9px]">↑</kbd> <kbd class="px-1 py-0.5 rounded bg-white border border-gray-200 font-mono text-[9px]">↓</kbd> নেভিগেশন</span>
              <span><kbd class="px-1 py-0.5 rounded bg-white border border-gray-200 font-mono text-[9px]">Enter</kbd> নির্বাচন</span>
            </span>
            <span class="text-[#0b4622] font-semibold">আগামীর শৈলকুপা অ্যাডমিন</span>
          </div>
        </div>
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
      @php
        $unreadContactMessages = \App\Models\ContactMessage::where('is_read', false)->latest()->take(5)->get();
        $unreadContactCount = \App\Models\ContactMessage::where('is_read', false)->count();

        $unreadSystemNotifications = auth()->check() ? auth()->user()->unreadNotifications->take(8) : collect();
        $unreadSystemCount = auth()->check() ? auth()->user()->unreadNotifications->count() : 0;

        $totalUnreadCount = $unreadSystemCount + $unreadContactCount;
      @endphp
      <div class="relative" id="admin-notification-container">
        <button
          type="button"
          onclick="toggleAdminNotification(event)"
          class="relative w-9 h-9 sm:w-10 sm:h-10 rounded-full border border-gray-200 text-gray-600 hover:text-[#0b4622] hover:bg-gray-50 flex items-center justify-center transition cursor-pointer focus:outline-none"
          aria-label="Notifications"
        >
          <i class="ri-notification-3-line text-base"></i>
          @if($totalUnreadCount > 0)
            <!-- Red Badge with Count -->
            <span class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 bg-[#c8102e] text-white text-[10px] font-extrabold rounded-full flex items-center justify-center ring-2 ring-white">
              {{ $totalUnreadCount > 9 ? '৯+' : $totalUnreadCount }}
            </span>
          @endif
        </button>

        <!-- Notification Popover -->
        <div
          id="admin-notification-menu"
          class="hidden absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-gray-100 py-2 z-50 animate-fadeIn"
        >
          {{-- Popover Header --}}
          <div class="px-4 py-2.5 border-b border-gray-100 flex items-center justify-between">
            <h4 class="text-xs font-extrabold text-gray-800 flex items-center gap-1.5">
              <i class="ri-notification-3-line text-[#0b4622]"></i>
              <span>বিজ্ঞপ্তি ও নোটিফিকেশন</span>
            </h4>
            <div class="flex items-center gap-2">
              @if($totalUnreadCount > 0)
                <span class="text-[10px] bg-red-50 text-[#c8102e] px-2 py-0.5 rounded-full font-bold">
                  {{ $totalUnreadCount }}টি নতুন
                </span>
                @if($unreadSystemCount > 0)
                  <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-[10px] text-gray-500 hover:text-[#0b4622] font-semibold hover:underline cursor-pointer" title="সব পড়া হয়েছে হিসেবে চিহ্নিত করুন">
                      পঠিত করুন
                    </button>
                  </form>
                @endif
              @else
                <span class="text-[10px] text-gray-400 font-semibold">সব পড়া হয়েছে</span>
              @endif
            </div>
          </div>

          {{-- Notification List --}}
          <div class="divide-y divide-gray-50 text-xs max-h-80 overflow-y-auto custom-scrollbar">
            {{-- System Notifications (Volunteers, Members & Donations) --}}
            @foreach($unreadSystemNotifications as $systemNotif)
              @php
                $notifType = $systemNotif->data['type'] ?? '';
                $isVolunteer = $notifType === 'volunteer_registration';
                $isMember = $notifType === 'member_registration';
                $isDonation = $notifType === 'donation_received';

                $badgeIcon = 'ri-notification-line';
                $badgeBg = 'bg-gray-100 text-gray-700';
                $actionText = 'বিস্তারিত দেখুন';

                if ($isVolunteer) {
                  $badgeIcon = 'ri-user-heart-line';
                  $badgeBg = 'bg-emerald-100 text-[#0b4622]';
                  $actionText = 'স্বেচ্ছাসেবী পেজে যান';
                } elseif ($isMember) {
                  $badgeIcon = 'ri-vip-crown-line';
                  $badgeBg = 'bg-blue-100 text-blue-700';
                  $actionText = 'সদস্য পেজে যান';
                } elseif ($isDonation) {
                  $badgeIcon = 'ri-hand-coin-line';
                  $badgeBg = 'bg-emerald-100 text-emerald-800';
                  $actionText = 'অনুদানের বিবরণ দেখুন';
                }
              @endphp
              <a href="{{ route('admin.notifications.read', $systemNotif->id) }}"
                 class="block px-4 py-3 hover:bg-emerald-50/40 transition group relative bg-emerald-50/15">
                <div class="flex items-start gap-3">
                  {{-- Icon Badge --}}
                  <div class="w-8 h-8 rounded-xl {{ $badgeBg }} flex items-center justify-center shrink-0 mt-0.5 shadow-2xs">
                    <i class="{{ $badgeIcon }} text-base"></i>
                  </div>

                  <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-1">
                      <p class="font-extrabold text-gray-900 text-xs truncate">
                        {{ $systemNotif->data['title'] ?? 'নতুন নোটিফিকেশন' }}
                      </p>
                      <span class="text-[10px] text-gray-400 shrink-0 font-medium">
                        {{ $systemNotif->created_at->diffForHumans() }}
                      </span>
                    </div>

                    <p class="text-[11px] text-gray-700 mt-0.5 leading-snug">
                      {{ $systemNotif->data['message'] ?? '' }}
                    </p>

                    <div class="flex items-center justify-between mt-1 pt-0.5">
                      <span class="text-[10px] font-mono text-gray-500">
                        {{ $systemNotif->data['id_number'] ?? '' }}
                      </span>
                      <span class="inline-flex items-center gap-1 text-[10px] font-bold text-[#0b4622] group-hover:underline">
                        <span>{{ $actionText }}</span>
                        <i class="ri-arrow-right-line text-[9px]"></i>
                      </span>
                    </div>
                  </div>
                </div>
              </a>
            @endforeach

            {{-- Unread Contact Messages --}}
            @foreach($unreadContactMessages as $notifMsg)
              <a href="{{ route('admin.contact-messages.show', $notifMsg) }}"
                 class="block px-4 py-3 hover:bg-amber-50/40 transition group relative">
                <div class="flex items-start gap-3">
                  <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center shrink-0 mt-0.5 shadow-2xs">
                    <i class="ri-mail-line text-base"></i>
                  </div>
                  <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-1">
                      <p class="font-extrabold text-gray-900 text-xs truncate">{{ $notifMsg->name }}</p>
                      <span class="text-[10px] text-gray-400 shrink-0 font-medium">{{ $notifMsg->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-[11px] text-gray-600 mt-0.5 truncate">{{ $notifMsg->subject ?: $notifMsg->message }}</p>
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-700 mt-1 group-hover:underline">
                      <span>বার্তা দেখুন</span>
                      <i class="ri-arrow-right-line text-[9px]"></i>
                    </span>
                  </div>
                </div>
              </a>
            @endforeach

            {{-- Empty State --}}
            @if($unreadSystemNotifications->isEmpty() && $unreadContactMessages->isEmpty())
              <div class="px-4 py-8 text-center text-gray-400 text-xs">
                <i class="ri-checkbox-circle-line text-3xl block mb-1 text-emerald-500/70"></i>
                নতুন কোনো অপঠিত নোটিফিকেশন নেই।
              </div>
            @endif
          </div>

          {{-- Popover Footer Links --}}
          <div class="px-3 pt-2 pb-1 border-t border-gray-100 flex items-center justify-between text-[11px]">
            <a href="{{ route('admin.volunteers.index') }}" class="font-bold text-[#0b4622] hover:underline py-1 flex items-center gap-1">
              <i class="ri-user-heart-line text-xs"></i>
              <span>স্বেচ্ছাসেবী তালিকা</span>
            </a>
            <span class="text-gray-300">|</span>
            <a href="{{ route('admin.members.index') }}" class="font-bold text-blue-700 hover:underline py-1 flex items-center gap-1">
              <i class="ri-vip-crown-line text-xs"></i>
              <span>সদস্য তালিকা</span>
            </a>
            <span class="text-gray-300">|</span>
            <a href="{{ route('admin.contact-messages.index') }}" class="font-bold text-gray-600 hover:underline py-1 flex items-center gap-1">
              <i class="ri-mail-line text-xs"></i>
              <span>সকল বার্তা</span>
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

{{-- Admin Global Search Script --}}
<script>
  let searchDebounceTimer = null;
  let activeSearchIndex = -1;
  let currentSearchResults = [];

  function openAdminSearchDropdown() {
    const dropdown = document.getElementById('adminSearchDropdownMenu');
    if (!dropdown) return;

    dropdown.classList.remove('hidden');

    // Close other popovers
    const notifMenu = document.getElementById('admin-notification-menu');
    if (notifMenu) notifMenu.classList.add('hidden');
    const userMenu = document.getElementById('admin-user-dropdown-menu');
    if (userMenu) userMenu.classList.add('hidden');

    const input = document.getElementById('adminGlobalSearchInput');
    const query = input ? input.value.trim() : '';

    fetchAdminSearchSuggestions(query);
  }

  function closeAdminSearchDropdown() {
    const dropdown = document.getElementById('adminSearchDropdownMenu');
    if (dropdown) dropdown.classList.add('hidden');
    activeSearchIndex = -1;
  }

  function handleAdminSearchInput(event) {
    const query = event.target.value.trim();
    clearTimeout(searchDebounceTimer);
    searchDebounceTimer = setTimeout(() => {
      fetchAdminSearchSuggestions(query);
    }, 180);
  }

  function fetchAdminSearchSuggestions(query) {
    const spinner = document.getElementById('adminSearchSpinner');
    const icon = document.getElementById('adminSearchIcon');
    const resultsContainer = document.getElementById('adminSearchResultsList');
    const titleEl = document.getElementById('adminSearchDropdownTitle');

    if (spinner && icon) {
      spinner.classList.remove('hidden');
      icon.classList.add('hidden');
    }

    const searchUrl = "{{ route('admin.quick-search') }}?q=" + encodeURIComponent(query);

    fetch(searchUrl, {
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(res => res.json())
    .then(data => {
      renderAdminSearchResults(data, query);
    })
    .catch(err => {
      console.error('Search error:', err);
    })
    .finally(() => {
      if (spinner && icon) {
        spinner.classList.add('hidden');
        icon.classList.remove('hidden');
      }
    });
  }

  function renderAdminSearchResults(data, query) {
    const resultsContainer = document.getElementById('adminSearchResultsList');
    const titleEl = document.getElementById('adminSearchDropdownTitle');
    if (!resultsContainer) return;

    currentSearchResults = [];
    activeSearchIndex = -1;

    let html = '';

    if (data.is_empty) {
      if (titleEl) {
        titleEl.innerHTML = '<i class="ri-flashlight-line text-emerald-600"></i> <span>জনপ্রিয় মেনু ও অপশনসমূহ</span>';
      }
    } else {
      if (titleEl) {
        titleEl.innerHTML = `<i class="ri-search-eye-line text-[#0b4622]"></i> <span>‘${escapeAdminSearchHtml(query)}’ এর ফলাফল (${data.total || 0}টি)</span>`;
      }
    }

    // 1. Menu items
    if (data.menu_items && data.menu_items.length > 0) {
      if (!data.is_empty) {
        html += `<div class="px-4 py-1.5 bg-gray-50/80 text-[10px] font-bold text-gray-400 uppercase tracking-wider">মেনু ও অ্যাকশন লিংক</div>`;
      }
      data.menu_items.forEach(item => {
        const itemIdx = currentSearchResults.length;
        currentSearchResults.push(item.url);

        html += `
          <a href="${item.url}"
             data-search-index="${itemIdx}"
             class="admin-search-result-item flex items-center justify-between px-4 py-2.5 hover:bg-emerald-50/50 transition group border-b border-gray-50">
            <div class="flex items-center gap-3 min-w-0">
              <span class="w-8 h-8 rounded-xl bg-gray-100 text-[#0b4622] group-hover:bg-emerald-100 flex items-center justify-center shrink-0 transition">
                <i class="${item.icon || 'ri-arrow-right-s-line'} text-base"></i>
              </span>
              <div class="min-w-0">
                <div class="flex items-center gap-2">
                  <p class="font-extrabold text-gray-900 group-hover:text-[#0b4622] truncate transition">${item.title}</p>
                  ${item.badge ? `<span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-emerald-50 text-[#0b4622] border border-emerald-200">${item.badge}</span>` : ''}
                </div>
                <p class="text-[10px] text-gray-400 truncate">${item.group || ''} ${item.subtitle ? '• ' + item.subtitle : ''}</p>
              </div>
            </div>
            <i class="ri-arrow-right-line text-gray-300 group-hover:text-[#0b4622] group-hover:translate-x-0.5 transition shrink-0 ml-2"></i>
          </a>
        `;
      });
    }

    // 2. Database records (Notices, Volunteers, Members, etc.)
    if (data.records && data.records.length > 0) {
      html += `<div class="px-4 py-1.5 bg-gray-50/80 text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-1">সরাসরি ডাটাবেজ রেকর্ড</div>`;
      data.records.forEach(rec => {
        const itemIdx = currentSearchResults.length;
        currentSearchResults.push(rec.url);

        html += `
          <a href="${rec.url}"
             data-search-index="${itemIdx}"
             class="admin-search-result-item flex items-center justify-between px-4 py-2.5 hover:bg-blue-50/50 transition group border-b border-gray-50">
            <div class="flex items-center gap-3 min-w-0">
              <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center shrink-0">
                <i class="${rec.icon || 'ri-file-list-line'} text-base"></i>
              </span>
              <div class="min-w-0">
                <div class="flex items-center gap-2">
                  <p class="font-extrabold text-gray-900 group-hover:text-blue-700 truncate transition">${rec.title}</p>
                  <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-blue-100/70 text-blue-700">${rec.type}</span>
                </div>
                <p class="text-[10px] text-gray-400 truncate">${rec.subtitle || ''}</p>
              </div>
            </div>
            <i class="ri-arrow-right-line text-gray-300 group-hover:text-blue-700 group-hover:translate-x-0.5 transition shrink-0 ml-2"></i>
          </a>
        `;
      });
    }

    // Empty result state
    if (!data.menu_items?.length && !data.records?.length) {
      html = `
        <div class="px-4 py-8 text-center text-gray-400">
          <i class="ri-search-line text-3xl block mb-2 text-gray-300"></i>
          <p class="font-bold text-gray-600 text-xs">‘${escapeAdminSearchHtml(query)}’ দিয়ে কিছু পাওয়া যায়নি</p>
          <p class="text-[11px] text-gray-400 mt-1">অন্য কোনো বাংলা বা ইংরেজি শব্দ লিখে চেষ্টা করুন (যেমন: নোটিশ, মেম্বার, অনুদান, ইভেন্ট)</p>
        </div>
      `;
    }

    resultsContainer.innerHTML = html;
  }

  function handleAdminSearchKeydown(e) {
    const dropdown = document.getElementById('adminSearchDropdownMenu');
    if (!dropdown || dropdown.classList.contains('hidden')) {
      if (e.key === 'ArrowDown' || e.key === 'Enter') {
        openAdminSearchDropdown();
      }
      return;
    }

    const items = document.querySelectorAll('.admin-search-result-item');
    if (items.length === 0) return;

    if (e.key === 'ArrowDown') {
      e.preventDefault();
      activeSearchIndex = (activeSearchIndex + 1) % items.length;
      updateActiveSearchItem(items);
    } else if (e.key === 'ArrowUp') {
      e.preventDefault();
      activeSearchIndex = (activeSearchIndex - 1 + items.length) % items.length;
      updateActiveSearchItem(items);
    } else if (e.key === 'Enter') {
      e.preventDefault();
      if (activeSearchIndex >= 0 && activeSearchIndex < items.length) {
        items[activeSearchIndex].click();
      } else if (items.length > 0) {
        items[0].click();
      }
    } else if (e.key === 'Escape') {
      e.preventDefault();
      closeAdminSearchDropdown();
    }
  }

  function updateActiveSearchItem(items) {
    items.forEach((item, idx) => {
      if (idx === activeSearchIndex) {
        item.classList.add('bg-emerald-100/60', 'ring-1', 'ring-inset', 'ring-emerald-400');
        item.scrollIntoView({ block: 'nearest' });
      } else {
        item.classList.remove('bg-emerald-100/60', 'ring-1', 'ring-inset', 'ring-emerald-400');
      }
    });
  }

  function escapeAdminSearchHtml(text) {
    if (!text) return '';
    return text.replace(/[&<>"']/g, function(m) {
      return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'})[m];
    });
  }

  // Global Ctrl+K / Cmd+K Shortcut Listener
  document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && (e.key === 'k' || e.key === 'K')) {
      e.preventDefault();
      const input = document.getElementById('adminGlobalSearchInput');
      if (input) {
        input.focus();
        openAdminSearchDropdown();
      }
    }
    if (e.key === 'Escape') {
      closeAdminSearchDropdown();
    }
  });

  // Close search dropdown on click outside
  document.addEventListener('click', function(e) {
    const container = document.getElementById('adminGlobalSearchContainer');
    if (container && !container.contains(e.target)) {
      closeAdminSearchDropdown();
    }
  });
</script>
