@extends('layouts.admin.admin-layout')

@section('title', 'হিরো ব্যানার সম্পাদনা | আগামী শৈলকুপা')

@section('content')
<div class="space-y-6">
  <!-- Top Navigation & Actions Bar -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
    <div>
      <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622] transition">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <span>কাস্টমাইজেশন</span>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <a href="{{ route('admin.hero-banners.index') }}" class="hover:text-[#0b4622] transition">হিরো ব্যানার</a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <span class="text-[#0b4622] font-semibold">সম্পাদনা</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-800 tracking-tight flex items-center gap-2">
        <i class="ri-edit-line text-[#0b4622]"></i>
        <span>হিরো স্লাইডার সম্পাদনা (Edit Banner)</span>
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-0.5">ব্যানারের টেক্সট, বোতাম বা ব্যাকগ্রাউন্ড ছবি হালনাগাদ করুন।</p>
    </div>

    <div>
      <a
        href="{{ route('admin.hero-banners.index') }}"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition cursor-pointer"
      >
        <i class="ri-arrow-left-line"></i>
        <span>তালিকায় ফিরে যান</span>
      </a>
    </div>
  </div>

  <!-- Form Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <span class="w-9 h-9 rounded-xl bg-[#0b4622]/10 text-[#0b4622] flex items-center justify-center font-bold text-lg">
          <i class="ri-image-edit-line"></i>
        </span>
        <div>
          <h2 class="text-sm font-bold text-gray-800">ব্যানার বিবরণ হালনাগাদ</h2>
          <p class="text-xs text-gray-500">আইডি #{{ $heroBanner->id }} • {{ $heroBanner->title }}</p>
        </div>
      </div>
      <div>
        <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full {{ $heroBanner->status ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-gray-100 text-gray-600 border border-gray-200' }}">
          <span class="w-1.5 h-1.5 rounded-full {{ $heroBanner->status ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
          {{ $heroBanner->status ? 'বর্তমানে সক্রিয়' : 'বর্তমানে নিষ্ক্রিয়' }}
        </span>
      </div>
    </div>

    <form action="{{ route('admin.hero-banners.update', $heroBanner) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left 2 Cols: Text & Buttons Details -->
        <div class="lg:col-span-2 space-y-5">
          <!-- Title -->
          <div>
            <label for="title" class="block text-xs font-bold text-gray-700 mb-1.5">
              ব্যানার শিরোনাম (Title) <span class="text-[#c8102e]">*</span>
            </label>
            <input
              type="text"
              id="title"
              name="title"
              value="{{ old('title', $heroBanner->title) }}"
              placeholder="উদাঃ আগামী শৈলকুপা"
              class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('title') border-[#c8102e] bg-red-50/20 @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition"
              required
            >
            @error('title')
              <p class="mt-1.5 text-xs text-[#c8102e] flex items-center gap-1 font-medium">
                <i class="ri-error-warning-line"></i> {{ $message }}
              </p>
            @enderror
          </div>

          <!-- Subtitle / Description -->
          <div>
            <label for="subtitle" class="block text-xs font-bold text-gray-700 mb-1.5">
              উপশিরোনাম বা বিবরণ (Subtitle)
            </label>
            <textarea
              id="subtitle"
              name="subtitle"
              rows="3"
              placeholder="শৈলকুপার সার্বিক উন্নয়ন, ইতিহাস ও ঐতিহ্য রক্ষা..."
              class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('subtitle') border-[#c8102e] bg-red-50/20 @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition"
            >{{ old('subtitle', $heroBanner->subtitle) }}</textarea>
            @error('subtitle')
              <p class="mt-1.5 text-xs text-[#c8102e] flex items-center gap-1 font-medium">
                <i class="ri-error-warning-line"></i> {{ $message }}
              </p>
            @enderror
          </div>

          <!-- Badge text (optional) -->
          <div>
            <label for="badge" class="block text-xs font-bold text-gray-700 mb-1.5">
              ট্যাগ বা ব্যাজ টেক্সট (Badge) <span class="text-xs font-normal text-gray-400">(ঐচ্ছিক)</span>
            </label>
            <input
              type="text"
              id="badge"
              name="badge"
              value="{{ old('badge', $heroBanner->badge) }}"
              placeholder="উদাঃ ঐতিহ্য ও মানবিক উন্নয়ন"
              class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('badge') border-[#c8102e] bg-red-50/20 @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition"
            >
            @error('badge')
              <p class="mt-1.5 text-xs text-[#c8102e] flex items-center gap-1 font-medium">
                <i class="ri-error-warning-line"></i> {{ $message }}
              </p>
            @enderror
          </div>

          <!-- Buttons Row: Primary & Secondary -->
          <div class="p-4 bg-gray-50/70 border border-gray-100 rounded-xl space-y-4">
            <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider flex items-center gap-1.5">
              <i class="ri-cursor-line text-[#0b4622]"></i>
              <span>কল টু অ্যাকশন বাটনসমূহ (CTA Buttons)</span>
            </h3>

            <!-- Primary Button -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label for="primary_button_text" class="block text-xs font-semibold text-gray-700 mb-1">
                  প্রাইমারি বাটন টেক্সট <span class="text-[#c8102e]">*</span>
                </label>
                <input
                  type="text"
                  id="primary_button_text"
                  name="primary_button_text"
                  value="{{ old('primary_button_text', $heroBanner->primary_button_text) }}"
                  placeholder="উদাঃ আমাদের সম্পর্কে জানুন"
                  class="w-full px-3.5 py-2 text-sm bg-white border @error('primary_button_text') border-[#c8102e] @else border-gray-200 @enderror rounded-lg focus:outline-none focus:border-[#0b4622] transition"
                  required
                >
                @error('primary_button_text')
                  <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
                @enderror
              </div>

              <div>
                <label for="primary_button_link" class="block text-xs font-semibold text-gray-700 mb-1">
                  প্রাইমারি বাটন লিংক (URL)
                </label>
                <input
                  type="text"
                  id="primary_button_link"
                  name="primary_button_link"
                  value="{{ old('primary_button_link', $heroBanner->primary_button_link) }}"
                  placeholder="#about অথবা https://..."
                  class="w-full px-3.5 py-2 text-sm bg-white border @error('primary_button_link') border-[#c8102e] @else border-gray-200 @enderror rounded-lg focus:outline-none focus:border-[#0b4622] transition"
                >
                @error('primary_button_link')
                  <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
                @enderror
              </div>
            </div>

            <!-- Secondary Button -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-gray-200/60">
              <div>
                <label for="secondary_button_text" class="block text-xs font-semibold text-gray-700 mb-1">
                  সেকেন্ডারি বাটন টেক্সট <span class="text-xs font-normal text-gray-400">(ঐচ্ছিক)</span>
                </label>
                <input
                  type="text"
                  id="secondary_button_text"
                  name="secondary_button_text"
                  value="{{ old('secondary_button_text', $heroBanner->secondary_button_text) }}"
                  placeholder="উদাঃ ভিডিও দেখুন বা অনুদান দিন"
                  class="w-full px-3.5 py-2 text-sm bg-white border @error('secondary_button_text') border-[#c8102e] @else border-gray-200 @enderror rounded-lg focus:outline-none focus:border-[#0b4622] transition"
                >
                @error('secondary_button_text')
                  <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
                @enderror
              </div>

              <div>
                <label for="secondary_button_link" class="block text-xs font-semibold text-gray-700 mb-1">
                  সেকেন্ডারি বাটন লিংক (URL / Video Link)
                </label>
                <input
                  type="text"
                  id="secondary_button_link"
                  name="secondary_button_link"
                  value="{{ old('secondary_button_link', $heroBanner->secondary_button_link) }}"
                  placeholder="https://youtube.com/... অথবা #video"
                  class="w-full px-3.5 py-2 text-sm bg-white border @error('secondary_button_link') border-[#c8102e] @else border-gray-200 @enderror rounded-lg focus:outline-none focus:border-[#0b4622] transition"
                >
                @error('secondary_button_link')
                  <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
                @enderror
              </div>
            </div>
          </div>
        </div>

        <!-- Right Col: Image Upload & Order / Status -->
        <div class="space-y-5">
          <!-- Image Upload with Live Preview -->
          <div class="bg-gray-50/70 border border-gray-100 rounded-xl p-4 space-y-3">
            <label class="block text-xs font-bold text-gray-700">
              ব্যানার ব্যাকগ্রাউন্ড ছবি (Banner Image) <span class="text-xs font-normal text-gray-400">(অনূর্ধ্ব 4MB)</span>
            </label>

            <!-- Preview box -->
            <div class="relative w-full h-44 rounded-xl border-2 border-dashed border-gray-300 overflow-hidden bg-gray-100 flex items-center justify-center group">
              <img
                id="image-preview"
                src="{{ $heroBanner->image_url }}"
                alt="Banner Preview"
                onerror="this.src='https://placehold.co/1200x500/0b4622/ffffff?text=Banner+Preview+(1920x800)'"
                class="w-full h-full object-cover transition duration-300 group-hover:scale-105"
              >
              <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                <span class="text-white text-xs font-semibold px-3 py-1.5 rounded-lg bg-black/60 backdrop-blur-xs flex items-center gap-1.5 pointer-events-none">
                  <i class="ri-camera-lens-line"></i> ছবি পরিবর্তন করুন
                </span>
              </div>
              <input
                type="file"
                id="banner-image-input"
                name="image"
                accept="image/*"
                class="absolute inset-0 opacity-0 cursor-pointer w-full h-full z-10"
                onchange="previewBannerImage(event)"
              >
            </div>

            <p class="text-[11px] text-gray-500 leading-relaxed">
              ছবি অপরিবর্তিত রাখতে চাইলে নতুন ফাইল নির্বাচন করার প্রয়োজন নেই।
            </p>

            @error('image')
              <p class="mt-1 text-xs text-[#c8102e] flex items-center gap-1 font-medium">
                <i class="ri-error-warning-line"></i> {{ $message }}
              </p>
            @enderror
          </div>

          <!-- Order -->
          <div>
            <label for="order" class="block text-xs font-bold text-gray-700 mb-1.5">
              প্রদর্শনের ক্রম (Sort Order)
            </label>
            <input
              type="number"
              id="order"
              name="order"
              value="{{ old('order', $heroBanner->order) }}"
              min="0"
              class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('order') border-[#c8102e] @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
            >
            <p class="text-[11px] text-gray-400 mt-1">কম সংখ্যাযুক্ত ব্যানার আগে প্রদর্শিত হবে</p>
            @error('order')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Status toggle -->
          <div class="p-4 bg-gray-50 border border-gray-100 rounded-xl flex items-center justify-between">
            <div>
              <span class="text-xs font-bold text-gray-700 block">সক্রিয় স্ট্যাটাস (Status)</span>
              <span class="text-[11px] text-gray-500">হোমপেজের স্লাইডারে দৃশ্যমান বা লুকায়িত রাখা</span>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
              <input
                type="checkbox"
                name="status"
                value="1"
                class="sr-only peer"
                {{ old('status', $heroBanner->status) ? 'checked' : '' }}
              >
              <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0b4622]"></div>
            </label>
          </div>
        </div>
      </div>

      <!-- Action buttons -->
      <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
        <a
          href="{{ route('admin.hero-banners.index') }}"
          class="px-5 py-2.5 border border-gray-200 text-gray-700 text-xs font-bold rounded-xl hover:bg-gray-50 transition"
        >
          বাতিল
        </a>
        <button
          type="submit"
          class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-sm hover:shadow transition cursor-pointer"
        >
          <i class="ri-check-line"></i>
          <span>পরিবর্তন সংরক্ষণ করুন</span>
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function previewBannerImage(event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('image-preview').src = e.target.result;
    }
    reader.readAsDataURL(file);
  }
}
</script>
@endsection

