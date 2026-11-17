@extends('layouts.website.website-layout')

@section('title', 'সম্মানিত স্বেচ্ছাসেবী কর্মীগণ — আগামীর শৈলকুপা')

@section('content')
<div class="max-w-[1220px] mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-8 sm:space-y-10">

  <!-- Breadcrumb -->
  <nav class="flex items-center gap-2 text-xs sm:text-sm text-gray-500 bg-white px-4 py-2.5 rounded-2xl border border-gray-100 shadow-2xs">
    <a href="{{ route('home') }}" class="hover:text-[#0b4622] flex items-center gap-1 transition">
      <i class="ri-home-4-line"></i>
      <span>হোম</span>
    </a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <span class="text-[#0b4622] font-semibold">স্বেচ্ছাসেবী কর্মীগণ</span>
  </nav>

  <!-- Page Header -->
  <div class="text-center max-w-3xl mx-auto space-y-3">
    <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-[#0b4622] border border-emerald-200">
      <i class="ri-hand-heart-line"></i>
      আমাদের প্রাণশক্তি
    </span>
    <h1 class="text-2xl sm:text-4xl font-black text-gray-900 tracking-tight">
      স্বেচ্ছাসেবী কর্মী দল
    </h1>
    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed max-w-2xl mx-auto">
      শৈলকুপার সাধারণ মানুষের পাশে দাঁড়াতে ও সমাজসেবামূলক কর্মকাণ্ড বাস্তবায়নে নিবেদিত আগামীর শৈলকুপার নিবন্ধিত স্বেচ্ছাসেবীগণের তালিকা। মোট সক্রিয় কর্মী: <strong class="text-[#0b4622]">{{ $totalActive }}</strong> জন।
    </p>

    <!-- Join CTA Link -->
    <div class="pt-1">
      <a href="{{ route('volunteers.apply') }}"
         class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#0b4622] hover:bg-[#08351a] text-white text-xs sm:text-sm font-bold shadow-md hover:shadow-lg transition">
        <i class="ri-user-add-line text-base"></i>
        <span>স্বেচ্ছাসেবী কর্মী হিসেবে যোগ দিন</span>
      </a>
    </div>
  </div>

  <!-- Search & Filter Bar -->
  <div class="bg-white rounded-2xl border border-gray-200/80 p-4 sm:p-5 shadow-xs">
    <form action="{{ route('volunteers.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
      <!-- Search Input -->
      <div class="sm:col-span-8 relative">
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="নাম, ফোন নম্বর, রক্তের গ্রুপ বা এলাকা দিয়ে খুঁজুন..."
               class="w-full pl-10 pr-4 py-2.5 text-xs sm:text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition">
        <i class="ri-search-line absolute left-3.5 top-3 text-gray-400 text-sm"></i>
      </div>

      <!-- Blood Group Filter -->
      <div class="sm:col-span-2">
        <select name="blood_group"
                class="w-full py-2.5 px-3 text-xs sm:text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition cursor-pointer">
          <option value="">রক্তের গ্রুপ (সব)</option>
          @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
            <option value="{{ $bg }}" {{ request('blood_group') == $bg ? 'selected' : '' }}>{{ $bg }}</option>
          @endforeach
        </select>
      </div>

      <!-- Filter Buttons -->
      <div class="sm:col-span-2 flex items-center gap-2">
        <button type="submit"
                class="flex-1 py-2.5 px-4 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs sm:text-sm font-bold rounded-xl shadow-xs transition flex items-center justify-center gap-1.5 cursor-pointer">
          <i class="ri-filter-3-line"></i>
          <span>ফিল্টার</span>
        </button>
        @if(request()->hasAny(['search', 'blood_group']))
          <a href="{{ route('volunteers.index') }}"
             class="p-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl transition flex items-center justify-center"
             title="রিসেট করুন">
            <i class="ri-refresh-line"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  <!-- Volunteers Grid -->
  @if($volunteers->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 sm:gap-6">
      @foreach($volunteers as $volunteer)
        <div class="bg-white rounded-2xl border border-gray-200/90 shadow-2xs hover:shadow-md hover:border-[#0b4622]/40 transition duration-300 overflow-hidden flex flex-col group">
          
          <!-- Card Header: Photo, Name & ID -->
          <a href="{{ $volunteer->public_card_url }}" class="p-5 pb-3 flex flex-col items-center text-center relative border-b border-gray-50 hover:bg-emerald-50/20 transition cursor-pointer">
            <!-- Active Badge -->
            <div class="absolute top-3.5 right-3.5">
              <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-[#0b4622] border border-emerald-200">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                সক্রিয় কর্মী
              </span>
            </div>

            <!-- Profile Photo -->
            <div class="relative w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-md ring-2 ring-[#0b4622]/15 bg-gray-100 mb-3 group-hover:scale-105 transition duration-300">
              <img src="{{ $volunteer->photo_url }}"
                   alt="{{ $volunteer->name }}"
                   class="w-full h-full object-cover">
            </div>

            <!-- Full Name -->
            <h3 class="text-base font-extrabold text-gray-900 group-hover:text-[#0b4622] transition line-clamp-1">
              {{ $volunteer->name }}
            </h3>

            <!-- ID Number & Blood Group -->
            <div class="flex items-center gap-1.5 mt-1.5 flex-wrap justify-center">
              <span class="inline-block px-2.5 py-0.5 rounded-md bg-gray-100 text-gray-700 text-[11px] font-bold font-mono">
                ID: {{ $volunteer->card_id_number }}
              </span>
              @if(!empty($volunteer->blood_group))
                <span class="inline-flex items-center gap-0.5 px-2 py-0.5 rounded-md bg-red-50 text-[#c8102e] border border-red-200/70 text-[11px] font-bold">
                  <i class="ri-drop-fill text-red-500 text-[10px]"></i>
                  {{ $volunteer->blood_group }}
                </span>
              @endif
            </div>
          </a>

          <!-- Card Body: Contact Info -->
          <div class="p-4 sm:p-5 space-y-2.5 text-xs text-gray-600 flex-1">
            <!-- Phone Number -->
            <div class="flex items-center gap-2.5">
              <span class="w-7 h-7 rounded-lg bg-emerald-50 text-[#0b4622] flex items-center justify-center shrink-0">
                <i class="ri-phone-line text-sm"></i>
              </span>
              <a href="tel:{{ $volunteer->phone }}" class="font-semibold text-gray-800 hover:text-[#0b4622] transition">
                {{ $volunteer->phone }}
              </a>
            </div>

            <!-- Email Address -->
            @if(!empty($volunteer->email))
              <div class="flex items-center gap-2.5">
                <span class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                  <i class="ri-mail-line text-sm"></i>
                </span>
                <a href="mailto:{{ $volunteer->email }}" class="font-medium text-gray-700 hover:text-[#0b4622] transition truncate" title="{{ $volunteer->email }}">
                  {{ $volunteer->email }}
                </a>
              </div>
            @endif

            <!-- Address -->
            @if(!empty($volunteer->address))
              <div class="flex items-start gap-2.5 pt-0.5">
                <span class="w-7 h-7 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 mt-0.5">
                  <i class="ri-map-pin-line text-sm"></i>
                </span>
                <span class="text-gray-600 line-clamp-2 leading-relaxed" title="{{ $volunteer->address }}">
                  {{ $volunteer->address }}
                </span>
              </div>
            @endif
          </div>

          <!-- Card Footer: View ID Card Button -->
          <div class="p-3 bg-gray-50 border-t border-gray-100 text-center">
            <a href="{{ $volunteer->public_card_url }}"
               target="_blank"
               class="inline-flex items-center justify-center gap-1.5 w-full py-2 px-3 rounded-xl bg-white hover:bg-[#0b4622] text-[#0b4622] hover:text-white border border-gray-200 text-xs font-bold transition shadow-2xs">
              <i class="ri-id-card-line text-sm"></i>
              <span>ডিজিটাল আইডি কার্ড দেখুন</span>
            </a>
          </div>

        </div>
      @endforeach
    </div>

    <!-- Pagination -->
    <div class="pt-4 flex justify-center">
      {{ $volunteers->links() }}
    </div>
  @else
    <!-- Empty State -->
    <div class="bg-white rounded-3xl border border-gray-200 p-10 text-center space-y-4 max-w-md mx-auto shadow-2xs">
      <div class="w-16 h-16 rounded-full bg-emerald-50 text-[#0b4622] flex items-center justify-center mx-auto text-3xl">
        <i class="ri-user-search-line"></i>
      </div>
      <h3 class="text-base sm:text-lg font-bold text-gray-900">কোন সক্রিয় কর্মী পাওয়া যায়নি</h3>
      <p class="text-xs sm:text-sm text-gray-500">
        আপনার অনুসন্ধানের সাথে মিলে এমন কোনো সক্রিয় স্বেচ্ছাসেবী কর্মীর তথ্য পাওয়া যায়নি।
      </p>
      @if(request()->hasAny(['search', 'blood_group']))
        <a href="{{ route('volunteers.index') }}"
           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#0b4622] text-white text-xs font-bold hover:bg-[#08351a] transition">
          <i class="ri-refresh-line"></i>
          <span>ফিল্টার রিসেট করুন</span>
        </a>
      @endif
    </div>
  @endif

</div>
@endsection
