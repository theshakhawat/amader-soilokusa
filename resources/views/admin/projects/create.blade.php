@extends('layouts.admin.admin-layout')

@section('title', 'নতুন উন্নয়ন প্রকল্প যোগ করুন | আগামীর শৈলকুপা')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

  <!-- Top bar -->
  <div class="flex items-center justify-between">
    <div>
      <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line"></i>
        <a href="{{ route('admin.projects.index') }}" class="hover:text-[#0b4622]">উন্নয়ন প্রকল্প</a>
        <i class="ri-arrow-right-s-line"></i>
        <span class="text-[#0b4622] font-semibold">নতুন প্রকল্প</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
        <i class="ri-add-circle-line text-[#0b4622]"></i>
        <span>নতুন উন্নয়ন প্রকল্প যোগ করুন</span>
      </h1>
      <p class="text-xs text-gray-500 mt-0.5">
        প্রকল্পের শিরোনাম, পর্যায় (চলমান/সম্পন্ন), কভার ছবি, স্লাইডার ছবি এবং বিস্তারিত বিবরণ যুক্ত করুন।
      </p>
    </div>

    <a
      href="{{ route('admin.projects.index') }}"
      class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition"
    >
      <i class="ri-arrow-left-line"></i>
      <span>তালিকায় ফিরুন</span>
    </a>
  </div>

  <!-- Form Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-2xs p-6 sm:p-8">
    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
      @csrf

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Left 2 Cols: Title, Status & Rich Text Description -->
        <div class="md:col-span-2 space-y-5">
          
          <!-- Title -->
          <div>
            <label for="title" class="block text-xs font-bold text-gray-700 mb-1.5">
              প্রকল্পের শিরোনাম (Title) <span class="text-[#c8102e]">*</span>
            </label>
            <input
              type="text"
              id="title"
              name="title"
              value="{{ old('title') }}"
              placeholder="উদাঃ গ্রামীণ সড়ক সংস্কার ও কালভার্ট নির্মাণ প্রকল্প"
              class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('title') border-[#c8102e] bg-red-50/20 @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition"
              required
            >
            @error('title')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Project Status (Running, Completed, Upcoming) -->
          <div>
            <label class="block text-xs font-bold text-gray-700 mb-2">
              প্রকল্প পর্যায় (Project Status) <span class="text-[#c8102e]">*</span>
            </label>
            <div class="grid grid-cols-3 gap-3">
              <label class="flex items-center gap-2.5 p-3 rounded-xl border-2 cursor-pointer transition has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/40">
                <input type="radio" name="project_status" value="running" checked class="text-emerald-600 focus:ring-emerald-600">
                <span class="text-xs font-bold text-gray-800">চলমান প্রকল্প</span>
              </label>

              <label class="flex items-center gap-2.5 p-3 rounded-xl border-2 cursor-pointer transition has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50/40">
                <input type="radio" name="project_status" value="completed" {{ old('project_status') === 'completed' ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-600">
                <span class="text-xs font-bold text-gray-800">সম্পন্ন প্রকল্প</span>
              </label>

              <label class="flex items-center gap-2.5 p-3 rounded-xl border-2 cursor-pointer transition has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50/40">
                <input type="radio" name="project_status" value="upcoming" {{ old('project_status') === 'upcoming' ? 'checked' : '' }} class="text-amber-500 focus:ring-amber-500">
                <span class="text-xs font-bold text-gray-800">আসন্ন প্রকল্প</span>
              </label>
            </div>
            @error('project_status')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Quill Rich Text Editor Description -->
          <div>
            <label class="block text-xs font-bold text-gray-700 mb-1.5">
              প্রকল্পের বিস্তারিত বিবরণ (Description)
            </label>
            <div id="quill-editor" class="bg-white rounded-b-xl min-h-[220px]"></div>
            <input type="hidden" name="description" id="hidden-description" value="{{ old('description') }}">
            @error('description')
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
              প্রকল্পের একাধিক ছবি (স্লাইডার গ্যালারি)
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
        <a
          href="{{ route('admin.projects.index') }}"
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
    placeholder: 'প্রকল্পের সম্পূর্ণ পটভূমি, উদ্দেশ্য, কাজের পরিধি ও সুবিধা লিখুন...',
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

  const hiddenInput = document.getElementById('hidden-description');
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

