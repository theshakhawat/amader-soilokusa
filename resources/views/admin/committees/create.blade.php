@extends('layouts.admin.admin-layout')

@section('title', 'নতুন কমিটি যুক্ত করুন')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
  <!-- Header / Breadcrumb -->
  <div class="flex items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
    <div>
      <div class="flex items-center gap-2 text-xs font-semibold text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <a href="{{ route('admin.committees.index') }}" class="hover:text-[#0b4622]">কমিটি তালিকা</a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <span class="text-[#0b4622]">নতুন কমিটি</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-900">নতুন কমিটি যুক্ত করুন</h1>
    </div>

    <a
      href="{{ route('admin.committees.index') }}"
      class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-gray-200 text-gray-600 hover:text-gray-900 hover:bg-gray-50 text-xs sm:text-sm font-bold transition"
    >
      <i class="ri-arrow-left-line"></i>
      <span>ফিরে যান</span>
    </a>
  </div>

  @if($errors->any())
    <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
      <ul class="list-disc list-inside space-y-1">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- Form -->
  <form action="{{ route('admin.committees.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-100 shadow-xs space-y-6">
    @csrf

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
      <!-- কমিটির নাম -->
      <div>
        <label for="name" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">
          কমিটির নাম <span class="text-red-500">*</span>
        </label>
        <input
          type="text"
          id="name"
          name="name"
          value="{{ old('name', 'কার্যনির্বাহী কমিটি') }}"
          placeholder="যেমন: কার্যনির্বাহী কমিটি"
          required
          class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0b4622] text-sm"
        />
      </div>

      <!-- মেয়াদকাল / সেশন -->
      <div>
        <label for="session_duration" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">
          মেয়াদকাল / সেশন <span class="text-red-500">*</span>
        </label>
        <input
          type="text"
          id="session_duration"
          name="session_duration"
          value="{{ old('session_duration', '২০২৬-২০২৮') }}"
          placeholder="যেমন: ২০২৬-২০২৮ বা 2026-2028"
          required
          class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0b4622] text-sm"
        />
        <span class="text-[11px] text-gray-500 mt-1 block">কমিটির নামের পাশে বন্ধনীর মধ্যে দেখাবে: <strong>নাম (মেয়াদকাল)</strong></span>
      </div>

      <!-- উপ-শিরোনাম (Subtitle) -->
      <div>
        <label for="subtitle" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">
          উপ-শিরোনাম (Subtitle)
        </label>
        <input
          type="text"
          id="subtitle"
          name="subtitle"
          value="{{ old('subtitle', 'আগামীর শৈলকুপা') }}"
          placeholder="যেমন: আগামীর শৈলকুপা"
          class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0b4622] text-sm"
        />
      </div>

      <!-- ডিসপ্লে ক্রম (Order) -->
      <div>
        <label for="order" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">
          ডিসপ্লে ক্রম (Order)
        </label>
        <input
          type="number"
          id="order"
          name="order"
          value="{{ old('order', 1) }}"
          class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0b4622] text-sm"
        />
        <span class="text-[11px] text-gray-500 mt-1 block">হোম পেজে সর্বনিম্ন ক্রমের সক্রিয় কমিটি প্রদর্শিত হবে।</span>
      </div>
    </div>

    <!-- কমিটির ছবি -->
    <div>
      <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">
        কমিটির গ্রুপ ছবি
      </label>
      <div class="flex items-center gap-4">
        <div id="preview-container" class="w-36 h-24 rounded-xl overflow-hidden border border-gray-200 bg-gray-50 flex items-center justify-center shrink-0">
          <i class="ri-image-add-line text-3xl text-gray-300"></i>
        </div>
        <div class="flex-1">
          <input
            type="file"
            name="image"
            id="image"
            accept="image/*"
            onchange="previewImage(event)"
            class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-[#0b4622] hover:file:bg-emerald-100 cursor-pointer"
          />
          <p class="text-[11px] text-gray-500 mt-1.5">অনুমোদিত ফরম্যাট: JPG, JPEG, PNG, WEBP। সর্বোচ্চ সাইজ: ৫ মেগাবাইট।</p>
        </div>
      </div>
    </div>

    <!-- কমিটির বিবরণ / সদস্যদের তথ্য -->
    <div>
      <label for="description" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">
        কমিটির বিস্তারিত বিবরণ / সদস্যদের তালিকা (মডাল বা বিস্তারিতের জন্য)
      </label>
      <textarea
        id="description"
        name="description"
        rows="4"
        placeholder="কমিটির সাধারণ সদস্যদের তথ্য বা বিবরণ এখানে লিখতে পারেন..."
        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0b4622] text-sm"
      >{{ old('description') }}</textarea>
    </div>

    <!-- সক্রিয় স্ট্যাটাস -->
    <div class="flex items-center gap-3 pt-2">
      <input
        type="checkbox"
        id="is_active"
        name="is_active"
        value="1"
        {{ old('is_active', true) ? 'checked' : '' }}
        class="w-4 h-4 text-[#0b4622] rounded border-gray-300 focus:ring-[#0b4622]"
      />
      <label for="is_active" class="text-xs sm:text-sm font-bold text-gray-700 cursor-pointer">
        এই কমিটি সক্রিয় রাখুন এবং হোম পেজে প্রদর্শন করুন
      </label>
    </div>

    <!-- Submit Button -->
    <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
      <a
        href="{{ route('admin.committees.index') }}"
        class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-xs sm:text-sm font-bold transition"
      >
        বাতিল
      </a>
      <button
        type="submit"
        class="px-6 py-2.5 rounded-xl bg-[#0b4622] hover:bg-[#08351a] text-white text-xs sm:text-sm font-bold shadow-sm hover:shadow transition cursor-pointer"
      >
        কমিটি সংরক্ষণ করুন
      </button>
    </div>
  </form>
</div>

<script>
function previewImage(event) {
  const container = document.getElementById('preview-container');
  const file = event.target.files[0];
  if(file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      container.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover" />`;
    };
    reader.readAsDataURL(file);
  }
}
</script>
@endsection

