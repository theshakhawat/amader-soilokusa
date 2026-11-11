@extends('layouts.website.website-layout')

@section('title', 'নতুন পাসওয়ার্ড নির্ধারণ — আগামীর শৈলকুপা')

@section('content')
<div class="py-10 sm:py-16 bg-gradient-to-b from-[#f4f5f7] via-white to-[#f4f5f7]">
  <div class="max-w-[460px] mx-auto px-4">
    <!-- Reset Password Card -->
    <div class="bg-white rounded-2xl shadow-[0_10px_35px_rgba(0,0,0,0.06)] border border-gray-100 p-6 sm:p-8 relative overflow-hidden">
      <!-- Decorative Top Color Strip -->
      <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-[#0b4622] via-[#c8102e] to-[#0b4622]"></div>

      <!-- Card Header -->
      <div class="text-center mb-6">
        <div class="w-14 h-14 rounded-2xl bg-red-50 border border-red-100 flex items-center justify-center mx-auto mb-3 shadow-inner">
          <i class="fa-solid fa-shield-halved text-[#c8102e] text-2xl"></i>
        </div>
        <h1 class="text-2xl sm:text-[25px] font-extrabold text-gray-900 tracking-tight leading-snug">
          নতুন পাসওয়ার্ড সেট করুন
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1 leading-relaxed">
          আপনার অ্যাকাউন্টের সুরক্ষার জন্য একটি শক্তিশালী নতুন পাসওয়ার্ড তৈরি করুন।
        </p>
      </div>

      <!-- Error Alert -->
      @if ($errors->any())
        <div class="mb-5 p-3.5 rounded-xl bg-red-50 border border-red-200 text-[#c8102e] text-xs sm:text-sm font-semibold flex items-start gap-2.5">
          <i class="fa-solid fa-circle-exclamation text-base mt-0.5 shrink-0"></i>
          <span>{{ $errors->first() }}</span>
        </div>
      @endif

      <!-- Reset Password Form -->
      <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $token }}">

        <!-- Email Address -->
        <div>
          <label for="email" class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">
            ইমেইল ঠিকানা
          </label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
              <i class="fa-regular fa-envelope text-sm"></i>
            </span>
            <input
              type="email"
              id="email"
              name="email"
              value="{{ old('email', $email) }}"
              required
              readonly
              class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 bg-gray-100/70 text-sm text-gray-600 focus:outline-none cursor-not-allowed"
            />
          </div>
        </div>

        <!-- New Password -->
        <div>
          <label for="password" class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">
            নতুন পাসওয়ার্ড
          </label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
              <i class="fa-solid fa-lock text-sm"></i>
            </span>
            <input
              type="password"
              id="password"
              name="password"
              required
              autofocus
              placeholder="কমপক্ষে ৬ অক্ষর"
              class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50/30 text-sm focus:outline-none focus:border-[#c8102e] focus:bg-white transition"
            />
          </div>
        </div>

        <!-- Confirm Password -->
        <div>
          <label for="password_confirmation" class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">
            নতুন পাসওয়ার্ড নিশ্চিত করুন
          </label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
              <i class="fa-solid fa-lock-open text-sm"></i>
            </span>
            <input
              type="password"
              id="password_confirmation"
              name="password_confirmation"
              required
              placeholder="পুনরায় পাসওয়ার্ড দিন"
              class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50/30 text-sm focus:outline-none focus:border-[#c8102e] focus:bg-white transition"
            />
          </div>
        </div>

        <!-- Submit Button -->
        <button
          type="submit"
          class="w-full bg-[#0b4622] hover:bg-[#083519] text-white text-sm sm:text-base font-bold py-2.5 sm:py-3 rounded-xl shadow-md hover:shadow-lg transition flex items-center justify-center gap-2 cursor-pointer mt-2"
        >
          <i class="fa-solid fa-check text-xs"></i>
          <span>পাসওয়ার্ড সংরক্ষণ করুন</span>
        </button>
      </form>

      <!-- Back to Login Link -->
      <div class="mt-7 pt-5 border-t border-gray-100 text-center">
        <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-extrabold text-[#c8102e] hover:underline">
          <i class="fa-solid fa-arrow-left text-xs"></i>
          <span>লগইন পেজে ফিরে যান</span>
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
