@extends('layouts.admin.admin-layout')

@section('title', 'পরিসংখ্যান কাউন্টার ব্যবস্থাপনা | আগামী শৈলকুপা')

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
        <span class="text-[#0b4622] font-semibold">পরিসংখ্যান কাউন্টার</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-800 tracking-tight flex items-center gap-2">
        <i class="ri-bar-chart-box-line text-[#0b4622]"></i>
        <span>হোমপেজ পরিসংখ্যান কাউন্টার (Stat Counter Bar)</span>
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-0.5">হোমপেজের হিরো সেকশনের নিচের ৫টি প্রধান পরিসংখ্যান বক্সের ডাটা, আইকন এবং স্ট্যাটাস নিয়ন্ত্রণ করুন।</p>
    </div>

    <div>
      <a
        href="{{ route('admin.stat-counters.create') }}"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-sm hover:shadow transition cursor-pointer"
      >
        <i class="ri-add-line text-base"></i>
        <span>নতুন পরিসংখ্যান যোগ করুন</span>
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

  <!-- Stats Table Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
    <div class="p-5 border-b border-gray-100 flex items-center justify-between">
      <div class="flex items-center gap-2">
        <span class="w-8 h-8 rounded-lg bg-[#0b4622]/10 text-[#0b4622] flex items-center justify-center font-bold text-sm">
          <i class="ri-list-check-2"></i>
        </span>
        <h2 class="text-sm font-bold text-gray-800">পরিসংখ্যান তালিকা</h2>
      </div>
      <span class="text-xs font-medium text-gray-500 bg-gray-50 px-2.5 py-1 rounded-lg border border-gray-100">
        মোট: {{ $stats->count() }}টি
      </span>
    </div>

    <div class="overflow-x-auto custom-slim-scrollbar">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-gray-50/70 border-b border-gray-100 text-[11px] font-bold text-gray-500 uppercase tracking-wider">
            <th class="py-3.5 px-4 w-12 text-center">ক্রম</th>
            <th class="py-3.5 px-4">আইকন</th>
            <th class="py-3.5 px-4">পরিসংখ্যান পরিমাণ (Count)</th>
            <th class="py-3.5 px-4">শিরোনাম (Title)</th>
            <th class="py-3.5 px-4 text-center">স্ট্যাটাস (AJAX ON/OFF)</th>
            <th class="py-3.5 px-4 text-right">অ্যাকশন</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-xs text-gray-700">
          @forelse($stats as $stat)
            <tr class="hover:bg-gray-50/60 transition">
              <!-- Order -->
              <td class="py-3.5 px-4 text-center font-bold text-gray-500">
                <span class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-gray-100 text-gray-700 font-mono text-[11px]">
                  {{ $stat->order }}
                </span>
              </td>

              <!-- Icon Preview -->
              <td class="py-3.5 px-4">
                <div class="w-10 h-10 rounded-xl bg-red-50 text-[#c8102e] border border-red-100 flex items-center justify-center text-xl shadow-2xs">
                  @if(str_starts_with($stat->icon, 'fa'))
                    <i class="{{ $stat->icon }}"></i>
                  @elseif(str_starts_with($stat->icon, 'ri-'))
                    <i class="{{ $stat->icon }}"></i>
                  @else
                    <i class="ri-numbers-line"></i>
                  @endif
                </div>
                <span class="block text-[10px] text-gray-400 font-mono mt-1 max-w-[120px] truncate" title="{{ $stat->icon }}">{{ $stat->icon ?? 'ডিফল্ট' }}</span>
              </td>

              <!-- Count Number -->
              <td class="py-3.5 px-4">
                <span class="text-base sm:text-lg font-black text-gray-900 font-mono">
                  {{ $stat->count }}
                </span>
              </td>

              <!-- Title -->
              <td class="py-3.5 px-4">
                <div class="font-bold text-gray-800 text-sm">
                  {{ $stat->title }}
                </div>
                <span class="text-[11px] text-gray-400">হোমপেজ বারের দৃশ্যমান লেবেল</span>
              </td>

              <!-- Status Toggle Switch (AJAX) -->
              <td class="py-3.5 px-4 text-center">
                <label class="relative inline-flex items-center cursor-pointer select-none">
                  <input
                    type="checkbox"
                    class="sr-only peer"
                    {{ $stat->status ? 'checked' : '' }}
                    onchange="toggleStatStatus({{ $stat->id }}, this)"
                  >
                  <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0b4622]"></div>
                </label>
                <span id="status-label-{{ $stat->id }}" class="block text-[10px] font-semibold mt-1 {{ $stat->status ? 'text-emerald-700' : 'text-gray-400' }}">
                  {{ $stat->status ? 'সক্রিয় (ON)' : 'নিষ্ক্রিয় (OFF)' }}
                </span>
              </td>

              <!-- Actions -->
              <td class="py-3.5 px-4 text-right whitespace-nowrap">
                <div class="inline-flex items-center gap-1.5">
                  <!-- Edit Button -->
                  <a
                    href="{{ route('admin.stat-counters.edit', $stat) }}"
                    class="p-2 text-gray-600 hover:text-[#0b4622] hover:bg-[#0b4622]/10 rounded-lg transition"
                    title="সম্পাদনা করুন"
                  >
                    <i class="ri-edit-line text-base"></i>
                  </a>

                  <!-- Delete Button (Custom Modal) -->
                  <button
                    type="button"
                    onclick="openDeleteModal('{{ route('admin.stat-counters.destroy', $stat) }}', '{{ addslashes($stat->title) }}')"
                    class="p-2 text-gray-400 hover:text-[#c8102e] hover:bg-red-50 rounded-lg transition cursor-pointer"
                    title="মুছে ফেলুন"
                  >
                    <i class="ri-delete-bin-line text-base"></i>
                  </button>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="py-12 text-center text-gray-400">
                <i class="ri-inbox-line text-4xl block mb-2 text-gray-300"></i>
                <span class="text-sm">কোনো পরিসংখ্যান পাওয়া যায়নি।</span>
                <div class="mt-3">
                  <a href="{{ route('admin.stat-counters.create') }}" class="text-xs font-bold text-[#0b4622] hover:underline">
                    + নতুন পরিসংখ্যান যোগ করুন
                  </a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Custom Delete Confirmation Modal (NO native browser alert/confirm) -->
<div id="delete-modal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs flex items-center justify-center p-4 opacity-0 pointer-events-none transition-opacity duration-200">
  <div class="bg-white rounded-2xl max-w-sm w-full p-6 text-center shadow-2xl transform scale-95 transition-transform duration-200" id="delete-modal-card">
    <div class="w-12 h-12 rounded-full bg-red-100 text-[#c8102e] mx-auto flex items-center justify-center text-2xl mb-4">
      <i class="ri-alert-line"></i>
    </div>
    <h3 class="text-base font-bold text-gray-800 mb-1">আপনি কি নিশ্চিত?</h3>
    <p class="text-xs text-gray-500 mb-5 leading-relaxed">
      আপনি কি পরিসংখ্যান <strong id="delete-target-title" class="text-gray-800"></strong> চিরতরে মুছে ফেলতে চান? এটি হোমপেজ থেকে অপসারিত হবে।
    </p>

    <div class="flex items-center justify-center gap-3">
      <button
        type="button"
        onclick="closeDeleteModal()"
        class="px-4 py-2 text-xs font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition cursor-pointer"
      >
        বাতিল
      </button>
      <form id="delete-form" method="POST" action="" class="inline">
        @csrf
        @method('DELETE')
        <button
          type="submit"
          class="px-5 py-2 text-xs font-bold text-white bg-[#c8102e] hover:bg-[#a00c24] rounded-xl shadow-xs transition cursor-pointer"
        >
          হ্যাঁ, ডিলিট করুন
        </button>
      </form>
    </div>
  </div>
</div>

<!-- Dynamic Toast Container for AJAX status notification -->
<div id="ajax-toast" class="fixed bottom-5 right-5 z-50 flex items-center gap-2.5 px-4 py-3 bg-gray-900 text-white text-xs font-medium rounded-xl shadow-xl transform translate-y-12 opacity-0 transition-all duration-300 pointer-events-none">
  <i id="toast-icon" class="ri-checkbox-circle-fill text-emerald-400 text-base"></i>
  <span id="toast-message">স্ট্যাটাস সফলভাবে আপডেট হয়েছে</span>
</div>

<script>
// AJAX Status Toggle function
function toggleStatStatus(statId, checkboxEl) {
  const isChecked = checkboxEl.checked;
  const statusLabel = document.getElementById(`status-label-${statId}`);
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  // Disable switch temporarily during request
  checkboxEl.disabled = true;

  fetch(`/admin/stat-counters/${statId}/status`, {
    method: 'PATCH',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken,
      'Accept': 'application/json'
    },
    body: JSON.stringify({ status: isChecked ? 1 : 0 })
  })
  .then(response => {
    if (!response.ok) throw new Error('Network error');
    return response.json();
  })
  .then(data => {
    checkboxEl.disabled = false;
    if (data.status === 'success') {
      if (statusLabel) {
        statusLabel.textContent = isChecked ? 'সক্রিয় (ON)' : 'নিষ্ক্রিয় (OFF)';
        statusLabel.className = `block text-[10px] font-semibold mt-1 ${isChecked ? 'text-emerald-700' : 'text-gray-400'}`;
      }
      showToast(data.message || 'স্ট্যাটাস সফলভাবে আপডেট করা হয়েছে।', true);
    } else {
      // Revert if error
      checkboxEl.checked = !isChecked;
      showToast('স্ট্যাটাস আপডেট ব্যর্থ হয়েছে!', false);
    }
  })
  .catch(err => {
    console.error(err);
    checkboxEl.disabled = false;
    checkboxEl.checked = !isChecked;
    showToast('সার্ভার এরর! স্ট্যাটাস পরিবর্তন করা সম্ভব হয়নি।', false);
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

// Custom Modal Trigger logic (No browser window.confirm)
function openDeleteModal(actionUrl, statTitle) {
  const modal = document.getElementById('delete-modal');
  const card = document.getElementById('delete-modal-card');
  const form = document.getElementById('delete-form');
  const titleEl = document.getElementById('delete-target-title');

  form.action = actionUrl;
  titleEl.textContent = `"${statTitle}"`;

  modal.classList.remove('opacity-0', 'pointer-events-none');
  modal.classList.add('opacity-100');
  card.classList.remove('scale-95');
  card.classList.add('scale-100');
}

function closeDeleteModal() {
  const modal = document.getElementById('delete-modal');
  const card = document.getElementById('delete-modal-card');

  modal.classList.remove('opacity-100');
  modal.classList.add('opacity-0', 'pointer-events-none');
  card.classList.remove('scale-100');
  card.classList.add('scale-95');
}
</script>
@endsection

