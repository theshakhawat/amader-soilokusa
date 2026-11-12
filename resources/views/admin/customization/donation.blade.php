@extends('layouts.admin.admin-layout')

@section('title', 'অনুদান ব্যানার কাস্টমাইজেশন | আগামীর শৈলকুপা')

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
        <span class="text-[#0b4622] font-semibold">অনুদান ব্যানার</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
        <i class="ri-heart-add-line text-[#c8102e]"></i>
        <span>অনুদান ব্যানার সেকশন কাস্টমাইজেশন</span>
      </h1>
      <p class="text-xs text-gray-500 mt-0.5">
        হোমপেজের অনুদান ব্যানারের লেখা, ছবি, ব্যাকগ্রাউন্ড কালার গ্রেডিয়েন্ট ও বাটন রঙ পরিবর্তন করুন।
      </p>
    </div>

    <a
      href="{{ route('home') }}#blog-section"
      target="_blank"
      class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition cursor-pointer"
    >
      <i class="ri-external-link-line"></i>
      <span>হোমপেজে দেখুন</span>
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

  <!-- Live Preview Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-2xs p-5">
    <div class="flex items-center justify-between mb-3">
      <span class="text-xs font-bold text-gray-500 uppercase tracking-wider flex items-center gap-1.5">
        <i class="ri-eye-line text-[#0b4622]"></i>
        <span>লাইভ প্রিভিউ (Live Color & Text Preview)</span>
      </span>
      <span class="text-[11px] text-gray-400">নিচের কালার পিকার পরিবর্তন করলে সরাসরি প্রিভিউ দেখতে পাবেন</span>
    </div>
    
    <div
      id="preview-banner-box"
      class="rounded-2xl overflow-hidden shadow-md relative flex flex-col sm:flex-row items-center justify-between p-5 sm:p-7 text-white gap-5 sm:gap-4 transition-all duration-300"
      style="background: {{ $donation->background_gradient }}; color: {{ $donation->text_color ?: '#ffffff' }};"
    >
      <div class="relative z-10 w-full sm:max-w-[62%] text-center sm:text-left flex flex-col items-center sm:items-start">
        <div class="flex items-center sm:items-start gap-2.5 sm:gap-3">
          <div class="text-2xl sm:text-4xl shrink-0 mt-0.5" id="preview-icon-wrapper">
            <i id="preview-icon" class="{{ $donation->icon ?: 'fa-solid fa-hand-holding-heart' }}"></i>
          </div>
          <h2 id="preview-title" class="text-lg sm:text-[22px] font-extrabold leading-tight">
            {!! nl2br(e($donation->title)) !!}
          </h2>
        </div>

        <p id="preview-description" class="text-xs sm:text-[13px] leading-relaxed mt-2.5 sm:mt-3.5 font-medium opacity-90">
          {{ $donation->description }}
        </p>

        <span
          id="preview-button"
          class="mt-4 sm:mt-5 text-xs sm:text-sm font-extrabold px-5 py-2.5 rounded-full shadow inline-flex items-center gap-2 select-none transition"
          style="background-color: {{ $donation->button_bg_color ?: '#ffffff' }}; color: {{ $donation->button_text_color ?: '#111827' }};"
        >
          <span id="preview-btn-text">{{ $donation->button_text }}</span>
          <i class="ri-arrow-right-line font-bold" id="preview-btn-icon" style="color: {{ $donation->bg_color_start ?: '#c8102e' }};"></i>
        </span>
      </div>

      <div class="w-28 sm:w-36 h-28 sm:h-36 flex items-center justify-center shrink-0">
        <img
          id="preview-image"
          src="{{ $donation->image_url }}"
          alt="প্রতীক"
          class="w-full h-full object-cover rounded-xl shadow"
        />
      </div>
    </div>
  </div>

  <!-- Form Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-2xs p-6 sm:p-8">
    <form action="{{ route('admin.customization.donation.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
      @csrf
      @method('PUT')

      <!-- Section 1: Color Customization -->
      <div class="p-4 bg-gray-50/70 border border-gray-100 rounded-xl space-y-4">
        <div class="flex items-center gap-2 pb-2 border-b border-gray-200">
          <i class="ri-palette-line text-[#0b4622] text-lg"></i>
          <h3 class="text-xs font-black text-gray-900 uppercase tracking-wider">ব্যানারের কালার ও গ্রেডিয়েন্ট সেটিংস</h3>
        </div>

        <!-- Quick Palette Presets -->
        <div>
          <span class="text-[11px] font-bold text-gray-600 block mb-2">রেডিমেড প্রিসেট প্যালেট নির্বাচন করুনঃ</span>
          <div class="flex flex-wrap items-center gap-2">
            <button
              type="button"
              onclick="applyColorPreset('#d92638', '#7d0615', '#ffffff', '#ffffff', '#111827')"
              class="px-3 py-1.5 rounded-lg text-xs font-bold text-white flex items-center gap-1.5 shadow-2xs hover:scale-105 transition cursor-pointer"
              style="background: linear-gradient(135deg, #d92638, #7d0615);"
            >
              <span>লাল থিম (মূল)</span>
            </button>
            <button
              type="button"
              onclick="applyColorPreset('#0b4622', '#052311', '#ffffff', '#ffffff', '#0b4622')"
              class="px-3 py-1.5 rounded-lg text-xs font-bold text-white flex items-center gap-1.5 shadow-2xs hover:scale-105 transition cursor-pointer"
              style="background: linear-gradient(135deg, #0b4622, #052311);"
            >
              <span>গাঢ় সবুজ থিম</span>
            </button>
            <button
              type="button"
              onclick="applyColorPreset('#1e3a8a', '#0f172a', '#ffffff', '#38bdf8', '#0f172a')"
              class="px-3 py-1.5 rounded-lg text-xs font-bold text-white flex items-center gap-1.5 shadow-2xs hover:scale-105 transition cursor-pointer"
              style="background: linear-gradient(135deg, #1e3a8a, #0f172a);"
            >
              <span>রয়েল ব্লু থিম</span>
            </button>
            <button
              type="button"
              onclick="applyColorPreset('#d97706', '#78350f', '#ffffff', '#ffffff', '#78350f')"
              class="px-3 py-1.5 rounded-lg text-xs font-bold text-white flex items-center gap-1.5 shadow-2xs hover:scale-105 transition cursor-pointer"
              style="background: linear-gradient(135deg, #d97706, #78350f);"
            >
              <span>সোনালী / গোল্ডেন</span>
            </button>
            <button
              type="button"
              onclick="applyColorPreset('#4c1d95', '#1e1b4b', '#ffffff', '#ffffff', '#4c1d95')"
              class="px-3 py-1.5 rounded-lg text-xs font-bold text-white flex items-center gap-1.5 shadow-2xs hover:scale-105 transition cursor-pointer"
              style="background: linear-gradient(135deg, #4c1d95, #1e1b4b);"
            >
              <span>বেগুনি / পার্পল</span>
            </button>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 pt-2">
          <!-- Start Color -->
          <div>
            <label for="bg_color_start" class="block text-[11px] font-bold text-gray-700 mb-1">
              ব্যাকগ্রাউন্ড কালার ১
            </label>
            <div class="flex items-center gap-2 bg-white border border-gray-200 rounded-xl p-1.5">
              <input
                type="color"
                id="bg_color_start"
                name="bg_color_start"
                value="{{ old('bg_color_start', $donation->bg_color_start ?: '#d92638') }}"
                class="w-8 h-8 rounded-lg border-0 cursor-pointer p-0"
              >
              <input
                type="text"
                id="bg_color_start_text"
                value="{{ old('bg_color_start', $donation->bg_color_start ?: '#d92638') }}"
                class="w-full text-xs font-mono font-bold uppercase text-gray-700 outline-none"
              >
            </div>
          </div>

          <!-- End Color -->
          <div>
            <label for="bg_color_end" class="block text-[11px] font-bold text-gray-700 mb-1">
              ব্যাকগ্রাউন্ড কালার ২
            </label>
            <div class="flex items-center gap-2 bg-white border border-gray-200 rounded-xl p-1.5">
              <input
                type="color"
                id="bg_color_end"
                name="bg_color_end"
                value="{{ old('bg_color_end', $donation->bg_color_end ?: '#7d0615') }}"
                class="w-8 h-8 rounded-lg border-0 cursor-pointer p-0"
              >
              <input
                type="text"
                id="bg_color_end_text"
                value="{{ old('bg_color_end', $donation->bg_color_end ?: '#7d0615') }}"
                class="w-full text-xs font-mono font-bold uppercase text-gray-700 outline-none"
              >
            </div>
          </div>

          <!-- Text Color -->
          <div>
            <label for="text_color" class="block text-[11px] font-bold text-gray-700 mb-1">
              ব্যানার লেখার রঙ
            </label>
            <div class="flex items-center gap-2 bg-white border border-gray-200 rounded-xl p-1.5">
              <input
                type="color"
                id="text_color"
                name="text_color"
                value="{{ old('text_color', $donation->text_color ?: '#ffffff') }}"
                class="w-8 h-8 rounded-lg border-0 cursor-pointer p-0"
              >
              <input
                type="text"
                id="text_color_text"
                value="{{ old('text_color', $donation->text_color ?: '#ffffff') }}"
                class="w-full text-xs font-mono font-bold uppercase text-gray-700 outline-none"
              >
            </div>
          </div>

          <!-- Button Background Color -->
          <div>
            <label for="button_bg_color" class="block text-[11px] font-bold text-gray-700 mb-1">
              বাটনের ব্যাকগ্রাউন্ড
            </label>
            <div class="flex items-center gap-2 bg-white border border-gray-200 rounded-xl p-1.5">
              <input
                type="color"
                id="button_bg_color"
                name="button_bg_color"
                value="{{ old('button_bg_color', $donation->button_bg_color ?: '#ffffff') }}"
                class="w-8 h-8 rounded-lg border-0 cursor-pointer p-0"
              >
              <input
                type="text"
                id="button_bg_color_text"
                value="{{ old('button_bg_color', $donation->button_bg_color ?: '#ffffff') }}"
                class="w-full text-xs font-mono font-bold uppercase text-gray-700 outline-none"
              >
            </div>
          </div>

          <!-- Button Text Color -->
          <div>
            <label for="button_text_color" class="block text-[11px] font-bold text-gray-700 mb-1">
              বাটনের লেখার রঙ
            </label>
            <div class="flex items-center gap-2 bg-white border border-gray-200 rounded-xl p-1.5">
              <input
                type="color"
                id="button_text_color"
                name="button_text_color"
                value="{{ old('button_text_color', $donation->button_text_color ?: '#111827') }}"
                class="w-8 h-8 rounded-lg border-0 cursor-pointer p-0"
              >
              <input
                type="text"
                id="button_text_color_text"
                value="{{ old('button_text_color', $donation->button_text_color ?: '#111827') }}"
                class="w-full text-xs font-mono font-bold uppercase text-gray-700 outline-none"
              >
            </div>
          </div>
        </div>
      </div>

      <!-- Section 2: Content & Details -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Title -->
        <div class="md:col-span-2">
          <label for="title" class="block text-xs font-bold text-gray-700 mb-1.5">
            ব্যানারের মূল শিরোনাম (Title) <span class="text-[#c8102e]">*</span>
          </label>
          <textarea
            id="title"
            name="title"
            rows="2"
            class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('title') border-[#c8102e] @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition"
            required
          >{{ old('title', $donation->title) }}</textarea>
          <p class="text-[11px] text-gray-400 mt-1">নতুন লাইনের জন্য Enter চাপুন।</p>
          @error('title')
            <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
          @enderror
        </div>

        <!-- Description -->
        <div class="md:col-span-2">
          <label for="description" class="block text-xs font-bold text-gray-700 mb-1.5">
            সংক্ষিপ্ত বিবরণ (Description)
          </label>
          <textarea
            id="description"
            name="description"
            rows="3"
            class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition"
          >{{ old('description', $donation->description) }}</textarea>
        </div>

        <!-- Button Text -->
        <div>
          <label for="button_text" class="block text-xs font-bold text-gray-700 mb-1.5">
            বাটন টেক্সট (Button Text) <span class="text-[#c8102e]">*</span>
          </label>
          <input
            type="text"
            id="button_text"
            name="button_text"
            value="{{ old('button_text', $donation->button_text) }}"
            class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
            required
          >
        </div>

        <!-- Button Link -->
        <div>
          <label for="button_link" class="block text-xs font-bold text-gray-700 mb-1.5">
            বাটন লিংক (ঐচ্ছিক - ফাঁকা রাখলে অনুদান মডাল খুলবে)
          </label>
          <input
            type="text"
            id="button_link"
            name="button_link"
            value="{{ old('button_link', $donation->button_link) }}"
            placeholder="উদাঃ /donate বা # বা ফাঁকা রাখুন"
            class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
          >
        </div>

        <!-- Icon Class -->
        <div>
          <label for="icon" class="block text-xs font-bold text-gray-700 mb-1.5">
            আইকন ক্লাস (FontAwesome বা RemixIcon)
          </label>
          <input
            type="text"
            id="icon"
            name="icon"
            value="{{ old('icon', $donation->icon) }}"
            placeholder="fa-solid fa-hand-holding-heart"
            class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
          >
        </div>

        <!-- Active Status Toggle -->
        <div class="flex items-center justify-between p-3.5 bg-gray-50 border border-gray-200 rounded-xl">
          <div>
            <span class="text-xs font-bold text-gray-700 block">ব্যানার স্ট্যাটাস</span>
            <span class="text-[11px] text-gray-400">হোমপেজে ব্যানারটি প্রদর্শন করবেন কিনা</span>
          </div>
          <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="status" value="1" class="sr-only peer" {{ $donation->status ? 'checked' : '' }}>
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0b4622]"></div>
          </label>
        </div>

        <!-- Right Side Image Upload -->
        <div class="md:col-span-2 bg-gray-50/70 border border-gray-100 rounded-xl p-4 space-y-3">
          <label class="block text-xs font-bold text-gray-700">
            ডানপাশের প্রতীকী ছবি (Sapling / Donation Image)
          </label>
          <div class="flex flex-col sm:flex-row items-center gap-4">
            <div class="w-24 h-24 rounded-xl overflow-hidden border border-gray-200 bg-white shrink-0">
              <img src="{{ $donation->image_url }}" alt="ছবি প্রিভিউ" class="w-full h-full object-cover">
            </div>
            <div class="flex-1 w-full">
              <input
                type="file"
                name="image"
                accept="image/*"
                class="w-full text-xs text-gray-500 file:mr-2 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#c8102e]/10 file:text-[#c8102e] hover:file:bg-[#c8102e]/20 cursor-pointer"
              >
              <p class="text-[11px] text-gray-400 mt-1.5">প্রস্তাবিত সাইজঃ 400x400 পিক্সেল (JPG, PNG, WEBP)। সর্বোচ্চ 4MB।</p>
            </div>
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
          <span>পরিবর্তন সংরক্ষণ করুন</span>
        </button>
      </div>

    </form>
  </div>
</div>

<!-- Live Preview Sync Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const bgStart = document.getElementById('bg_color_start');
  const bgStartText = document.getElementById('bg_color_start_text');
  const bgEnd = document.getElementById('bg_color_end');
  const bgEndText = document.getElementById('bg_color_end_text');
  const textColor = document.getElementById('text_color');
  const textColorText = document.getElementById('text_color_text');
  const btnBg = document.getElementById('button_bg_color');
  const btnBgText = document.getElementById('button_bg_color_text');
  const btnText = document.getElementById('button_text_color');
  const btnTextText = document.getElementById('button_text_color_text');

  const titleInput = document.getElementById('title');
  const descInput = document.getElementById('description');
  const btnTextInput = document.getElementById('button_text');
  const iconInput = document.getElementById('icon');

  const bannerBox = document.getElementById('preview-banner-box');
  const previewTitle = document.getElementById('preview-title');
  const previewDesc = document.getElementById('preview-description');
  const previewBtn = document.getElementById('preview-button');
  const previewBtnText = document.getElementById('preview-btn-text');
  const previewBtnIcon = document.getElementById('preview-btn-icon');
  const previewIcon = document.getElementById('preview-icon');

  function updatePreview() {
    const start = bgStart.value;
    const end = bgEnd.value;
    const text = textColor.value;
    const bBg = btnBg.value;
    const bText = btnText.value;

    bannerBox.style.background = `radial-gradient(circle at 78% 45%, ${start} 0%, ${end} 100%)`;
    bannerBox.style.color = text;
    previewBtn.style.backgroundColor = bBg;
    previewBtn.style.color = bText;
    previewBtnIcon.style.color = start;

    previewTitle.innerHTML = titleInput.value.replace(/\n/g, '<br>');
    previewDesc.innerText = descInput.value;
    previewBtnText.innerText = btnTextInput.value;

    if (iconInput.value) {
      previewIcon.className = iconInput.value;
    }
  }

  function bindColorPair(picker, textInput) {
    picker.addEventListener('input', () => {
      textInput.value = picker.value.toUpperCase();
      updatePreview();
    });
    textInput.addEventListener('input', () => {
      if (/^#[0-9A-F]{6}$/i.test(textInput.value)) {
        picker.value = textInput.value;
        updatePreview();
      }
    });
  }

  bindColorPair(bgStart, bgStartText);
  bindColorPair(bgEnd, bgEndText);
  bindColorPair(textColor, textColorText);
  bindColorPair(btnBg, btnBgText);
  bindColorPair(btnText, btnTextText);

  titleInput.addEventListener('input', updatePreview);
  descInput.addEventListener('input', updatePreview);
  btnTextInput.addEventListener('input', updatePreview);
  iconInput.addEventListener('input', updatePreview);

  window.applyColorPreset = function(start, end, text, btnBgVal, btnTextVal) {
    bgStart.value = start;
    bgStartText.value = start.toUpperCase();
    bgEnd.value = end;
    bgEndText.value = end.toUpperCase();
    textColor.value = text;
    textColorText.value = text.toUpperCase();
    btnBg.value = btnBgVal;
    btnBgText.value = btnBgVal.toUpperCase();
    btnText.value = btnTextVal;
    btnTextText.value = btnTextVal.toUpperCase();
    updatePreview();
  };
});
</script>
@endsection
