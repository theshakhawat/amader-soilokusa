@extends('layouts.website.website-layout')

@section('title', 'পাসওয়ার্ড পুনরুদ্ধার — আগামীর শৈলকুপা')

@section('content')
<div class="py-10 sm:py-16 bg-gradient-to-b from-[#f4f5f7] via-white to-[#f4f5f7]">
  <div class="max-w-[460px] mx-auto px-4">
    <!-- Forgot Password Card -->
    <div class="bg-white rounded-2xl shadow-[0_10px_35px_rgba(0,0,0,0.06)] border border-gray-100 p-6 sm:p-8 relative overflow-hidden">
      <!-- Decorative Top Color Strip -->
      <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-[#c8102e] via-[#0b4622] to-[#c8102e]"></div>

      <!-- Card Header -->
      <div class="text-center mb-6">
        <div class="w-14 h-14 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center mx-auto mb-3 shadow-inner">
          <i class="fa-solid fa-key text-amber-600 text-2xl"></i>
        </div>
        <h1 class="text-2xl sm:text-[25px] font-extrabold text-gray-900 tracking-tight leading-snug">
          পাসওয়ার্ড ভুলে গেছেন?
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1 leading-relaxed">
          আপনার অ্যাকাউন্টের নিবন্ধিত ইমেইল ঠিকানা দিন। আমরা আপনাকে পাসওয়ার্ড রিসেট করার একটি লিংক পাঠাবো।
        </p>
      </div>

      <!-- Flash Status Message -->
      @if (session('status'))
        <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold flex items-start gap-2.5">
          <i class="fa-solid fa-circle-check text-emerald-600 text-base mt-0.5 shrink-0"></i>
          <span>{{ session('status') }}</span>
        </div>
      @endif

      <!-- Error Alert -->
      @if ($errors->any())
        <div class="mb-5 p-3.5 rounded-xl bg-red-50 border border-red-200 text-[#c8102e] text-xs sm:text-sm font-semibold flex items-start gap-2.5">
          <i class="fa-solid fa-circle-exclamation text-base mt-0.5 shrink-0"></i>
          <span>{{ $errors->first() }}</span>
        </div>
      @endif

      <!-- Forgot Password Form -->
      <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
          <label for="email" class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">
            নিবন্ধিত ইমেইল ঠিকানা
          </label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
              <i class="fa-regular fa-envelope text-sm"></i>
            </span>
            <input
              type="email"
              id="email"
              name="email"
              value="{{ old('email') }}"
              required
              autofocus
              placeholder="example@mail.com"
              class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50/30 text-sm focus:outline-none focus:border-[#c8102e] focus:bg-white transition"
            />
          </div>
        </div>

        <!-- Submit Button -->
        <button
          type="submit"
          class="w-full bg-[#c8102e] hover:bg-[#a30b24] text-white text-sm sm:text-base font-bold py-2.5 sm:py-3 rounded-xl shadow-md hover:shadow-lg transition flex items-center justify-center gap-2 cursor-pointer mt-2"
        >
          <i class="fa-regular fa-paper-plane text-xs"></i>
          <span>রিসেট লিংক পাঠান</span>
        </button>
      </form>

      <!-- Back to Login Link -->
      <div class="mt-7 pt-5 border-t border-gray-100 text-center">
        <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-extrabold text-[#0b4622] hover:text-[#c8102e] hover:underline">
          <i class="fa-solid fa-arrow-left text-xs"></i>
          <span>লগইন পেজে ফিরে যান</span>
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
