@extends('layouts.admin.admin-layout')

@section('title', 'ব্লগ পোস্ট সম্পাদনা | আগামীর শৈলকুপা')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

  <!-- Top bar -->
  <div class="flex items-center justify-between">
    <div>
      <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line"></i>
        <a href="{{ route('admin.posts.index') }}" class="hover:text-[#0b4622]">ব্লগ ও আপডেট</a>
        <i class="ri-arrow-right-s-line"></i>
        <span class="text-[#0b4622] font-semibold">সম্পাদনা</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
        <i class="ri-edit-line text-[#0b4622]"></i>
        <span>ব্লগ পোস্ট সম্পাদনা করুন</span>
      </h1>
      <p class="text-xs text-gray-500 mt-0.5">
        পোস্টের বিষয়বস্তু, ক্যাটাগরি, থাম্বনেইল ও প্রকাশের তথ্য হালনাগাদ করুন।
      </p>
    </div>

    <a
      href="{{ route('admin.posts.index') }}"
      class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition"
    >
      <i class="ri-arrow-left-line"></i>
      <span>তালিকায় ফিরুন</span>
    </a>
  </div>

  <!-- Form Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-2xs p-6 sm:p-8">
    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Left 2 Cols: Category, Title, Slug & Quill Content -->
        <div class="md:col-span-2 space-y-5">

          <!-- Category -->
          <div>
            <div class="flex items-center justify-between mb-1.5">
              <label for="category_id" class="block text-xs font-bold text-gray-700">
                ক্যাটাগরি (Category) <span class="text-[#c8102e]">*</span>
              </label>
              <a href="{{ route('admin.categories.index') }}" target="_blank" class="text-[11px] font-bold text-[#0b4622] hover:underline flex items-center gap-0.5">
                <i class="ri-add-line"></i>
                <span>ক্যাটাগরি পরিচালনা</span>
              </a>
            </div>
            <select
              id="category_id"
              name="category_id"
              class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('category_id') border-[#c8102e] @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition cursor-pointer"
              required
            >
              <option value="">ক্যাটাগরি নির্বাচন করুন</option>
              @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                  {{ $category->name }}
                </option>
              @endforeach
            </select>
            @error('category_id')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Title -->
          <div>
            <label for="title" class="block text-xs font-bold text-gray-700 mb-1.5">
              ব্লগ পোস্টের শিরোনাম (Title) <span class="text-[#c8102e]">*</span>
            </label>
            <input
              type="text"
              id="title"
              name="title"
              value="{{ old('title', $post->title) }}"
              placeholder="উদাঃ শৈলকুপার সম্ভাবনা ও উন্নয়নের রূপকল্প"
              class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('title') border-[#c8102e] bg-red-50/20 @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition"
              required
            >
            @error('title')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Slug -->
          <div>
            <label for="slug" class="block text-xs font-bold text-gray-700 mb-1.5">
              কাস্টম স্লাগ (Slug)
            </label>
            <input
              type="text"
              id="slug"
              name="slug"
              value="{{ old('slug', $post->slug) }}"
              placeholder="উদাঃ shailkupa-development-vision"
              class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
            >
          </div>

          <!-- Quill Rich Text Editor Content -->
          <div>
            <label class="block text-xs font-bold text-gray-700 mb-1.5">
              ব্লগ বিস্তারিত বিবরণ (Content)
            </label>
            <div id="quill-editor" class="bg-white rounded-b-xl min-h-[260px]"></div>
            <input type="hidden" name="content" id="hidden-content" value="{{ old('content', $post->content) }}">
            @error('content')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>

        </div>

        <!-- Right Col: Thumbnail, Published Date & Status -->
        <div class="space-y-5">

          <!-- Thumbnail Upload -->
          <div class="bg-gray-50/70 border border-gray-100 rounded-xl p-4 space-y-3">
            <label class="block text-xs font-bold text-gray-700">
              থাম্বনেইল পরিবর্তন (ঐচ্ছিক)
            </label>
            @if($post->thumbnail)
              <div class="w-full aspect-[16/10] rounded-xl overflow-hidden border border-gray-200 mb-2">
                <img src="{{ $post->thumbnail_url }}" alt="thumb" class="w-full h-full object-cover">
              </div>
            @endif
            <input
              type="file"
              name="thumbnail"
              id="thumbnail-input"
              accept="image/*"
              class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#0b4622]/10 file:text-[#0b4622] hover:file:bg-[#0b4622]/20 cursor-pointer"
            >
            @error('thumbnail')
              <p class="text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Published Timestamp -->
          <div>
            <label for="published" class="block text-xs font-bold text-gray-700 mb-1.5">
              প্রকাশের সময়কাল (Published At)
            </label>
            <input
              type="datetime-local"
              id="published"
              name="published"
              value="{{ old('published', $post->published ? $post->published->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}"
              class="w-full px-3.5 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
            >
          </div>

          <!-- Active Status Toggle -->
          <div class="flex items-center justify-between p-3.5 bg-gray-50 border border-gray-200 rounded-xl">
            <span class="text-xs font-bold text-gray-700">সক্রিয় স্ট্যাটাস</span>
            <label class="relative inline-flex items-center cursor-pointer">
              <input type="checkbox" name="status" value="1" class="sr-only peer" {{ $post->status ? 'checked' : '' }}>
              <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0b4622]"></div>
            </label>
          </div>

        </div>

      </div>

      <!-- Submit button -->
      <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
        <a
          href="{{ route('admin.posts.index') }}"
          class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition"
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

<!-- Quill.js Editor Setup -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const quill = new Quill('#quill-editor', {
    theme: 'snow',
    placeholder: 'ব্লগ পোস্টের সম্পূর্ণ বিষয়বস্তু, নিবন্ধ বা সংবাদ এখানে লিখুন...',
    modules: {
      toolbar: [
        [{ 'header': [1, 2, 3, false] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        ['blockquote', 'link', 'image'],
        ['clean']
      ]
    }
  });

  const hiddenInput = document.getElementById('hidden-content');
  if (hiddenInput.value) {
    quill.root.innerHTML = hiddenInput.value;
  }

  const form = hiddenInput.closest('form');
  form.addEventListener('submit', function() {
    hiddenInput.value = quill.root.innerHTML;
  });
});
</script>
@endsection

