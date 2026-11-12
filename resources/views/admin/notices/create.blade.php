@extends('layouts.admin.admin-layout')

@section('title', 'নতুন নোটিশ যোগ করুন | আগামী শৈলকুপা')

@section('content')
<div class="space-y-6">
  <!-- Top Bar -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
    <div>
      <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622] transition">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <a href="{{ route('admin.notices.index') }}" class="hover:text-[#0b4622] transition">নোটিশ ও বিজ্ঞপ্তি</a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <span class="text-[#0b4622] font-semibold">নতুন নোটিশ</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-800 tracking-tight flex items-center gap-2">
        <i class="ri-add-circle-fill text-[#0b4622]"></i>
        <span>নতুন নোটিশ / বিজ্ঞপ্তি প্রকাশ করুন</span>
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-0.5">নোটিশের শিরোনাম, তারিখ, রিচ টেক্সট বিবরণ ও একাধিক ফাইল/ডকুমেন্ট আপলোড করুন।</p>
    </div>

    <div>
      <a
        href="{{ route('admin.notices.index') }}"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition cursor-pointer"
      >
        <i class="ri-arrow-left-line"></i>
        <span>নোটিশ তালিকায় ফিরুন</span>
      </a>
    </div>
  </div>

  <!-- Form Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <span class="w-9 h-9 rounded-xl bg-[#0b4622]/10 text-[#0b4622] flex items-center justify-center font-bold text-lg">
          <i class="ri-file-add-line"></i>
        </span>
        <div>
          <h2 class="text-sm font-bold text-gray-800">নোটিশ ফর্ম পূরণ করুন</h2>
          <p class="text-xs text-gray-500">সকল তথ্য সতর্কতার সাথে লিখুন</p>
        </div>
      </div>
    </div>

    <form
      id="notice-form"
      action="{{ route('admin.notices.store') }}"
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
              নোটিশ শিরোনাম (Title) <span class="text-[#c8102e]">*</span>
            </label>
            <input
              type="text"
              id="title"
              name="title"
              value="{{ old('title') }}"
              placeholder="উদাঃ বার্ষিক সাধারণ সভার নোটিশ"
              class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('title') border-[#c8102e] bg-red-50/20 @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition"
              required
            >
            @error('title')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Date & Status Row -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Date -->
            <div>
              <label for="date" class="block text-xs font-bold text-gray-700 mb-1.5">
                প্রকাশের তারিখ <span class="text-[#c8102e]">*</span>
              </label>
              <input
                type="date"
                id="date"
                name="date"
                value="{{ old('date', date('Y-m-d')) }}"
                class="w-full px-3.5 py-2.5 text-xs bg-gray-50 border @error('date') border-[#c8102e] @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
                required
              >
              @error('date')
                <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
              @enderror
            </div>

            <!-- Status -->
            <div>
              <label for="status" class="block text-xs font-bold text-gray-700 mb-1.5">
                নোটিশের স্ট্যাটাস <span class="text-[#c8102e]">*</span>
              </label>
              <select
                id="status"
                name="status"
                class="w-full px-3.5 py-2.5 text-xs bg-gray-50 border @error('status') border-[#c8102e] @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
                required
              >
                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>সক্রিয় (Active)</option>
                <option value="pinned" {{ old('status') === 'pinned' ? 'selected' : '' }}>জরুরি নোটিশ / শীর্ষে পিন (Pinned)</option>
                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>নিষ্ক্রিয় / অপ্রকাশিত (Inactive)</option>
              </select>
              @error('status')
                <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <!-- Quill.js Rich Text Editor for Description -->
          <div>
            <div class="flex items-center justify-between mb-1.5">
              <label class="block text-xs font-bold text-gray-700">
                নোটিশের বিস্তারিত বিবরণ (Quill.js Rich Text Editor)
              </label>
              <span class="text-[11px] text-gray-400">Heading 2, Bold, List ইত্যাদি ফরম্যাটিং ব্যবহার করুন</span>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-2xs">
              <div id="quill-notice-editor" style="min-height: 220px; font-size: 14px;">{!! old('description') !!}</div>
            </div>

            <input type="hidden" name="description" id="hidden_notice_description" value="{{ old('description') }}">
            @error('description')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <!-- Right Col: Attachments & Order -->
        <div class="space-y-5">
          <!-- Multiple Files / PDF / Documents Attachment -->
          <div class="bg-gray-50/70 border border-gray-200 rounded-xl p-4 space-y-3">
            <div class="flex items-center justify-between">
              <div>
                <label class="block text-xs font-bold text-gray-700">
                  সংযুক্ত ফাইল (Multiple Files)
                </label>
                <p class="text-[11px] text-gray-500">PDF, Word বা ছবি ফাইল একসাথে সিলেক্ট করুন (প্রতিটি অনূর্ধ্ব 10MB)।</p>
              </div>
              <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                Attachment
              </span>
            </div>

            <input
              type="file"
              name="files[]"
              id="notice-files-input"
              multiple
              class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0b4622]/10 file:text-[#0b4622] hover:file:bg-[#0b4622]/20 cursor-pointer"
            >
            @error('files.*')
              <p class="text-xs text-[#c8102e] font-medium">{{ $message }}</p>
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
          <span>নোটিশ প্রকাশ করুন</span>
        </button>
      </div>
    </form>
  </div>
</div>

<script>
let quillNotice;

function syncNoticeEditor() {
  const hiddenInput = document.getElementById('hidden_notice_description');
  if (quillNotice && hiddenInput) {
    hiddenInput.value = quillNotice.root.innerHTML;
  }
}

document.addEventListener('DOMContentLoaded', function () {
  quillNotice = new Quill('#quill-notice-editor', {
    theme: 'snow',
    placeholder: 'নোটিশের বিস্তারিত বক্তব্য এখানে লিখুন...',
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

  quillNotice.on('text-change', function () {
    syncNoticeEditor();
  });

  const form = document.getElementById('notice-form');
  if (form) {
    form.addEventListener('submit', function () {
      syncNoticeEditor();
    });
  }
});
</script>
@endsection

