@extends('layouts.website.website-layout')

@section('title', 'নিবন্ধন করুন — আগামীর শৈলকুপা')

@section('content')
<div class="py-10 sm:py-16 bg-gradient-to-b from-[#f4f5f7] via-white to-[#f4f5f7]">
  <div class="max-w-[500px] mx-auto px-4">
    <!-- Register Card -->
    <div class="bg-white rounded-2xl shadow-[0_10px_35px_rgba(0,0,0,0.06)] border border-gray-100 p-6 sm:p-8 relative overflow-hidden">
      <!-- Decorative Top Color Strip -->
      <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-[#c8102e] via-[#0b4622] to-[#c8102e]"></div>

      <!-- Card Header -->
      <div class="text-center mb-6">
        <div class="w-14 h-14 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center mx-auto mb-3 shadow-inner">
          <i class="fa-solid fa-user-plus text-[#0b4622] text-2xl"></i>
        </div>
        <h1 class="text-2xl sm:text-[26px] font-extrabold text-gray-900 tracking-tight leading-snug">
          নতুন সদস্য নিবন্ধন
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">
          শৈলকুপার সার্বিক উন্নয়নে আমাদের এক পরিবারের সদস্য হোন
        </p>
      </div>

      <!-- Register Form -->
      <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <!-- 1. Profile Photo Placeholder & Upload (Optional) -->
        <div class="flex flex-col items-center justify-center pb-2">
          <!-- Circular Image Preview / Placeholder -->
          <div class="relative group">
            <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full border-2 border-dashed border-[#0b4622]/40 p-1 bg-gray-50 flex items-center justify-center overflow-hidden shadow-xs hover:border-[#0b4622] transition">
              <img
                id="photo-preview"
                src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%239ca3af'%3E%3Cpath d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/%3E%3C/svg%3E"
                alt="প্রোফাইল ছবি প্রিভিউ"
                class="w-full h-full object-cover rounded-full"
              />
            </div>
            <!-- Quick Camera Badge (Clickable) -->
            <label
              for="photo"
              class="absolute bottom-0 right-0 w-8 h-8 rounded-full bg-[#0b4622] hover:bg-[#083519] text-white flex items-center justify-center shadow-md cursor-pointer transition transform hover:scale-105"
              title="ছবি নির্বাচন করুন"
            >
              <i class="fa-solid fa-camera text-xs"></i>
            </label>
          </div>

          <!-- Upload Option / File Input below Placeholder -->
          <div class="mt-2.5 text-center w-full max-w-xs">
            <label for="photo" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 bg-gray-50 hover:bg-emerald-50 text-gray-700 hover:text-[#0b4622] text-xs font-semibold cursor-pointer shadow-2xs transition">
              <i class="fa-solid fa-cloud-arrow-up text-sm text-[#0b4622]"></i>
              <span id="photo-file-label">ছবি আপলোড করুন</span>
            </label>
            <input
              type="file"
              id="photo"
              name="photo"
              accept="image/*"
              class="hidden"
              onchange="previewProfilePhoto(event)"
            />
            <p class="text-[11px] text-gray-400 mt-1">ঐচ্ছিক (JPG, PNG বা WebP, সর্বোচ্চ ২MB)</p>
          </div>
          @error('photo')
            <p class="text-xs text-[#c8102e] mt-1 font-semibold text-center">{{ $message }}</p>
          @enderror
        </div>

        <!-- 2. Full Name -->
        <div>
          <label for="name" class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">
            আপনার পূর্ণ নাম <span class="text-[#c8102e]">*</span>
          </label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
              <i class="fa-regular fa-id-card text-sm"></i>
            </span>
            <input
              type="text"
              id="name"
              name="name"
              value="{{ old('name') }}"
              required
              autofocus
              placeholder="যেমন: মোঃ শওকত আলী"
              class="w-full pl-10 pr-4 py-2.5 rounded-xl border {{ $errors->has('name') ? 'border-red-300 bg-red-50/20' : 'border-gray-200 bg-gray-50/30' }} text-sm focus:outline-none focus:border-[#c8102e] focus:bg-white transition"
            />
          </div>
          @error('name')
            <p class="text-xs text-[#c8102e] mt-1 font-semibold">{{ $message }}</p>
          @enderror
        </div>

        <!-- 3. Phone Number -->
        <div>
          <label for="phone" class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">
            মোবাইল নম্বর <span class="text-[#c8102e]">*</span>
          </label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
              <i class="fa-solid fa-phone text-sm"></i>
            </span>
            <input
              type="tel"
              id="phone"
              name="phone"
              value="{{ old('phone') }}"
              required
              placeholder="017XXXXXXXX"
              class="w-full pl-10 pr-4 py-2.5 rounded-xl border {{ $errors->has('phone') ? 'border-red-300 bg-red-50/20' : 'border-gray-200 bg-gray-50/30' }} text-sm focus:outline-none focus:border-[#c8102e] focus:bg-white transition"
            />
          </div>
          @error('phone')
            <p class="text-xs text-[#c8102e] mt-1 font-semibold">{{ $message }}</p>
          @enderror
        </div>

        <!-- 4. Email Address -->
        <div>
          <label for="email" class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">
            ইমেইল ঠিকানা <span class="text-[#c8102e]">*</span>
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
              placeholder="example@mail.com"
              class="w-full pl-10 pr-4 py-2.5 rounded-xl border {{ $errors->has('email') ? 'border-red-300 bg-red-50/20' : 'border-gray-200 bg-gray-50/30' }} text-sm focus:outline-none focus:border-[#c8102e] focus:bg-white transition"
            />
          </div>
          @error('email')
            <p class="text-xs text-[#c8102e] mt-1 font-semibold">{{ $message }}</p>
          @enderror
        </div>

        <!-- 5. Password and Confirm Password Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
          <!-- Password -->
          <div>
            <label for="password" class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">
              পাসওয়ার্ড <span class="text-[#c8102e]">*</span>
            </label>
            <div class="relative">
              <input
                type="password"
                id="password"
                name="password"
                required
                placeholder="কমপক্ষে ৬ অক্ষর"
                class="w-full px-3.5 py-2.5 rounded-xl border {{ $errors->has('password') ? 'border-red-300 bg-red-50/20' : 'border-gray-200 bg-gray-50/30' }} text-sm focus:outline-none focus:border-[#c8102e] focus:bg-white transition"
              />
            </div>
          </div>

          <!-- Password Confirmation -->
          <div>
            <label for="password_confirmation" class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">
              পাসওয়ার্ড নিশ্চিত করুন <span class="text-[#c8102e]">*</span>
            </label>
            <div class="relative">
              <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                required
                placeholder="পুনরায় পাসওয়ার্ড দিন"
                class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 bg-gray-50/30 text-sm focus:outline-none focus:border-[#c8102e] focus:bg-white transition"
              />
            </div>
          </div>
        </div>
        @error('password')
          <p class="text-xs text-[#c8102e] font-semibold">{{ $message }}</p>
        @enderror

        <!-- Terms agreement notice -->
        <p class="text-[11.5px] text-gray-500 leading-relaxed pt-1">
          "নিবন্ধন করুন" বাটনে ক্লিক করার মাধ্যমে আপনি আমাদের
          <a href="#" class="text-[#c8102e] hover:underline font-semibold">ব্যবহারের শর্তাবলী</a>
          ও <a href="#" class="text-[#c8102e] hover:underline font-semibold">গোপনীয়তা নীতি</a> মেনে নিচ্ছেন।
        </p>

        <!-- Submit Button -->
        <button
          type="submit"
          class="w-full bg-[#0b4622] hover:bg-[#083519] text-white text-sm sm:text-base font-bold py-2.5 sm:py-3 rounded-xl shadow-md hover:shadow-lg transition flex items-center justify-center gap-2 cursor-pointer mt-2"
        >
          <span>নিবন্ধন সম্পন্ন করুন</span>
          <i class="fa-solid fa-arrow-right text-xs"></i>
        </button>
      </form>

      <!-- Bottom Card Footer (Link to Login) -->
      <div class="mt-6 pt-5 border-t border-gray-100 text-center">
        <p class="text-xs sm:text-sm text-gray-600">
          ইতিমধ্যে একটি অ্যাকাউন্ট আছে?
          <a href="{{ route('login') }}" class="font-extrabold text-[#c8102e] hover:underline ml-1">
            লগইন করুন
          </a>
        </p>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  function previewProfilePhoto(event) {
    const file = event.target.files && event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        const preview = document.getElementById('photo-preview');
        if (preview) {
          preview.src = e.target.result;
        }
        const label = document.getElementById('photo-file-label');
        if (label) {
          label.textContent = file.name.length > 20 ? file.name.substring(0, 18) + '...' : file.name;
        }
      };
      reader.readAsDataURL(file);
    }
  }
</script>
@endpush
