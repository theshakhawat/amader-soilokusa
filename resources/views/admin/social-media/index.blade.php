@extends('layouts.admin.admin-layout')

@section('title', 'সোশ্যাল মিডিয়া লিংক ব্যবস্থাপনা — আগামীর শৈলকুপা')

@section('content')
<div class="max-w-6xl mx-auto space-y-7">

  <!-- Header Section -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <div class="inline-flex items-center gap-2 bg-emerald-50 text-[#0b4622] px-3 py-1 rounded-full text-xs font-bold mb-1 border border-emerald-100">
        <i class="ri-brush-3-line"></i>
        <span>কাস্টমাইজেশন হাব</span>
      </div>
      <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
        সোশ্যাল মিডিয়া লিংক ব্যবস্থাপনা
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
        ওয়েবসাইটের টপবার ও ফুটারের জন্য সোশ্যাল মিডিয়া প্ল্যাটফর্ম ও লিংক যোগ, এডিট ও নিয়ন্ত্রণ করুন।
      </p>
    </div>

    <!-- Create Button (Redirects to Create Page) -->
    <a
      href="{{ route('admin.social-media.create') }}"
      class="inline-flex items-center gap-2 bg-[#0b4622] hover:bg-[#083519] text-white text-xs sm:text-sm font-bold px-4 py-2.5 rounded-xl shadow-xs transition cursor-pointer self-start sm:self-auto"
    >
      <i class="ri-add-circle-line text-base"></i>
      <span>নতুন লিংক যোগ করুন</span>
    </a>
  </div>

  {{-- Success Alert --}}
  @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold flex items-center gap-2.5 shadow-2xs">
      <i class="ri-checkbox-circle-fill text-lg text-emerald-600"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <!-- Social Links Table Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)] overflow-hidden">
    <div class="p-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
      <div class="flex items-center gap-2.5">
        <span class="w-8 h-8 rounded-lg bg-emerald-50 text-[#0b4622] flex items-center justify-center text-sm font-bold">
          <i class="ri-share-line"></i>
        </span>
        <h3 class="text-sm font-extrabold text-gray-900">সংযুক্ত সোশ্যাল মিডিয়া তালিকা</h3>
      </div>
      <span class="text-xs font-bold text-gray-400">মোট: {{ $socialLinks->count() }}টি</span>
    </div>

    @if($socialLinks->isEmpty())
      <div class="p-12 text-center">
        <div class="w-16 h-16 rounded-full bg-emerald-50 text-[#0b4622] flex items-center justify-center text-2xl mx-auto mb-3">
          <i class="ri-share-forward-line"></i>
        </div>
        <h4 class="text-base font-bold text-gray-800">কোনো সোশ্যাল মিডিয়া লিংক নেই</h4>
        <p class="text-xs text-gray-500 mt-1 max-w-sm mx-auto">এখনো কোনো লিংক যুক্ত করা হয়নি। "নতুন লিংক যোগ করুন" বাটনে ক্লিক করে যুক্ত করুন।</p>
      </div>
    @else
      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs sm:text-sm">
          <thead class="bg-gray-50/70 text-gray-500 font-extrabold uppercase text-[11px] border-b border-gray-100">
            <tr>
              <th class="py-3.5 px-5">আইকন ও প্ল্যাটফর্ম</th>
              <th class="py-3.5 px-5">URL / লিংক</th>
              <th class="py-3.5 px-5">টার্গেট উইন্ডো</th>
              <th class="py-3.5 px-5 text-center">ক্রম (Order)</th>
              <th class="py-3.5 px-5 text-center">স্ট্যাটাস</th>
              <th class="py-3.5 px-5 text-right">অ্যাকশন</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100 text-gray-700">
            @foreach($socialLinks as $link)
              <tr class="hover:bg-gray-50/60 transition">
                <!-- Icon & Platform -->
                <td class="py-3.5 px-5">
                  <div class="flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-gray-100 border border-gray-200 text-gray-800 flex items-center justify-center text-base shrink-0 shadow-2xs">
                      <i class="{{ $link->icon }}"></i>
                    </span>
                    <div>
                      <p class="font-extrabold text-gray-900 leading-tight">{{ $link->platform }}</p>
                      <p class="text-[10px] text-gray-400 font-mono mt-0.5">{{ $link->icon }}</p>
                    </div>
                  </div>
                </td>

                <!-- URL -->
                <td class="py-3.5 px-5 max-w-xs">
                  <a
                    href="{{ $link->url }}"
                    target="_blank"
                    class="text-xs font-semibold text-emerald-800 hover:text-[#0b4622] hover:underline flex items-center gap-1.5 truncate"
                  >
                    <span class="truncate">{{ $link->url }}</span>
                    <i class="ri-external-link-line text-xs shrink-0 text-gray-400"></i>
                  </a>
                </td>

                <!-- Target -->
                <td class="py-3.5 px-5">
                  @if($link->target === '_blank')
                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                      <i class="ri-window-line"></i>
                      <span>নতুন ট্যাব (New Tab)</span>
                    </span>
                  @else
                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-gray-600 bg-gray-100 px-2.5 py-1 rounded-full">
                      <i class="ri-checkbox-blank-line"></i>
                      <span>কারেন্ট পেজ (Same Tab)</span>
                    </span>
                  @endif
                </td>

                <!-- Order -->
                <td class="py-3.5 px-5 text-center font-bold text-gray-700">
                  {{ $link->order }}
                </td>

                <!-- Status (AJAX Toggle Switch) -->
                <td class="py-3.5 px-5 text-center">
                  <label class="relative inline-flex items-center cursor-pointer select-none">
                    <input
                      type="checkbox"
                      class="sr-only peer"
                      {{ $link->is_active ? 'checked' : '' }}
                      onchange="toggleSocialStatus({{ $link->id }}, this)"
                    >
                    <div class="w-10 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#0b4622]"></div>
                  </label>
                  <span id="status-label-{{ $link->id }}" class="block text-[10px] font-semibold mt-0.5 {{ $link->is_active ? 'text-emerald-700' : 'text-gray-400' }}">
                    {{ $link->is_active ? 'সক্রিয় (ON)' : 'নিষ্ক্রিয় (OFF)' }}
                  </span>
                </td>

                <!-- Actions (Redirects to Edit Page & Triggers Custom Delete Modal) -->
                <td class="py-3.5 px-5 text-right">
                  <div class="inline-flex items-center gap-1.5">
                    <!-- Edit Page Link -->
                    <a
                      href="{{ route('admin.social-media.edit', $link->id) }}"
                      title="সম্পাদনা করুন"
                      class="w-8 h-8 rounded-lg border border-gray-200 text-gray-600 hover:text-[#0b4622] hover:bg-emerald-50 hover:border-emerald-200 flex items-center justify-center transition"
                    >
                      <i class="ri-edit-line text-sm"></i>
                    </a>

                    <!-- Custom Delete Modal Trigger -->
                    <button
                      type="button"
                      onclick="openDeleteModal({{ $link->id }}, '{{ $link->platform }}')"
                      title="মুছে ফেলুন"
                      class="w-8 h-8 rounded-lg border border-gray-200 text-gray-600 hover:text-[#c8102e] hover:bg-red-50 hover:border-red-200 flex items-center justify-center transition cursor-pointer"
                    >
                      <i class="ri-delete-bin-line text-sm"></i>
                    </button>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>

</div>

<!-- =====================================================================
     CUSTOM DELETE CONFIRMATION MODAL (No Native Browser Prompt)
     ===================================================================== -->
<div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4 backdrop-blur-2xs transition-opacity">
  <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl border border-gray-100 animate-fadeIn text-center">
    
    <div class="w-14 h-14 rounded-2xl bg-red-50 text-[#c8102e] border border-red-100 flex items-center justify-center text-2xl mx-auto mb-3.5 shadow-2xs">
      <i class="ri-delete-bin-line"></i>
    </div>

    <h3 class="text-base font-extrabold text-gray-900 leading-snug">
      আপনি কি নিশ্চিত?
    </h3>
    <p class="text-xs text-gray-500 mt-1.5 leading-relaxed">
      আপনি <span id="delete-item-title" class="font-bold text-gray-800"></span> সোশ্যাল মিডিয়া লিঙ্কটি মুছে ফেলতে যাচ্ছেন। এটি স্থায়ীভাবে মুছে যাবে।
    </p>

    <!-- Delete Form -->
    <form id="delete-form" method="POST" class="mt-5 flex items-center justify-center gap-2.5">
      @csrf
      @method('DELETE')
      <button
        type="button"
        onclick="closeDeleteModal()"
        class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 text-xs font-bold transition cursor-pointer"
      >
        না, বাতিল করুন
      </button>
      <button
        type="submit"
        class="flex-1 px-4 py-2.5 rounded-xl bg-[#c8102e] hover:bg-[#a30b24] text-white text-xs font-bold shadow-xs transition cursor-pointer"
      >
        হ্যাঁ, মুছে ফেলুন
      </button>
    </form>

  </div>
</div>
<!-- Dynamic Toast Container for AJAX status notification (Bottom Right) -->
<div id="ajax-toast" class="fixed bottom-5 right-5 z-50 flex items-center gap-2.5 px-4 py-3 bg-gray-900 text-white text-xs font-medium rounded-xl shadow-xl transform translate-y-12 opacity-0 transition-all duration-300 pointer-events-none">
  <i id="toast-icon" class="ri-checkbox-circle-fill text-emerald-400 text-base"></i>
  <span id="toast-message">স্ট্যাটাস সফলভাবে আপডেট হয়েছে</span>
</div>

@endsection

@push('scripts')
<script>
  function toggleSocialStatus(id, checkboxEl) {
    const isChecked = checkboxEl.checked;
    const statusLabel = document.getElementById(`status-label-${id}`);
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    checkboxEl.disabled = true;

    fetch(`/admin/social-media/${id}/status`, {
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
          statusLabel.className = `block text-[10px] font-semibold mt-0.5 ${isChecked ? 'text-emerald-700' : 'text-gray-400'}`;
        }
        showToast(data.message || 'স্ট্যাটাস সফলভাবে পরিবর্তন হয়েছে।', true);
      } else {
        checkboxEl.checked = !isChecked;
        showToast('স্ট্যাটাস পরিবর্তন করা সম্ভব হয়নি!', false);
      }
    })
    .catch(err => {
      console.error(err);
      checkboxEl.disabled = false;
      checkboxEl.checked = !isChecked;
      showToast('সার্ভার এরর! স্ট্যাটাস পরিবর্তন ব্যর্থ হয়েছে।', false);
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

  function openDeleteModal(id, platform) {
    const modal = document.getElementById('delete-modal');
    const form = document.getElementById('delete-form');
    const title = document.getElementById('delete-item-title');

    form.action = `/admin/social-media/${id}`;
    title.textContent = `"${platform}"`;

    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }

  function closeDeleteModal() {
    const modal = document.getElementById('delete-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeDeleteModal();
  });
</script>
@endpush

