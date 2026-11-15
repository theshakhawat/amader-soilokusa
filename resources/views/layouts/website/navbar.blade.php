<!-- =====================================================================
     2. MAIN NAVIGATION BAR (Fully Dynamic Nav Items with Multi-level Dropdowns)
     ===================================================================== -->
<header id="site-main-header" class="site-main-navbar bg-white sticky top-0 z-40 shadow-[0_2px_10px_rgba(0,0,0,0.06)]">
  <div class="max-w-[1240px] mx-auto px-3 sm:px-6 h-[64px] sm:h-[76px] flex items-center justify-between gap-2 sm:gap-4">
    @php
      $navBranding = \App\Models\SiteSetting::first();
      $navLogo = $navBranding ? $navBranding->header_logo_url : asset('assets/images/logo-icon.png');
      $navTitle = $navBranding ? $navBranding->site_title : 'আগামীর শৈলকুপা';
      $navTagline = $navBranding ? $navBranding->site_tagline : 'শৈলকুপার উন্নয়নে আমরা এক পরিবার';

      // Load Dynamic Navigation Tree from DB
      $dynamicNavItems = \App\Models\NavItem::whereNull('parent_id')
          ->where('status', true)
          ->with(['activeChildren.activeChildren'])
          ->orderBy('order', 'asc')
          ->get();
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
    <nav class="hidden xl:flex items-center gap-1 text-[14px] 2xl:text-[15px] font-semibold text-gray-800">
      @foreach($dynamicNavItems as $navItem)
        @php
          $isCommitteeNav = ($navItem->title === 'কমিটি' || str_contains($navItem->title, 'কমিটি'));
          $activeCommitteesDropdown = $isCommitteeNav ? \App\Models\Committee::where('is_active', true)->orderBy('order', 'asc')->get() : collect();

          $isUpazilaNav = ($navItem->title === 'উপজেলা পরিচিতি' || str_contains($navItem->title, 'উপজেলা'));
          $activeUnionsDropdown = $isUpazilaNav ? \App\Models\Union::where('status', true)->orderBy('order', 'asc')->get() : collect();

          $hasChildren = ($navItem->activeChildren->count() > 0) 
            || ($isCommitteeNav && $activeCommitteesDropdown->count() > 0)
            || ($isUpazilaNav && $activeUnionsDropdown->count() > 0);
          $isHome = ($navItem->url === '/' || $navItem->url === route('home')) && request()->routeIs('home');
        @endphp

        @if(!$hasChildren)
          <!-- Simple Nav Link (হোম হলে লাল ব্যাকগ্রাউন্ড বাটন, বাকিগুলো সাধারণ নরমাল টেক্সট লিংক) -->
          @if($isHome)
            <a href="{{ url($navItem->url) }}" target="{{ $navItem->target }}" 
               class="bg-[#c8102e] text-white px-4 py-1.5 rounded-[6px] shadow-sm hover:bg-[#a30b24] transition flex items-center gap-1">
              @if($navItem->icon)
                <i class="{{ $navItem->icon }}"></i>
              @endif
              <span>{{ $navItem->title }}</span>
            </a>
          @else
            <a href="{{ url($navItem->url) }}" target="{{ $navItem->target }}" 
               class="px-3.5 py-1.5 rounded-[6px] hover:text-[#c8102e] transition flex items-center gap-1">
              @if($navItem->icon)
                <i class="{{ $navItem->icon }}"></i>
              @endif
              <span>{{ $navItem->title }}</span>
            </a>
          @endif
        @else
          <!-- Dropdown Nav Item (Level 1) -->
          <div class="relative group">
            <button type="button" class="px-3 py-1.5 rounded-[6px] hover:text-[#c8102e] inline-flex items-center gap-1 transition focus:outline-none cursor-pointer">
              @if($navItem->icon)
                <i class="{{ $navItem->icon }} text-[#0b4622]"></i>
              @endif
              <span>{{ $navItem->title }}</span>
              <i class="ri-arrow-down-s-line text-[#c8102e] text-base transition-transform group-hover:rotate-180"></i>
            </button>

            <!-- Level 2 Container -->
            <div class="absolute left-0 top-full pt-1.5 w-60 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-150 z-50">
              <div class="bg-white rounded-xl shadow-2xl border border-gray-100 py-1.5 text-sm {{ $isUpazilaNav ? 'max-h-[460px] overflow-y-auto custom-nav-scrollbar' : '' }}">
                @if($isCommitteeNav)
                  <a href="{{ route('committee.index') }}"
                     class="flex items-center justify-between px-4 py-2 bg-emerald-50/70 hover:bg-emerald-100/80 text-[#0b4622] transition text-xs font-bold border-b border-emerald-100">
                    <span class="flex items-center gap-1.5">
                      <i class="ri-function-line text-sm text-[#0b4622]"></i>
                      <span>সকল কমিটি সমূহ</span>
                    </span>
                    <i class="ri-arrow-right-s-line text-emerald-600"></i>
                  </a>
                  @forelse($activeCommitteesDropdown as $comm)
                    <a href="{{ route('committee.show', $comm->slug ?: $comm->id) }}"
                       class="flex items-center gap-2 px-4 py-2 hover:bg-emerald-50 hover:text-[#0b4622] transition text-xs font-semibold text-gray-700">
                      <i class="ri-team-line text-[#0b4622]"></i>
                      <span>{{ $comm->name }}</span>
                    </a>
                  @empty
                    <div class="px-4 py-2 text-xs text-gray-400">কোনো সক্রিয় কমিটি নেই</div>
                  @endforelse
                @elseif($isUpazilaNav)
                  <a href="{{ route('unions.index') }}"
                     class="flex items-center justify-between px-4 py-2 bg-emerald-50/70 hover:bg-emerald-100/80 text-[#0b4622] transition text-xs font-bold border-b border-emerald-100">
                    <span class="flex items-center gap-1.5">
                      <i class="ri-community-line text-sm text-[#0b4622]"></i>
                      <span>সমস্ত ইউনিয়ন সমূহ</span>
                    </span>
                    <i class="ri-arrow-right-s-line text-emerald-600"></i>
                  </a>
                  @forelse($activeUnionsDropdown as $u)
                    <a href="{{ route('unions.detail', $u->slug) }}"
                       class="flex items-center gap-2 px-4 py-1.5 hover:bg-emerald-50 hover:text-[#0b4622] transition text-xs font-semibold text-gray-700">
                      <i class="ri-building-line text-[#0b4622]"></i>
                      <span>{{ $u->name }}</span>
                    </a>
                  @empty
                    <div class="px-4 py-2 text-xs text-gray-400">কোনো সক্রিয় ইউনিয়ন নেই</div>
                  @endforelse
                @else
                  @php
                    $isInstitutionNav = (str_contains($navItem->title, 'প্রতিষ্ঠান') || $navItem->url === '/institutions');
                    $isOfficeNav = (str_contains($navItem->title, 'অফিস') || $navItem->url === '/offices');
                  @endphp

                  @if($isInstitutionNav)
                    <a href="{{ route('institutions.home') }}"
                       class="flex items-center justify-between px-4 py-2 bg-emerald-50/70 hover:bg-emerald-100/80 text-[#0b4622] transition text-xs font-bold border-b border-emerald-100">
                      <span class="flex items-center gap-1.5">
                        <i class="ri-building-line text-sm text-[#0b4622]"></i>
                        <span>সমস্ত প্রতিষ্ঠান সমূহ</span>
                      </span>
                      <i class="ri-arrow-right-s-line text-emerald-600"></i>
                    </a>
                  @elseif($isOfficeNav)
                    <a href="{{ route('offices.index') }}"
                       class="flex items-center justify-between px-4 py-2 bg-emerald-50/70 hover:bg-emerald-100/80 text-[#0b4622] transition text-xs font-bold border-b border-emerald-100">
                      <span class="flex items-center gap-1.5">
                        <i class="ri-government-line text-sm text-[#0b4622]"></i>
                        <span>সমস্ত অফিস সমূহ</span>
                      </span>
                      <i class="ri-arrow-right-s-line text-emerald-600"></i>
                    </a>
                  @endif

                  @foreach($navItem->activeChildren as $child)
                    @php
                      $hasSubChildren = $child->activeChildren->count() > 0;
                      $isOverviewItem = ($isInstitutionNav && ($child->url === '/institutions' || str_contains($child->title, 'সমস্ত'))) 
                                     || ($isOfficeNav && ($child->url === '/offices' || str_contains($child->title, 'সমস্ত')));
                    @endphp

                    @if($isOverviewItem)
                      @continue
                    @endif

                  @if(!$hasSubChildren)
                    <a href="{{ url($child->url) }}" target="{{ $child->target }}"
                       class="flex items-center gap-2 px-4 py-2 hover:bg-red-50 hover:text-[#c8102e] transition text-xs font-semibold text-gray-700">
                      @if($child->icon)
                        <i class="{{ $child->icon }} text-[#0b4622]"></i>
                      @endif
                      <span>{{ $child->title }}</span>
                    </a>
                  @else
                    <!-- Level 2 Item with Level 3 Flyout -->
                    <div class="relative group/lvl2">
                      <a href="{{ url($child->url ?: '/unions') }}" class="px-4 py-2 hover:bg-emerald-50 hover:text-[#0b4622] flex items-center justify-between cursor-pointer text-xs font-bold text-gray-800 transition">
                        <span class="flex items-center gap-2">
                          @if($child->icon)
                            <i class="{{ $child->icon }} text-[#0b4622]"></i>
                          @endif
                          {{ $child->title }}
                        </span>
                        <i class="ri-arrow-right-s-line text-gray-400 group-hover/lvl2:text-[#0b4622]"></i>
                      </a>

                      <!-- Level 3 Flyout -->
                      <div class="absolute left-full top-0 pl-1 w-56 hidden group-hover/lvl2:block lvl3-flyout z-50">
                        <div class="bg-white rounded-xl shadow-2xl border border-gray-100 py-1.5 text-xs max-h-[460px] overflow-y-auto custom-nav-scrollbar">
                          @php
                            $isUnionLvl2 = ($child->title === 'ইউনিয়ন পরিচিতি' || $child->url === '/unions' || str_contains($child->url, 'unions'));
                          @endphp

                          @if($isUnionLvl2)
                            @php
                              $activeUnionsList = \App\Models\Union::where('status', true)->orderBy('order', 'asc')->get();
                            @endphp
                            @forelse($activeUnionsList as $u)
                              <a href="{{ route('unions.detail', $u->slug) }}"
                                 class="flex items-center gap-2 px-3.5 py-1.5 hover:bg-emerald-50 hover:text-[#0b4622] text-gray-700 font-medium transition">
                                <i class="ri-community-line text-[#0b4622] text-xs shrink-0"></i>
                                <span>{{ str_replace([' ইউনিয়ন পরিষদ', ' ইউনিয়ন পরিষদ'], '', $u->name) }}</span>
                              </a>
                            @empty
                              <span class="block px-3.5 py-1.5 text-gray-400 text-xs">কোনো সক্রিয় ইউনিয়ন নেই</span>
                            @endforelse
                          @else
                            @foreach($child->activeChildren as $grandChild)
                              @php
                                $hasGreatChildren = $grandChild->activeChildren->count() > 0;
                              @endphp

                              @if(!$hasGreatChildren)
                                <a href="{{ url($grandChild->url) }}" target="{{ $grandChild->target }}"
                                   class="flex items-center gap-2 px-3.5 py-1.5 hover:bg-emerald-50 hover:text-[#0b4622] text-gray-700 font-medium transition">
                                  @if($grandChild->icon)
                                    <i class="{{ $grandChild->icon }} text-[#0b4622]"></i>
                                  @endif
                                  <span>{{ $grandChild->title }}</span>
                                </a>
                              @else
                                <!-- Level 3 with Level 4 Flyout -->
                                <div class="relative group/lvl3">
                                  <div class="px-3.5 py-1.5 hover:bg-emerald-50 hover:text-[#0b4622] flex items-center justify-between cursor-pointer text-xs font-semibold text-gray-700 transition">
                                    <span>{{ $grandChild->title }}</span>
                                    <i class="ri-arrow-right-s-line text-gray-400 group-hover/lvl3:text-[#0b4622]"></i>
                                  </div>
                                  <div class="absolute left-full top-0 pl-1 w-44 hidden group-hover/lvl3:block lvl4-flyout z-50">
                                    <div class="bg-white rounded-xl shadow-2xl border border-gray-100 py-1.5 text-xs">
                                      @foreach($grandChild->activeChildren as $fourthChild)
                                        <a href="{{ url($fourthChild->url) }}" target="{{ $fourthChild->target }}"
                                           class="flex items-center gap-2 px-3.5 py-1.5 hover:bg-emerald-50 hover:text-[#0b4622] text-gray-700 font-medium transition">
                                          @if($fourthChild->icon)
                                            <i class="{{ $fourthChild->icon }}"></i>
                                          @endif
                                          <span>{{ $fourthChild->title }}</span>
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
              @endif
              </div>
            </div>
          </div>
        @endif
      @endforeach
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
        <!-- Desktop User Dropdown Avatar -->
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
      @endguest

      <!-- Mobile Menu Button (Hamburger toggle) -->
      <button type="button" onclick="toggleMobileMenu()" aria-label="Toggle Menu" class="xl:hidden w-9 h-9 sm:w-10 sm:h-10 rounded-lg border border-gray-200 flex items-center justify-center text-gray-700 hover:bg-gray-50 hover:text-[#c8102e] transition cursor-pointer">
        <i id="mobile-menu-icon" class="ri-menu-3-line text-lg sm:text-xl"></i>
      </button>
    </div>
  </div>

  <!-- Mobile Responsive Navigation Drawer (Dynamic Tree) -->
  <div id="mobile-menu" class="hidden xl:hidden bg-white border-t border-gray-100 px-4 pt-3 pb-6 shadow-xl max-h-[calc(100vh-70px)] overflow-y-auto">
    <div class="flex flex-col space-y-1.5 text-[15px] font-semibold">
      @foreach($dynamicNavItems as $mIdx => $navItem)
        @php
          $isCommitteeNavMobile = ($navItem->title === 'কমিটি' || str_contains($navItem->title, 'কমিটি'));
          $activeCommitteesDropdownMobile = $isCommitteeNavMobile ? \App\Models\Committee::where('is_active', true)->orderBy('order', 'asc')->get() : collect();

          $isUpazilaNavMobile = ($navItem->title === 'উপজেলা পরিচিতি' || str_contains($navItem->title, 'উপজেলা'));
          $activeUnionsDropdownMobile = $isUpazilaNavMobile ? \App\Models\Union::where('status', true)->orderBy('order', 'asc')->get() : collect();

          $hasChildren = ($navItem->activeChildren->count() > 0) 
            || ($isCommitteeNavMobile && $activeCommitteesDropdownMobile->count() > 0)
            || ($isUpazilaNavMobile && $activeUnionsDropdownMobile->count() > 0);
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
            <div id="mobile-nav-{{ $mIdx }}" class="hidden pl-4 pr-2 py-1.5 space-y-1 text-sm text-gray-600 border-l-2 border-emerald-500 ml-4 mt-1">
              @if($isCommitteeNavMobile)
                <a href="{{ route('committee.index') }}" class="mobile-nav-link block py-1.5 hover:text-[#0b4622] text-xs font-bold text-[#0b4622] border-b border-gray-100 mb-1">
                  <i class="ri-function-line mr-1"></i>
                  সকল কমিটি সমূহ
                </a>
                @forelse($activeCommitteesDropdownMobile as $comm)
                  <a href="{{ route('committee.show', $comm->slug ?: $comm->id) }}" class="mobile-nav-link block py-1.5 hover:text-[#0b4622] text-xs font-semibold">
                    <i class="ri-team-line text-[#0b4622] mr-1"></i>
                    {{ $comm->name }}
                  </a>
                @empty
                  <span class="block py-1 text-gray-400 text-xs">কোনো সক্রিয় কমিটি নেই</span>
                @endforelse
              @elseif($isUpazilaNavMobile)
                <a href="{{ route('unions.index') }}" class="mobile-nav-link block py-1.5 hover:text-[#0b4622] text-xs font-bold text-[#0b4622] border-b border-gray-100 mb-1">
                  <i class="ri-community-line mr-1"></i>
                  সমস্ত ইউনিয়ন সমূহ
                </a>
                @forelse($activeUnionsDropdownMobile as $u)
                  <a href="{{ route('unions.detail', $u->slug) }}" class="mobile-nav-link block py-1.5 hover:text-[#0b4622] text-xs font-semibold">
                    <i class="ri-building-line text-[#0b4622] mr-1"></i>
                    {{ $u->name }}
                  </a>
                @empty
                  <span class="block py-1 text-gray-400 text-xs">কোনো সক্রিয় ইউনিয়ন নেই</span>
                @endforelse
              @else
                @php
                  $isInstitutionNavMobile = (str_contains($navItem->title, 'প্রতিষ্ঠান') || $navItem->url === '/institutions');
                  $isOfficeNavMobile = (str_contains($navItem->title, 'অফিস') || $navItem->url === '/offices');
                @endphp

                @if($isInstitutionNavMobile)
                  <a href="{{ route('institutions.home') }}" class="mobile-nav-link block py-1.5 hover:text-[#0b4622] text-xs font-bold text-[#0b4622] border-b border-gray-100 mb-1">
                    <i class="ri-building-line mr-1"></i>
                    সমস্ত প্রতিষ্ঠান সমূহ
                  </a>
                @elseif($isOfficeNavMobile)
                  <a href="{{ route('offices.index') }}" class="mobile-nav-link block py-1.5 hover:text-[#0b4622] text-xs font-bold text-[#0b4622] border-b border-gray-100 mb-1">
                    <i class="ri-government-line mr-1"></i>
                    সমস্ত অফিস সমূহ
                  </a>
                @endif

                @foreach($navItem->activeChildren as $cIdx => $child)
                  @php
                    $hasSubChildren = $child->activeChildren->count() > 0;
                    $isOverviewItemMobile = ($isInstitutionNavMobile && ($child->url === '/institutions' || str_contains($child->title, 'সমস্ত'))) 
                                         || ($isOfficeNavMobile && ($child->url === '/offices' || str_contains($child->title, 'সমস্ত')));
                  @endphp

                  @if($isOverviewItemMobile)
                    @continue
                  @endif

                @if(!$hasSubChildren)
                  <a href="{{ url($child->url) }}" target="{{ $child->target }}" class="mobile-nav-link block py-1.5 hover:text-[#c8102e] text-xs">
                    {{ $child->title }}
                  </a>
                @else
                  <!-- Level 3 Mobile Submenu -->
                  <div class="py-1">
                    <button type="button" onclick="toggleMobileSub('mobile-sub-{{ $mIdx }}-{{ $cIdx }}', 'mobile-sub-arrow-{{ $mIdx }}-{{ $cIdx }}')" 
                            class="w-full flex items-center justify-between py-1 text-xs font-bold text-gray-800 hover:text-[#0b4622]">
                      <span>{{ $child->title }}</span>
                      <i id="mobile-sub-arrow-{{ $mIdx }}-{{ $cIdx }}" class="ri-arrow-down-s-line text-xs transition-transform"></i>
                    </button>
                    <div id="mobile-sub-{{ $mIdx }}-{{ $cIdx }}" class="hidden pl-3 space-y-1 text-xs border-l border-gray-200 ml-2 mt-1">
                      @php
                        $isUnionMobile = ($child->title === 'ইউনিয়ন পরিচিতি' || $child->url === '/unions' || str_contains($child->url, 'unions'));
                      @endphp

                      @if($isUnionMobile)
                        @php
                          $activeUnionsMobile = \App\Models\Union::where('status', true)->orderBy('order', 'asc')->get();
                        @endphp
                        @forelse($activeUnionsMobile as $u)
                          <a href="{{ route('unions.detail', $u->slug) }}" class="block py-1 hover:text-[#0b4622] text-gray-700 font-medium">
                            {{ str_replace([' ইউনিয়ন পরিষদ', ' ইউনিয়ন পরিষদ'], '', $u->name) }}
                          </a>
                        @empty
                          <span class="block py-1 text-gray-400 text-[11px]">কোনো সক্রিয় ইউনিয়ন নেই</span>
                        @endforelse
                      @else
                        @foreach($child->activeChildren as $gcIdx => $grandChild)
                          @php
                            $hasGreatChildren = $grandChild->activeChildren->count() > 0;
                          @endphp

                          @if(!$hasGreatChildren)
                            <a href="{{ url($grandChild->url) }}" target="{{ $grandChild->target }}" class="block py-1 hover:text-[#0b4622]">
                              {{ $grandChild->title }}
                            </a>
                          @else
                            <div class="py-1">
                              <button type="button" onclick="toggleMobileSub('mobile-g-{{ $mIdx }}-{{ $cIdx }}-{{ $gcIdx }}', 'mobile-g-arrow-{{ $mIdx }}-{{ $cIdx }}-{{ $gcIdx }}')" 
                                      class="w-full flex items-center justify-between py-0.5 text-gray-700 font-semibold hover:text-[#0b4622]">
                                <span>{{ $grandChild->title }}</span>
                                <i id="mobile-g-arrow-{{ $mIdx }}-{{ $cIdx }}-{{ $gcIdx }}" class="ri-arrow-down-s-line text-[10px] transition-transform"></i>
                              </button>
                              <div id="mobile-g-{{ $mIdx }}-{{ $cIdx }}-{{ $gcIdx }}" class="hidden pl-3 space-y-0.5 text-[11px] text-gray-500 border-l border-emerald-200 ml-2 py-1">
                                @foreach($grandChild->activeChildren as $fourthChild)
                                  <a href="{{ url($fourthChild->url) }}" target="{{ $fourthChild->target }}" class="block py-0.5 hover:text-[#0b4622]">
                                    {{ $fourthChild->title }}
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
              @endif
            </div>
          </div>
        @endif
      @endforeach
    </div>

    <!-- Mobile Auth Section -->
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
        <div class="bg-gray-50/80 rounded-xl border border-gray-200/80 overflow-hidden">
          <div class="p-3">
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
            <div class="mt-3 pt-2 border-t border-gray-200/60 flex items-center justify-between text-xs font-bold">
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
        </div>
      @endguest
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
