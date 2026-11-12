@extends('layouts.admin.admin-layout')

@section('title', 'নতুন সোশ্যাল মিডিয়া যোগ — আগামীর শৈলকুপা')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

  <!-- Header Section -->
  <div class="flex items-center justify-between">
    <div>
      <div class="inline-flex items-center gap-1.5 bg-emerald-50 text-[#0b4622] px-3 py-1 rounded-full text-xs font-bold mb-1 border border-emerald-100">
        <i class="ri-add-line"></i>
        <span>নতুন সোশ্যাল মিডিয়া</span>
      </div>
      <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">
        নতুন সোশ্যাল মিডিয়া যোগ করুন
      </h1>
      <p class="text-xs text-gray-500 mt-0.5">টপবার ও ফুটারে প্রদর্শনের জন্য নতুন লিঙ্ক তৈরি করুন</p>
    </div>
    <a
      href="{{ route('admin.social-media.index') }}"
      class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 text-xs font-bold transition shadow-2xs"
    >
      <i class="ri-arrow-left-line text-sm"></i>
      <span>তালিকায় ফিরুন</span>
    </a>
  </div>

  {{-- Validation Error Alert --}}
  @if($errors->any())
    <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-[#c8102e] text-xs sm:text-sm font-semibold">
      <div class="flex items-center gap-2 mb-1">
        <i class="ri-error-warning-fill text-lg"></i>
        <span>অনুগ্রহ করে তথ্যগুলো সংশোধন করুন:</span>
      </div>
      <ul class="list-disc list-inside text-xs space-y-0.5 pl-6 font-medium">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- Create Form Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)] p-6 sm:p-8">
    <form action="{{ route('admin.social-media.store') }}" method="POST" class="space-y-5">
      @csrf

      <!-- Quick Platform Presets -->
      <div class="p-4 bg-gray-50/70 border border-gray-100 rounded-xl">
        <label class="block text-xs font-bold text-gray-700 mb-1.5">
          জনপ্রিয় প্ল্যাটফর্ম নির্বাচন করুন (Auto Fill)
        </label>
        <select
          id="preset-platform"
          onchange="applyPlatformPreset(this.value)"
          class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 bg-white text-xs sm:text-sm text-gray-800 focus:outline-none focus:border-[#0b4622] transition cursor-pointer"
        >
          <option value="">-- প্ল্যাটফর্ম বাছাই করুন --</option>
          <option value="Facebook|fa-brands fa-facebook-f">Facebook</option>
          <option value="YouTube|fa-brands fa-youtube">YouTube</option>
          <option value="X (Twitter)|fa-brands fa-x-twitter">X (Twitter)</option>
          <option value="Instagram|fa-brands fa-instagram">Instagram</option>
          <option value="WhatsApp|fa-brands fa-whatsapp">WhatsApp</option>
          <option value="LinkedIn|fa-brands fa-linkedin-in">LinkedIn</option>
          <option value="TikTok|fa-brands fa-tiktok">TikTok</option>
          <option value="Telegram|fa-brands fa-telegram">Telegram</option>
          <option value="GitHub|fa-brands fa-github">GitHub</option>
          <option value="Website|fa-solid fa-globe">Website (Globe)</option>
        </select>
      </div>

      <!-- Platform Name -->
      <div>
        <label for="input-platform" class="block text-xs font-bold text-gray-700 mb-1.5">
          প্ল্যাটফর্মের নাম <span class="text-[#c8102e]">*</span>
        </label>
        <input
          type="text"
          id="input-platform"
          name="platform"
          value="{{ old('platform') }}"
          required
          placeholder="যেমন: Facebook, YouTube, ইত্যাদি"
          class="w-full px-3.5 py-2.5 rounded-xl border {{ $errors->has('platform') ? 'border-red-300 bg-red-50/20' : 'border-gray-200 bg-gray-50/40' }} text-xs sm:text-sm text-gray-900 focus:outline-none focus:border-[#0b4622] focus:bg-white transition"
        />
        @error('platform')
          <p class="text-xs text-[#c8102e] mt-1 font-semibold">{{ $message }}</p>
        @enderror
      </div>

      <!-- Font Awesome Icon Class & Live Preview -->
      <div>
        <label for="input-icon" class="block text-xs font-bold text-gray-700 mb-1.5">
          Font Awesome আইকন ক্লাস <span class="text-[#c8102e]">*</span>
        </label>
        <div class="flex items-center gap-3">
          <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
              <i class="ri-font-size text-sm"></i>
            </span>
            <input
              type="text"
              id="input-icon"
              name="icon"
              value="{{ old('icon') }}"
              required
              oninput="updateIconLivePreview(this.value)"
              placeholder="যেমন: fa-brands fa-facebook-f"
              class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border {{ $errors->has('icon') ? 'border-red-300 bg-red-50/20' : 'border-gray-200 bg-gray-50/40' }} text-xs sm:text-sm text-gray-900 focus:outline-none focus:border-[#0b4622] focus:bg-white transition font-mono"
            />
          </div>
          <!-- Live Preview Box -->
          <div class="w-11 h-11 rounded-xl border border-gray-200 bg-gray-50 flex items-center justify-center text-lg text-gray-800 shadow-2xs shrink-0" title="আইকন প্রিভিউ">
            <i id="icon-live-preview" class="fa-solid fa-icons text-gray-400"></i>
          </div>
        </div>
        <p class="text-[11px] text-gray-400 mt-1">Font Awesome 6 ক্লাস (যেমন: fa-brands fa-facebook-f, fa-brands fa-whatsapp)</p>
        @error('icon')
          <p class="text-xs text-[#c8102e] mt-1 font-semibold">{{ $message }}</p>
        @enderror
      </div>

      <!-- URL Input -->
      <div>
        <label for="input-url" class="block text-xs font-bold text-gray-700 mb-1.5">
          সোশ্যাল মিডিয়া লিংক (URL) <span class="text-[#c8102e]">*</span>
        </label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
            <i class="ri-link text-sm"></i>
          </span>
          <input
            type="url"
            id="input-url"
            name="url"
            value="{{ old('url') }}"
            required
            placeholder="https://facebook.com/your-page"
            class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border {{ $errors->has('url') ? 'border-red-300 bg-red-50/20' : 'border-gray-200 bg-gray-50/40' }} text-xs sm:text-sm text-gray-900 focus:outline-none focus:border-[#0b4622] focus:bg-white transition"
          />
        </div>
        @error('url')
          <p class="text-xs text-[#c8102e] mt-1 font-semibold">{{ $message }}</p>
        @enderror
      </div>

      <!-- Target Window & Order Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Target Window -->
        <div>
          <label for="input-target" class="block text-xs font-bold text-gray-700 mb-1.5">
            উইন্ডো মোড (Target) <span class="text-[#c8102e]">*</span>
          </label>
          <select
            id="input-target"
            name="target"
            class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 bg-gray-50/40 text-xs sm:text-sm text-gray-800 focus:outline-none focus:border-[#0b4622] focus:bg-white transition cursor-pointer"
          >
            <option value="_blank" {{ old('target') === '_blank' ? 'selected' : '' }}>নতুন ট্যাব (_blank)</option>
            <option value="_self" {{ old('target') === '_self' ? 'selected' : '' }}>একই পেজ (_self)</option>
          </select>
        </div>

        <!-- Display Order -->
        <div>
          <label for="input-order" class="block text-xs font-bold text-gray-700 mb-1.5">
            ক্রম (Display Order)
          </label>
          <input
            type="number"
            id="input-order"
            name="order"
            value="{{ old('order') }}"
            min="0"
            placeholder="যেমন: 1, 2, 3..."
            class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 bg-gray-50/40 text-xs sm:text-sm text-gray-900 focus:outline-none focus:border-[#0b4622] focus:bg-white transition"
          />
        </div>
      </div>

      <!-- Active Checkbox -->
      <div class="flex items-center gap-2 pt-1">
        <input
          type="checkbox"
          id="input-is-active"
          name="is_active"
          value="1"
          checked
          class="w-4 h-4 text-[#0b4622] rounded border-gray-300 focus:ring-[#0b4622]"
        />
        <label for="input-is-active" class="text-xs font-bold text-gray-700 cursor-pointer">
          লিংকটি সক্রিয় (Active) রাখুন
        </label>
      </div>

      <!-- Submit Buttons -->
      <div class="pt-5 border-t border-gray-100 flex items-center justify-end gap-3">
        <a
          href="{{ route('admin.social-media.index') }}"
          class="px-4 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-xs font-bold transition"
        >
          বাতিল
        </a>
        <button
          type="submit"
          class="inline-flex items-center gap-2 bg-[#0b4622] hover:bg-[#083519] text-white text-xs sm:text-sm font-bold px-5 py-2.5 rounded-xl shadow-xs transition cursor-pointer"
        >
          <i class="ri-save-line text-sm"></i>
          <span>সংরক্ষণ করুন</span>
        </button>
      </div>
    </form>
  </div>

</div>
@endsection

@push('scripts')
<script>
  function applyPlatformPreset(val) {
    if (!val) return;
    const [name, icon] = val.split('|');
    document.getElementById('input-platform').value = name;
    document.getElementById('input-icon').value = icon;
    updateIconLivePreview(icon);
  }

  function updateIconLivePreview(iconClass) {
    const preview = document.getElementById('icon-live-preview');
    if (!preview) return;
    preview.className = iconClass ? `${iconClass} text-emerald-700` : 'fa-solid fa-icons text-gray-400';
  }

  // Initial check if old icon present
  document.addEventListener('DOMContentLoaded', () => {
    const curIcon = document.getElementById('input-icon')?.value;
    if (curIcon) updateIconLivePreview(curIcon);
  });
</script>
@endpush

