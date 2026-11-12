@extends('layouts.admin.admin-layout')

@section('title', 'Administrative Console — আগামীর শৈলকুপা')

@section('content')
<div class="space-y-7 max-w-7xl mx-auto">

  <!-- Header Action Row (Like Reference: Title + Add Product / Review Buttons) -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-950 tracking-tight leading-tight">
        Administrative Console
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-1 font-medium">
        প্ল্যাটফর্ম পারফরম্যান্স ওভারভিউ, ব্যবস্থাপনা ও সার্বিক কার্যক্রম পর্যালোচনা।
      </p>
    </div>

    <!-- Right Header Action Pills -->
    <div class="flex items-center flex-wrap gap-2.5 shrink-0">
      <button
        type="button"
        class="inline-flex items-center gap-1.5 bg-[#0b4622] hover:bg-[#083519] text-white text-xs sm:text-sm font-bold px-4 py-2 rounded-xl shadow-xs transition cursor-pointer"
      >
        <i class="ri-add-line text-base font-bold"></i>
        <span>নতুন কন্টেন্ট</span>
      </button>

      <a
        href="#"
        class="inline-flex items-center gap-1.5 bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 text-xs sm:text-sm font-bold px-4 py-2 rounded-xl shadow-2xs transition"
      >
        <i class="ri-survey-line text-sm text-emerald-700"></i>
        <span>রিপোর্ট পর্যালোচনা</span>
      </a>

      <a
        href="{{ route('home') }}"
        target="_blank"
        class="inline-flex items-center gap-1.5 bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 text-xs sm:text-sm font-bold px-4 py-2 rounded-xl shadow-2xs transition"
      >
        <i class="ri-global-line text-sm text-[#0b4622]"></i>
        <span>লাইভ সাইট</span>
      </a>
    </div>
  </div>

  <!-- Primary Metric Cards (Reference style: White card, left accent border, soft green icon badge, clean bold typography) -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
    
    <!-- 1. Total Members -->
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)] border-l-4 border-l-[#0b4622] flex items-center justify-between hover:shadow-md transition">
      <div>
        <p class="text-xs font-bold text-gray-500 tracking-wide">মোট সদস্য (Members)</p>
        <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-1.5">{{ $stats['total_users'] ?? 5 }}</h3>
        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full mt-2">
          {{ $stats['active_users'] ?? 5 }} জন সক্রিয় সদস্য
        </span>
      </div>
      <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#0b4622] flex items-center justify-center text-xl shrink-0">
        <i class="ri-user-star-line"></i>
      </div>
    </div>

    <!-- 2. Fund & Donations -->
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)] border-l-4 border-l-[#0b4622] flex items-center justify-between hover:shadow-md transition">
      <div>
        <p class="text-xs font-bold text-gray-500 tracking-wide">মোট অনুদান তহবিল</p>
        <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-1.5">৳ ১,৫০,০০০</h3>
        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-[#c8102e] bg-red-50 px-2 py-0.5 rounded-full mt-2">
          চলতি মাস: ৳ ২৫,০০০
        </span>
      </div>
      <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#0b4622] flex items-center justify-center text-xl shrink-0">
        <i class="ri-hand-heart-line"></i>
      </div>
    </div>

    <!-- 3. Ongoing Projects -->
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)] border-l-4 border-l-[#0b4622] flex items-center justify-between hover:shadow-md transition">
      <div>
        <p class="text-xs font-bold text-gray-500 tracking-wide">চলমান উদ্যোগ ও প্রকল্প</p>
        <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-1.5">৮টি</h3>
        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full mt-2">
          ৩টি সফল প্রকল্প
        </span>
      </div>
      <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#0b4622] flex items-center justify-center text-xl shrink-0">
        <i class="ri-projector-line"></i>
      </div>
    </div>

    <!-- 4. Notices & Bulletins -->
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)] border-l-4 border-l-[#0b4622] flex items-center justify-between hover:shadow-md transition">
      <div>
        <p class="text-xs font-bold text-gray-500 tracking-wide">প্রকাশিত নোটিশ</p>
        <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-1.5">১২টি</h3>
        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-gray-700 bg-gray-100 px-2 py-0.5 rounded-full mt-2">
          ১টি সাম্প্রতিক বিজ্ঞপ্তি
        </span>
      </div>
      <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#0b4622] flex items-center justify-center text-xl shrink-0">
        <i class="ri-notification-badge-line"></i>
      </div>
    </div>

  </div>

  <!-- Secondary Row (Reference: 4 cards with Manage link on top right, clean icons) -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
    
    <!-- Portfolio / Activities -->
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)] hover:shadow-md transition">
      <div class="flex items-center justify-between">
        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#0b4622] flex items-center justify-center text-lg">
          <i class="ri-node-tree"></i>
        </div>
        <a href="#" class="text-xs font-bold text-gray-500 hover:text-[#0b4622] flex items-center gap-1 transition">
          <span>Manage</span>
          <i class="ri-arrow-right-line text-xs"></i>
        </a>
      </div>
      <div class="mt-4">
        <p class="text-xs font-bold text-gray-500">কার্যক্রমের তালিকা</p>
        <h4 class="text-2xl font-extrabold text-gray-900 mt-1">১৫+</h4>
        <p class="text-[11px] text-gray-400 mt-1">কমিউনিটি ও সমাজকল্যাণমূলক কর্মসূচি</p>
      </div>
    </div>

    <!-- Contact Messages -->
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)] hover:shadow-md transition">
      <div class="flex items-center justify-between">
        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#0b4622] flex items-center justify-center text-lg">
          <i class="ri-mail-open-line"></i>
        </div>
        <a href="#" class="text-xs font-bold text-gray-500 hover:text-[#0b4622] flex items-center gap-1 transition">
          <span>Manage</span>
          <i class="ri-arrow-right-line text-xs"></i>
        </a>
      </div>
      <div class="mt-4">
        <p class="text-xs font-bold text-gray-500">যোগাযোগের বার্তা</p>
        <h4 class="text-2xl font-extrabold text-gray-900 mt-1">৮টি</h4>
        <p class="text-[11px] text-gray-400 mt-1">নতুন অনুসন্ধান ও মতামতের তালিকা</p>
      </div>
    </div>

    <!-- Committee & Team Members -->
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)] hover:shadow-md transition">
      <div class="flex items-center justify-between">
        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#0b4622] flex items-center justify-center text-lg">
          <i class="ri-team-line"></i>
        </div>
        <a href="#" class="text-xs font-bold text-gray-500 hover:text-[#0b4622] flex items-center gap-1 transition">
          <span>Manage</span>
          <i class="ri-arrow-right-line text-xs"></i>
        </a>
      </div>
      <div class="mt-4">
        <p class="text-xs font-bold text-gray-500">কমিটি সদস্যবৃন্দ</p>
        <h4 class="text-2xl font-extrabold text-gray-900 mt-1">২১ জন</h4>
        <p class="text-[11px] text-gray-400 mt-1">কার্যনির্বাহী ও উপদেষ্টা পরিষদ</p>
      </div>
    </div>

    <!-- Gallery Media -->
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)] hover:shadow-md transition">
      <div class="flex items-center justify-between">
        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#0b4622] flex items-center justify-center text-lg">
          <i class="ri-image-add-line"></i>
        </div>
        <a href="#" class="text-xs font-bold text-gray-500 hover:text-[#0b4622] flex items-center gap-1 transition">
          <span>Manage</span>
          <i class="ri-arrow-right-line text-xs"></i>
        </a>
      </div>
      <div class="mt-4">
        <p class="text-xs font-bold text-gray-500">গ্যালারি মিডিয়া</p>
        <h4 class="text-2xl font-extrabold text-gray-900 mt-1">৪৫টি</h4>
        <p class="text-[11px] text-gray-400 mt-1">ছবি ও ভিডিও ডকুমেন্টস</p>
      </div>
    </div>

  </div>

  <!-- Bottom Section: Landing & Public Website Management Hub (Reference match) -->
  <div class="pt-4">
    <div class="mb-4">
      <span class="text-xs font-extrabold text-gray-900 uppercase tracking-wider">
        LANDING & PUBLIC WEBSITE MANAGEMENT HUB
      </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      
      <!-- Quick Action Cards (Clean minimal white) -->
      <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)] space-y-3">
        <h3 class="text-sm font-extrabold text-gray-900 flex items-center gap-2">
          <i class="ri-flashlight-line text-[#0b4622]"></i>
          <span>দ্রুত প্রকাশনা (Quick Actions)</span>
        </h3>
        
        <a href="#" class="flex items-center justify-between p-3 rounded-xl border border-gray-100 hover:border-emerald-200 hover:bg-emerald-50/40 text-gray-800 transition group">
          <div class="flex items-center gap-2.5">
            <span class="w-8 h-8 rounded-lg bg-emerald-50 text-[#0b4622] flex items-center justify-center text-sm">
              <i class="ri-megaphone-line"></i>
            </span>
            <span class="text-xs font-bold">নতুন নোটিশ তৈরি করুন</span>
          </div>
          <i class="ri-arrow-right-s-line text-gray-400 group-hover:text-[#0b4622] transition"></i>
        </a>

        <a href="#" class="flex items-center justify-between p-3 rounded-xl border border-gray-100 hover:border-red-200 hover:bg-red-50/40 text-gray-800 transition group">
          <div class="flex items-center gap-2.5">
            <span class="w-8 h-8 rounded-lg bg-red-50 text-[#c8102e] flex items-center justify-center text-sm">
              <i class="ri-image-line"></i>
            </span>
            <span class="text-xs font-bold">গ্যালারিতে ছবি যোগ করুন</span>
          </div>
          <i class="ri-arrow-right-s-line text-gray-400 group-hover:text-[#c8102e] transition"></i>
        </a>
      </div>

      <!-- Recent Log / Feed (Clean White & Slate) -->
      <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)] lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-sm font-extrabold text-gray-900 flex items-center gap-2">
            <i class="ri-history-line text-gray-400"></i>
            <span>সাম্প্রতিক সিস্টেম লগ (Recent Updates)</span>
          </h3>
          <span class="text-xs font-semibold text-gray-400">রিয়েল-টাইম</span>
        </div>

        <div class="divide-y divide-gray-100 text-xs">
          <div class="py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
              <span class="w-8 h-8 rounded-full bg-emerald-50 text-[#0b4622] flex items-center justify-center shrink-0">
                <i class="ri-user-add-line"></i>
              </span>
              <div>
                <p class="font-bold text-gray-900">নতুন সদস্য নিবন্ধন হয়েছে</p>
                <p class="text-[11px] text-gray-500">অনলাইন পোর্টালের মাধ্যমে যাচাই সম্পন্ন</p>
              </div>
            </div>
            <span class="text-gray-400">১০ মি. আগে</span>
          </div>

          <div class="py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
              <span class="w-8 h-8 rounded-full bg-red-50 text-[#c8102e] flex items-center justify-center shrink-0">
                <i class="ri-heart-pulse-line"></i>
              </span>
              <div>
                <p class="font-bold text-gray-900">অনুদানের ভাউচার তৈরি হয়েছে</p>
                <p class="text-[11px] text-gray-500">বিকাশ গেটওয়ের মাধ্যমে ১,০০০ টাকা প্রাপ্তি</p>
              </div>
            </div>
            <span class="text-gray-400">১ ঘণ্টা আগে</span>
          </div>
        </div>
      </div>

    </div>
  </div>

</div>
@endsection
