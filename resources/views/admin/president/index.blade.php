@extends('layouts.admin.admin-layout')

@section('title', 'সভাপতির বাণী কাস্টমাইজেশন | আগামী শৈলকুপা')

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
        <span class="text-[#0b4622] font-semibold">সভাপতির বাণী</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-800 tracking-tight flex items-center gap-2">
        <i class="ri-user-voice-line text-[#0b4622]"></i>
        <span>সভাপতির বাণী (President's Message)</span>
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-0.5">হোমপেজের সভাপতির বাণী কার্ডের টেক্সট, নাম, পদবী, ছবি ও বিস্তারিত বক্তব্য সম্পাদনা করুন।</p>
    </div>

    <div>
      <a
        href="{{ route('home') }}#president-section"
        target="_blank"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition cursor-pointer"
      >
        <i class="ri-external-link-line"></i>
        <span>হোমপেজে প্রিভিউ দেখুন</span>
      </a>
    </div>
  </div>

  <!-- Success Notification Alert -->
  @if(session('success'))
    <div id="flash-alert" class="flex items-center justify-between p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-xs font-semibold animate-fade-in">
      <div class="flex items-center gap-2.5">
        <i class="ri-checkbox-circle-fill text-emerald-600 text-lg"></i>
        <span>{{ session('success') }}</span>
      </div>
      <button type="button" onclick="document.getElementById('flash-alert').remove()" class="text-emerald-600 hover:text-emerald-800 cursor-pointer">
        <i class="ri-close-line text-base"></i>
      </button>
    </div>
  @endif

  <!-- Form Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <span class="w-9 h-9 rounded-xl bg-[#0b4622]/10 text-[#0b4622] flex items-center justify-center font-bold text-lg">
          <i class="ri-user-star-line"></i>
        </span>
        <div>
          <h2 class="text-sm font-bold text-gray-800">সভাপতির তথ্য ও বাণীর বিবরণ</h2>
          <p class="text-xs text-gray-500">হোমপেজে দৃশ্যমান বাণী ও বিস্তারিত পেজের তথ্য হালনাগাদ করুন</p>
        </div>
      </div>
    </div>

    <form id="president-form" action="{{ route('admin.customization.president.update') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left 2 Cols: Title, Name, Designation & Message -->
        <div class="lg:col-span-2 space-y-5">
          <!-- Title & Name -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Section Title -->
            <div>
              <label for="title" class="block text-xs font-bold text-gray-700 mb-1.5">
                কার্ডের শিরোনাম (Title) <span class="text-[#c8102e]">*</span>
              </label>
              <input
                type="text"
                id="title"
                name="title"
                value="{{ old('title', $president->title) }}"
                placeholder="সভাপতির বাণী"
                class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('title') border-[#c8102e] bg-red-50/20 @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition"
                required
              >
              @error('title')
                <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
              @enderror
            </div>

            <!-- President Name -->
            <div>
              <label for="name" class="block text-xs font-bold text-gray-700 mb-1.5">
                সভাপতির নাম (Full Name) <span class="text-[#c8102e]">*</span>
              </label>
              <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $president->name) }}"
                placeholder="মোঃ আব্দুল করিম"
                class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('name') border-[#c8102e] bg-red-50/20 @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition"
                required
              >
              @error('name')
                <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Designation -->
          <div>
            <label for="designation" class="block text-xs font-bold text-gray-700 mb-1.5">
              পদবী ও পরিচয় (Designation) <span class="text-[#c8102e]">*</span>
            </label>
            <input
              type="text"
              id="designation"
              name="designation"
              value="{{ old('designation', $president->designation) }}"
              placeholder="সভাপতি, আগামীর শৈলকুপা"
              class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('designation') border-[#c8102e] @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
              required
            >
            @error('designation')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Quote (Card text) -->
          <div>
            <label for="quote" class="block text-xs font-bold text-gray-700 mb-1.5">
              মূল বাণী বা উদ্ধৃতি (Homepage Quote) <span class="text-[#c8102e]">*</span>
            </label>
            <textarea
              id="quote"
              name="quote"
              rows="3"
              placeholder="শৈলকুপাকে একটি আধুনিক, শিক্ষিত, সমৃদ্ধ ও মানবিক জনপদে রূপ দিতে আমরা সবাই একসাথে কাজ করছি।"
              class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('quote') border-[#c8102e] bg-red-50/20 @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition"
              required
            >{{ old('quote', $president->quote) }}</textarea>
            <p class="text-[11px] text-gray-400 mt-1">এটি হোমপেজের লাল কোটেশন মার্কের ভেতরের মূল উদ্ধৃতি হিসেবে প্রদর্শিত হবে।</p>
            @error('quote')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Rich Text Quill.js Editor (Full detailed message) -->
          <div>
            <div class="flex items-center justify-between mb-1.5">
              <label class="block text-xs font-bold text-gray-700">
                বিস্তারিত বার্তা (Quill.js Rich Text Editor)
              </label>
              <span class="text-[11px] text-gray-400">বিস্তারিত বক্তব্যের জন্য</span>
            </div>

            <!-- Quill Editor Container -->
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-2xs">
              <div id="quill-president-editor" style="min-height: 160px; font-size: 14px;">{!! old('message', $president->message) !!}</div>
            </div>

            <input type="hidden" name="message" id="hidden_message" value="{{ old('message', $president->message) }}">

            @error('message')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <!-- Right Col: President Circular Photo -->
        <div class="space-y-5">
          <!-- Image Upload & Preview -->
          <div class="bg-gray-50/70 border border-gray-100 rounded-xl p-5 space-y-4 text-center">
            <label class="block text-xs font-bold text-gray-700">
              সভাপতির ছবি (Portrait Photo) <span class="text-xs font-normal text-gray-400">(অনূর্ধ্ব 4MB)</span>
            </label>

            <!-- Circular Preview box -->
            <div class="relative w-36 h-36 mx-auto rounded-full border-4 border-white shadow-md overflow-hidden bg-gray-100 group">
              <img
                id="president-image-preview"
                src="{{ $president->image_url }}"
                alt="{{ $president->name }}"
                onerror="this.src='https://placehold.co/400x400/0b4622/ffffff?text=President'"
                class="w-full h-full object-cover transition duration-300 group-hover:scale-105"
              >
              <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                <span class="text-white text-[11px] font-semibold px-2.5 py-1 rounded-md bg-black/60 pointer-events-none">
                  <i class="ri-camera-lens-line"></i> পরিবর্তন
                </span>
              </div>
              <input
                type="file"
                id="president-image-input"
                name="image"
                accept="image/*"
                class="absolute inset-0 opacity-0 cursor-pointer w-full h-full z-10"
                onchange="previewPresidentImage(event)"
              >
            </div>

            <p class="text-[11px] text-gray-500 leading-relaxed">
              সুপারিশকৃত ফরম্যাট: স্কয়ার (1:1 রেশিও) যেমন: 400x400 পিক্সেল।
            </p>

            @error('image')
              <p class="mt-1 text-xs text-[#c8102e] flex items-center justify-center gap-1 font-medium">
                <i class="ri-error-warning-line"></i> {{ $message }}
              </p>
            @enderror
          </div>
        </div>
      </div>

      <!-- Action buttons -->
      <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
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
let quillPresident;

function syncPresidentEditor() {
  const hiddenInput = document.getElementById('hidden_message');
  if (quillPresident && hiddenInput) {
    hiddenInput.value = quillPresident.root.innerHTML;
  }
}

document.addEventListener('DOMContentLoaded', function () {
  quillPresident = new Quill('#quill-president-editor', {
    theme: 'snow',
    placeholder: 'সভাপতির বিস্তারিত বার্তা এখানে লিখুন...',
    modules: {
      toolbar: [
        [{ header: [1, 2, 3, false] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ color: [] }, { background: [] }],
        [{ list: 'ordered' }, { list: 'bullet' }],
        ['link', 'clean']
      ]
    }
  });

  // Sync on every text change in editor
  quillPresident.on('text-change', function() {
    syncPresidentEditor();
  });

  const form = document.getElementById('president-form');
  if (form) {
    form.addEventListener('submit', function () {
      syncPresidentEditor();
    });
  }
});

function previewPresidentImage(event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('president-image-preview').src = e.target.result;
    }
    reader.readAsDataURL(file);
  }
}
</script>
@endsection

