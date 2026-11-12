@extends('layouts.admin.admin-layout')

@section('title', 'ইমেইল কনফিগারেশন (Email SMTP Settings) | আগামীর শৈলকুপা')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

  <!-- Top bar -->
  <div class="flex items-center justify-between">
    <div>
      <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line"></i>
        <span class="text-gray-400">সাধারণ সেটিংস</span>
        <i class="ri-arrow-right-s-line"></i>
        <span class="text-[#0b4622] font-semibold">ইমেইল কনফিগারেশন</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
        <i class="ri-mail-settings-line text-[#0b4622]"></i>
        <span>ইমেইল কনফিগারেশন (Database SMTP Settings)</span>
      </h1>
      <p class="text-xs text-gray-500 mt-0.5">
        .env ফাইলের বদলে সরাসরি ডাটাবেজ থেকে ওয়েবসাইটের ইমেইল (SMTP) সার্ভার কনফিগার ও টেস্ট করুন।
      </p>
    </div>
  </div>

  @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-2xl flex items-center justify-between">
      <div class="flex items-center gap-2">
        <i class="ri-checkbox-circle-fill text-emerald-600 text-base"></i>
        <span>{{ session('success') }}</span>
      </div>
    </div>
  @endif

  @if(session('error'))
    <div class="p-4 bg-red-50 border border-red-200 text-red-800 text-xs font-bold rounded-2xl flex items-start gap-2.5">
      <i class="ri-error-warning-fill text-red-600 text-base shrink-0 mt-0.5"></i>
      <div class="leading-relaxed">
        {{ session('error') }}
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

  <!-- Info Alert Box -->
  <div class="p-4 bg-blue-50/80 border border-blue-200/80 rounded-2xl flex items-start gap-3">
    <i class="ri-information-line text-blue-600 text-lg shrink-0 mt-0.5"></i>
    <div class="text-xs text-blue-900 leading-relaxed">
      <p class="font-bold">ডাটাবেজ ড্রাইভেন ইমেইল সিস্টেম সক্রিয় রয়েছে</p>
      <p class="text-blue-700 mt-0.5">
        এখানে সংরক্ষিত তথ্য স্বয়ংক্রিয়ভাবে অ্যাপ্লিকেশনের মেইল কনফিগারেশনে সেট হয়। cPanel / Custom Domain মেইল ব্যবহার করলে আপনার সঠিক ওয়েবমেইল পাসওয়ার্ড দিন।
      </p>
    </div>
  </div>

  <!-- Form Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-2xs p-6 sm:p-8 space-y-6">
    <form action="{{ route('admin.settings.mail.update') }}" method="POST" class="space-y-6">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Mail Driver / Mailer -->
        <div>
          <label for="mail_mailer" class="block text-xs font-bold text-gray-700 mb-1.5">
            মেইল ড্রাইভার (Mail Mailer) <span class="text-[#c8102e]">*</span>
          </label>
          <select
            id="mail_mailer"
            name="mail_mailer"
            class="w-full px-4 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition font-semibold text-gray-800 cursor-pointer"
            required
          >
            <option value="smtp" {{ old('mail_mailer', $setting->mail_mailer) === 'smtp' ? 'selected' : '' }}>SMTP (সুপারিশকৃত)</option>
            <option value="sendmail" {{ old('mail_mailer', $setting->mail_mailer) === 'sendmail' ? 'selected' : '' }}>Sendmail</option>
            <option value="log" {{ old('mail_mailer', $setting->mail_mailer) === 'log' ? 'selected' : '' }}>Log (টেস্টিং উদ্দেশ্যে)</option>
          </select>
        </div>

        <!-- Mail Host -->
        <div>
          <label for="mail_host" class="block text-xs font-bold text-gray-700 mb-1.5">
            মেইল হোস্ট (Mail Host / SMTP Host) <span class="text-[#c8102e]">*</span>
          </label>
          <input
            type="text"
            id="mail_host"
            name="mail_host"
            value="{{ old('mail_host', $setting->mail_host) }}"
            placeholder="উদাঃ mail.yourdomain.com অথবা smtp.gmail.com"
            class="w-full px-4 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
            required
          >
        </div>

        <!-- Mail Port -->
        <div>
          <label for="mail_port" class="block text-xs font-bold text-gray-700 mb-1.5">
            মেইল পোর্ট (Mail Port) <span class="text-[#c8102e]">*</span>
          </label>
          <input
            type="number"
            id="mail_port"
            name="mail_port"
            value="{{ old('mail_port', $setting->mail_port) }}"
            placeholder="465 অথবা 587"
            class="w-full px-4 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
            required
          >
          <p class="text-[10px] text-gray-400 mt-1">SSL-এর জন্য সাধারণত 465 এবং TLS-এর জন্য 587 ব্যবহৃত হয়।</p>
        </div>

        <!-- Encryption -->
        <div>
          <label for="mail_encryption" class="block text-xs font-bold text-gray-700 mb-1.5">
            এনক্রিপশন (Mail Encryption)
          </label>
          <select
            id="mail_encryption"
            name="mail_encryption"
            class="w-full px-4 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition font-semibold text-gray-800 cursor-pointer"
          >
            <option value="ssl" {{ old('mail_encryption', $setting->mail_encryption) === 'ssl' ? 'selected' : '' }}>SSL (পোর্ট 465 এর জন্য)</option>
            <option value="tls" {{ old('mail_encryption', $setting->mail_encryption) === 'tls' ? 'selected' : '' }}>TLS (পোর্ট 587 এর জন্য)</option>
            <option value="none" {{ old('mail_encryption', $setting->mail_encryption) === 'none' ? 'selected' : '' }}>None (কোনোটিই নয়)</option>
          </select>
        </div>

        <!-- Username -->
        <div>
          <label for="mail_username" class="block text-xs font-bold text-gray-700 mb-1.5">
            মেইল ইউজারনেম (SMTP Username / Full Email)
          </label>
          <input
            type="text"
            id="mail_username"
            name="mail_username"
            value="{{ old('mail_username', $setting->mail_username) }}"
            placeholder="উদাঃ info@yourdomain.com"
            class="w-full px-4 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
          >
        </div>

        <!-- Password with toggle visibility -->
        <div>
          <label for="mail_password" class="block text-xs font-bold text-gray-700 mb-1.5">
            মেইল পাসওয়ার্ড (SMTP Password)
          </label>
          <div class="relative">
            <input
              type="password"
              id="mail_password"
              name="mail_password"
              value="{{ old('mail_password', $setting->mail_password) }}"
              placeholder="পাসওয়ার্ড লিখুন..."
              class="w-full pl-4 pr-10 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
            >
            <button
              type="button"
              onclick="togglePasswordVisibility()"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 text-sm focus:outline-none"
              title="পাসওয়ার্ড দেখুন"
            >
              <i id="toggle-pwd-icon" class="ri-eye-line"></i>
            </button>
          </div>
          <p class="text-[10px] text-gray-400 mt-1">আপনার ইমেইল অ্যাকাউন্টটির সঠিক লগইন পাসওয়ার্ড দিন।</p>
        </div>

        <!-- From Address -->
        <div>
          <label for="mail_from_address" class="block text-xs font-bold text-gray-700 mb-1.5">
            প্রেরক ইমেইল (From Address) <span class="text-[#c8102e]">*</span>
          </label>
          <input
            type="email"
            id="mail_from_address"
            name="mail_from_address"
            value="{{ old('mail_from_address', $setting->mail_from_address) }}"
            placeholder="info@yourdomain.com"
            class="w-full px-4 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
            required
          >
        </div>

        <!-- From Name -->
        <div>
          <label for="mail_from_name" class="block text-xs font-bold text-gray-700 mb-1.5">
            প্রেরকের নাম (From Name) <span class="text-[#c8102e]">*</span>
          </label>
          <input
            type="text"
            id="mail_from_name"
            name="mail_from_name"
            value="{{ old('mail_from_name', $setting->mail_from_name) }}"
            placeholder="আগামীর শৈলকুপা"
            class="w-full px-4 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
            required
          >
        </div>

        <!-- Status Toggle -->
        <div class="md:col-span-2 flex items-center justify-between p-3.5 bg-gray-50 border border-gray-200 rounded-xl">
          <div>
            <span class="text-xs font-bold text-gray-700 block">ডাটাবেজ ইমেইল স্ট্যাটাস</span>
            <span class="text-[11px] text-gray-400">চালু থাকলে সমস্ত ইমেইল প্রেরণে এই ডাটাবেজ কনফিগারেশন প্রযোজ্য হবে।</span>
          </div>
          <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="status" value="1" class="sr-only peer" {{ $setting->status ? 'checked' : '' }}>
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0b4622]"></div>
          </label>
        </div>

      </div>

      <!-- Submit button -->
      <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
        <button
          type="submit"
          class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-sm hover:shadow transition cursor-pointer"
        >
          <i class="ri-check-line text-base"></i>
          <span>কনফিগারেশন সংরক্ষণ করুন</span>
        </button>
      </div>

    </form>
  </div>

  <!-- Test Email Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-2xs p-6 sm:p-8 space-y-4">
    <div class="flex items-center gap-2 pb-3 border-b border-gray-100">
      <i class="ri-send-plane-2-line text-[#0b4622] text-lg"></i>
      <h3 class="text-sm font-black text-gray-900">টেস্ট ইমেইল পাঠিয়ে যাচাই করুন (Send Test Email)</h3>
    </div>
    <p class="text-xs text-gray-500">
      আপনার সংরক্ষিত SMTP কনফিগারেশন সঠিকভাবে কাজ করছে কিনা তা দেখতে নিচের বক্সে আপনার একটি সক্রিয় ইমেইল ঠিকানা লিখে টেস্ট মেইল পাঠান।
    </p>

    <form action="{{ route('admin.settings.mail.test') }}" method="POST" class="flex flex-col sm:flex-row items-center gap-3">
      @csrf
      <div class="relative w-full sm:flex-1">
        <input
          type="email"
          name="test_email"
          placeholder="আপনার ইমেইল ঠিকানা লিখুন (যেমনঃ yourpersonal@gmail.com)..."
          class="w-full pl-9 pr-4 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
          required
        >
        <i class="ri-mail-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
      </div>
      <button
        type="submit"
        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gray-800 hover:bg-black text-white text-xs font-bold rounded-xl shadow-xs transition cursor-pointer shrink-0"
      >
        <i class="ri-send-plane-fill"></i>
        <span>টেস্ট মেইল পাঠান</span>
      </button>
    </form>
  </div>

</div>

<script>
function togglePasswordVisibility() {
  const pwd = document.getElementById('mail_password');
  const icon = document.getElementById('toggle-pwd-icon');
  if (pwd.type === 'password') {
    pwd.type = 'text';
    icon.className = 'ri-eye-off-line';
  } else {
    pwd.type = 'password';
    icon.className = 'ri-eye-line';
  }
}
</script>
@endsection
