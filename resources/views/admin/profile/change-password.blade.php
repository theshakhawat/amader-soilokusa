@extends('layouts.admin.admin-layout')

@section('title', 'পাসওয়ার্ড পরিবর্তন — আগামীর শৈলকুপা')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

  <!-- Header -->
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">পাসওয়ার্ড পরিবর্তন</h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-0.5">অ্যাকাউন্টের নিরাপত্তার জন্য একটি শক্তিশালী পাসওয়ার্ড নির্ধারণ করুন</p>
    </div>
    <a
      href="{{ route('admin.profile') }}"
      class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 text-xs font-bold transition shadow-2xs"
    >
      <i class="ri-arrow-left-line text-sm"></i>
      <span>প্রোফাইলে ফিরুন</span>
    </a>
  </div>

  @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold flex items-center gap-2.5">
      <i class="ri-checkbox-circle-fill text-lg text-emerald-600"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <!-- Password Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)] p-6 sm:p-8">
    <form action="{{ route('admin.profile.password.update') }}" method="POST" class="space-y-5">
      @csrf
      @method('PUT')

      <!-- Current Password -->
      <div>
        <label for="current_password" class="block text-xs font-bold text-gray-700 mb-1.5">
          বর্তমান পাসওয়ার্ড <span class="text-[#c8102e]">*</span>
        </label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
            <i class="ri-lock-line text-sm"></i>
          </span>
          <input
            type="password"
            id="current_password"
            name="current_password"
            required
            placeholder="আপনার বর্তমান পাসওয়ার্ড দিন"
            class="w-full pl-10 pr-4 py-2.5 rounded-xl border {{ $errors->has('current_password') ? 'border-red-300 bg-red-50/20' : 'border-gray-200 bg-gray-50/40' }} text-xs sm:text-sm text-gray-900 focus:outline-none focus:border-[#0b4622] focus:bg-white transition"
          />
        </div>
        @error('current_password')
          <p class="text-xs text-[#c8102e] mt-1 font-semibold">{{ $message }}</p>
        @enderror
      </div>

      <!-- New Password -->
      <div>
        <label for="password" class="block text-xs font-bold text-gray-700 mb-1.5">
          নতুন পাসওয়ার্ড <span class="text-[#c8102e]">*</span>
        </label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
            <i class="ri-lock-password-line text-sm"></i>
          </span>
          <input
            type="password"
            id="password"
            name="password"
            required
            placeholder="কমপক্ষে ৬ অক্ষর বিশিষ্ট নতুন পাসওয়ার্ড"
            class="w-full pl-10 pr-4 py-2.5 rounded-xl border {{ $errors->has('password') ? 'border-red-300 bg-red-50/20' : 'border-gray-200 bg-gray-50/40' }} text-xs sm:text-sm text-gray-900 focus:outline-none focus:border-[#0b4622] focus:bg-white transition"
          />
        </div>
        @error('password')
          <p class="text-xs text-[#c8102e] mt-1 font-semibold">{{ $message }}</p>
        @enderror
      </div>

      <!-- Confirm New Password -->
      <div>
        <label for="password_confirmation" class="block text-xs font-bold text-gray-700 mb-1.5">
          নতুন পাসওয়ার্ড নিশ্চিত করুন <span class="text-[#c8102e]">*</span>
        </label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
            <i class="ri-shield-check-line text-sm"></i>
          </span>
          <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            required
            placeholder="পুনরায় নতুন পাসওয়ার্ড দিন"
            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50/40 text-xs sm:text-sm text-gray-900 focus:outline-none focus:border-[#0b4622] focus:bg-white transition"
          />
        </div>
      </div>

      <!-- Action Button -->
      <div class="pt-4 border-t border-gray-100 flex items-center justify-end">
        <button
          type="submit"
          class="inline-flex items-center gap-2 bg-[#0b4622] hover:bg-[#083519] text-white text-xs sm:text-sm font-bold px-5 py-2.5 rounded-xl shadow-xs transition cursor-pointer"
        >
          <i class="ri-key-line text-sm"></i>
          <span>পাসওয়ার্ড আপডেট করুন</span>
        </button>
      </div>
    </form>
  </div>

</div>
@endsection

