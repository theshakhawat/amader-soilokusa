@extends('layouts.admin.admin-layout')

@section('title', 'আমাদের সম্পর্কে কাস্টমাইজেশন | আগামী শৈলকুপা')

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
        <span class="text-[#0b4622] font-semibold">আমাদের সম্পর্কে</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-800 tracking-tight flex items-center gap-2">
        <i class="ri-information-line text-[#0b4622]"></i>
        <span>আমাদের সম্পর্কে (About Us Section)</span>
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-0.5">হোমপেজের আমাদের সম্পর্কে সেকশন এবং বিস্তারিত পেজের কনটেন্ট পরিচালনা ও আপডেট করুন।</p>
    </div>

    <div>
      <a
        href="{{ route('about.us') }}"
        target="_blank"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition cursor-pointer"
      >
        <i class="ri-external-link-line"></i>
        <span>লাইভ পেজ দেখুন</span>
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
          <i class="ri-edit-2-line"></i>
        </span>
        <div>
          <h2 class="text-sm font-bold text-gray-800">কন্টেন্ট সম্পাদনা</h2>
          <p class="text-xs text-gray-500">হোমপেজ ও বিস্তারিত পেজের সকল টেক্সট, ছবি ও রিচ টেক্সট ফরম্যাটিং</p>
        </div>
      </div>
    </div>

    <form id="about-form" action="{{ route('admin.customization.about.update') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left 2 Cols: Main Content Fields -->
        <div class="lg:col-span-2 space-y-5">
          <!-- Title & Subtitle -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Title -->
            <div>
              <label for="title" class="block text-xs font-bold text-gray-700 mb-1.5">
                সেকশন শিরোনাম (Title) <span class="text-[#c8102e]">*</span>
              </label>
              <input
                type="text"
                id="title"
                name="title"
                value="{{ old('title', $about->title) }}"
                placeholder="আমাদের সম্পর্কে"
                class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('title') border-[#c8102e] bg-red-50/20 @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition"
                required
              >
              @error('title')
                <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
              @enderror
            </div>

            <!-- Subtitle -->
            <div>
              <label for="subtitle" class="block text-xs font-bold text-gray-700 mb-1.5">
                উপশিরোনাম (Subtitle / Tagline) <span class="text-xs font-normal text-gray-400">(ঐচ্ছিক)</span>
              </label>
              <input
                type="text"
                id="subtitle"
                name="subtitle"
                value="{{ old('subtitle', $about->subtitle) }}"
                placeholder="ঐতিহ্য, উন্নয়ন ও মানবিক শৈলকুপা"
                class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('subtitle') border-[#c8102e] @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
              >
              @error('subtitle')
                <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Short Description (Shown on Homepage Card) -->
          <div>
            <label for="short_description" class="block text-xs font-bold text-gray-700 mb-1.5">
              হোমপেজ সংক্ষিপ্ত বিবরণ (Short Description) <span class="text-[#c8102e]">*</span>
            </label>
            <textarea
              id="short_description"
              name="short_description"
              rows="3"
              placeholder="আগামীর শৈলকুপা একটি অরাজনৈতিক সামাজিক উদ্যোগ, যা শৈলকুপার সার্বিক উন্নয়ন..."
              class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('short_description') border-[#c8102e] bg-red-50/20 @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition"
              required
            >{{ old('short_description', $about->short_description) }}</textarea>
            <p class="text-[11px] text-gray-400 mt-1">এটি হোমপেজের মূল কার্ডে প্রদর্শিত হবে।</p>
            @error('short_description')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Rich Text Quill.js Editor (Full Detailed Description) -->
          <div>
            <div class="flex items-center justify-between mb-1.5">
              <label class="block text-xs font-bold text-gray-700">
                বিস্তারিত বিবরণ (Quill.js Rich Text Editor)
              </label>
              <span class="text-[11px] text-gray-400">বিস্তারিত পেজে (`/page/aboutus`) প্রদর্শিত হবে</span>
            </div>

            <!-- Quill Editor Container -->
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-2xs">
              <div id="quill-editor" style="min-height: 220px; font-size: 14px;">{!! old('description', $about->description) !!}</div>
            </div>

            <!-- Hidden Input to sync HTML on form submit -->
            <input type="hidden" name="description" id="hidden_description" value="{{ old('description', $about->description) }}">

            @error('description')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <!-- Right Col: Image & Button Settings -->
        <div class="space-y-5">
          <!-- Image Upload & Preview -->
          <div class="bg-gray-50/70 border border-gray-100 rounded-xl p-4 space-y-3">
            <label class="block text-xs font-bold text-gray-700">
              ফিচার ছবি (Feature Photo) <span class="text-xs font-normal text-gray-400">(অনূর্ধ্ব 4MB)</span>
            </label>

            <!-- Preview box -->
            <div class="relative w-full h-44 rounded-xl border-2 border-dashed border-gray-300 overflow-hidden bg-gray-100 flex items-center justify-center group">
              <img
                id="about-image-preview"
                src="{{ $about->image_url }}"
                alt="About Image Preview"
                onerror="this.src='https://placehold.co/800x600/0b4622/ffffff?text=About+Us'"
                class="w-full h-full object-cover transition duration-300 group-hover:scale-105"
              >
              <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                <span class="text-white text-xs font-semibold px-3 py-1.5 rounded-lg bg-black/60 backdrop-blur-xs flex items-center gap-1.5 pointer-events-none">
                  <i class="ri-camera-lens-line"></i> ছবি পরিবর্তন করুন
                </span>
              </div>
              <input
                type="file"
                id="about-image-input"
                name="image"
                accept="image/*"
                class="absolute inset-0 opacity-0 cursor-pointer w-full h-full z-10"
                onchange="previewAboutImage(event)"
              >
            </div>

            <p class="text-[11px] text-gray-500 leading-relaxed">
              হোমপেজের কার্ডে ও বিস্তারিত পেজের ব্যানারে এই ছবিটি প্রদর্শিত হবে।
            </p>

            @error('image')
              <p class="mt-1 text-xs text-[#c8102e] flex items-center gap-1 font-medium">
                <i class="ri-error-warning-line"></i> {{ $message }}
              </p>
            @enderror
          </div>

          <!-- Button Text -->
          <div>
            <label for="button_text" class="block text-xs font-bold text-gray-700 mb-1.5">
              হোমপেজ বাটন টেক্সট <span class="text-[#c8102e]">*</span>
            </label>
            <input
              type="text"
              id="button_text"
              name="button_text"
              value="{{ old('button_text', $about->button_text) }}"
              placeholder="বিস্তারিত পড়ুন"
              class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('button_text') border-[#c8102e] @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
              required
            >
            <p class="text-[11px] text-gray-400 mt-1">হোমপেজে এই বাটনে ক্লিক করলে ব্যবহারকারী `/page/aboutus` পেজে যাবে।</p>
            @error('button_text')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
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
let quillAbout;

function syncAboutEditor() {
  const hiddenInput = document.getElementById('hidden_description');
  if (quillAbout && hiddenInput) {
    hiddenInput.value = quillAbout.root.innerHTML;
  }
}

document.addEventListener('DOMContentLoaded', function () {
  quillAbout = new Quill('#quill-editor', {
    theme: 'snow',
    placeholder: 'বিস্তারিত বিবরণ এখানে লিখুন...',
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
  quillAbout.on('text-change', function() {
    syncAboutEditor();
  });

  const form = document.getElementById('about-form');
  if (form) {
    form.addEventListener('submit', function () {
      syncAboutEditor();
    });
  }
});

function previewAboutImage(event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('about-image-preview').src = e.target.result;
    }
    reader.readAsDataURL(file);
  }
}
</script>
@endsection

