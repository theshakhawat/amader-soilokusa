@extends('layouts.website.website-layout')

@section('title', 'লগইন — আগামীর শৈলকুপা')

@section('content')
<div class="py-10 sm:py-16 bg-gradient-to-b from-[#f4f5f7] via-white to-[#f4f5f7]">
  <div class="max-w-[460px] mx-auto px-4">
    <!-- Login Card -->
    <div class="bg-white rounded-2xl shadow-[0_10px_35px_rgba(0,0,0,0.06)] border border-gray-100 p-6 sm:p-8 relative overflow-hidden">
      <!-- Decorative Top Color Strip -->
      <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-[#0b4622] via-[#c8102e] to-[#0b4622]"></div>

      <!-- Card Header -->
      <div class="text-center mb-7">
        <div class="w-14 h-14 rounded-2xl bg-red-50 border border-red-100 flex items-center justify-center mx-auto mb-3 shadow-inner">
          <i class="fa-solid fa-arrow-right-to-bracket text-[#c8102e] text-2xl"></i>
        </div>
        <h1 class="text-2xl sm:text-[26px] font-extrabold text-gray-900 tracking-tight leading-snug">
          অ্যাকাউন্টে লগইন করুন
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">
          আগামীর শৈলকুপা ডিজিটাল প্ল্যাটফর্মে আপনাকে স্বাগতম
        </p>
      </div>

      <!-- Flash Success / Status Message -->
      @if (session('success'))
        <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold flex items-center gap-2">
          <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
          <span>{{ session('success') }}</span>
        </div>
      @endif

      @if (session('status'))
        <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold flex items-center gap-2">
          <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
          <span>{{ session('status') }}</span>
        </div>
      @endif

      <!-- Global / Rate Limit Error Alert -->
      @if ($errors->has('login'))
        <div class="mb-5 p-3.5 rounded-xl bg-red-50 border border-red-200 text-[#c8102e] text-xs sm:text-sm font-semibold flex items-start gap-2.5">
          <i class="fa-solid fa-circle-exclamation text-base mt-0.5 shrink-0"></i>
          <span>{{ $errors->first('login') }}</span>
        </div>
      @endif

      <!-- Login Form -->
      <form action="{{ route('login') }}" method="POST" class="space-y-4 sm:space-y-5">
        @csrf

        <!-- Email or Phone -->
        <div>
          <label for="login" class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">
            ইমেইল অথবা মোবাইল নম্বর
          </label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
              <i class="fa-regular fa-user text-sm"></i>
            </span>
            <input
              type="text"
              id="login"
              name="login"
              value="{{ old('login') }}"
              required
              autofocus
              placeholder="example@mail.com অথবা 017XXXXXXXX"
              class="w-full pl-10 pr-4 py-2.5 rounded-xl border {{ $errors->has('login') ? 'border-red-300 bg-red-50/20' : 'border-gray-200 bg-gray-50/30' }} text-sm focus:outline-none focus:border-[#c8102e] focus:bg-white transition"
            />
          </div>
        </div>

        <!-- Password -->
        <div>
          <div class="flex items-center justify-between mb-1.5">
            <label for="password" class="block text-xs sm:text-sm font-bold text-gray-700">
              পাসওয়ার্ড
            </label>
            <a href="{{ route('password.request') }}" class="text-xs font-bold text-[#c8102e] hover:underline">
              পাসওয়ার্ড ভুলে গেছেন?
            </a>
          </div>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
              <i class="fa-solid fa-lock text-sm"></i>
            </span>
            <input
              type="password"
              id="password"
              name="password"
              required
              placeholder="••••••••"
              class="w-full pl-10 pr-11 py-2.5 rounded-xl border border-gray-200 bg-gray-50/30 text-sm focus:outline-none focus:border-[#c8102e] focus:bg-white transition"
            />
            <button
              type="button"
              onclick="togglePasswordVisibility('password', this)"
              class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 transition"
              aria-label="Toggle Password Visibility"
            >
              <i class="fa-regular fa-eye text-sm"></i>
            </button>
          </div>
          @error('password')
            <p class="text-xs text-[#c8102e] mt-1 font-semibold">{{ $message }}</p>
          @enderror
        </div>

        <!-- Remember Me Checkbox -->
        <div class="flex items-center justify-between pt-1">
          <label class="flex items-center gap-2 cursor-pointer select-none">
            <input
              type="checkbox"
              name="remember"
              id="remember"
              class="w-4 h-4 rounded border-gray-300 text-[#c8102e] focus:ring-[#c8102e] accent-[#c8102e]"
            />
            <span class="text-xs sm:text-sm text-gray-600 font-medium">আমাকে মনে রাখুন</span>
          </label>
        </div>

        <!-- Submit Button -->
        <button
          type="submit"
          class="w-full bg-[#c8102e] hover:bg-[#a30b24] text-white text-sm sm:text-base font-bold py-2.5 sm:py-3 rounded-xl shadow-md hover:shadow-lg transition flex items-center justify-center gap-2 cursor-pointer"
        >
          <span>লগইন করুন</span>
          <i class="fa-solid fa-arrow-right text-xs"></i>
        </button>
      </form>

      <!-- Bottom Card Footer (Link to Register) -->
      <div class="mt-7 pt-5 border-t border-gray-100 text-center">
        <p class="text-xs sm:text-sm text-gray-600">
          কোনো অ্যাকাউন্ট নেই?
          <a href="{{ route('register') }}" class="font-extrabold text-[#0b4622] hover:text-[#c8102e] hover:underline ml-1">
            নতুন অ্যাকাউন্ট তৈরি করুন
          </a>
        </p>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function togglePasswordVisibility(fieldId, btnEl) {
  const input = document.getElementById(fieldId);
  const icon = btnEl.querySelector('i');
  if (!input) return;
  if (input.type === 'password') {
    input.type = 'text';
    if (icon) {
      icon.classList.remove('fa-eye');
      icon.classList.add('fa-eye-slash');
    }
  } else {
    input.type = 'password';
    if (icon) {
      icon.classList.remove('fa-eye-slash');
      icon.classList.add('fa-eye');
    }
  }
}
</script>
@endpush
