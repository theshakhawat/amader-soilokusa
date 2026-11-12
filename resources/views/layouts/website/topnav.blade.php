<!-- =====================================================================
     1. TOP HEADER BAR (Fully Responsive & Dynamic from Admin Customization)
     ===================================================================== -->
@php
  $topbarSetting = \App\Models\TopbarSetting::first();
  $isTopbarActive = $topbarSetting ? $topbarSetting->is_active : true;
  $showContact = $topbarSetting ? $topbarSetting->show_contact : true;
  $showSocial = $topbarSetting ? $topbarSetting->show_social : true;

  $topbarContact = \App\Models\ContactSetting::first();
  $topbarSocialLinks = \App\Models\SocialLink::where('is_active', true)->orderBy('order')->orderBy('id')->get();
@endphp

@if($isTopbarActive)
<div id="website-topbar-header" class="bg-[#c8102e] text-white text-[11px] sm:text-xs md:text-[13px] py-1.5 sm:py-2 border-b border-red-800/30 transition-all duration-300">
  <div class="max-w-[1220px] mx-auto px-3 sm:px-6 flex flex-row items-center justify-between gap-2">
    <!-- Left Contact Info -->
    @if($showContact)
    <div class="flex items-center gap-x-3 sm:gap-x-5 overflow-hidden text-ellipsis whitespace-nowrap">
      @if(!empty($topbarContact->location))
      <span class="inline-flex items-center gap-1 font-medium shrink-0">
        <i class="fa-solid fa-location-dot text-white text-[10px] sm:text-[12px]"></i>
        <span>{{ $topbarContact->location }}</span>
      </span>
      @endif

      @if(!empty($topbarContact->phone))
      <a href="tel:{{ $topbarContact->phone }}" class="inline-flex items-center gap-1 hover:text-red-100 transition-colors shrink-0">
        <i class="fa-solid fa-phone text-white text-[10px] sm:text-[11px]"></i>
        <span class="font-sans text-[11px] sm:text-xs">{{ $topbarContact->phone }}</span>
      </a>
      @endif

      @if(!empty($topbarContact->email))
      <a href="mailto:{{ $topbarContact->email }}" class="hidden md:inline-flex items-center gap-1.5 hover:text-red-100 transition-colors">
        <i class="fa-regular fa-envelope text-white text-[12px]"></i>
        <span class="font-sans">{{ $topbarContact->email }}</span>
      </a>
      @endif
    </div>
    @else
    <div></div>
    @endif

    <!-- Right Dynamic Social Icons -->
    @if($showSocial)
    <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
      @foreach($topbarSocialLinks as $social)
        <a
          href="{{ $social->url }}"
          target="{{ $social->target }}"
          aria-label="{{ $social->platform }}"
          class="w-5 h-5 rounded-[4px] bg-white text-[#c8102e] flex items-center justify-center hover:bg-red-50 hover:scale-105 transition shadow-2xs"
        >
          <i class="{{ $social->icon }} text-[10px] sm:text-[11px]"></i>
        </a>
      @endforeach
    </div>
    @endif
  </div>
</div>
@endif
