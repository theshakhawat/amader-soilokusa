@extends('layouts.admin.admin-layout')

@section('title', 'টপবার হেডার কাস্টমাইজেশন | আগামী শৈলকুপা')

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
        <span class="text-[#0b4622] font-semibold">টপবার হেডার</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-800 tracking-tight flex items-center gap-2">
        <i class="ri-layout-top-2-line text-[#0b4622]"></i>
        <span>টপবার হেডার সেটিংস (Top Header Bar)</span>
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-0.5">ওয়েবসাইটের একদম উপরের লাল রঙের টপবার হেডারের প্রদর্শন অন/অফ এবং কন্টেন্ট নিয়ন্ত্রণ করুন।</p>
    </div>

    <div>
      <a
        href="{{ route('home') }}"
        target="_blank"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition cursor-pointer"
      >
        <i class="ri-external-link-line"></i>
        <span>ওয়েবসাইটে প্রিভিউ দেখুন</span>
      </a>
    </div>
  </div>

  <!-- Success Notification Alert -->
  @if(session('success'))
    <div id="flash-alert" class="flex items-center justify-between p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-xs font-semibold animate-fade-in">
      <div class="flex items-center gap-2.5">
        <i class="ri-checkbox-circle-fill text-emerald-600 text-lg"></i>
        <span>{{ session('success') }}</span>
      </div>
      <button type="button" onclick="document.getElementById('flash-alert').remove()" class="text-emerald-600 hover:text-emerald-800 cursor-pointer">
        <i class="ri-close-line text-base"></i>
      </button>
    </div>
  @endif

  <!-- Live Topbar Visual Preview Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6 space-y-4">
    <div class="flex items-center justify-between">
      <div class="flex items-center gap-2">
        <span class="w-8 h-8 rounded-lg bg-[#c8102e]/10 text-[#c8102e] flex items-center justify-center font-bold text-sm">
          <i class="ri-eye-line"></i>
        </span>
        <h2 class="text-sm font-bold text-gray-800">টপবার লাইভ প্রিভিউ (Visual Preview)</h2>
      </div>
      <span id="preview-status-badge" class="px-3 py-1 rounded-full text-xs font-bold {{ $topbar->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-gray-100 text-gray-500 border border-gray-200' }}">
        {{ $topbar->is_active ? 'বর্তমানে সক্রিয় (Visible)' : 'বর্তমানে বন্ধ (Hidden)' }}
      </span>
    </div>

    <!-- The Realistic Mock Topbar -->
    <div class="rounded-xl overflow-hidden border border-gray-200 shadow-sm">
      <div id="mock-topbar" class="bg-[#c8102e] text-white py-2 px-4 sm:px-6 flex items-center justify-between text-xs transition duration-300 {{ $topbar->is_active ? 'opacity-100' : 'opacity-40 grayscale' }}">
        <!-- Left Contact Info -->
        <div class="flex items-center gap-4 truncate">
          <span class="inline-flex items-center gap-1.5 font-medium">
            <i class="fa-solid fa-location-dot text-[11px]"></i>
            <span>{{ $contact->location ?? 'শৈলকুপা, ঝিনাইদহ' }}</span>
          </span>
          <span class="inline-flex items-center gap-1.5 font-medium font-sans">
            <i class="fa-solid fa-phone text-[11px]"></i>
            <span>{{ $contact->phone ?? '+880 1700-123456' }}</span>
          </span>
          <span class="hidden sm:inline-flex items-center gap-1.5 font-medium font-sans">
            <i class="fa-regular fa-envelope text-[11px]"></i>
            <span>{{ $contact->email ?? 'info@agamirshailkupa.org' }}</span>
          </span>
        </div>

        <!-- Right Social Icons -->
        <div class="flex items-center gap-1.5 shrink-0">
          @forelse($socialLinks as $social)
            <span class="w-5 h-5 rounded-[4px] bg-white text-[#c8102e] flex items-center justify-center text-[10px] shadow-2xs">
              <i class="{{ $social->icon }}"></i>
            </span>
          @empty
            <span class="w-5 h-5 rounded-[4px] bg-white text-[#c8102e] flex items-center justify-center text-[10px]">
              <i class="fa-brands fa-facebook-f"></i>
            </span>
            <span class="w-5 h-5 rounded-[4px] bg-white text-[#c8102e] flex items-center justify-center text-[10px]">
              <i class="fa-brands fa-youtube"></i>
            </span>
          @endforelse
        </div>
      </div>
    </div>
  </div>

  <!-- Settings Control Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <span class="w-9 h-9 rounded-xl bg-[#0b4622]/10 text-[#0b4622] flex items-center justify-center font-bold text-lg">
          <i class="ri-toggle-line"></i>
        </span>
        <div>
          <h2 class="text-sm font-bold text-gray-800">ডিসপ্লে এবং দৃশ্যমানতা কনফিগারেশন</h2>
          <p class="text-xs text-gray-500">টপবার হেডারের অন/অফ সুইচ এবং সংশ্লিষ্ট উপাদানসমূহ</p>
        </div>
      </div>
    </div>

    <form action="{{ route('admin.customization.topbar.update') }}" method="POST" class="p-6 sm:p-8 space-y-6">
      @csrf
      @method('PUT')

      <div class="space-y-5">
        <!-- Main Master ON/OFF Switch -->
        <div class="p-5 bg-gradient-to-r from-red-50/60 to-white border border-red-100 rounded-2xl flex items-center justify-between">
          <div class="space-y-1">
            <span class="text-sm font-bold text-gray-800 flex items-center gap-2">
              <i class="ri-layout-top-line text-[#c8102e] text-lg"></i>
              <span>টপবার হেডার সক্রিয় (Master ON/OFF Switch)</span>
            </span>
            <p class="text-xs text-gray-500">
              এটি চালু থাকলে হোমপেজের নেভিগেশন বারের উপরে লাল টপবার হেডারটি দৃশ্যমান হবে। বন্ধ থাকলে সম্পূর্ণ হেডারটি গোপন থাকবে।
            </p>
          </div>
          <!-- AJAX Interactive Toggle Switch -->
          <label class="relative inline-flex items-center cursor-pointer select-none shrink-0 ml-4">
            <input
              type="checkbox"
              id="topbar-status-switch"
              name="is_active"
              value="1"
              class="sr-only peer"
              {{ $topbar->is_active ? 'checked' : '' }}
              onchange="toggleTopbarAjax(this)"
            >
            <div class="w-14 h-7 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-[#0b4622]"></div>
          </label>
        </div>

        <!-- Sub components options -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
          <!-- Show Contact Info Option -->
          <div class="p-4 bg-gray-50/70 border border-gray-100 rounded-xl flex items-start justify-between">
            <div class="pr-3">
              <span class="text-xs font-bold text-gray-800 block mb-0.5">যোগাযোগের তথ্য প্রদর্শন</span>
              <p class="text-[11px] text-gray-500 leading-relaxed">
                লোকেশন, ফোন নম্বর ও ইমেইল ঠিকানা প্রদর্শন। ডাটা পরিবর্তন করতে 
                <a href="{{ route('admin.customization.contact') }}" class="text-[#0b4622] font-semibold underline">যোগাযোগ সেটিংসে</a> যান।
              </p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer shrink-0">
              <input
                type="checkbox"
                name="show_contact"
                value="1"
                class="sr-only peer"
                {{ $topbar->show_contact ? 'checked' : '' }}
              >
              <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0b4622]"></div>
            </label>
          </div>

          <!-- Show Social Icons Option -->
          <div class="p-4 bg-gray-50/70 border border-gray-100 rounded-xl flex items-start justify-between">
            <div class="pr-3">
              <span class="text-xs font-bold text-gray-800 block mb-0.5">সোশ্যাল মিডিয়া আইকন প্রদর্শন</span>
              <p class="text-[11px] text-gray-500 leading-relaxed">
                ডান পাশে সক্রিয় সোশ্যাল মিডিয়া আইকনসমূহ প্রদর্শন। লিংক পরিচালনা করতে 
                <a href="{{ route('admin.social-media.index') }}" class="text-[#0b4622] font-semibold underline">সোশ্যাল মিডিয়া সেটিংসে</a> যান।
              </p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer shrink-0">
              <input
                type="checkbox"
                name="show_social"
                value="1"
                class="sr-only peer"
                {{ $topbar->show_social ? 'checked' : '' }}
              >
              <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0b4622]"></div>
            </label>
          </div>
        </div>
      </div>

      <!-- Action buttons -->
      <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
        <button
          type="submit"
          class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-sm hover:shadow transition cursor-pointer"
        >
          <i class="ri-check-line"></i>
          <span>সেটিংস সংরক্ষণ করুন</span>
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Dynamic Toast Container for AJAX status notification (Bottom Right) -->
<div id="ajax-toast" class="fixed bottom-5 right-5 z-50 flex items-center gap-2.5 px-4 py-3 bg-gray-900 text-white text-xs font-medium rounded-xl shadow-xl transform translate-y-12 opacity-0 transition-all duration-300 pointer-events-none">
  <i id="toast-icon" class="ri-checkbox-circle-fill text-emerald-400 text-base"></i>
  <span id="toast-message">স্ট্যাটাস সফলভাবে আপডেট হয়েছে</span>
</div>

<script>
function toggleTopbarAjax(checkboxEl) {
  const isChecked = checkboxEl.checked;
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  const mockTopbar = document.getElementById('mock-topbar');
  const statusBadge = document.getElementById('preview-status-badge');

  checkboxEl.disabled = true;

  fetch(`{{ route('admin.customization.topbar.status') }}`, {
    method: 'PATCH',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken,
      'Accept': 'application/json'
    },
    body: JSON.stringify({ status: isChecked ? 1 : 0 })
  })
  .then(res => res.json())
  .then(data => {
    checkboxEl.disabled = false;
    if (data.status === 'success') {
      if (isChecked) {
        mockTopbar.classList.remove('opacity-40', 'grayscale');
        mockTopbar.classList.add('opacity-100');
        statusBadge.textContent = 'বর্তমানে সক্রিয় (Visible)';
        statusBadge.className = 'px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200';
      } else {
        mockTopbar.classList.add('opacity-40', 'grayscale');
        mockTopbar.classList.remove('opacity-100');
        statusBadge.textContent = 'বর্তমানে বন্ধ (Hidden)';
        statusBadge.className = 'px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-500 border border-gray-200';
      }
      showToast(data.message, true);
    } else {
      checkboxEl.checked = !isChecked;
      showToast('স্ট্যাটাস আপডেট ব্যর্থ হয়েছে!', false);
    }
  })
  .catch(err => {
    console.error(err);
    checkboxEl.disabled = false;
    checkboxEl.checked = !isChecked;
    showToast('সার্ভার এরর!', false);
  });
}

function showToast(message, isSuccess = true) {
  const toast = document.getElementById('ajax-toast');
  const msgEl = document.getElementById('toast-message');
  const iconEl = document.getElementById('toast-icon');

  msgEl.textContent = message;
  iconEl.className = isSuccess ? 'ri-checkbox-circle-fill text-emerald-400 text-base' : 'ri-error-warning-fill text-red-400 text-base';

  toast.classList.remove('translate-y-12', 'opacity-0', 'pointer-events-none');
  toast.classList.add('translate-y-0', 'opacity-100');

  setTimeout(() => {
    toast.classList.remove('translate-y-0', 'opacity-100');
    toast.classList.add('translate-y-12', 'opacity-0', 'pointer-events-none');
  }, 3000);
}
</script>
@endsection

