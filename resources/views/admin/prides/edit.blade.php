@extends('layouts.admin.admin-layout')

@section('title', 'কৃতি সন্তান সম্পাদনা — ' . $pride->name . ' | আগামী শৈলকুপা')

@section('content')
<div class="space-y-6">
  <!-- Top Bar -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
    <div>
      <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622] transition">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <a href="{{ route('admin.prides.index') }}" class="hover:text-[#0b4622] transition">কৃতি সন্তান</a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <span class="text-[#0b4622] font-semibold">সম্পাদনা</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-800 tracking-tight flex items-center gap-2">
        <i class="ri-edit-2-line text-[#0b4622]"></i>
        <span>কৃতি সন্তান সম্পাদনা: {{ $pride->name }}</span>
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-0.5">নাম, পদবি, ছবি ও জীবনীর বিবরণ হালনাগাদ করুন।</p>
    </div>

    <div>
      <a
        href="{{ route('admin.prides.index') }}"
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
          <p class="text-xs text-gray-500">আইডি: #{{ $pride->id }}</p>
        </div>
      </div>
    </div>

    <form
      id="pride-edit-form"
      action="{{ route('admin.prides.update', $pride->id) }}"
      method="POST"
      enctype="multipart/form-data"
      class="p-6 sm:p-8 space-y-6"
    >
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left 2 Cols: Main Info -->
        <div class="lg:col-span-2 space-y-5">
          <!-- Name -->
          <div>
            <label for="name" class="block text-xs font-bold text-gray-700 mb-1.5">
              কৃতি সন্তানের নাম <span class="text-[#c8102e]">*</span>
            </label>
            <input
              type="text"
              id="name"
              name="name"
              value="{{ old('name', $pride->name) }}"
              placeholder="উদাঃ বেগম খালেদা জিয়া"
              class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('name') border-[#c8102e] bg-red-50/20 @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition"
              required
            >
            @error('name')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Designation -->
          <div>
            <label for="designation" class="block text-xs font-bold text-gray-700 mb-1.5">
              পদবি / পরিচয় (Designation) <span class="text-[#c8102e]">*</span>
            </label>
            <input
              type="text"
              id="designation"
              name="designation"
              value="{{ old('designation', $pride->designation) }}"
              placeholder="উদাঃ সাবেক প্রধানমন্ত্রী"
              class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('designation') border-[#c8102e] bg-red-50/20 @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition"
              required
            >
            @error('designation')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Quill.js Rich Text Editor for Description -->
          <div>
            <div class="flex items-center justify-between mb-1.5">
              <label class="block text-xs font-bold text-gray-700">
                জীবনী ও অবদান (Quill.js Rich Text Editor)
              </label>
              <span class="text-[11px] text-gray-400">Heading 2, Bold, List ইত্যাদি ফরম্যাটিং ব্যবহার করুন</span>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-2xs">
              <div id="quill-pride-editor" style="min-height: 220px; font-size: 14px;">{!! old('description', $pride->description) !!}</div>
            </div>

            <input type="hidden" name="description" id="hidden_pride_description" value="{{ old('description', $pride->description) }}">
            @error('description')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <!-- Right Col: Photo & Order -->
        <div class="space-y-5">
          <!-- Photo Upload & Preview -->
          <div class="bg-gray-50/70 border border-gray-100 rounded-xl p-4 space-y-3">
            <label class="block text-xs font-bold text-gray-700">
              প্রোফাইল ছবি (Photo) <span class="text-xs font-normal text-gray-400">(অনূর্ধ্ব 4MB)</span>
            </label>

            <!-- Preview box -->
            <div class="relative w-full h-48 rounded-2xl border-2 border-dashed border-gray-300 overflow-hidden bg-gray-100 flex items-center justify-center group">
              <img
                id="pride-photo-preview"
                src="{{ $pride->photo_url }}"
                alt="Photo Preview"
                class="w-full h-full object-cover transition duration-300 group-hover:scale-105"
                onerror="this.src='https://placehold.co/400x400/0b4622/ffffff?text={{ urlencode($pride->name) }}'"
              >
              <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                <span class="text-white text-xs font-semibold px-3 py-1.5 rounded-lg bg-black/60 backdrop-blur-xs flex items-center gap-1.5 pointer-events-none">
                  <i class="ri-camera-lens-line"></i> ছবি পরিবর্তন করুন
                </span>
              </div>
              <input
                type="file"
                name="photo"
                accept="image/*"
                class="absolute inset-0 opacity-0 cursor-pointer w-full h-full z-10"
                onchange="previewPridePhoto(event)"
              >
            </div>
            <p class="text-[11px] text-gray-500 leading-relaxed">
              বর্গাকার ছবি ব্যবহার করা সুপারিশকৃত।
            </p>
            @error('photo')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
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
              value="{{ old('order_index', $pride->order_index) }}"
              class="w-full px-3.5 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
            >
            <p class="text-[11px] text-emerald-700 font-semibold mt-1">
              💡 ক্রম ১ (Order 1) দিলে এই ব্যক্তি পেজের শীর্ষে প্রধান ফোকাস কার্ডে প্রদর্শিত হবেন।
            </p>
          </div>

          <!-- Active Status Toggle -->
          <div class="flex items-center justify-between p-3.5 bg-gray-50 border border-gray-200 rounded-xl">
            <span class="text-xs font-bold text-gray-700">সক্রিয় স্ট্যাটাস</span>
            <label class="relative inline-flex items-center cursor-pointer">
              <input type="checkbox" name="status" value="1" class="sr-only peer" {{ $pride->status ? 'checked' : '' }}>
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
let quillPride;

function syncPrideEditor() {
  const hiddenInput = document.getElementById('hidden_pride_description');
  if (quillPride && hiddenInput) {
    hiddenInput.value = quillPride.root.innerHTML;
  }
}

document.addEventListener('DOMContentLoaded', function () {
  quillPride = new Quill('#quill-pride-editor', {
    theme: 'snow',
    placeholder: 'কৃতি সন্তানের সংক্ষিপ্ত জীবনী ও অবদান লিখুন...',
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

  quillPride.on('text-change', function () {
    syncPrideEditor();
  });

  const form = document.getElementById('pride-edit-form');
  if (form) {
    form.addEventListener('submit', function () {
      syncPrideEditor();
    });
  }
});

function previewPridePhoto(event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('pride-photo-preview').src = e.target.result;
    }
    reader.readAsDataURL(file);
  }
}
</script>
@endsection

