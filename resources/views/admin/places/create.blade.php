@extends('layouts.admin.admin-layout')

@section('title', 'নতুন দর্শনীয় স্থান যোগ করুন | আগামীর শৈলকুপা')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

  <!-- Top bar -->
  <div class="flex items-center justify-between">
    <div>
      <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line"></i>
        <a href="{{ route('admin.places.index') }}" class="hover:text-[#0b4622]">দর্শনীয় স্থান</a>
        <i class="ri-arrow-right-s-line"></i>
        <span class="text-[#0b4622] font-semibold">নতুন স্থান</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
        <i class="ri-add-circle-line text-[#0b4622]"></i>
        <span>নতুন দর্শনীয় স্থান যোগ করুন</span>
      </h1>
      <p class="text-xs text-gray-500 mt-0.5">
        স্থানের শিরোনাম, অবস্থান, কভার ছবি, স্লাইডার ছবি এবং বিস্তারিত বিবরণ যুক্ত করুন।
      </p>
    </div>

    <a
      href="{{ route('admin.places.index') }}"
      class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition"
    >
      <i class="ri-arrow-left-line"></i>
      <span>তালিকায় ফিরুন</span>
    </a>
  </div>

  <!-- Form Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-2xs p-6 sm:p-8">
    <form action="{{ route('admin.places.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
      @csrf

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Left 2 Cols: Title, Subtitle, Location, Description -->
        <div class="md:col-span-2 space-y-5">

          <!-- Title -->
          <div>
            <label for="title" class="block text-xs font-bold text-gray-700 mb-1.5">
              স্থানের শিরোনাম (Title) <span class="text-[#c8102e]">*</span>
            </label>
            <input
              type="text"
              id="title"
              name="title"
              value="{{ old('title') }}"
              placeholder="উদাঃ শৈলকুপা নদী তীর"
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
              উপশিরোনাম (Subtitle)
            </label>
            <input
              type="text"
              id="subtitle"
              name="subtitle"
              value="{{ old('subtitle') }}"
              placeholder="উদাঃ প্রাকৃতিক সৌন্দর্যের আধার"
              class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition"
            >
          </div>

          <!-- Location -->
          <div>
            <label for="location" class="block text-xs font-bold text-gray-700 mb-1.5">
              অবস্থান (Location)
            </label>
            <input
              type="text"
              id="location"
              name="location"
              value="{{ old('location') }}"
              placeholder="উদাঃ শৈলকুপা উপজেলা, ঝিনাইদহ"
              class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition"
            >
          </div>

          <!-- Quill Rich Text Editor Descriptions -->
          <div>
            <label class="block text-xs font-bold text-gray-700 mb-1.5">
              স্থানের বিস্তারিত বিবরণ (Descriptions)
            </label>
            <div id="quill-editor" class="bg-white rounded-b-xl min-h-[220px]"></div>
            <input type="hidden" name="descriptions" id="hidden-descriptions" value="{{ old('descriptions') }}">
            @error('descriptions')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>

        </div>

        <!-- Right Col: Thumbnail, Slider Images & Settings -->
        <div class="space-y-5">

          <!-- Thumbnail Upload -->
          <div class="bg-gray-50/70 border border-gray-100 rounded-xl p-4 space-y-3">
            <label class="block text-xs font-bold text-gray-700">
              মূল থাম্বনেইল / কভার ছবি <span class="text-[#c8102e]">*</span>
            </label>
            <input
              type="file"
              name="thumbnail"
              id="thumbnail-input"
              accept="image/*"
              class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#0b4622]/10 file:text-[#0b4622] hover:file:bg-[#0b4622]/20 cursor-pointer"
              required
            >
            <p class="text-[11px] text-gray-400">কার্ডে ও স্লাইডারের প্রধান ছবি হিসেবে প্রদর্শিত হবে।</p>
            @error('thumbnail')
              <p class="text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Multiple Photos for Carousel Slide -->
          <div class="bg-gray-50/70 border border-gray-100 rounded-xl p-4 space-y-3">
            <label class="block text-xs font-bold text-gray-700">
              স্থানের একাধিক ছবি (স্লাইডার গ্যালারি)
            </label>
            <input
              type="file"
              name="photos[]"
              multiple
              accept="image/*"
              class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#0b4622]/10 file:text-[#0b4622] hover:file:bg-[#0b4622]/20 cursor-pointer"
            >
            <p class="text-[11px] text-gray-400 leading-relaxed">
              একসাথে একাধিক ছবি সিলেক্ট করতে পারেন। এগুলো বিস্তারিত পেজে স্লাইড আকারে শো করবে।
            </p>
            @error('photos.*')
              <p class="text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
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

          <!-- Active Status Toggle -->
          <div class="flex items-center justify-between p-3.5 bg-gray-50 border border-gray-200 rounded-xl">
            <span class="text-xs font-bold text-gray-700">সক্রিয় স্ট্যাটাস</span>
            <label class="relative inline-flex items-center cursor-pointer">
              <input type="checkbox" name="status" value="1" class="sr-only peer" checked>
              <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0b4622]"></div>
            </label>
          </div>

        </div>

      </div>

      <!-- Submit button -->
      <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
        <a
          href="{{ route('admin.places.index') }}"
          class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition"
        >
          বাতিল
        </a>
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

<!-- Quill.js Editor Setup -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const quill = new Quill('#quill-editor', {
    theme: 'snow',
    placeholder: 'এই দর্শনীয় স্থানের ইতিহাস, সৌন্দর্য, কিভাবে যাবেন ইত্যাদি বিস্তারিত লিখুন...',
    modules: {
      toolbar: [
        [{ 'header': [1, 2, 3, false] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        ['blockquote', 'link'],
        ['clean']
      ]
    }
  });

  const hiddenInput = document.getElementById('hidden-descriptions');
  if (hiddenInput.value) {
    quill.root.innerHTML = hiddenInput.value;
  }

  // Sync content before form submission
  const form = hiddenInput.closest('form');
  form.addEventListener('submit', function() {
    hiddenInput.value = quill.root.innerHTML;
  });
});
</script>
@endsection

