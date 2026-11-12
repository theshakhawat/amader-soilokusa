@extends('layouts.admin.admin-layout')

@section('title', 'যোগাযোগ সেটিংস কাস্টমাইজেশন — আগামীর শৈলকুপা')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

  <!-- Header Section -->
  <div class="flex items-center justify-between">
    <div>
      <div class="inline-flex items-center gap-1.5 bg-emerald-50 text-[#0b4622] px-3 py-1 rounded-full text-xs font-bold mb-1 border border-emerald-100">
        <i class="ri-brush-3-line"></i>
        <span>কাস্টমাইজেশন</span>
      </div>
      <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">
        যোগাযোগ সেটিংস (Contact Info)
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
        ওয়েবসাইটের টপবার ও ফুটারের যোগাযোগ তথ্য (লোকেশন, মোবাইল নম্বর, ইমেইল) পরিচালনা করুন।
      </p>
    </div>

    <a
      href="{{ route('home') }}"
      target="_blank"
      class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 text-xs font-bold transition shadow-2xs"
    >
      <i class="ri-external-link-line text-sm text-[#0b4622]"></i>
      <span>লাইভ দেখুন</span>
    </a>
  </div>

  {{-- Success Alert --}}
  @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold flex items-center gap-2.5 shadow-2xs">
      <i class="ri-checkbox-circle-fill text-lg text-emerald-600"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  {{-- Validation Errors Alert --}}
  @if($errors->any())
    <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-[#c8102e] text-xs sm:text-sm font-semibold shadow-2xs">
      <div class="flex items-center gap-2 mb-1">
        <i class="ri-error-warning-fill text-lg"></i>
        <span>অনুগ্রহ করে নিচের ত্রুটিগুলো সংশোধন করুন:</span>
      </div>
      <ul class="list-disc list-inside text-xs space-y-0.5 pl-6 font-medium">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- Live Topbar Preview Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)] p-5 space-y-3">
    <div class="flex items-center justify-between">
      <span class="text-xs font-extrabold text-gray-800 flex items-center gap-2">
        <i class="ri-eye-line text-emerald-700 text-base"></i>
        <span>টপবারে যেভাবে প্রদর্শিত হচ্ছে (Live Preview):</span>
      </span>
      <span class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider">Top Header</span>
    </div>
    <div class="bg-[#c8102e] text-white px-4 py-2.5 rounded-xl flex items-center justify-between text-xs overflow-x-auto shadow-inner">
      <div class="flex items-center gap-4 whitespace-nowrap">
        <span class="inline-flex items-center gap-1.5 font-medium">
          <i class="fa-solid fa-location-dot text-[11px]"></i>
          <span id="preview-location">{{ $contact->location ?? 'শৈলকুপা' }}</span>
        </span>
        <span class="inline-flex items-center gap-1.5 font-medium">
          <i class="fa-solid fa-phone text-[10px]"></i>
          <span id="preview-phone">{{ $contact->phone ?? '+880 1700-123456' }}</span>
        </span>
        <span class="inline-flex items-center gap-1.5 font-medium">
          <i class="fa-regular fa-envelope text-[11px]"></i>
          <span id="preview-email">{{ $contact->email ?? 'info@agamirshailkupa.org' }}</span>
        </span>
      </div>
      <div class="text-[10px] opacity-75 font-semibold hidden sm:block">আগামীর শৈলকুপা</div>
    </div>
  </div>

  <!-- Form Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)] p-6 sm:p-8">
    <form action="{{ route('admin.customization.contact.update') }}" method="POST" class="space-y-5">
      @csrf
      @method('PUT')

      <!-- Location Input -->
      <div>
        <label for="location" class="block text-xs font-bold text-gray-700 mb-1.5">
          লোকেশন / স্থান (Location) <span class="text-[#c8102e]">*</span>
        </label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
            <i class="fa-solid fa-location-dot text-sm text-[#c8102e]"></i>
          </span>
          <input
            type="text"
            id="location"
            name="location"
            value="{{ old('location', $contact->location) }}"
            required
            oninput="document.getElementById('preview-location').textContent = this.value || 'শৈলকুপা'"
            placeholder="যেমন: শৈলকুপা"
            class="w-full pl-10 pr-4 py-2.5 rounded-xl border {{ $errors->has('location') ? 'border-red-300 bg-red-50/20' : 'border-gray-200 bg-gray-50/40' }} text-xs sm:text-sm text-gray-900 focus:outline-none focus:border-[#0b4622] focus:bg-white transition"
          />
        </div>
        <p class="text-[11px] text-gray-400 mt-1">এটি টপবারে লোকেশন আইকনের সাথে প্রদর্শিত হবে</p>
        @error('location')
          <p class="text-xs text-[#c8102e] mt-1 font-semibold">{{ $message }}</p>
        @enderror
      </div>

      <!-- Phone Number & Alt Phone Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Primary Phone -->
        <div>
          <label for="phone" class="block text-xs font-bold text-gray-700 mb-1.5">
            প্রধান মোবাইল নম্বর (Phone) <span class="text-[#c8102e]">*</span>
          </label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
              <i class="fa-solid fa-phone text-sm text-[#0b4622]"></i>
            </span>
            <input
              type="text"
              id="phone"
              name="phone"
              value="{{ old('phone', $contact->phone) }}"
              required
              oninput="document.getElementById('preview-phone').textContent = this.value || '+880 1700-123456'"
              placeholder="+880 1700-123456"
              class="w-full pl-10 pr-4 py-2.5 rounded-xl border {{ $errors->has('phone') ? 'border-red-300 bg-red-50/20' : 'border-gray-200 bg-gray-50/40' }} text-xs sm:text-sm text-gray-900 focus:outline-none focus:border-[#0b4622] focus:bg-white transition"
            />
          </div>
          @error('phone')
            <p class="text-xs text-[#c8102e] mt-1 font-semibold">{{ $message }}</p>
          @enderror
        </div>

        <!-- Alternate Phone (Optional) -->
        <div>
          <label for="alt_phone" class="block text-xs font-bold text-gray-700 mb-1.5">
            বিকল্প মোবাইল নম্বর <span class="text-gray-400 font-normal">(ঐচ্ছিক)</span>
          </label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
              <i class="ri-phone-line text-sm"></i>
            </span>
            <input
              type="text"
              id="alt_phone"
              name="alt_phone"
              value="{{ old('alt_phone', $contact->alt_phone) }}"
              placeholder="+880 1800-123456"
              class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50/40 text-xs sm:text-sm text-gray-900 focus:outline-none focus:border-[#0b4622] focus:bg-white transition"
            />
          </div>
        </div>
      </div>

      <!-- Email Address Input -->
      <div>
        <label for="email" class="block text-xs font-bold text-gray-700 mb-1.5">
          ইমেইল ঠিকানা (Email Address) <span class="text-[#c8102e]">*</span>
        </label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
            <i class="fa-regular fa-envelope text-sm text-amber-600"></i>
          </span>
          <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email', $contact->email) }}"
            required
            oninput="document.getElementById('preview-email').textContent = this.value || 'info@agamirshailkupa.org'"
            placeholder="info@agamirshailkupa.org"
            class="w-full pl-10 pr-4 py-2.5 rounded-xl border {{ $errors->has('email') ? 'border-red-300 bg-red-50/20' : 'border-gray-200 bg-gray-50/40' }} text-xs sm:text-sm text-gray-900 focus:outline-none focus:border-[#0b4622] focus:bg-white transition"
          />
        </div>
        @error('email')
          <p class="text-xs text-[#c8102e] mt-1 font-semibold">{{ $message }}</p>
        @enderror
      </div>

      <!-- Full Address (For footer/contact page) -->
      <div>
        <label for="address" class="block text-xs font-bold text-gray-700 mb-1.5">
          পূর্ণ ঠিকানা (Full Address) <span class="text-gray-400 font-normal">(ঐচ্ছিক)</span>
        </label>
        <div class="relative">
          <textarea
            id="address"
            name="address"
            rows="2"
            placeholder="শৈলকুপা, ঝিনাইদহ, বাংলাদেশ"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50/40 text-xs sm:text-sm text-gray-900 focus:outline-none focus:border-[#0b4622] focus:bg-white transition"
          >{{ old('address', $contact->address) }}</textarea>
        </div>
      </div>

      <!-- Action Button -->
      <div class="pt-5 border-t border-gray-100 flex items-center justify-end gap-3">
        <button
          type="submit"
          class="inline-flex items-center gap-2 bg-[#0b4622] hover:bg-[#083519] text-white text-xs sm:text-sm font-bold px-6 py-2.5 rounded-xl shadow-xs transition cursor-pointer"
        >
          <i class="ri-check-line text-base"></i>
          <span>যোগাযোগ তথ্য সংরক্ষণ করুন</span>
        </button>
      </div>

    </form>
  </div>

</div>
@endsection
