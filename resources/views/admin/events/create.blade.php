@extends('layouts.admin.admin-layout')

@section('title', 'নতুন ইভেন্ট যোগ করুন | আগামী শৈলকুপা')

@section('content')
<div class="space-y-6">
  <!-- Top Bar -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
    <div>
      <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622] transition">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <a href="{{ route('admin.events.index') }}" class="hover:text-[#0b4622] transition">কার্যক্রম ও ইভেন্ট</a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <span class="text-[#0b4622] font-semibold">নতুন ইভেন্ট</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-800 tracking-tight flex items-center gap-2">
        <i class="ri-calendar-event-fill text-[#0b4622]"></i>
        <span>নতুন কার্যক্রম / ইভেন্ট যোগ করুন</span>
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-0.5">ইভেন্টের থাম্বনেইল, সময়, স্থান, রিচ টেক্সট বিবরণ ও একাধিক ছবি আপলোড করুন।</p>
    </div>

    <div>
      <a
        href="{{ route('admin.events.index') }}"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition cursor-pointer"
      >
        <i class="ri-arrow-left-line"></i>
        <span>ইভেন্ট তালিকায় ফিরুন</span>
      </a>
    </div>
  </div>

  <!-- Form Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <span class="w-9 h-9 rounded-xl bg-[#0b4622]/10 text-[#0b4622] flex items-center justify-center font-bold text-lg">
          <i class="ri-add-circle-line"></i>
        </span>
        <div>
          <h2 class="text-sm font-bold text-gray-800">ইভেন্ট তথ্য পূরণ করুন</h2>
          <p class="text-xs text-gray-500">সকল তথ্য সতর্কতার সাথে লিখুন</p>
        </div>
      </div>
    </div>

    <form
      id="event-form"
      action="{{ route('admin.events.store') }}"
      method="POST"
      enctype="multipart/form-data"
      class="p-6 sm:p-8 space-y-6"
    >
      @csrf

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left 2 Cols: Main Info -->
        <div class="lg:col-span-2 space-y-5">
          <!-- Title -->
          <div>
            <label for="title" class="block text-xs font-bold text-gray-700 mb-1.5">
              ইভেন্টের শিরোনাম (Title) <span class="text-[#c8102e]">*</span>
            </label>
            <input
              type="text"
              id="title"
              name="title"
              value="{{ old('title') }}"
              placeholder="উদাঃ শিক্ষা বৃত্তি বিতরণ অনুষ্ঠান"
              class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('title') border-[#c8102e] bg-red-50/20 @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition"
              required
            >
            @error('title')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Date, Time, Location Grid -->
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Date -->
            <div>
              <label for="date" class="block text-xs font-bold text-gray-700 mb-1.5">
                অনুষ্ঠানের তারিখ
              </label>
              <input
                type="date"
                id="date"
                name="date"
                value="{{ old('date', date('Y-m-d')) }}"
                class="w-full px-3.5 py-2.5 text-xs bg-gray-50 border @error('date') border-[#c8102e] @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
              >
              @error('date')
                <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
              @enderror
            </div>

            <!-- Time -->
            <div>
              <label for="time" class="block text-xs font-bold text-gray-700 mb-1.5">
                সময় (Time)
              </label>
              <input
                type="text"
                id="time"
                name="time"
                value="{{ old('time', 'সকাল ১০:০০') }}"
                placeholder="উদাঃ সকাল ১০:০০"
                class="w-full px-3.5 py-2.5 text-xs bg-gray-50 border @error('time') border-[#c8102e] @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
              >
              @error('time')
                <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
              @enderror
            </div>

            <!-- Location -->
            <div>
              <label for="location" class="block text-xs font-bold text-gray-700 mb-1.5">
                স্থান (Location)
              </label>
              <input
                type="text"
                id="location"
                name="location"
                value="{{ old('location', 'শৈলকুপা পাবলিক হল') }}"
                placeholder="উদাঃ শৈলকুপা পাবলিক হল"
                class="w-full px-3.5 py-2.5 text-xs bg-gray-50 border @error('location') border-[#c8102e] @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
              >
              @error('location')
                <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Quill.js Rich Text Editor for Detailed Description -->
          <div>
            <div class="flex items-center justify-between mb-1.5">
              <label class="block text-xs font-bold text-gray-700">
                ইভেন্টের বিস্তারিত বিবরণ (Quill.js Rich Text Editor)
              </label>
              <span class="text-[11px] text-gray-400">Heading 2, Bold, List ইত্যাদি ফরম্যাটিং ব্যবহার করুন</span>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-2xs">
              <div id="quill-event-editor" style="min-height: 220px; font-size: 14px;">{!! old('description') !!}</div>
            </div>

            <input type="hidden" name="description" id="hidden_event_description" value="{{ old('description') }}">
            @error('description')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Multiple Photos Gallery Upload -->
          <div class="bg-gray-50/70 border border-gray-200 rounded-xl p-4 space-y-3">
            <div class="flex items-center justify-between">
              <div>
                <label class="block text-xs font-bold text-gray-700">
                  ইভেন্ট ফটো গ্যালারি (Multiple Photos)
                </label>
                <p class="text-[11px] text-gray-500">একসাথে একাধিক ছবি সিলেক্ট করে আপলোড করতে পারেন।</p>
              </div>
              <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                Gallery Photos
              </span>
            </div>

            <input
              type="file"
              name="photos[]"
              id="event-photos-input"
              multiple
              accept="image/*"
              class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0b4622]/10 file:text-[#0b4622] hover:file:bg-[#0b4622]/20 cursor-pointer"
            >
            @error('photos.*')
              <p class="text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <!-- Right Col: Thumbnail & Status -->
        <div class="space-y-5">
          <!-- Thumbnail Upload & Preview -->
          <div class="bg-gray-50/70 border border-gray-100 rounded-xl p-4 space-y-3">
            <label class="block text-xs font-bold text-gray-700">
              থাম্বনেইল ফিচার ছবি (Thumbnail) <span class="text-xs font-normal text-gray-400">(অনূর্ধ্ব 4MB)</span>
            </label>

            <!-- Preview box -->
            <div class="relative w-full h-44 rounded-xl border-2 border-dashed border-gray-300 overflow-hidden bg-gray-100 flex items-center justify-center group">
              <img
                id="event-thumb-preview"
                src="{{ asset('assets/images/event-1.jpg') }}"
                alt="Thumbnail Preview"
                class="w-full h-full object-cover transition duration-300 group-hover:scale-105"
              >
              <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                <span class="text-white text-xs font-semibold px-3 py-1.5 rounded-lg bg-black/60 backdrop-blur-xs flex items-center gap-1.5 pointer-events-none">
                  <i class="ri-camera-lens-line"></i> ছবি নির্বাচন করুন
                </span>
              </div>
              <input
                type="file"
                name="thumbnail"
                accept="image/*"
                class="absolute inset-0 opacity-0 cursor-pointer w-full h-full z-10"
                onchange="previewThumbnail(event)"
              >
            </div>
            <p class="text-[11px] text-gray-500 leading-relaxed">
              হোমপেজের কার্ডে এই ছবিটি প্রদর্শিত হবে (16:10 রেশিও সুপারিশকৃত)।
            </p>
            @error('thumbnail')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Status Selection -->
          <div>
            <label for="status" class="block text-xs font-bold text-gray-700 mb-1.5">
              ইভেন্ট স্ট্যাটাস <span class="text-[#c8102e]">*</span>
            </label>
            <select
              id="status"
              name="status"
              class="w-full px-3.5 py-2.5 text-xs bg-gray-50 border @error('status') border-[#c8102e] @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
              required
            >
              <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>সক্রিয় (Active)</option>
              <option value="upcoming" {{ old('status') === 'upcoming' ? 'selected' : '' }}>আসন্ন (Upcoming)</option>
              <option value="ongoing" {{ old('status') === 'ongoing' ? 'selected' : '' }}>চলমান (Ongoing)</option>
              <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>সম্পন্ন (Completed)</option>
              <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>লুকানো / নিষ্ক্রিয় (Inactive)</option>
            </select>
            @error('status')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Order Index -->
          <div>
            <label for="order_index" class="block text-xs font-bold text-gray-700 mb-1.5">
              ডিসপ্লে সিরিয়াল ক্রম (Order Index)
            </label>
            <input
              type="number"
              id="order_index"
              name="order_index"
              value="{{ old('order_index', 0) }}"
              class="w-full px-3.5 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
            >
            <p class="text-[11px] text-gray-400 mt-1">ছোট সংখ্যা আগে প্রদর্শিত হবে (যেমন 1, 2, 3)।</p>
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
          <span>ইভেন্ট সংরক্ষণ করুন</span>
        </button>
      </div>
    </form>
  </div>
</div>

<script>
let quillEvent;

function syncEventEditor() {
  const hiddenInput = document.getElementById('hidden_event_description');
  if (quillEvent && hiddenInput) {
    hiddenInput.value = quillEvent.root.innerHTML;
  }
}

document.addEventListener('DOMContentLoaded', function () {
  quillEvent = new Quill('#quill-event-editor', {
    theme: 'snow',
    placeholder: 'ইভেন্টের বিস্তারিত তথ্য ও উদ্দেশ্য এখানে লিখুন...',
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

  quillEvent.on('text-change', function () {
    syncEventEditor();
  });

  const form = document.getElementById('event-form');
  if (form) {
    form.addEventListener('submit', function () {
      syncEventEditor();
    });
  }
});

function previewThumbnail(event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('event-thumb-preview').src = e.target.result;
    }
    reader.readAsDataURL(file);
  }
}
</script>
@endsection
