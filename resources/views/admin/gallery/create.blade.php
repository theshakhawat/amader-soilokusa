@extends('layouts.admin.admin-layout')

@section('title', 'নতুন ছবি বা ভিডিও যুক্ত করুন | আগামী শৈলকুপা')

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
        <span class="text-[#0b4622] font-semibold">নতুন মিডিয়া</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-800 tracking-tight flex items-center gap-2">
        <i class="ri-add-circle-fill text-[#0b4622]"></i>
        <span>নতুন ছবি বা ভিডিও যুক্ত করুন</span>
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-0.5">গ্যালারির টাইপ (ফটো বা ভিডিও), শিরোনাম এবং ফাইল/ইউআরএল যুক্ত করুন।</p>
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
          <i class="ri-image-add-line"></i>
        </span>
        <div>
          <h2 class="text-sm font-bold text-gray-800">মিডিয়া তথ্য</h2>
          <p class="text-xs text-gray-500">টাইপ নির্বাচন করে ফাইল বা ভিডিও লিংক প্রদান করুন</p>
        </div>
      </div>
    </div>

    <form
      action="{{ route('admin.gallery.store') }}"
      method="POST"
      enctype="multipart/form-data"
      class="p-6 sm:p-8 space-y-6"
    >
      @csrf

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
                  checked
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
              value="{{ old('title') }}"
              placeholder="উদাঃ বার্ষিক সাধারণ সভা ও স্বেচ্ছাসেবী মিলনমেলা"
              class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('title') border-[#c8102e] bg-red-50/20 @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition"
              required
            >
            @error('title')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Photo Upload Field (Shown when photo selected) -->
          <div id="photo-upload-group" class="space-y-2">
            <label class="block text-xs font-bold text-gray-700">
              ছবি আপলোড (Photo File) <span class="text-xs font-normal text-gray-400">(অনূর্ধ্ব 20MB)</span>
            </label>
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

          <!-- Video Options Group (Shown when video selected) -->
          <div id="video-options-group" class="hidden space-y-4">
            <!-- Source Selector: URL vs Direct Upload -->
            <div>
              <label class="block text-xs font-bold text-gray-700 mb-2">
                ভিডিও মাধ্যম (Video Source) <span class="text-[#c8102e]">*</span>
              </label>
              <div class="grid grid-cols-2 gap-3">
                <label class="flex items-center gap-2.5 p-3 rounded-xl border cursor-pointer transition has-[:checked]:border-purple-600 has-[:checked]:bg-purple-50/50">
                  <input
                    type="radio"
                    name="video_source_type"
                    value="url"
                    checked
                    onchange="toggleVideoSource('url')"
                    class="text-purple-600 focus:ring-purple-600"
                  >
                  <div class="flex items-center gap-1.5 text-xs font-bold text-gray-800">
                    <i class="ri-youtube-line text-base text-[#c8102e]"></i>
                    <span>ইউটিউব লিংক (URL)</span>
                  </div>
                </label>

                <label class="flex items-center gap-2.5 p-3 rounded-xl border cursor-pointer transition has-[:checked]:border-purple-600 has-[:checked]:bg-purple-50/50">
                  <input
                    type="radio"
                    name="video_source_type"
                    value="upload"
                    onchange="toggleVideoSource('upload')"
                    class="text-purple-600 focus:ring-purple-600"
                  >
                  <div class="flex items-center gap-1.5 text-xs font-bold text-gray-800">
                    <i class="ri-upload-cloud-2-line text-base text-[#0b4622]"></i>
                    <span>কাস্টম ভিডিও আপলোড</span>
                  </div>
                </label>
              </div>
            </div>

            <!-- 1. Video URL Input -->
            <div id="video-url-subgroup" class="space-y-1.5">
              <label for="video_url" class="block text-xs font-bold text-gray-700">
                ইউটিউব / ভিডিও লিংক (Video URL)
              </label>
              <input
                type="url"
                id="video_url"
                name="video_url"
                value="{{ old('video_url') }}"
                placeholder="https://www.youtube.com/watch?v=... বা https://youtu.be/..."
                class="w-full px-4 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
              >
              <p class="text-[11px] text-gray-400">ইউটিউব লিংক দিলে থাম্বনেইল স্বয়ংক্রিয়ভাবে জেনারেট হবে।</p>
              @error('video_url')
                <p class="text-xs text-[#c8102e] font-medium">{{ $message }}</p>
              @enderror
            </div>

            <!-- 2. Video Direct File Upload -->
            <div id="video-file-subgroup" class="hidden space-y-1.5">
              <label for="video_file" class="block text-xs font-bold text-gray-700">
                ভিডিও ফাইল নির্বাচন করুন (MP4, WebM, MOV) <span class="text-xs font-normal text-gray-400">(সর্বোচ্চ 100MB)</span>
              </label>
              <input
                type="file"
                id="video_file"
                name="video_file"
                accept="video/mp4,video/webm,video/ogg,video/quicktime"
                class="w-full text-xs text-gray-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 cursor-pointer"
              >
              <p class="text-[11px] text-gray-400">আপনার কম্পিউটার থেকে সরাসরি যেকোনো ভিডিও ফাইল আপলোড করুন।</p>
              @error('video_file')
                <p class="text-xs text-[#c8102e] font-medium">{{ $message }}</p>
              @enderror
            </div>
          </div>
        </div>

        <!-- Right Col: Thumbnail & Order -->
        <div class="space-y-5">
          <!-- Optional Thumbnail (For Video or Custom Cover) -->
          <div id="custom-thumb-group" class="bg-gray-50/70 border border-gray-100 rounded-xl p-4 space-y-3">
            <label class="block text-xs font-bold text-gray-700">
              কাস্টম থাম্বনেইল (ঐচ্ছিক)
            </label>
            <input
              type="file"
              name="thumbnail"
              accept="image/*"
              class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-gray-200 cursor-pointer"
            >
            <p class="text-[11px] text-gray-400 leading-relaxed">
              ভিডিওর জন্য আলাদা কোনো কভার ছবি ব্যবহার করতে চাইলে আপলোড করুন।
            </p>
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
              value="{{ old('order_index', 0) }}"
              class="w-full px-3.5 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
            >
            <p class="text-[11px] text-gray-400 mt-1">ছোট সংখ্যা আগে প্রদর্শিত হবে।</p>
          </div>

          <!-- Status Toggle -->
          <div class="flex items-center justify-between p-3.5 bg-gray-50 border border-gray-200 rounded-xl">
            <span class="text-xs font-bold text-gray-700">সক্রিয় স্ট্যাটাস</span>
            <label class="relative inline-flex items-center cursor-pointer">
              <input type="checkbox" name="status" value="1" class="sr-only peer" checked>
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
          <span>সংরক্ষণ করুন</span>
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function toggleMediaFields(type) {
  const photoGroup = document.getElementById('photo-upload-group');
  const videoGroup = document.getElementById('video-options-group');

  if (type === 'photo') {
    photoGroup.classList.remove('hidden');
    videoGroup.classList.add('hidden');
  } else {
    photoGroup.classList.add('hidden');
    videoGroup.classList.remove('hidden');
  }
}

function toggleVideoSource(source) {
  const urlSubgroup = document.getElementById('video-url-subgroup');
  const fileSubgroup = document.getElementById('video-file-subgroup');

  if (source === 'url') {
    urlSubgroup.classList.remove('hidden');
    fileSubgroup.classList.add('hidden');
  } else {
    urlSubgroup.classList.add('hidden');
    fileSubgroup.classList.remove('hidden');
  }
}
</script>
@endsection

