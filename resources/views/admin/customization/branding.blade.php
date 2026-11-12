@extends('layouts.admin.admin-layout')

@section('title', 'লোগো ও ব্র্যান্ডিং সেটিংস | আগামীর শৈলকুপা')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

  <!-- Top bar -->
  <div class="flex items-center justify-between">
    <div>
      <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line"></i>
        <span class="text-gray-400">কাস্টমাইজেশন</span>
        <i class="ri-arrow-right-s-line"></i>
        <span class="text-[#0b4622] font-semibold">লোগো ও ব্র্যান্ডিং</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
        <i class="ri-pantone-line text-[#0b4622]"></i>
        <span>লোগো ও ব্র্যান্ডিং সেটিংস (Logo & Branding)</span>
      </h1>
      <p class="text-xs text-gray-500 mt-0.5">
        ওয়েবসাইটের মূল হেডার লোগো, ফুটার লোগো, ব্রাউজার ফেভিকন (Favicon) এবং সাইটের নাম/স্লোগান পরিবর্তন করুন।
      </p>
    </div>

    <a
      href="{{ route('home') }}"
      target="_blank"
      class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition cursor-pointer"
    >
      <i class="ri-external-link-line"></i>
      <span>লাইভ ওয়েবসাইট দেখুন</span>
    </a>
  </div>

  @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-2xl flex items-center justify-between">
      <div class="flex items-center gap-2">
        <i class="ri-checkbox-circle-fill text-emerald-600 text-base"></i>
        <span>{{ session('success') }}</span>
      </div>
    </div>
  @endif

  @if($errors->any())
    <div class="p-4 bg-red-50 border border-red-200 text-red-700 text-xs font-bold rounded-2xl">
      <ul class="list-disc list-inside space-y-1">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- Form Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-2xs p-6 sm:p-8">
    <form action="{{ route('admin.customization.branding.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
      @csrf
      @method('PUT')

      <!-- 1. Site Title & Tagline -->
      <div class="p-4 bg-gray-50/70 border border-gray-100 rounded-xl space-y-4">
        <div class="flex items-center gap-2 pb-2 border-b border-gray-200">
          <i class="ri-text text-[#0b4622] text-lg"></i>
          <h3 class="text-xs font-black text-gray-900 uppercase tracking-wider">সাইটের শিরোনাম ও স্লোগান</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="site_title" class="block text-xs font-bold text-gray-700 mb-1.5">
              ওয়েবসাইটের নাম (Site Title) <span class="text-[#c8102e]">*</span>
            </label>
            <input
              type="text"
              id="site_title"
              name="site_title"
              value="{{ old('site_title', $setting->site_title) }}"
              placeholder="উদাঃ আগামীর শৈলকুপা"
              class="w-full px-4 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-[#0b4622] transition"
              required
            >
          </div>

          <div>
            <label for="site_tagline" class="block text-xs font-bold text-gray-700 mb-1.5">
              ট্যাগলাইন বা স্লোগান (Tagline)
            </label>
            <input
              type="text"
              id="site_tagline"
              name="site_tagline"
              value="{{ old('site_tagline', $setting->site_tagline) }}"
              placeholder="উদাঃ শৈলকুপার উন্নয়নে আমরা এক পরিবার"
              class="w-full px-4 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-[#0b4622] transition"
            >
          </div>
        </div>
      </div>

      <!-- 2. Logo Uploads Grid -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Header / Navigation Logo -->
        <div class="bg-gray-50/70 border border-gray-100 rounded-xl p-4 flex flex-col justify-between space-y-4">
          <div>
            <div class="flex items-center gap-1.5 mb-2">
              <i class="ri-layout-top-line text-[#0b4622]"></i>
              <label class="block text-xs font-bold text-gray-800">
                হেডার / নেভিগেশন লোগো
              </label>
            </div>
            <p class="text-[11px] text-gray-400 mb-3">
              ওয়েবসাইটের উপরের মূল নেভিগেশন বারে প্রদর্শিত হবে।
            </p>

            <!-- Preview -->
            <div class="w-full h-24 bg-white border border-gray-200 rounded-xl flex items-center justify-center p-2 mb-3">
              <img
                src="{{ $setting->header_logo_url }}"
                alt="Header Logo"
                class="max-h-full max-w-full object-contain"
              >
            </div>
          </div>

          <div>
            <input
              type="file"
              name="header_logo"
              accept="image/*"
              class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#0b4622]/10 file:text-[#0b4622] hover:file:bg-[#0b4622]/20 cursor-pointer"
            >
            <span class="text-[10px] text-gray-400 mt-1 block">PNG, SVG বা WEBP ফরম্যাট সুপারিশকৃত।</span>
          </div>
        </div>

        <!-- Footer Logo -->
        <div class="bg-gray-50/70 border border-gray-100 rounded-xl p-4 flex flex-col justify-between space-y-4">
          <div>
            <div class="flex items-center gap-1.5 mb-2">
              <i class="ri-layout-bottom-line text-[#0b4622]"></i>
              <label class="block text-xs font-bold text-gray-800">
                ফুটার লোগো (Footer Logo)
              </label>
            </div>
            <p class="text-[11px] text-gray-400 mb-3">
              ওয়েবসাইটের নিচের গাঢ় সবুজ ফুটার অংশে প্রদর্শিত হবে।
            </p>

            <!-- Preview on dark bg -->
            <div class="w-full h-24 bg-[#07381b] border border-gray-200 rounded-xl flex items-center justify-center p-2 mb-3">
              <img
                src="{{ $setting->footer_logo_url }}"
                alt="Footer Logo"
                class="max-h-full max-w-full object-contain"
              >
            </div>
          </div>

          <div>
            <input
              type="file"
              name="footer_logo"
              accept="image/*"
              class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#0b4622]/10 file:text-[#0b4622] hover:file:bg-[#0b4622]/20 cursor-pointer"
            >
            <span class="text-[10px] text-gray-400 mt-1 block">স্বচ্ছ (Transparent) ব্যাকগ্রাউন্ড লোগো দিন।</span>
          </div>
        </div>

        <!-- Favicon -->
        <div class="bg-gray-50/70 border border-gray-100 rounded-xl p-4 flex flex-col justify-between space-y-4">
          <div>
            <div class="flex items-center gap-1.5 mb-2">
              <i class="ri-global-line text-[#0b4622]"></i>
              <label class="block text-xs font-bold text-gray-800">
                ফেভিকন (Favicon)
              </label>
            </div>
            <p class="text-[11px] text-gray-400 mb-3">
              ব্রাউজারের ট্যাব বারে ছোট আইকন হিসেবে প্রদর্শিত হবে।
            </p>

            <!-- Preview like browser tab -->
            <div class="w-full h-24 bg-gray-100 border border-gray-200 rounded-xl flex items-center justify-center p-2 mb-3">
              <div class="flex items-center gap-2 px-3 py-1.5 bg-white rounded-lg shadow-xs border border-gray-200">
                <img
                  src="{{ $setting->favicon_url }}"
                  alt="Favicon"
                  class="w-5 h-5 object-contain"
                >
                <span class="text-[11px] font-bold text-gray-700 truncate max-w-[90px]">{{ $setting->site_title }}</span>
              </div>
            </div>
          </div>

          <div>
            <input
              type="file"
              name="favicon"
              accept="image/*,.ico"
              class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#0b4622]/10 file:text-[#0b4622] hover:file:bg-[#0b4622]/20 cursor-pointer"
            >
            <span class="text-[10px] text-gray-400 mt-1 block">32x32 বা 64x64 পিক্সেল (PNG বা ICO)।</span>
          </div>
        </div>

      </div>

      <!-- Submit button -->
      <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
        <button
          type="submit"
          class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-sm hover:shadow transition cursor-pointer"
        >
          <i class="ri-check-line text-base"></i>
          <span>লোগো ও ব্র্যান্ডিং সংরক্ষণ করুন</span>
        </button>
      </div>

    </form>
  </div>
</div>
@endsection

