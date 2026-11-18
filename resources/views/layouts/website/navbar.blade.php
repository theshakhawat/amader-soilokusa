<!-- =====================================================================
     2. MAIN NAVIGATION BAR (Fully Dynamic Nav Items with Multi-level Dropdowns)
     ===================================================================== -->
<header id="site-main-header" class="site-main-navbar bg-white sticky top-0 z-40 shadow-[0_2px_10px_rgba(0,0,0,0.06)]">
  <div class="max-w-[1240px] mx-auto px-3 sm:px-6 h-[64px] sm:h-[76px] flex items-center justify-between gap-2 sm:gap-4">
    @php
      $navBranding = $sharedSiteBranding ?? \App\Models\SiteSetting::first();
      $navLogo = $navBranding ? $navBranding->header_logo_url : asset('assets/images/logo-icon.png');
      $navTitle = $navBranding ? $navBranding->site_title : 'আগামীর শৈলকুপা';
      $navTagline = $navBranding ? $navBranding->site_tagline : 'শৈলকুপার উন্নয়নে আমরা এক পরিবার';

      // Load Dynamic Navigation Tree (from shared cached composer or DB)
      $dynamicNavItems = $sharedNavItems ?? \App\Models\NavItem::whereNull('parent_id')
          ->where('status', true)
          ->with(['activeChildren.activeChildren'])
          ->orderBy('order', 'asc')
          ->get();

      $cachedActiveCommittees = $sharedActiveCommittees ?? \App\Models\Committee::where('is_active', true)->orderBy('order', 'asc')->get();
      $cachedActiveUnions = $sharedActiveUnions ?? \App\Models\Union::where('status', true)->orderBy('order', 'asc')->get();
    @endphp

    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="flex items-center gap-2 sm:gap-3 group shrink-0 py-1">
      <img src="{{ $navLogo }}" alt="{{ $navTitle }} লোগো" class="w-9 h-9 sm:w-12 sm:h-12 object-contain shrink-0" />
      <div class="flex flex-col justify-center py-0.5">
        <span class="block text-[18px] sm:text-[22px] md:text-[25px] font-extrabold text-[#b91c1c] tracking-normal leading-[1.3] pt-0.5">
          {{ $navTitle }}
        </span>
        @if($navTagline)
          <span class="hidden sm:block text-[11px] sm:text-[12px] font-semibold text-[#0b4622] leading-tight mt-0.5">
            {{ $navTagline }}
          </span>
        @endif
      </div>
    </a>

    <!-- Desktop Navigation Menu (Dynamic from Database) -->
    <nav class="hidden lg:flex items-center gap-1 xl:gap-1.5 text-[15px] xl:text-[15.5px] 2xl:text-[16px] font-bold text-gray-800">
      @foreach($dynamicNavItems as $navItem)
        @php
          $isCommitteeNav = ($navItem->title === 'কমিটি' || str_contains($navItem->title, 'কমিটি'));
          $activeCommitteesDropdown = $isCommitteeNav ? $cachedActiveCommittees : collect();

          $hasChildren = ($navItem->activeChildren->count() > 0) 
            || ($isCommitteeNav && $activeCommitteesDropdown->count() > 0);
          $isHome = ($navItem->url === '/' || $navItem->url === route('home')) && request()->routeIs('home');
        @endphp

        @if(!$hasChildren)
          <!-- Simple Nav Link (হোম হলে লাল ব্যাকগ্রাউন্ড বাটন, বাকিগুলো সাধারণ নরমাল টেক্সট লিংক) -->
          @if($isHome)
            <a href="{{ url($navItem->url) }}" target="{{ $navItem->target }}" 
               class="bg-[#c8102e] text-white px-3 py-1.5 rounded-[6px] shadow-sm hover:bg-[#a30b24] transition flex items-center gap-1">
              @if($navItem->icon)
                <i class="{{ $navItem->icon }}"></i>
              @endif
              <span>{{ $navItem->title }}</span>
            </a>
          @else
            <a href="{{ url($navItem->url) }}" target="{{ $navItem->target }}" 
               class="px-2.5 py-1.5 rounded-[6px] hover:text-[#c8102e] transition flex items-center gap-1">
              @if($navItem->icon)
                <i class="{{ $navItem->icon }}"></i>
              @endif
              <span>{{ $navItem->title }}</span>
            </a>
          @endif
        @else
          <!-- Dropdown Nav Item (Level 1) -->
          <div class="relative group">
            <button type="button" class="px-2.5 py-1.5 rounded-[6px] hover:text-[#c8102e] inline-flex items-center gap-1 transition focus:outline-none cursor-pointer">
              @if($navItem->icon)
                <i class="{{ $navItem->icon }} text-[#0b4622]"></i>
              @endif
              <span>{{ $navItem->title }}</span>
              <i class="ri-arrow-down-s-line text-[#c8102e] text-base transition-transform group-hover:rotate-180"></i>
            </button>

            <!-- Level 2 Container (Dropdown Menu) -->
            <div class="absolute left-0 top-full pt-1.5 w-64 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-150 z-50">
              <div class="bg-white rounded-xl shadow-2xl border border-gray-100 py-1.5 text-[13.5px]">
                @if($isCommitteeNav && $navItem->activeChildren->count() === 0)
                  <a href="{{ route('committee.index') }}"
                     class="flex items-center justify-between px-3.5 py-2 bg-emerald-50/70 hover:bg-emerald-100/80 text-[#0b4622] transition text-[13px] font-bold border-b border-emerald-100">
                    <span class="flex items-center gap-1.5">
                      <i class="ri-function-line text-sm text-[#0b4622]"></i>
                      <span>সকল কমিটি সমূহ</span>
                    </span>
                    <i class="ri-arrow-right-s-line text-emerald-600"></i>
                  </a>
                  @forelse($activeCommitteesDropdown as $comm)
                    <a href="{{ route('committee.show', $comm->slug ?: $comm->id) }}"
                       class="flex items-center gap-2 px-3.5 py-2 hover:bg-emerald-50 hover:text-[#0b4622] transition text-[13px] font-bold text-gray-800">
                      <i class="ri-team-line text-[#0b4622]"></i>
                      <span>{{ $comm->name }}</span>
                    </a>
                  @empty
                    <div class="px-3.5 py-2 text-[12.5px] text-gray-400">কোনো সক্রিয় কমিটি নেই</div>
                  @endforelse
                @else
                  @foreach($navItem->activeChildren as $child)
                    @php
                      $hasSubChildren = $child->activeChildren->count() > 0;
                    @endphp

                    @if(!$hasSubChildren)
                      <a href="{{ url($child->url) }}" target="{{ $child->target }}"
                         class="flex items-center gap-2 px-3.5 py-2 hover:bg-red-50 hover:text-[#c8102e] transition text-[13px] font-bold text-gray-800">
                        @if($child->icon)
                          <i class="{{ $child->icon }} text-[#0b4622] text-sm"></i>
                        @endif
                        <span>{{ $child->title }}</span>
                      </a>
                    @else
                      <!-- Level 2 Item with Level 3 Flyout (Max 3rd Level) -->
                      <div class="relative group/lvl2">
                        <a href="{{ url($child->url) }}" target="{{ $child->target }}" class="px-3.5 py-2 hover:bg-emerald-50 hover:text-[#0b4622] flex items-center justify-between cursor-pointer text-[13px] font-bold text-gray-800 transition">
                          <span class="flex items-center gap-2">
                            @if($child->icon)
                              <i class="{{ $child->icon }} text-[#0b4622] text-sm"></i>
                            @endif
                            {{ $child->title }}
                          </span>
                          <i class="ri-arrow-right-s-line text-gray-400 group-hover/lvl2:text-[#0b4622]"></i>
                        </a>

                        <!-- Level 3 Flyout -->
                        <div class="absolute left-full top-0 pl-1.5 w-64 hidden group-hover/lvl2:block lvl3-flyout z-50">
                          <div class="bg-white rounded-xl shadow-2xl border border-gray-100 py-1.5 text-[13px]">
                            @foreach($child->activeChildren as $grandChild)
                              <a href="{{ url($grandChild->url) }}" target="{{ $grandChild->target }}"
                                 class="flex items-center gap-2 px-3.5 py-2 hover:bg-emerald-50 hover:text-[#0b4622] text-gray-800 font-bold transition">
                                @if($grandChild->icon)
                                  <i class="{{ $grandChild->icon }} text-[#0b4622] text-sm"></i>
                                @endif
                                <span>{{ $grandChild->title }}</span>
                              </a>
                            @endforeach
                          </div>
                        </div>
                      </div>
                    @endif
                  @endforeach
                @endif
              </div>
            </div>
          </div>
        @endif
      @endforeach
    </nav>

    <!-- Right Action Buttons (Donate + Mobile Toggle) -->
    <div class="flex items-center gap-2 sm:gap-3 shrink-0">
      <!-- Donate Button -->
      <button type="button" onclick="openDonateModal()" class="inline-flex items-center bg-[#146c32] hover:bg-[#0f5426] text-white rounded-full p-0.5 pr-3 sm:pr-4 shadow-sm transition group cursor-pointer">
        <span class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-[#c8102e] flex items-center justify-center shadow-inner group-hover:scale-105 transition">
          <i class="fa-solid fa-heart text-white text-[11px] sm:text-xs"></i>
        </span>
        <span class="pl-1.5 sm:pl-2.5 text-xs sm:text-sm font-bold tracking-wide">অনুদান</span>
      </button>

      <!-- Desktop User Dropdown Avatar (Logged In Only) -->
      @auth
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
            <div class="px-4 py-2.5 border-b border-gray-100 bg-gray-50/60 rounded-t-2xl">
              <p class="font-extrabold text-gray-900 truncate leading-tight">{{ Auth::user()->name }}</p>
              <p class="text-xs text-gray-500 truncate mt-0.5">{{ Auth::user()->email }}</p>
            </div>

            <div class="py-1">
              <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2 text-gray-700 hover:bg-emerald-50 hover:text-[#0b4622] font-semibold transition">
                <i class="fa-solid fa-gauge text-base text-gray-400"></i>
                <span>ড্যাশবোর্ডে যান</span>
              </a>
            </div>

            <div class="border-t border-gray-100 pt-1">
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
      @endauth

      <!-- Mobile Menu Button (Hamburger toggle) -->
      <button type="button" onclick="toggleMobileMenu()" aria-label="Toggle Menu" class="lg:hidden w-9 h-9 sm:w-10 sm:h-10 rounded-lg border border-gray-200 flex items-center justify-center text-gray-700 hover:bg-gray-50 hover:text-[#c8102e] transition cursor-pointer">
        <i id="mobile-menu-icon" class="ri-menu-3-line text-lg sm:text-xl"></i>
      </button>
    </div>
  </div>

  <!-- Mobile Responsive Navigation Drawer (Dynamic Tree) -->
  <div id="mobile-menu" class="hidden lg:hidden bg-white border-t border-gray-100 px-4 pt-3 pb-6 shadow-xl max-h-[calc(100vh-70px)] overflow-y-auto">
    <div class="flex flex-col space-y-1.5 text-[15px] font-semibold">
      @foreach($dynamicNavItems as $mIdx => $navItem)
        @php
          $isCommitteeNavMobile = ($navItem->title === 'কমিটি' || str_contains($navItem->title, 'কমিটি'));
          $activeCommitteesDropdownMobile = $isCommitteeNavMobile ? $cachedActiveCommittees : collect();

          $hasChildren = ($navItem->activeChildren->count() > 0) 
            || ($isCommitteeNavMobile && $activeCommitteesDropdownMobile->count() > 0);
          $isHome = ($navItem->url === '/' || $navItem->url === route('home')) && request()->routeIs('home');
        @endphp

        @if(!$hasChildren)
          @if($isHome)
            <a href="{{ url($navItem->url) }}" target="{{ $navItem->target }}" 
               class="mobile-nav-link bg-[#c8102e] text-white px-4 py-2.5 rounded-lg flex items-center gap-2">
              @if($navItem->icon)
                <i class="{{ $navItem->icon }}"></i>
              @endif
              <span>{{ $navItem->title }}</span>
            </a>
          @else
            <a href="{{ url($navItem->url) }}" target="{{ $navItem->target }}" 
               class="mobile-nav-link hover:bg-gray-50 px-4 py-2.5 rounded-lg flex items-center gap-2">
              @if($navItem->icon)
                <i class="{{ $navItem->icon }}"></i>
              @endif
              <span>{{ $navItem->title }}</span>
            </a>
          @endif
        @else
          <div>
            <button type="button" onclick="toggleMobileSub('mobile-nav-{{ $mIdx }}', 'mobile-arrow-{{ $mIdx }}')" 
                    class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-gray-800 hover:bg-gray-50">
              <span class="flex items-center gap-2">
                @if($navItem->icon)
                  <i class="{{ $navItem->icon }} text-[#0b4622]"></i>
                @endif
                {{ $navItem->title }}
              </span>
              <i id="mobile-arrow-{{ $mIdx }}" class="ri-arrow-down-s-line text-[#c8102e] text-lg transition-transform"></i>
            </button>

            <!-- Level 2 Mobile Submenu -->
            <div id="mobile-nav-{{ $mIdx }}" class="hidden pl-4 pr-2 py-2 space-y-1.5 text-base text-gray-700 border-l-2 border-emerald-500 ml-4 mt-1">
              @if($isCommitteeNavMobile && $navItem->activeChildren->count() === 0)
                <a href="{{ route('committee.index') }}" class="mobile-nav-link block py-2 hover:text-[#0b4622] text-sm font-bold text-[#0b4622] border-b border-gray-100 mb-1">
                  <i class="ri-function-line mr-1"></i>
                  সকল কমিটি সমূহ
                </a>
                @forelse($activeCommitteesDropdownMobile as $comm)
                  <a href="{{ route('committee.show', $comm->slug ?: $comm->id) }}" class="mobile-nav-link block py-2 hover:text-[#0b4622] text-sm font-bold">
                    <i class="ri-team-line text-[#0b4622] mr-1"></i>
                    {{ $comm->name }}
                  </a>
                @empty
                  <span class="block py-1.5 text-gray-400 text-sm">কোনো সক্রিয় কমিটি নেই</span>
                @endforelse
              @else
                @foreach($navItem->activeChildren as $cIdx => $child)
                  @php
                    $hasSubChildren = $child->activeChildren->count() > 0;
                  @endphp

                @if(!$hasSubChildren)
                  <a href="{{ url($child->url) }}" target="{{ $child->target }}" class="mobile-nav-link block py-2 hover:text-[#c8102e] text-sm font-bold">
                    {{ $child->title }}
                  </a>
                @else
                  <!-- Level 3 Mobile Submenu (Max 3rd Level) -->
                  <div class="py-1">
                    <button type="button" onclick="toggleMobileSub('mobile-sub-{{ $mIdx }}-{{ $cIdx }}', 'mobile-sub-arrow-{{ $mIdx }}-{{ $cIdx }}')" 
                            class="w-full flex items-center justify-between py-1.5 text-sm font-bold text-gray-800 hover:text-[#0b4622]">
                      <span>{{ $child->title }}</span>
                      <i id="mobile-sub-arrow-{{ $mIdx }}-{{ $cIdx }}" class="ri-arrow-down-s-line text-sm transition-transform"></i>
                    </button>
                    <div id="mobile-sub-{{ $mIdx }}-{{ $cIdx }}" class="hidden pl-3 space-y-1.5 text-sm border-l border-gray-200 ml-2 mt-1">
                      @foreach($child->activeChildren as $gcIdx => $grandChild)
                        <a href="{{ url($grandChild->url) }}" target="{{ $grandChild->target }}" class="block py-1.5 font-bold hover:text-[#0b4622]">
                          {{ $grandChild->title }}
                        </a>
                      @endforeach
                    </div>
                  </div>
                @endif
              @endforeach
              @endif
            </div>
          </div>
        @endif
      @endforeach
    </div>

    <!-- Mobile Bottom Action Links (স্বেচ্ছাসেবী কর্মী ও সদস্য হিসেবে যোগদান) -->
    <div class="mt-4 pt-3 border-t border-gray-100 space-y-2">
      <a href="{{ route('volunteers.apply') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-teal-50/70 border border-teal-200/80 text-teal-800 hover:bg-teal-100/80 transition group">
        <div class="flex items-center gap-2.5">
          <span class="w-7 h-7 rounded-lg bg-teal-600 text-white flex items-center justify-center text-xs shadow-2xs">
            <i class="fa-solid fa-hand-holding-heart"></i>
          </span>
          <span class="text-xs sm:text-sm font-bold">স্বেচ্ছাসেবী কর্মী হিসেবে যোগদান করুন</span>
        </div>
        <i class="fa-solid fa-arrow-right text-xs text-teal-600 group-hover:translate-x-0.5 transition-transform"></i>
      </a>

      <a href="{{ route('members.apply') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-emerald-50/70 border border-emerald-200/80 text-[#0b4622] hover:bg-emerald-100/80 transition group">
        <div class="flex items-center gap-2.5">
          <span class="w-7 h-7 rounded-lg bg-[#0b4622] text-white flex items-center justify-center text-xs shadow-2xs">
            <i class="fa-solid fa-user-plus"></i>
          </span>
          <span class="text-xs sm:text-sm font-bold">সদস্য হিসেবে যোগদান করুন</span>
        </div>
        <i class="fa-solid fa-arrow-right text-xs text-[#0b4622] group-hover:translate-x-0.5 transition-transform"></i>
      </a>

      @auth
        <div class="mt-2 bg-gray-50/80 rounded-xl border border-gray-200/80 p-3">
          <div class="flex items-center gap-2.5 min-w-0">
            @if(Auth::user()->photo)
              <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-full object-cover shrink-0 border border-gray-200" />
            @else
              <div class="w-8 h-8 rounded-full bg-[#0b4622] text-white flex items-center justify-center text-xs font-bold shrink-0">
                {{ mb_substr(Auth::user()->name, 0, 1) }}
              </div>
            @endif
            <div class="min-w-0">
              <span class="block text-xs font-bold text-gray-900 leading-tight truncate">{{ Auth::user()->name }}</span>
              <span class="block text-[10px] text-gray-500 truncate">{{ Auth::user()->email }}</span>
            </div>
          </div>
          <div class="mt-2.5 pt-2 border-t border-gray-200/60 flex items-center justify-between text-xs font-bold">
            <a href="{{ route('admin.dashboard') }}" class="text-[#0b4622] hover:underline flex items-center gap-1">
              <i class="fa-solid fa-gauge"></i> ড্যাশবোর্ড
            </a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
              @csrf
              <button type="submit" class="text-[#c8102e] hover:underline cursor-pointer">
                লগআউট
              </button>
            </form>
          </div>
        </div>
      @endauth
    </div>
  </div>
</header>

<script>
function toggleMobileSub(menuId, arrowId) {
  const menu = document.getElementById(menuId);
  const arrow = document.getElementById(arrowId);
  if (!menu) return;
  if (menu.classList.contains('hidden')) {
    menu.classList.remove('hidden');
    if (arrow) arrow.classList.add('rotate-180');
  } else {
    menu.classList.add('hidden');
    if (arrow) arrow.classList.remove('rotate-180');
  }
}
</script>
