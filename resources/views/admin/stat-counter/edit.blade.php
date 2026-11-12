@extends('layouts.admin.admin-layout')

@section('title', 'পরিসংখ্যান কাউন্টার সম্পাদনা | আগামী শৈলকুপা')

@section('content')
<div class="space-y-6">
  <!-- Top Navigation & Actions Bar -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
    <div>
      <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622] transition">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <span>কাস্টমাইজেশন</span>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <a href="{{ route('admin.stat-counters.index') }}" class="hover:text-[#0b4622] transition">পরিসংখ্যান কাউন্টার</a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <span class="text-[#0b4622] font-semibold">সম্পাদনা</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-800 tracking-tight flex items-center gap-2">
        <i class="ri-edit-line text-[#0b4622]"></i>
        <span>পরিসংখ্যান সম্পাদনা (Edit Stat Item)</span>
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-0.5">পরিসংখ্যানের সংখ্যা, শিরোনাম বা আইকন পরিবর্তন করুন।</p>
    </div>

    <div>
      <a
        href="{{ route('admin.stat-counters.index') }}"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition cursor-pointer"
      >
        <i class="ri-arrow-left-line"></i>
        <span>তালিকায় ফিরে যান</span>
      </a>
    </div>
  </div>

  <!-- Form Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-xs max-w-2xl overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <span class="w-9 h-9 rounded-xl bg-[#0b4622]/10 text-[#0b4622] flex items-center justify-center font-bold text-lg">
          <i class="ri-bar-chart-box-line"></i>
        </span>
        <div>
          <h2 class="text-sm font-bold text-gray-800">পরিসংখ্যান হালনাগাদ</h2>
          <p class="text-xs text-gray-500">আইডি #{{ $statCounter->id }} • {{ $statCounter->title }}</p>
        </div>
      </div>
      <div>
        <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full {{ $statCounter->status ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-gray-100 text-gray-600 border border-gray-200' }}">
          <span class="w-1.5 h-1.5 rounded-full {{ $statCounter->status ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
          {{ $statCounter->status ? 'বর্তমানে সক্রিয়' : 'বর্তমানে নিষ্ক্রিয়' }}
        </span>
      </div>
    </div>

    <form action="{{ route('admin.stat-counters.update', $statCounter) }}" method="POST" class="p-6 sm:p-8 space-y-6">
      @csrf
      @method('PUT')

      <div class="space-y-5">
        <!-- Title & Count -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <!-- Count -->
          <div>
            <label for="count" class="block text-xs font-bold text-gray-700 mb-1.5">
              পরিসংখ্যান পরিমাণ (Count) <span class="text-[#c8102e]">*</span>
            </label>
            <input
              type="text"
              id="count"
              name="count"
              value="{{ old('count', $statCounter->count) }}"
              placeholder="উদাঃ ৫০০+ বা ১,২০০+"
              class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('count') border-[#c8102e] bg-red-50/20 @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition"
              required
            >
            @error('count')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>

          <!-- Title -->
          <div>
            <label for="title" class="block text-xs font-bold text-gray-700 mb-1.5">
              লেবেল বা শিরোনাম (Title) <span class="text-[#c8102e]">*</span>
            </label>
            <input
              type="text"
              id="title"
              name="title"
              value="{{ old('title', $statCounter->title) }}"
              placeholder="উদাঃ সক্রিয় সদস্য"
              class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('title') border-[#c8102e] bg-red-50/20 @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition"
              required
            >
            @error('title')
              <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <!-- Icon Picker / Text -->
        <div>
          <label for="icon" class="block text-xs font-bold text-gray-700 mb-1.5">
            আইকন ক্লাস (Icon Class) <span class="text-xs font-normal text-gray-400">(Remix Icon বা Font Awesome)</span>
          </label>
          <div class="flex items-center gap-3">
            <div id="icon-preview-box" class="w-11 h-11 rounded-xl bg-red-50 text-[#c8102e] border border-red-100 flex items-center justify-center text-xl shrink-0">
              <i id="preview-icon-elem" class="{{ old('icon', $statCounter->icon ?? 'ri-numbers-line') }}"></i>
            </div>
            <input
              type="text"
              id="icon"
              name="icon"
              value="{{ old('icon', $statCounter->icon) }}"
              placeholder="উদাঃ ri-book-open-line অথবা fa-solid fa-people-group"
              class="w-full px-4 py-2.5 text-sm bg-gray-50 border @error('icon') border-[#c8102e] @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] font-mono transition"
              oninput="updateIconPreview(this.value)"
            >
          </div>
          <!-- Quick Preset Icons -->
          <div class="mt-2 flex flex-wrap items-center gap-2">
            <span class="text-[11px] text-gray-400">জনপ্রিয় আইকন:</span>
            <button type="button" onclick="selectPresetIcon('fa-solid fa-people-group')" class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-md text-[11px] font-mono">
              <i class="fa-solid fa-people-group text-[#c8102e] mr-1"></i> সদস্য
            </button>
            <button type="button" onclick="selectPresetIcon('ri-book-open-line')" class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-md text-[11px] font-mono">
              <i class="ri-book-open-line text-[#c8102e] mr-1"></i> শিক্ষা
            </button>
            <button type="button" onclick="selectPresetIcon('ri-stack-line')" class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-md text-[11px] font-mono">
              <i class="ri-stack-line text-[#c8102e] mr-1"></i> প্রকল্প
            </button>
            <button type="button" onclick="selectPresetIcon('ri-map-pin-line')" class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-md text-[11px] font-mono">
              <i class="ri-map-pin-line text-[#c8102e] mr-1"></i> স্থান
            </button>
            <button type="button" onclick="selectPresetIcon('ri-calendar-todo-line')" class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-md text-[11px] font-mono">
              <i class="ri-calendar-todo-line text-[#c8102e] mr-1"></i> ইভেন্ট
            </button>
            <button type="button" onclick="selectPresetIcon('ri-heart-pulse-line')" class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-md text-[11px] font-mono">
              <i class="ri-heart-pulse-line text-[#c8102e] mr-1"></i> চিকিৎসা
            </button>
          </div>
          @error('icon')
            <p class="mt-1 text-xs text-[#c8102e] font-medium">{{ $message }}</p>
          @enderror
        </div>

        <!-- Order & Status -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center pt-2">
          <!-- Order -->
          <div>
            <label for="order" class="block text-xs font-bold text-gray-700 mb-1.5">
              প্রদর্শনের ক্রম (Sort Order)
            </label>
            <input
              type="number"
              id="order"
              name="order"
              value="{{ old('order', $statCounter->order) }}"
              min="0"
              class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
            >
            <p class="text-[11px] text-gray-400 mt-1">বাম থেকে ডানে প্রদর্শনের ক্রম</p>
          </div>

          <!-- Status toggle -->
          <div class="p-3.5 bg-gray-50 border border-gray-100 rounded-xl flex items-center justify-between mt-3 sm:mt-0">
            <div>
              <span class="text-xs font-bold text-gray-700 block">সক্রিয় স্ট্যাটাস</span>
              <span class="text-[11px] text-gray-500">হোমপেজে দৃশ্যমান রাখা</span>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
              <input
                type="checkbox"
                name="status"
                value="1"
                class="sr-only peer"
                {{ old('status', $statCounter->status) ? 'checked' : '' }}
              >
              <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0b4622]"></div>
            </label>
          </div>
        </div>
      </div>

      <!-- Action buttons -->
      <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
        <a
          href="{{ route('admin.stat-counters.index') }}"
          class="px-5 py-2.5 border border-gray-200 text-gray-700 text-xs font-bold rounded-xl hover:bg-gray-50 transition"
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

<script>
function updateIconPreview(iconClass) {
  const elem = document.getElementById('preview-icon-elem');
  elem.className = iconClass || 'ri-numbers-line';
}

function selectPresetIcon(iconClass) {
  const input = document.getElementById('icon');
  input.value = iconClass;
  updateIconPreview(iconClass);
}
</script>
@endsection

