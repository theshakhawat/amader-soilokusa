@extends('layouts.admin.admin-layout')

@section('title', 'নতুন বিধিমালার ভাগ যোগ করুন | আগামীর শৈলকুপা')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

  <!-- Header -->
  <div class="flex items-center justify-between">
    <div>
      <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line"></i>
        <a href="{{ route('admin.rules.index') }}" class="hover:text-[#0b4622]">বিধিমালা</a>
        <i class="ri-arrow-right-s-line"></i>
        <span class="text-[#0b4622] font-semibold">নতুন ভাগ</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
        <i class="ri-add-circle-line text-[#0b4622]"></i>
        <span>নতুন বিধিমালার ভাগ যোগ করুন</span>
      </h1>
      <p class="text-xs text-gray-500 mt-0.5">গঠনতন্ত্রের নতুন একটি খণ্ড বা অধ্যায় ও তার বিস্তারিত ধারাগুলো লিখুন।</p>
    </div>

    <a
      href="{{ route('admin.rules.index') }}"
      class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition cursor-pointer"
    >
      <i class="ri-arrow-left-line"></i>
      <span>তালিকায় ফিরে যান</span>
    </a>
  </div>

  @if($errors->any())
    <div class="p-4 bg-red-50 border border-red-200 text-red-700 text-xs font-bold rounded-2xl">
      <ul class="list-disc list-inside space-y-1">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.rules.store') }}" method="POST" class="space-y-6" onsubmit="syncQuill()">
    @csrf

    <div class="bg-white border border-gray-100 rounded-2xl p-6 sm:p-8 shadow-xs space-y-5">
      
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <!-- Part No -->
        <div>
          <label for="part_no" class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-1.5">
            ভাগের নাম (Part Name) <span class="text-red-500">*</span>
          </label>
          <input
            type="text"
            id="part_no"
            name="part_no"
            value="{{ old('part_no', 'প্রথম ভাগ') }}"
            placeholder="e.g. প্রথম ভাগ বা অধ্যায় ১"
            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold text-gray-800 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#0b4622] transition"
            required
          />
          <p class="text-[11px] text-gray-400 mt-1">বাম পাশের ট্যাবে এই নাম প্রদর্শিত হবে।</p>
        </div>

        <!-- Title -->
        <div class="sm:col-span-2">
          <label for="title" class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-1.5">
            শিরোনাম বা মূল বিষয় (Title) <span class="text-red-500">*</span>
          </label>
          <input
            type="text"
            id="title"
            name="title"
            value="{{ old('title') }}"
            placeholder="e.g. সংগঠনের পরিচিতি ও লক্ষ্য-উদ্দেশ্য"
            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold text-gray-800 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#0b4622] transition"
            required
          />
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <!-- Slug -->
        <div>
          <label for="slug" class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-1.5">
            স্লাগ (Slug / Anchor URL)
          </label>
          <input
            type="text"
            id="slug"
            name="slug"
            value="{{ old('slug') }}"
            placeholder="e.g. part-1 (ফাঁকা রাখলে স্বয়ংক্রিয় তৈরি হবে)"
            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold text-gray-800 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#0b4622] transition"
          />
        </div>

        <!-- Order & Status -->
        <div class="grid grid-cols-2 gap-3">
          <div>
            <label for="order" class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-1.5">
              ক্রম (Order)
            </label>
            <input
              type="number"
              id="order"
              name="order"
              value="{{ old('order', $nextOrder) }}"
              class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold text-gray-800 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#0b4622] transition"
            />
          </div>

          <div>
            <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-1.5">
              স্ট্যাটাস
            </label>
            <label class="flex items-center gap-2 mt-2 cursor-pointer select-none">
              <input
                type="checkbox"
                name="status"
                value="1"
                class="w-4 h-4 text-[#0b4622] rounded focus:ring-[#0b4622]"
                checked
              />
              <span class="text-xs font-bold text-gray-700">সরাসরি সক্রিয় রাখুন</span>
            </label>
          </div>
        </div>
      </div>

      <!-- Summary -->
      <div>
        <label for="summary" class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-1.5">
          সংক্ষিপ্ত সারসংক্ষেপ (Optional Summary)
        </label>
        <textarea
          id="summary"
          name="summary"
          rows="2"
          placeholder="এই ভাগের প্রধান আলোচ্য বিষয়ের সংক্ষিপ্ত রূপ..."
          class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs font-medium text-gray-800 focus:bg-white focus:outline-hidden focus:ring-2 focus:ring-[#0b4622] transition"
        >{{ old('summary') }}</textarea>
      </div>

      <!-- Detailed Content (Quill Rich Text) -->
      <div>
        <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-1.5">
          বিস্তারিত ধারা ও নিয়মাবলী (Rules Content) <span class="text-red-500">*</span>
        </label>
        
        <input type="hidden" name="content" id="contentInput" value="{{ old('content') }}">
        
        <div id="editor-container" class="bg-white rounded-xl border border-gray-200" style="min-height: 280px;">
          {!! old('content', '<h3>ধারা ১: শিরোনাম</h3><p>১.১ উপধারা বা নিয়মাবলী এখানে লিখুন...</p>') !!}
        </div>
        <p class="text-[11px] text-gray-400 mt-1">টেক্সট ফরম্যাটিং, বুলেট পয়েন্ট, বোল্ড ইত্যাদি ব্যবহার করতে উপরের এডিটর টুলবার ব্যবহার করুন।</p>
      </div>

      <!-- Actions -->
      <div class="pt-5 border-t border-gray-100 flex items-center justify-end gap-3">
        <a
          href="{{ route('admin.rules.index') }}"
          class="px-5 py-2.5 rounded-xl border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 transition cursor-pointer"
        >
          বাতিল
        </a>
        <button
          type="submit"
          class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-[#0b4622] hover:bg-[#146c32] text-white text-xs font-extrabold shadow-sm hover:shadow transition cursor-pointer"
        >
          <i class="ri-check-line text-sm"></i>
          <span>সংরক্ষণ করুন</span>
        </button>
      </div>

    </div>
  </form>

</div>

<script>
let quill;
document.addEventListener('DOMContentLoaded', function () {
  quill = new Quill('#editor-container', {
    theme: 'snow',
    placeholder: 'ধারা, উপধারা ও নীতিমালার বিবরণ এখানে লিখুন...',
    modules: {
      toolbar: [
        [{ 'header': [2, 3, 4, false] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'color': [] }, { 'background': [] }],
        ['link', 'clean']
      ]
    }
  });
});

function syncQuill() {
  if (quill) {
    document.getElementById('contentInput').value = quill.root.innerHTML;
  }
}
</script>
@endsection
