@extends('layouts.admin.admin-layout')

@section('title', 'গ্যালারি সম্পাদনা — ' . $gallery->title . ' | আগামী শৈলকুপা')

@section('content')
<div class="space-y-6">
  <!-- Top Bar -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
    <div>
      <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622] transition">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <a href="{{ route('admin.gallery.index') }}" class="hover:text-[#0b4622] transition">গ্যালারি</a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <span class="text-[#0b4622] font-semibold">সম্পাদনা</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-800 tracking-tight flex items-center gap-2">
        <i class="ri-edit-2-line text-[#0b4622]"></i>
        <span>গ্যালারি সম্পাদনা: {{ $gallery->title }}</span>
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-0.5">মিডিয়া টাইপ, শিরোনাম, ফাইল বা ভিডিও লিংক হালনাগাদ করুন।</p>
    </div>

    <div>
      <a
        href="{{ route('admin.gallery.index') }}"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition cursor-pointer"
      >
        <i class="ri-arrow-left-line"></i>
        <span>তালিকায় ফিরুন</span>
      </a>
    </div>
  </div>

  <!-- Form Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <span class="w-9 h-9 rounded-xl bg-[#0b4622]/10 text-[#0b4622] flex items-center justify-center font-bold text-lg">
          <i class="ri-edit-box-line"></i>
        </span>
        <div>
          <h2 class="text-sm font-bold text-gray-800">তথ্য হালনাগাদ</h2>
          <p class="text-xs text-gray-500">আইডি: #{{ $gallery->id }}</p>
        </div>
      </div>
    </div>

    <form
      action="{{ route('admin.gallery.update', $gallery->id) }}"
      method="POST"
      enctype="multipart/form-data"
      class="p-6 sm:p-8 space-y-6"
    >
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left 2 Cols: Main Info -->
        <div class="lg:col-span-2 space-y-5">
          <!-- Type Selection Radio -->
          <div>
            <label class="block text-xs font-bold text-gray-700 mb-2">
              মিডিয়া টাইপ (Type) <span class="text-[#c8102e]">*</span>
            </label>
            <div class="grid grid-cols-2 gap-4">
              <label class="flex items-center gap-3 p-3.5 rounded-xl border-2 cursor-pointer transition has-[:checked]:border-[#0b4622] has-[:checked]:bg-[#0b4622]/5">
                <input
                  type="radio"
                  name="type"
                  value="photo"
                  {{ old('type', $gallery->type) === 'photo' ? 'checked' : '' }}
                  onchange="toggleMediaFields('photo')"
                  class="text-[#0b4622] focus:ring-[#0b4622]"
                >
                <div class="flex items-center gap-2 text-xs font-bold text-gray-800">
                  <i class="ri-image-line text-lg text-[#0b4622]"></i>
                  <span>ফটো গ্যালারি (Photo)</span>
                </div>
              </label>

              <label class="flex items-center gap-3 p-3.5 rounded-xl border-2 cursor-pointer transition has-[:checked]:border-[#0b4622] has-[:checked]:bg-[#0b4622]/5">
                <input
                  type="radio"
                  name="type"
                  value="video"
                  {{ old('type', $gallery->type) === 'video' ? 'checked' : '' }}
                  onchange="toggleMediaFields('video')"
                  class="text-[#0b4622] focus:ring-[#0b4622]"
                >
                <div class="flex items-center gap-2 text-xs font-bold text-gray-800">
                  <i class="ri-video-line text-lg text-purple-600"></i>
                  <span>ভিডিও গ্যালারি (Video)</span>
                </div>
              </label>
            </div>
            @error('type')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Title -->
          <div>
            <label for="title" class="block text-xs font-bold text-gray-700 mb-1.5">
              মিডিয়া শিরোনাম (Title) <span class="text-[#c8102e]">*</span>
            </label>
            <input
              type="text"
              id="title"
              name="title"
              value="{{ old('title', $gallery->title) }}"
              placeholder="উদাঃ বৃক্ষরোপণ কর্মসূচি"
              class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('title') border-[#c8102e] bg-red-50/20 @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition"
              required
            >
            @error('title')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Subtitle / Short Description -->
          <div>
            <div class="flex items-center justify-between mb-1.5">
              <label for="subtitle" class="block text-xs font-bold text-gray-700">
                সাব-টাইটেল বা বিবরণ (Subtitle) <span class="text-xs font-normal text-gray-400">(ঐচ্ছিক)</span>
              </label>
              <span id="subtitle-char-count" class="text-[11px] text-gray-400 font-mono">{{ mb_strlen($gallery->subtitle ?? '') }} / ২০০০ অক্ষর</span>
            </div>
            <textarea
              id="subtitle"
              name="subtitle"
              rows="3"
              maxlength="2000"
              oninput="document.getElementById('subtitle-char-count').innerText = this.value.length + ' / ২০০০ অক্ষর'"
              placeholder="উদাঃ কুলাঘাট ইউনিয়নে ১০০০টি বৃক্ষরোপণ কর্মসূচি।"
              class="w-full px-4 py-2.5 text-xs sm:text-sm bg-gray-50 border @error('subtitle') border-[#c8102e] @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
            >{{ old('subtitle', $gallery->subtitle) }}</textarea>
            @error('subtitle')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Hyperlink URL & Event Date Row -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Action / Hyperlink URL -->
            <div>
              <label for="link_url" class="block text-xs font-bold text-gray-700 mb-1.5">
                ক্লিক করলে যে লিংকে যাবে (Hyperlink URL) <span class="text-xs font-normal text-gray-400">(ঐচ্ছিক)</span>
              </label>
              <input
                type="text"
                id="link_url"
                name="link_url"
                value="{{ old('link_url', $gallery->link_url) }}"
                placeholder="উদাঃ https://... অথবা /events/1"
                class="w-full px-4 py-2.5 text-xs bg-gray-50 border @error('link_url') border-[#c8102e] @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
              >
              <p class="text-[10px] text-gray-400 mt-1">লিংক দেওয়া থাকলে কার্ডে ক্লিক করলে সরাসরি ওই পেজে নিয়ে যাবে।</p>
              @error('link_url')
                <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
              @enderror
            </div>

            <!-- Event Date -->
            <div>
              <label for="event_date" class="block text-xs font-bold text-gray-700 mb-1.5">
                তারিখ (Event Date) <span class="text-xs font-normal text-gray-400">(ঐচ্ছিক)</span>
              </label>
              <input
                type="date"
                id="event_date"
                name="event_date"
                value="{{ old('event_date', $gallery->event_date ? $gallery->event_date->format('Y-m-d') : '') }}"
                class="w-full px-4 py-2.5 text-xs bg-gray-50 border @error('event_date') border-[#c8102e] @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
              >
              @error('event_date')
                <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Photo Upload Field -->
          <div id="photo-upload-group" class="{{ $gallery->type === 'photo' ? '' : 'hidden' }} space-y-2">
            <label class="block text-xs font-bold text-gray-700">
              ছবি পরিবর্তন করুন (Photo File)
            </label>
            @if($gallery->type === 'photo' && $gallery->file_path)
              <div class="w-32 h-24 rounded-xl overflow-hidden border border-gray-200 mb-2">
                <img src="{{ $gallery->image_url }}" class="w-full h-full object-cover">
              </div>
            @endif
            <input
              type="file"
              name="file"
              id="photo-file-input"
              accept="image/*"
              class="w-full text-xs text-gray-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0b4622]/10 file:text-[#0b4622] hover:file:bg-[#0b4622]/20 cursor-pointer"
            >
            @error('file')
              <p class="text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Video Options Group (Shown when video selected - Only YouTube URL) -->
          <div id="video-options-group" class="{{ $gallery->type === 'video' ? '' : 'hidden' }} space-y-4">
            <!-- Video URL Field -->
            <div id="video-url-subgroup" class="space-y-1.5">
              <label for="video_url" class="block text-xs font-bold text-gray-700">
                ইউটিউব ভিডিও লিংক (YouTube URL) <span class="text-[#c8102e]">*</span>
              </label>
              <div class="relative">
                <input
                  type="url"
                  id="video_url"
                  name="video_url"
                  value="{{ old('video_url', $gallery->video_url) }}"
                  placeholder="https://www.youtube.com/watch?v=... বা https://youtu.be/..."
                  class="w-full pl-10 pr-4 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
                >
                <i class="ri-youtube-line absolute left-3.5 top-2.5 text-[#c8102e] text-base"></i>
              </div>
              <p class="text-[11px] text-gray-500">ইউটিউব ভিডিওর সম্পূর্ণ লিংক বা শর্ট লিংক দিন। ইউটিউবের কভার ছবি স্বয়ংক্রিয়ভাবে থাম্বনেইল হিসেবে সেট হবে (অথবা আপনি চাইলে ডানে কাস্টম থাম্বনেইল যুক্ত করতে পারেন)।</p>
              @error('video_url')
                <p class="text-xs text-[#c8102e] font-medium">{{ $message }}</p>
              @enderror
            </div>
          </div>
        </div>

        <!-- Right Col: Thumbnail & Order -->
        <div class="space-y-5">
          <!-- Optional Thumbnail -->
          <div id="custom-thumb-group" class="bg-gray-50/70 border border-gray-100 rounded-xl p-4 space-y-3">
            <label class="block text-xs font-bold text-gray-700">
              কাস্টম থাম্বনেইল পরিবর্তন (ঐচ্ছিক)
            </label>
            @if($gallery->thumbnail)
              <div class="w-32 h-20 rounded-xl overflow-hidden border border-gray-200 mb-2">
                <img src="{{ $gallery->video_thumbnail }}" class="w-full h-full object-cover">
              </div>
            @endif
            <input
              type="file"
              name="thumbnail"
              accept="image/*"
              class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-gray-200 cursor-pointer"
            >
          </div>

          <!-- Order Index -->
          <div>
            <label for="order_index" class="block text-xs font-bold text-gray-700 mb-1.5">
              ডিসপ্লে ক্রম (Order Index)
            </label>
            <input
              type="number"
              id="order_index"
              name="order_index"
              value="{{ old('order_index', $gallery->order_index) }}"
              class="w-full px-3.5 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
            >
          </div>

          <!-- Status Toggle -->
          <div class="flex items-center justify-between p-3.5 bg-gray-50 border border-gray-200 rounded-xl">
            <span class="text-xs font-bold text-gray-700">সক্রিয় স্ট্যাটাস</span>
            <label class="relative inline-flex items-center cursor-pointer">
              <input type="checkbox" name="status" value="1" class="sr-only peer" {{ $gallery->status ? 'checked' : '' }}>
              <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0b4622]"></div>
            </label>
          </div>
        </div>
      </div>

      <!-- Submit button -->
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
function toggleMediaFields(type) {
  const photoGroup = document.getElementById('photo-upload-group');
  const videoGroup = document.getElementById('video-options-group');
  const videoUrlInput = document.getElementById('video_url');

  if (type === 'photo') {
    photoGroup.classList.remove('hidden');
    videoGroup.classList.add('hidden');
    if (videoUrlInput) videoUrlInput.removeAttribute('required');
  } else {
    photoGroup.classList.add('hidden');
    videoGroup.classList.remove('hidden');
    if (videoUrlInput) videoUrlInput.setAttribute('required', 'required');
  }
}
</script>
@endsection

