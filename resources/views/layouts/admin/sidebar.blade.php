<!-- Clean, Modern White Admin Sidebar (Categorized & Organized by Website Structure) -->
<aside
  id="admin-sidebar"
  class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-100 flex flex-col transition-transform duration-300 ease-in-out lg:translate-x-0 -translate-x-full shadow-[2px_0_12px_rgba(0,0,0,0.02)]"
>
  <!-- Sidebar Header / Logo (Dynamic from Website Settings) -->
  @php
    $adminBranding = $sharedSiteBranding ?? \App\Models\SiteSetting::first();
    $adminLogo = $adminBranding ? $adminBranding->header_logo_url : asset('assets/images/logo-icon.png');
    $adminTitle = ($adminBranding && !empty($adminBranding->site_title)) ? $adminBranding->site_title : 'আগামীর শৈলকুপা';
    $sidebarUser = auth()->user();
    $can = function($permission) use ($sidebarUser) {
      if (!$sidebarUser) return false;
      if ($sidebarUser->hasRole('admin') || $sidebarUser->hasRole('super-admin')) return true;
      return $sidebarUser->can($permission);
    };

    // Pending counts for subtle badge notification
    $pendingVolunteersCount = \App\Models\Volunteer::where('status', false)->count();
    $pendingMembersCount = \App\Models\Member::where('status', false)->count();
    $unreadMessagesCount = \App\Models\ContactMessage::where('is_read', false)->count();
  @endphp

  <div class="h-16 sm:h-[72px] flex items-center justify-between px-5 border-b border-gray-100 bg-white">
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 group">
      <img
        src="{{ $adminLogo }}"
        alt="{{ $adminTitle }}"
        class="w-9 h-9 object-contain shrink-0 group-hover:scale-105 transition"
      />
      <div class="flex flex-col">
        <span class="text-[17px] font-extrabold tracking-tight text-[#b91c1c] leading-tight">
          {{ $adminTitle }}
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
      class="lg:hidden text-gray-400 hover:text-gray-700 p-1.5 rounded-lg hover:bg-gray-100 transition cursor-pointer"
      aria-label="Close Sidebar"
    >
      <i class="ri-close-line text-xl"></i>
    </button>
  </div>

  <!-- Navigation Menu List with Custom Scrollbar -->
  <nav id="admin-sidebar-nav" class="flex-1 overflow-y-auto px-3.5 py-3 space-y-4 text-sm custom-scrollbar">

    <!-- ========================================================================= -->
    <!-- ১. ওভারভিউ / Overview                                                     -->
    <!-- ========================================================================= -->
    <div>
      <div class="px-3 pb-1">
        <span class="text-[10px] font-extrabold uppercase tracking-wider text-gray-400">ওভারভিউ</span>
      </div>
      <a
        href="{{ route('admin.dashboard') }}"
        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#0b4622] text-white shadow-2xs font-bold' : 'text-gray-700 hover:bg-gray-50 hover:text-[#0b4622]' }}"
      >
        <div class="flex items-center gap-3">
          <i class="ri-dashboard-3-line text-base w-5 text-center {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-400' }}"></i>
          <span>ড্যাশবোর্ড</span>
        </div>
      </a>
    </div>


    <!-- ========================================================================= -->
    <!-- ২. সংগঠন ও জনবল (Organization & People)                                 -->
    <!-- ========================================================================= -->
    @if($can('members.view') || $can('members.create') || $can('volunteers.view') || $can('volunteers.create') || $can('committees.view') || $can('committees.create') || $can('person_messages.view') || $can('person_messages.create'))
    <div>
      <div class="px-3 pb-1">
        <span class="text-[10px] font-extrabold uppercase tracking-wider text-gray-400">সংগঠন ও জনবল</span>
      </div>
      <div class="space-y-1">

        {{-- সদস্য ব্যবস্থাপনা --}}
        @if($can('members.view') || $can('members.create') || $can('members.export'))
        @php
          $isMembersActive = request()->routeIs('admin.members*');
        @endphp
        <div class="sidebar-dropdown-group">
          <button
            type="button"
            onclick="toggleSidebarDropdown('menu-members', this)"
            class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium transition cursor-pointer focus:outline-none {{ $isMembersActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
          >
            <div class="flex items-center gap-3">
              <i class="ri-user-star-line text-base w-5 text-center {{ $isMembersActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
              <span>সদস্য ব্যবস্থাপনা</span>
            </div>
            <div class="flex items-center gap-1.5">
              @if($pendingMembersCount > 0)
                <span class="px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800" title="অপেক্ষমাণ আবেদন">
                  {{ $pendingMembersCount }}
                </span>
              @endif
              <i class="ri-arrow-down-s-line text-sm transition-transform duration-300 dropdown-arrow {{ $isMembersActive ? 'rotate-180 text-[#0b4622]' : 'text-gray-400' }}"></i>
            </div>
          </button>
          <div id="menu-members" class="sidebar-submenu overflow-hidden transition-all duration-300 ease-in-out {{ $isMembersActive ? 'max-h-[500px] opacity-100 mt-1' : 'max-h-0 opacity-0' }}">
            <div class="bg-[#f8fafc] border border-gray-100 rounded-xl p-1.5 space-y-0.5 ml-2 border-l-2 border-l-[#0b4622]/40">
              @if($can('members.view'))
              <a href="{{ route('admin.members.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.members.index') && !request()->has('status') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-list-check-2 text-sm"></i>
                <span>সকল সদস্য</span>
              </a>
              <a href="{{ route('admin.members.index', ['status' => 'pending']) }}" class="flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request('status') === 'pending' ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <span class="flex items-center gap-2">
                  <i class="ri-time-line text-sm"></i>
                  <span>অপেক্ষমাণ আবেদন</span>
                </span>
                @if($pendingMembersCount > 0)
                  <span class="text-[10px] font-bold px-1.5 rounded bg-amber-100 text-amber-800">{{ $pendingMembersCount }}</span>
                @endif
              </a>
              @endif

              @if($can('members.create'))
              <a href="{{ route('admin.members.create') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.members.create') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-user-add-line text-sm"></i>
                <span>নতুন সদস্য যোগ</span>
              </a>
              @endif
            </div>
          </div>
        </div>
        @endif

        {{-- স্বেচ্ছাসেবী কর্মী --}}
        @if($can('volunteers.view') || $can('volunteers.create') || $can('volunteers.export'))
        @php
          $isVolunteersActive = request()->routeIs('admin.volunteers*');
        @endphp
        <div class="sidebar-dropdown-group">
          <button
            type="button"
            onclick="toggleSidebarDropdown('menu-volunteers', this)"
            class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium transition cursor-pointer focus:outline-none {{ $isVolunteersActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
          >
            <div class="flex items-center gap-3">
              <i class="ri-hand-heart-line text-base w-5 text-center {{ $isVolunteersActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
              <span>স্বেচ্ছাসেবী কর্মী</span>
            </div>
            <div class="flex items-center gap-1.5">
              @if($pendingVolunteersCount > 0)
                <span class="px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800" title="অপেক্ষমাণ আবেদন">
                  {{ $pendingVolunteersCount }}
                </span>
              @endif
              <i class="ri-arrow-down-s-line text-sm transition-transform duration-300 dropdown-arrow {{ $isVolunteersActive ? 'rotate-180 text-[#0b4622]' : 'text-gray-400' }}"></i>
            </div>
          </button>
          <div id="menu-volunteers" class="sidebar-submenu overflow-hidden transition-all duration-300 ease-in-out {{ $isVolunteersActive ? 'max-h-[500px] opacity-100 mt-1' : 'max-h-0 opacity-0' }}">
            <div class="bg-[#f8fafc] border border-gray-100 rounded-xl p-1.5 space-y-0.5 ml-2 border-l-2 border-l-[#0b4622]/40">
              @if($can('volunteers.view'))
              <a href="{{ route('admin.volunteers.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.volunteers.index') && !request()->has('status') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-list-check-2 text-sm"></i>
                <span>সকল স্বেচ্ছাসেবী</span>
              </a>
              <a href="{{ route('admin.volunteers.index', ['status' => 'pending']) }}" class="flex items-center justify-between px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request('status') === 'pending' ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <span class="flex items-center gap-2">
                  <i class="ri-time-line text-sm"></i>
                  <span>নতুন আবেদন</span>
                </span>
                @if($pendingVolunteersCount > 0)
                  <span class="text-[10px] font-bold px-1.5 rounded bg-amber-100 text-amber-800">{{ $pendingVolunteersCount }}</span>
                @endif
              </a>
              @endif

              @if($can('volunteers.create'))
              <a href="{{ route('admin.volunteers.create') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.volunteers.create') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-user-add-line text-sm"></i>
                <span>নতুন স্বেচ্ছাসেবী যোগ</span>
              </a>
              @endif
            </div>
          </div>
        </div>
        @endif

        {{-- কমিটি ও পরিষদ --}}
        @if($can('committees.view') || $can('committees.create'))
        @php
          $isCommitteeActive = request()->routeIs('admin.committees*') || request()->routeIs('admin.committee-members*');
        @endphp
        <div class="sidebar-dropdown-group">
          <button
            type="button"
            onclick="toggleSidebarDropdown('menu-committees', this)"
            class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium transition cursor-pointer focus:outline-none {{ $isCommitteeActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
          >
            <div class="flex items-center gap-3">
              <i class="ri-team-line text-base w-5 text-center {{ $isCommitteeActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
              <span>কমিটি ও পরিষদ</span>
            </div>
            <i class="ri-arrow-down-s-line text-sm transition-transform duration-300 dropdown-arrow {{ $isCommitteeActive ? 'rotate-180 text-[#0b4622]' : 'text-gray-400' }}"></i>
          </button>
          <div id="menu-committees" class="sidebar-submenu overflow-hidden transition-all duration-300 ease-in-out {{ $isCommitteeActive ? 'max-h-[500px] opacity-100 mt-1' : 'max-h-0 opacity-0' }}">
            <div class="bg-[#f8fafc] border border-gray-100 rounded-xl p-1.5 space-y-0.5 ml-2 border-l-2 border-l-[#0b4622]/40">
              @if($can('committees.view'))
              <a href="{{ route('admin.committees.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.committees.index') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-list-check-2 text-sm"></i>
                <span>সকল কমিটি</span>
              </a>
              <a href="{{ route('admin.committee-members.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.committee-members.*') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-user-star-line text-sm"></i>
                <span>কমিটি সদস্যবৃন্দ</span>
              </a>
              @endif

              @if($can('committees.create'))
              <a href="{{ route('admin.committees.create') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.committees.create') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-add-circle-line text-sm"></i>
                <span>নতুন কমিটি যোগ</span>
              </a>
              <a href="{{ route('admin.committee-members.create') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.committee-members.create') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-user-add-line text-sm"></i>
                <span>কমিটিতে সদস্য যোগ</span>
              </a>
              @endif
            </div>
          </div>
        </div>
        @endif

        {{-- ব্যক্তিবর্গের বাণী --}}
        @if($can('person_messages.view') || $can('person_messages.create'))
        @php
          $isMsgActive = request()->routeIs('admin.person-messages*');
        @endphp
        <div class="sidebar-dropdown-group">
          <button
            type="button"
            onclick="toggleSidebarDropdown('menu-person-messages', this)"
            class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium transition cursor-pointer focus:outline-none {{ $isMsgActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
          >
            <div class="flex items-center gap-3">
              <i class="ri-chat-quote-line text-base w-5 text-center {{ $isMsgActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
              <span>ব্যক্তিবর্গের বাণী</span>
            </div>
            <i class="ri-arrow-down-s-line text-sm transition-transform duration-300 dropdown-arrow {{ $isMsgActive ? 'rotate-180 text-[#0b4622]' : 'text-gray-400' }}"></i>
          </button>
          <div id="menu-person-messages" class="sidebar-submenu overflow-hidden transition-all duration-300 ease-in-out {{ $isMsgActive ? 'max-h-[500px] opacity-100 mt-1' : 'max-h-0 opacity-0' }}">
            <div class="bg-[#f8fafc] border border-gray-100 rounded-xl p-1.5 space-y-0.5 ml-2 border-l-2 border-l-[#0b4622]/40">
              @if($can('person_messages.view'))
              <a href="{{ route('admin.person-messages.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.person-messages.index') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-list-check-2 text-sm"></i>
                <span>সকল বাণী</span>
              </a>
              @endif
              @if($can('person_messages.create'))
              <a href="{{ route('admin.person-messages.create') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.person-messages.create') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-add-line text-sm"></i>
                <span>নতুন বাণী যোগ</span>
              </a>
              @endif
            </div>
          </div>
        </div>
        @endif

      </div>
    </div>
    @endif


    <!-- ========================================================================= -->
    <!-- ৩. উপজেলা পরিচিতি ও তথ্য (Upazila & Local Information)                 -->
    <!-- ========================================================================= -->
    @if($can('unions.view') || $can('unions.create') || $can('institutions.view') || $can('institutions.create') || $can('offices.view') || $can('offices.create') || $can('places.view') || $can('places.create') || $can('prides.view') || $can('prides.create'))
    <div>
      <div class="px-3 pb-1">
        <span class="text-[10px] font-extrabold uppercase tracking-wider text-gray-400">উপজেলা পরিচিতি ও তথ্য</span>
      </div>
      <div class="space-y-1">

        {{-- ইউনিয়ন পরিষদ --}}
        @if($can('unions.view') || $can('unions.create'))
        @php
          $isUnionsActive = request()->routeIs('admin.unions*');
        @endphp
        <div class="sidebar-dropdown-group">
          <button
            type="button"
            onclick="toggleSidebarDropdown('menu-unions', this)"
            class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium transition cursor-pointer focus:outline-none {{ $isUnionsActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
          >
            <div class="flex items-center gap-3">
              <i class="ri-community-line text-base w-5 text-center {{ $isUnionsActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
              <span>ইউনিয়ন পরিষদ</span>
            </div>
            <i class="ri-arrow-down-s-line text-sm transition-transform duration-300 dropdown-arrow {{ $isUnionsActive ? 'rotate-180 text-[#0b4622]' : 'text-gray-400' }}"></i>
          </button>
          <div id="menu-unions" class="sidebar-submenu overflow-hidden transition-all duration-300 ease-in-out {{ $isUnionsActive ? 'max-h-[500px] opacity-100 mt-1' : 'max-h-0 opacity-0' }}">
            <div class="bg-[#f8fafc] border border-gray-100 rounded-xl p-1.5 space-y-0.5 ml-2 border-l-2 border-l-[#0b4622]/40">
              @if($can('unions.view'))
              <a href="{{ route('admin.unions.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.unions.index') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-list-check-2 text-sm"></i>
                <span>সকল ইউনিয়ন</span>
              </a>
              @endif
              @if($can('unions.create'))
              <a href="{{ route('admin.unions.create') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.unions.create') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-add-line text-sm"></i>
                <span>নতুন ইউনিয়ন যোগ</span>
              </a>
              @endif
            </div>
          </div>
        </div>
        @endif

        {{-- প্রতিষ্ঠান সমূহ --}}
        @if($can('institutions.view') || $can('institutions.create'))
        @php
          $isInstitutionsActive = request()->routeIs('admin.institutions*');
        @endphp
        <div class="sidebar-dropdown-group">
          <button
            type="button"
            onclick="toggleSidebarDropdown('menu-institutions', this)"
            class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium transition cursor-pointer focus:outline-none {{ $isInstitutionsActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
          >
            <div class="flex items-center gap-3">
              <i class="ri-building-2-line text-base w-5 text-center {{ $isInstitutionsActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
              <span>প্রতিষ্ঠান সমূহ</span>
            </div>
            <i class="ri-arrow-down-s-line text-sm transition-transform duration-300 dropdown-arrow {{ $isInstitutionsActive ? 'rotate-180 text-[#0b4622]' : 'text-gray-400' }}"></i>
          </button>
          <div id="menu-institutions" class="sidebar-submenu overflow-hidden transition-all duration-300 ease-in-out {{ $isInstitutionsActive ? 'max-h-[500px] opacity-100 mt-1' : 'max-h-0 opacity-0' }}">
            <div class="bg-[#f8fafc] border border-gray-100 rounded-xl p-1.5 space-y-0.5 ml-2 border-l-2 border-l-[#0b4622]/40">
              @if($can('institutions.view'))
              <a href="{{ route('admin.institutions.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.institutions.index') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-list-check-2 text-sm"></i>
                <span>সকল প্রতিষ্ঠান</span>
              </a>
              <a href="{{ route('admin.institutions.categories.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.institutions.categories*') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-price-tag-3-line text-sm"></i>
                <span>ক্যাটাগরি সমূহ</span>
              </a>
              @endif
              @if($can('institutions.create'))
              <a href="{{ route('admin.institutions.create') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.institutions.create') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-add-line text-sm"></i>
                <span>প্রতিষ্ঠান যোগ করুন</span>
              </a>
              @endif
            </div>
          </div>
        </div>
        @endif

        {{-- অফিস সমূহ --}}
        @if($can('offices.view') || $can('offices.create'))
        @php
          $isOfficesActive = request()->routeIs('admin.offices*');
        @endphp
        <div class="sidebar-dropdown-group">
          <button
            type="button"
            onclick="toggleSidebarDropdown('menu-offices', this)"
            class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium transition cursor-pointer focus:outline-none {{ $isOfficesActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
          >
            <div class="flex items-center gap-3">
              <i class="ri-government-line text-base w-5 text-center {{ $isOfficesActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
              <span>অফিস সমূহ</span>
            </div>
            <i class="ri-arrow-down-s-line text-sm transition-transform duration-300 dropdown-arrow {{ $isOfficesActive ? 'rotate-180 text-[#0b4622]' : 'text-gray-400' }}"></i>
          </button>
          <div id="menu-offices" class="sidebar-submenu overflow-hidden transition-all duration-300 ease-in-out {{ $isOfficesActive ? 'max-h-[500px] opacity-100 mt-1' : 'max-h-0 opacity-0' }}">
            <div class="bg-[#f8fafc] border border-gray-100 rounded-xl p-1.5 space-y-0.5 ml-2 border-l-2 border-l-[#0b4622]/40">
              @if($can('offices.view'))
              <a href="{{ route('admin.offices.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.offices.index') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-list-check-2 text-sm"></i>
                <span>সকল অফিস</span>
              </a>
              @endif
              @if($can('offices.create'))
              <a href="{{ route('admin.offices.create') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.offices.create') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-add-line text-sm"></i>
                <span>নতুন অফিস যোগ</span>
              </a>
              @endif
            </div>
          </div>
        </div>
        @endif

        {{-- দর্শনীয় স্থান --}}
        @if($can('places.view') || $can('places.create'))
        @php
          $isPlacesActive = request()->routeIs('admin.places*');
        @endphp
        <div class="sidebar-dropdown-group">
          <button
            type="button"
            onclick="toggleSidebarDropdown('menu-places', this)"
            class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium transition cursor-pointer focus:outline-none {{ $isPlacesActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
          >
            <div class="flex items-center gap-3">
              <i class="ri-map-pin-2-line text-base w-5 text-center {{ $isPlacesActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
              <span>দর্শনীয় স্থান</span>
            </div>
            <i class="ri-arrow-down-s-line text-sm transition-transform duration-300 dropdown-arrow {{ $isPlacesActive ? 'rotate-180 text-[#0b4622]' : 'text-gray-400' }}"></i>
          </button>
          <div id="menu-places" class="sidebar-submenu overflow-hidden transition-all duration-300 ease-in-out {{ $isPlacesActive ? 'max-h-[500px] opacity-100 mt-1' : 'max-h-0 opacity-0' }}">
            <div class="bg-[#f8fafc] border border-gray-100 rounded-xl p-1.5 space-y-0.5 ml-2 border-l-2 border-l-[#0b4622]/40">
              @if($can('places.view'))
              <a href="{{ route('admin.places.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.places.index') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-list-check-2 text-sm"></i>
                <span>সকল দর্শনীয় স্থান</span>
              </a>
              @endif
              @if($can('places.create'))
              <a href="{{ route('admin.places.create') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.places.create') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-add-line text-sm"></i>
                <span>নতুন স্থান যোগ</span>
              </a>
              @endif
            </div>
          </div>
        </div>
        @endif

        {{-- কৃতি সন্তান --}}
        @if($can('prides.view') || $can('prides.create'))
        @php
          $isPridesActive = request()->routeIs('admin.prides*');
        @endphp
        <div class="sidebar-dropdown-group">
          <button
            type="button"
            onclick="toggleSidebarDropdown('menu-prides', this)"
            class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium transition cursor-pointer focus:outline-none {{ $isPridesActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
          >
            <div class="flex items-center gap-3">
              <i class="ri-award-line text-base w-5 text-center {{ $isPridesActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
              <span>কৃতি সন্তান</span>
            </div>
            <i class="ri-arrow-down-s-line text-sm transition-transform duration-300 dropdown-arrow {{ $isPridesActive ? 'rotate-180 text-[#0b4622]' : 'text-gray-400' }}"></i>
          </button>
          <div id="menu-prides" class="sidebar-submenu overflow-hidden transition-all duration-300 ease-in-out {{ $isPridesActive ? 'max-h-[500px] opacity-100 mt-1' : 'max-h-0 opacity-0' }}">
            <div class="bg-[#f8fafc] border border-gray-100 rounded-xl p-1.5 space-y-0.5 ml-2 border-l-2 border-l-[#0b4622]/40">
              @if($can('prides.view'))
              <a href="{{ route('admin.prides.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.prides.index') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-list-check-2 text-sm"></i>
                <span>সকল কৃতি সন্তান</span>
              </a>
              @endif
              @if($can('prides.create'))
              <a href="{{ route('admin.prides.create') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.prides.create') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-user-add-line text-sm"></i>
                <span>কৃতি সন্তান যোগ</span>
              </a>
              @endif
            </div>
          </div>
        </div>
        @endif

      </div>
    </div>
    @endif


    <!-- ========================================================================= -->
    <!-- ৪. কার্যক্রম ও তহবিল (Programs & Donations)                             -->
    <!-- ========================================================================= -->
    @if($can('donations.view') || $can('donations.create') || $can('projects.view') || $can('projects.create') || $can('events.view') || $can('events.create'))
    <div>
      <div class="px-3 pb-1">
        <span class="text-[10px] font-extrabold uppercase tracking-wider text-gray-400">কার্যক্রম ও তহবিল</span>
      </div>
      <div class="space-y-1">

        {{-- অনুদান সংগ্রহ --}}
        @if($can('donations.view') || $can('donations.create') || $can('donations.export'))
        @php
          $isDonationsActive = request()->routeIs('admin.donations*');
        @endphp
        <div class="sidebar-dropdown-group">
          <button
            type="button"
            onclick="toggleSidebarDropdown('menu-donations', this)"
            class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium transition cursor-pointer focus:outline-none {{ $isDonationsActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
          >
            <div class="flex items-center gap-3">
              <i class="ri-hand-coin-line text-base w-5 text-center {{ $isDonationsActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
              <span>অনুদান সংগ্রহ</span>
            </div>
            <i class="ri-arrow-down-s-line text-sm transition-transform duration-300 dropdown-arrow {{ $isDonationsActive ? 'rotate-180 text-[#0b4622]' : 'text-gray-400' }}"></i>
          </button>
          <div id="menu-donations" class="sidebar-submenu overflow-hidden transition-all duration-300 ease-in-out {{ $isDonationsActive ? 'max-h-[500px] opacity-100 mt-1' : 'max-h-0 opacity-0' }}">
            <div class="bg-[#f8fafc] border border-gray-100 rounded-xl p-1.5 space-y-0.5 ml-2 border-l-2 border-l-[#0b4622]/40">
              @if($can('donations.view'))
              <a href="{{ route('admin.donations.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.donations.index') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-file-list-3-line text-sm"></i>
                <span>অনুদানের তালিকা</span>
              </a>
              @endif
              @if($can('donations.create'))
              <a href="{{ route('admin.donations.create') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.donations.create') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-add-circle-line text-sm"></i>
                <span>নতুন অনুদান এন্ট্রি</span>
              </a>
              @endif
            </div>
          </div>
        </div>
        @endif

        {{-- উন্নয়ন প্রকল্পসমূহ --}}
        @if($can('projects.view') || $can('projects.create'))
        @php
          $isProjectsActive = request()->routeIs('admin.projects*');
        @endphp
        <div class="sidebar-dropdown-group">
          <button
            type="button"
            onclick="toggleSidebarDropdown('menu-projects', this)"
            class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium transition cursor-pointer focus:outline-none {{ $isProjectsActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
          >
            <div class="flex items-center gap-3">
              <i class="ri-stack-line text-base w-5 text-center {{ $isProjectsActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
              <span>উন্নয়ন প্রকল্প</span>
            </div>
            <i class="ri-arrow-down-s-line text-sm transition-transform duration-300 dropdown-arrow {{ $isProjectsActive ? 'rotate-180 text-[#0b4622]' : 'text-gray-400' }}"></i>
          </button>
          <div id="menu-projects" class="sidebar-submenu overflow-hidden transition-all duration-300 ease-in-out {{ $isProjectsActive ? 'max-h-[500px] opacity-100 mt-1' : 'max-h-0 opacity-0' }}">
            <div class="bg-[#f8fafc] border border-gray-100 rounded-xl p-1.5 space-y-0.5 ml-2 border-l-2 border-l-[#0b4622]/40">
              @if($can('projects.view'))
              <a href="{{ route('admin.projects.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.projects.index') && !request()->filled('project_status') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-list-check-2 text-sm"></i>
                <span>সকল প্রকল্প</span>
              </a>
              <a href="{{ route('admin.projects.index', ['project_status' => 'running']) }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request('project_status') === 'running' ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-loader-4-line text-sm text-emerald-600"></i>
                <span>চলমান প্রকল্পসমূহ</span>
              </a>
              @endif
              @if($can('projects.create'))
              <a href="{{ route('admin.projects.create') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.projects.create') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-add-line text-sm"></i>
                <span>নতুন প্রকল্প যোগ</span>
              </a>
              @endif
            </div>
          </div>
        </div>
        @endif

        {{-- কার্যক্রম ও ইভেন্ট --}}
        @if($can('events.view') || $can('events.create'))
        @php
          $isEventsActive = request()->routeIs('admin.events*');
        @endphp
        <div class="sidebar-dropdown-group">
          <button
            type="button"
            onclick="toggleSidebarDropdown('menu-events', this)"
            class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium transition cursor-pointer focus:outline-none {{ $isEventsActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
          >
            <div class="flex items-center gap-3">
              <i class="ri-calendar-event-line text-base w-5 text-center {{ $isEventsActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
              <span>কার্যক্রম ও ইভেন্ট</span>
            </div>
            <i class="ri-arrow-down-s-line text-sm transition-transform duration-300 dropdown-arrow {{ $isEventsActive ? 'rotate-180 text-[#0b4622]' : 'text-gray-400' }}"></i>
          </button>
          <div id="menu-events" class="sidebar-submenu overflow-hidden transition-all duration-300 ease-in-out {{ $isEventsActive ? 'max-h-[500px] opacity-100 mt-1' : 'max-h-0 opacity-0' }}">
            <div class="bg-[#f8fafc] border border-gray-100 rounded-xl p-1.5 space-y-0.5 ml-2 border-l-2 border-l-[#0b4622]/40">
              @if($can('events.view'))
              <a href="{{ route('admin.events.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.events.index') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-calendar-check-line text-sm"></i>
                <span>সকল ইভেন্ট</span>
              </a>
              @endif
              @if($can('events.create'))
              <a href="{{ route('admin.events.create') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.events.create') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-calendar-todo-line text-sm"></i>
                <span>নতুন ইভেন্ট যোগ</span>
              </a>
              @endif
            </div>
          </div>
        </div>
        @endif

      </div>
    </div>
    @endif


    <!-- ========================================================================= -->
    <!-- ৫. মিডিয়া ও প্রকাশনা (Media & Publications)                             -->
    <!-- ========================================================================= -->
    @if($can('notices.view') || $can('notices.create') || $can('posts.view') || $can('posts.create') || $can('gallery.view') || $can('gallery.create') || $can('pages.view') || $can('pages.create'))
    <div>
      <div class="px-3 pb-1">
        <span class="text-[10px] font-extrabold uppercase tracking-wider text-gray-400">মিডিয়া ও প্রকাশনা</span>
      </div>
      <div class="space-y-1">

        {{-- নোটিশ ও বিজ্ঞপ্তি --}}
        @if($can('notices.view') || $can('notices.create'))
        @php
          $isNoticesActive = request()->routeIs('admin.notices*');
        @endphp
        <div class="sidebar-dropdown-group">
          <button
            type="button"
            onclick="toggleSidebarDropdown('menu-notices', this)"
            class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium transition cursor-pointer focus:outline-none {{ $isNoticesActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
          >
            <div class="flex items-center gap-3">
              <i class="ri-megaphone-line text-base w-5 text-center {{ $isNoticesActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
              <span>নোটিশ ও বিজ্ঞপ্তি</span>
            </div>
            <i class="ri-arrow-down-s-line text-sm transition-transform duration-300 dropdown-arrow {{ $isNoticesActive ? 'rotate-180 text-[#0b4622]' : 'text-gray-400' }}"></i>
          </button>
          <div id="menu-notices" class="sidebar-submenu overflow-hidden transition-all duration-300 ease-in-out {{ $isNoticesActive ? 'max-h-[500px] opacity-100 mt-1' : 'max-h-0 opacity-0' }}">
            <div class="bg-[#f8fafc] border border-gray-100 rounded-xl p-1.5 space-y-0.5 ml-2 border-l-2 border-l-[#0b4622]/40">
              @if($can('notices.view'))
              <a href="{{ route('admin.notices.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.notices.index') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-file-list-3-line text-sm"></i>
                <span>সকল নোটিশ</span>
              </a>
              @endif
              @if($can('notices.create'))
              <a href="{{ route('admin.notices.create') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.notices.create') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-file-add-line text-sm"></i>
                <span>নোটিশ প্রকাশ করুন</span>
              </a>
              @endif
            </div>
          </div>
        </div>
        @endif

        {{-- ব্লগ ও সংবাদ --}}
        @if($can('posts.view') || $can('posts.create'))
        @php
          $isBlogActive = request()->routeIs('admin.categories*') || request()->routeIs('admin.posts*');
        @endphp
        <div class="sidebar-dropdown-group">
          <button
            type="button"
            onclick="toggleSidebarDropdown('menu-blogs', this)"
            class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium transition cursor-pointer focus:outline-none {{ $isBlogActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
          >
            <div class="flex items-center gap-3">
              <i class="ri-article-line text-base w-5 text-center {{ $isBlogActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
              <span>ব্লগ ও সংবাদ</span>
            </div>
            <i class="ri-arrow-down-s-line text-sm transition-transform duration-300 dropdown-arrow {{ $isBlogActive ? 'rotate-180 text-[#0b4622]' : 'text-gray-400' }}"></i>
          </button>
          <div id="menu-blogs" class="sidebar-submenu overflow-hidden transition-all duration-300 ease-in-out {{ $isBlogActive ? 'max-h-[500px] opacity-100 mt-1' : 'max-h-0 opacity-0' }}">
            <div class="bg-[#f8fafc] border border-gray-100 rounded-xl p-1.5 space-y-0.5 ml-2 border-l-2 border-l-[#0b4622]/40">
              @if($can('posts.view'))
              <a href="{{ route('admin.posts.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.posts.index') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-list-check-2 text-sm"></i>
                <span>সকল ব্লগ পোস্ট</span>
              </a>
              <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.categories.*') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-price-tag-3-line text-sm"></i>
                <span>ব্লগ ক্যাটাগরি</span>
              </a>
              @endif
              @if($can('posts.create'))
              <a href="{{ route('admin.posts.create') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.posts.create') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-add-line text-sm"></i>
                <span>নতুন পোস্ট লিখুন</span>
              </a>
              @endif
            </div>
          </div>
        </div>
        @endif

        {{-- গ্যালারি মিডিয়া --}}
        @if($can('gallery.view') || $can('gallery.create'))
        @php
          $isGalleryActive = request()->routeIs('admin.gallery*');
        @endphp
        <div class="sidebar-dropdown-group">
          <button
            type="button"
            onclick="toggleSidebarDropdown('menu-gallery', this)"
            class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium transition cursor-pointer focus:outline-none {{ $isGalleryActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
          >
            <div class="flex items-center gap-3">
              <i class="ri-image-2-line text-base w-5 text-center {{ $isGalleryActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
              <span>গ্যালারি মিডিয়া</span>
            </div>
            <i class="ri-arrow-down-s-line text-sm transition-transform duration-300 dropdown-arrow {{ $isGalleryActive ? 'rotate-180 text-[#0b4622]' : 'text-gray-400' }}"></i>
          </button>
          <div id="menu-gallery" class="sidebar-submenu overflow-hidden transition-all duration-300 ease-in-out {{ $isGalleryActive ? 'max-h-[500px] opacity-100 mt-1' : 'max-h-0 opacity-0' }}">
            <div class="bg-[#f8fafc] border border-gray-100 rounded-xl p-1.5 space-y-0.5 ml-2 border-l-2 border-l-[#0b4622]/40">
              @if($can('gallery.view'))
              <a href="{{ route('admin.gallery.index', ['type' => 'photo']) }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.gallery.index') && request('type') === 'photo' ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-image-line text-sm"></i>
                <span>ছবি অ্যালবাম</span>
              </a>
              <a href="{{ route('admin.gallery.index', ['type' => 'video']) }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.gallery.index') && request('type') === 'video' ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-video-line text-sm"></i>
                <span>ভিডিও গ্যালারি</span>
              </a>
              @endif
              @if($can('gallery.create'))
              <a href="{{ route('admin.gallery.create') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.gallery.create') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-image-add-line text-sm"></i>
                <span>ছবি/ভিডিও আপলোড</span>
              </a>
              @endif
            </div>
          </div>
        </div>
        @endif

        {{-- পেজ ব্যবস্থাপনা --}}
        @if($can('pages.view') || $can('pages.create'))
        @php
          $isPagesActive = request()->routeIs('admin.pages*');
        @endphp
        <div class="sidebar-dropdown-group">
          <button
            type="button"
            onclick="toggleSidebarDropdown('menu-pages', this)"
            class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium transition cursor-pointer focus:outline-none {{ $isPagesActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
          >
            <div class="flex items-center gap-3">
              <i class="ri-pages-line text-base w-5 text-center {{ $isPagesActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
              <span>পেজ ব্যবস্থাপনা</span>
            </div>
            <i class="ri-arrow-down-s-line text-sm transition-transform duration-300 dropdown-arrow {{ $isPagesActive ? 'rotate-180 text-[#0b4622]' : 'text-gray-400' }}"></i>
          </button>
          <div id="menu-pages" class="sidebar-submenu overflow-hidden transition-all duration-300 ease-in-out {{ $isPagesActive ? 'max-h-[500px] opacity-100 mt-1' : 'max-h-0 opacity-0' }}">
            <div class="bg-[#f8fafc] border border-gray-100 rounded-xl p-1.5 space-y-0.5 ml-2 border-l-2 border-l-[#0b4622]/40">
              @if($can('pages.view'))
              <a href="{{ route('admin.pages.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.pages.index') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-file-list-2-line text-sm"></i>
                <span>সকল পেজ</span>
              </a>
              @endif
              @if($can('pages.create'))
              <a href="{{ route('admin.pages.create') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.pages.create') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-file-add-line text-sm"></i>
                <span>নতুন পেজ তৈরি</span>
              </a>
              @endif
            </div>
          </div>
        </div>
        @endif

        {{-- গঠনতন্ত্র ও বিধিমালা --}}
        @php
          $isRulesActive = request()->routeIs('admin.rules*');
        @endphp
        <div class="sidebar-dropdown-group">
          <button
            type="button"
            onclick="toggleSidebarDropdown('menu-rules', this)"
            class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium transition cursor-pointer focus:outline-none {{ $isRulesActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
          >
            <div class="flex items-center gap-3">
              <i class="ri-book-open-line text-base w-5 text-center {{ $isRulesActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
              <span>গঠনতন্ত্র ও বিধিমালা</span>
            </div>
            <i class="ri-arrow-down-s-line text-sm transition-transform duration-300 dropdown-arrow {{ $isRulesActive ? 'rotate-180 text-[#0b4622]' : 'text-gray-400' }}"></i>
          </button>
          <div id="menu-rules" class="sidebar-submenu overflow-hidden transition-all duration-300 ease-in-out {{ $isRulesActive ? 'max-h-[500px] opacity-100 mt-1' : 'max-h-0 opacity-0' }}">
            <div class="bg-[#f8fafc] border border-gray-100 rounded-xl p-1.5 space-y-0.5 ml-2 border-l-2 border-l-[#0b4622]/40">
              <a href="{{ route('admin.rules.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.rules.index') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-list-check-2 text-sm"></i>
                <span>সকল ভাগ ও নীতিমালা</span>
              </a>
              <a href="{{ route('admin.rules.create') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.rules.create') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-add-circle-line text-sm"></i>
                <span>নতুন ভাগ যোগ করুন</span>
              </a>
            </div>
          </div>
        </div>

      </div>
    </div>
    @endif


    <!-- ========================================================================= -->
    <!-- ৬. যোগাযোগ ও প্রশাসন (Communications & Administration)                   -->
    <!-- ========================================================================= -->
    @if($can('contact_messages.view') || $can('users.view') || $can('roles.manage'))
    <div>
      <div class="px-3 pb-1">
        <span class="text-[10px] font-extrabold uppercase tracking-wider text-gray-400">যোগাযোগ ও প্রশাসন</span>
      </div>
      <div class="space-y-1">

        {{-- যোগাযোগের বার্তা --}}
        @if($can('contact_messages.view'))
        @php
          $isContactMsgActive = request()->routeIs('admin.contact-messages*');
        @endphp
        <a
          href="{{ route('admin.contact-messages.index') }}"
          class="flex items-center justify-between px-3.5 py-2 rounded-xl font-medium transition cursor-pointer {{ $isContactMsgActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
        >
          <div class="flex items-center gap-3">
            <i class="ri-mail-line text-base w-5 text-center {{ $isContactMsgActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
            <span>যোগাযোগের বার্তা</span>
          </div>
          @if($unreadMessagesCount > 0)
            <span class="inline-flex items-center justify-center px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-[#c8102e] text-white">
              {{ $unreadMessagesCount }}
            </span>
          @endif
        </a>
        @endif

        {{-- ব্যবহারকারী ও রোল --}}
        @if($can('users.view') || $can('roles.manage'))
        @php
          $isUsersActive = request()->routeIs('admin.users*') || request()->routeIs('admin.roles*') || request()->routeIs('admin.permissions*');
        @endphp
        <div class="sidebar-dropdown-group">
          <button
            type="button"
            onclick="toggleSidebarDropdown('menu-users', this)"
            class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium transition cursor-pointer focus:outline-none {{ $isUsersActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
          >
            <div class="flex items-center gap-3">
              <i class="ri-user-settings-line text-base w-5 text-center {{ $isUsersActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
              <span>ব্যবহারকারী ও রোল</span>
            </div>
            <i class="ri-arrow-down-s-line text-sm transition-transform duration-300 dropdown-arrow {{ $isUsersActive ? 'rotate-180 text-[#0b4622]' : 'text-gray-400' }}"></i>
          </button>
          <div id="menu-users" class="sidebar-submenu overflow-hidden transition-all duration-300 ease-in-out {{ $isUsersActive ? 'max-h-[500px] opacity-100 mt-1' : 'max-h-0 opacity-0' }}">
            <div class="bg-[#f8fafc] border border-gray-100 rounded-xl p-1.5 space-y-0.5 ml-2 border-l-2 border-l-[#0b4622]/40">
              @if($can('users.view'))
              <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.users*') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-team-line text-sm"></i>
                <span>সকল ব্যবহারকারী</span>
              </a>
              @endif

              @if($can('roles.manage'))
              <a href="{{ route('admin.roles.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.roles*') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-shield-user-line text-sm"></i>
                <span>রোল ও পারমিশন বরাদ্দ</span>
              </a>
              <a href="{{ route('admin.permissions.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.permissions.index') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-key-2-line text-sm"></i>
                <span>সিস্টেম পারমিশন তালিকা</span>
              </a>
              @endif
            </div>
          </div>
        </div>
        @endif

      </div>
    </div>
    @endif


    <!-- ========================================================================= -->
    <!-- ৭. সেটিংস ও কাস্টমাইজেশন (Settings & Customization)                     -->
    <!-- ========================================================================= -->
    @if($can('customization.view') || $can('settings.mail'))
    <div>
      <div class="px-3 pb-1">
        <span class="text-[10px] font-extrabold uppercase tracking-wider text-gray-400">সেটিংস ও কাস্টমাইজেশন</span>
      </div>
      <div class="space-y-1">

        {{-- ওয়েবসাইট কাস্টমাইজেশন --}}
        @if($can('customization.view'))
        @php
          $isCustomActive = request()->routeIs('admin.customization*') || request()->routeIs('admin.hero-banners*');
        @endphp
        <div class="sidebar-dropdown-group">
          <button
            type="button"
            onclick="toggleSidebarDropdown('menu-customization', this)"
            class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium transition cursor-pointer focus:outline-none {{ $isCustomActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
          >
            <div class="flex items-center gap-3">
              <i class="ri-palette-line text-base w-5 text-center {{ $isCustomActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
              <span>ওয়েবসাইট কাস্টমাইজ</span>
            </div>
            <i class="ri-arrow-down-s-line text-sm transition-transform duration-300 dropdown-arrow {{ $isCustomActive ? 'rotate-180 text-[#0b4622]' : 'text-gray-400' }}"></i>
          </button>
          <div id="menu-customization" class="sidebar-submenu overflow-hidden transition-all duration-300 ease-in-out {{ $isCustomActive ? 'max-h-[600px] opacity-100 mt-1' : 'max-h-0 opacity-0' }}">
            <div class="bg-[#f8fafc] border border-gray-100 rounded-xl p-1.5 space-y-0.5 ml-2 border-l-2 border-l-[#0b4622]/40">
              <a href="{{ route('admin.customization.branding') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.customization.branding') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-brush-line text-sm"></i>
                <span>লোগো ও ব্র্যান্ডিং</span>
              </a>
              <a href="{{ route('admin.hero-banners.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.hero-banners.*') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-slideshow-line text-sm"></i>
                <span>হোম স্লাইডার ও ব্যানার</span>
              </a>
              <a href="{{ route('admin.customization.navbar') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.customization.navbar') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-menu-line text-sm"></i>
                <span>নেভবার মেন্যু সেটিংস</span>
              </a>
              <a href="{{ route('admin.customization.topbar') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.customization.topbar') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-layout-top-line text-sm"></i>
                <span>টপবার হেডার</span>
              </a>
              <a href="{{ route('admin.stat-counters.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.stat-counters.*') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-numbers-line text-sm"></i>
                <span>পরিসংখ্যান কাউন্টার</span>
              </a>
              <a href="{{ route('admin.customization.about') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.customization.about') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-information-line text-sm"></i>
                <span>আমাদের সম্পর্কে</span>
              </a>
              <a href="{{ route('admin.customization.president') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.customization.president') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-user-voice-line text-sm"></i>
                <span>সভাপতির বাণী</span>
              </a>
              <a href="{{ route('admin.customization.donation') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.customization.donation') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-bank-card-line text-sm"></i>
                <span>অনুদান ব্যানার সেটিংস</span>
              </a>
              <a href="{{ route('admin.customization.contact') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.customization.contact') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-contacts-line text-sm"></i>
                <span>যোগাযোগ তথ্য</span>
              </a>
              <a href="{{ route('admin.social-media.index') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.social-media.*') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-share-line text-sm"></i>
                <span>সোশ্যাল মিডিয়া লিংক</span>
              </a>
              <a href="{{ route('admin.customization.footer') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.customization.footer') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
                <i class="ri-layout-bottom-line text-sm"></i>
                <span>ফুটার ও কপিরাইট</span>
              </a>
            </div>
          </div>
        </div>
        @endif

        {{-- ইমেইল কনফিগারেশন --}}
        @if($can('settings.mail'))
        @php
          $isSettingsActive = request()->routeIs('admin.settings.mail*');
        @endphp
        <a
          href="{{ route('admin.settings.mail') }}"
          class="flex items-center justify-between px-3.5 py-2 rounded-xl font-medium transition cursor-pointer {{ $isSettingsActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
        >
          <div class="flex items-center gap-3">
            <i class="ri-mail-settings-line text-base w-5 text-center {{ $isSettingsActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
            <span>ইমেইল কনফিগারেশন</span>
          </div>
        </a>
        @endif

        {{-- ফন্ট সেটিংস (Font Settings) --}}
        @if($can('customization.view') || $can('settings.mail'))
        @php
          $isFontActive = request()->routeIs('admin.settings.font*');
        @endphp
        <a
          href="{{ route('admin.settings.font') }}"
          class="flex items-center justify-between px-3.5 py-2 rounded-xl font-medium transition cursor-pointer {{ $isFontActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
        >
          <div class="flex items-center gap-3">
            <i class="ri-font-size text-base w-5 text-center {{ $isFontActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
            <span>ফন্ট সেটিংস</span>
          </div>
          <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-emerald-100 text-emerald-800">
            Font
          </span>
        </a>
        @endif

      </div>
    </div>
    @endif


    <!-- ========================================================================= -->
    <!-- ৮. আমার প্রোফাইল (My Profile & Session)                                   -->
    <!-- ========================================================================= -->
    <div>
      <div class="px-3 pb-1">
        <span class="text-[10px] font-extrabold uppercase tracking-wider text-gray-400">অ্যাকাউন্ট</span>
      </div>
      @php
        $isProfileActive = request()->routeIs('admin.profile*');
      @endphp
      <div class="sidebar-dropdown-group">
        <button
          type="button"
          onclick="toggleSidebarDropdown('menu-my-profile', this)"
          class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium transition cursor-pointer focus:outline-none {{ $isProfileActive ? 'bg-gray-100/70 text-[#0b4622] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"
        >
          <div class="flex items-center gap-3">
            <i class="ri-user-smile-line text-base w-5 text-center {{ $isProfileActive ? 'text-[#0b4622]' : 'text-gray-400' }}"></i>
            <span>আমার প্রোফাইল</span>
          </div>
          <i class="ri-arrow-down-s-line text-sm transition-transform duration-300 dropdown-arrow {{ $isProfileActive ? 'rotate-180 text-[#0b4622]' : 'text-gray-400' }}"></i>
        </button>

        <div id="menu-my-profile" class="sidebar-submenu overflow-hidden transition-all duration-300 ease-in-out {{ $isProfileActive ? 'max-h-96 opacity-100 mt-1' : 'max-h-0 opacity-0' }}">
          <div class="bg-[#f8fafc] border border-gray-100 rounded-xl p-1.5 space-y-0.5 ml-2 border-l-2 border-l-[#0b4622]/40">
            <a href="{{ route('admin.profile') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.profile') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
              <i class="ri-user-settings-line text-sm"></i>
              <span>প্রোফাইল আপডেট</span>
            </a>
            <a href="{{ route('admin.profile.password') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ request()->routeIs('admin.profile.password') ? 'bg-[#0b4622] text-white font-bold' : 'text-gray-600 hover:bg-white hover:text-[#0b4622]' }}">
              <i class="ri-lock-password-line text-sm"></i>
              <span>পাসওয়ার্ড পরিবর্তন</span>
            </a>
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="w-full flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold text-[#c8102e] hover:bg-red-50 transition cursor-pointer">
                <i class="ri-logout-box-r-line text-sm"></i>
                <span>লগআউট করুন</span>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

  </nav>

  <!-- Sidebar Footer: Visit Live Website Button -->
  <div class="p-3 border-t border-gray-100 bg-white">
    <a
      href="{{ route('home') }}"
      target="_blank"
      class="w-full flex items-center justify-center gap-2 px-3.5 py-2 rounded-xl border border-gray-200 text-gray-700 hover:text-[#0b4622] hover:border-emerald-300 hover:bg-emerald-50/50 text-xs font-semibold transition"
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
