@extends('layouts.admin.admin-layout')

@section('title', 'নতুন সদস্য যুক্ত করুন')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
  <!-- Header / Breadcrumb -->
  <div class="flex items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
    <div>
      <div class="flex items-center gap-2 text-xs font-semibold text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <a href="{{ route('admin.committee-members.index') }}" class="hover:text-[#0b4622]">কমিটি সদস্য তালিকা</a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <span class="text-[#0b4622]">নতুন সদস্য</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-900">নতুন কমিটি সদস্য যুক্ত করুন</h1>
    </div>

    <a
      href="{{ route('admin.committee-members.index') }}"
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
  <form action="{{ route('admin.committee-members.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-100 shadow-xs space-y-6">
    @csrf

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
      <!-- সদস্যের নাম -->
      <div>
        <label for="name" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">
          সদস্যের পুরো নাম <span class="text-red-500">*</span>
        </label>
        <input
          type="text"
          id="name"
          name="name"
          value="{{ old('name') }}"
          placeholder="যেমন: মোঃ আব্দুল করিম"
          required
          class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0b4622] text-sm"
        />
      </div>

      <!-- পদবী (Title) -->
      <div>
        <label for="title" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">
          পদবী (Title) <span class="text-red-500">*</span>
        </label>
        <input
          type="text"
          id="title"
          name="title"
          value="{{ old('title') }}"
          placeholder="যেমন: সভাপতি, সহ-সভাপতি, সাধারণ সম্পাদক ইত্যাদি"
          required
          class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0b4622] text-sm"
        />
      </div>

      <!-- কমিটি নির্বাচন -->
      <div>
        <label for="committee_id" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">
          কমিটি
        </label>
        <select
          id="committee_id"
          name="committee_id"
          class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0b4622] text-sm text-gray-700"
        >
          @foreach($committees as $c)
            <option value="{{ $c->id }}" {{ old('committee_id') == $c->id ? 'selected' : '' }}>
              {{ $c->name }} ({{ $c->session_duration }})
            </option>
          @endforeach
        </select>
      </div>

      <!-- ক্রম (Order) -->
      <div>
        <label for="order" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">
          প্রদর্শনের ক্রম (Order) <span class="text-red-500">*</span>
        </label>
        <input
          type="number"
          id="order"
          name="order"
          value="{{ old('order', $nextOrder) }}"
          required
          class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0b4622] text-sm"
        />
        <div class="text-[11px] text-gray-500 mt-1.5 space-y-0.5">
          <p>• <strong>Order 1:</strong> প্রথম রো-তে একা প্রদর্শিত হবে (সভাপতি)।</p>
          <p>• <strong>Order 2 ও 3:</strong> দ্বিতীয় রো-তে পাশাপাশি ২টি কার্ড প্রদর্শিত হবে।</p>
          <p>• <strong>Order 4 বা তার বেশি:</strong> পরবর্তী রো-গুলোতে প্রতি রো-তে ৪টি করে কার্ড হিসেবে প্রদর্শিত হবে।</p>
        </div>
      </div>
    </div>

    <!-- সদস্যের ছবি -->
    <div>
      <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">
        সদস্যের ছবি (Photo)
      </label>
      <div class="flex items-center gap-4">
        <div id="preview-container" class="w-24 h-24 rounded-full overflow-hidden border border-gray-200 bg-gray-50 flex items-center justify-center shrink-0">
          <i class="ri-user-add-line text-3xl text-gray-300"></i>
        </div>
        <div class="flex-1">
          <input
            type="file"
            name="photo"
            id="photo"
            accept="image/*"
            onchange="previewImage(event)"
            class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-[#0b4622] hover:file:bg-emerald-100 cursor-pointer"
          />
          <p class="text-[11px] text-gray-500 mt-1.5">অনুমোদিত ফরম্যাট: JPG, JPEG, PNG, WEBP। সাইজ: অনুপাত ১:১ বা পাসপোর্ট সাইজ হলে ভালো দেখায়।</p>
        </div>
      </div>
    </div>

    <!-- সক্রিয় স্ট্যাটাস -->
    <div class="flex items-center gap-3 pt-2">
      <input
        type="checkbox"
        id="status"
        name="status"
        value="1"
        {{ old('status', true) ? 'checked' : '' }}
        class="w-4 h-4 text-[#0b4622] rounded border-gray-300 focus:ring-[#0b4622]"
      />
      <label for="status" class="text-xs sm:text-sm font-bold text-gray-700 cursor-pointer">
        এই সদস্যকে সক্রিয় রাখুন
      </label>
    </div>

    <!-- Submit Button -->
    <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
      <a
        href="{{ route('admin.committee-members.index') }}"
        class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-xs sm:text-sm font-bold transition"
      >
        বাতিল
      </a>
      <button
        type="submit"
        class="px-6 py-2.5 rounded-xl bg-[#0b4622] hover:bg-[#08351a] text-white text-xs sm:text-sm font-bold shadow-sm hover:shadow transition cursor-pointer"
      >
        সদস্য সংরক্ষণ করুন
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

