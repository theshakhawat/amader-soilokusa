@extends('layouts.admin.admin-layout')

@section('title', 'হিরো ব্যানার স্লাইডার ব্যবস্থাপনা — আগামীর শৈলকুপা')

@section('content')
<div class="max-w-6xl mx-auto space-y-7">

  <!-- Header Section -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <div class="inline-flex items-center gap-2 bg-emerald-50 text-[#0b4622] px-3 py-1 rounded-full text-xs font-bold mb-1 border border-emerald-100">
        <i class="ri-slideshow-3-line"></i>
        <span>কাস্টমাইজেশন হাব</span>
      </div>
      <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
        হিরো ব্যানার স্লাইডার ব্যবস্থাপনা
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
        হোমপেজের মূল ব্যানার স্লাইডারের ছবি, টেক্সট, বাটন ও স্ট্যাটাস (On/Off) পরিচালনা করুন।
      </p>
    </div>

    <!-- Create Button -->
    <a
      href="{{ route('admin.hero-banners.create') }}"
      class="inline-flex items-center gap-2 bg-[#0b4622] hover:bg-[#083519] text-white text-xs sm:text-sm font-bold px-4 py-2.5 rounded-xl shadow-xs transition cursor-pointer self-start sm:self-auto"
    >
      <i class="ri-add-circle-line text-base"></i>
      <span>নতুন ব্যানার যোগ করুন</span>
    </a>
  </div>

  {{-- Success Alert --}}
  @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold flex items-center gap-2.5 shadow-2xs">
      <i class="ri-checkbox-circle-fill text-lg text-emerald-600"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <!-- Banners Table Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)] overflow-hidden">
    <div class="p-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
      <div class="flex items-center gap-2.5">
        <span class="w-8 h-8 rounded-lg bg-emerald-50 text-[#0b4622] flex items-center justify-center text-sm font-bold">
          <i class="ri-image-line"></i>
        </span>
        <h3 class="text-sm font-extrabold text-gray-900">স্লাইডার ব্যানারের তালিকা</h3>
      </div>
      <span class="text-xs font-bold text-gray-400">মোট: {{ $banners->count() }}টি</span>
    </div>

    @if($banners->isEmpty())
      <div class="p-12 text-center">
        <div class="w-16 h-16 rounded-full bg-emerald-50 text-[#0b4622] flex items-center justify-center text-2xl mx-auto mb-3">
          <i class="ri-image-add-line"></i>
        </div>
        <h4 class="text-base font-bold text-gray-800">কোনো ব্যানার নেই</h4>
        <p class="text-xs text-gray-500 mt-1 max-w-sm mx-auto">এখনো কোনো হিরো ব্যানার তৈরি করা হয়নি। "নতুন ব্যানার যোগ করুন" বাটনে ক্লিক করে যুক্ত করুন।</p>
      </div>
    @else
      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs sm:text-sm">
          <thead class="bg-gray-50/70 text-gray-500 font-extrabold uppercase text-[11px] border-b border-gray-100">
            <tr>
              <th class="py-3.5 px-5">ব্যানার ও ছবি</th>
              <th class="py-3.5 px-5">শিরোনাম ও বিবরণ</th>
              <th class="py-3.5 px-5">বাটনসমূহ (Buttons)</th>
              <th class="py-3.5 px-5 text-center">ক্রম (Order)</th>
              <th class="py-3.5 px-5 text-center">স্ট্যাটাস (AJAX Switch)</th>
              <th class="py-3.5 px-5 text-right">অ্যাকশন</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100 text-gray-700">
            @foreach($banners as $banner)
              <tr class="hover:bg-gray-50/60 transition">
                <!-- Image Preview -->
                <td class="py-3.5 px-5">
                  <div class="w-20 sm:w-24 h-12 sm:h-14 rounded-xl overflow-hidden border border-gray-200 bg-gray-100 shadow-2xs shrink-0 relative group">
                    <img
                      src="{{ $banner->image_url }}"
                      alt="{{ $banner->title }}"
                      class="w-full h-full object-cover group-hover:scale-105 transition"
                    />
                  </div>
                </td>

                <!-- Title & Subtitle -->
                <td class="py-3.5 px-5 max-w-xs">
                  <div class="space-y-1">
                    @if($banner->badge)
                      <span class="inline-block text-[10px] font-extrabold px-2 py-0.5 rounded-full bg-emerald-50 text-[#0b4622] border border-emerald-100">
                        {{ $banner->badge }}
                      </span>
                    @endif
                    <p class="font-extrabold text-gray-900 leading-tight">{{ $banner->title }}</p>
                    <p class="text-[11px] text-gray-500 line-clamp-2 leading-relaxed">{{ $banner->subtitle }}</p>
                  </div>
                </td>

                <!-- Buttons -->
                <td class="py-3.5 px-5">
                  <div class="space-y-1 text-xs">
                    <span class="inline-flex items-center gap-1 font-semibold text-gray-800 bg-gray-100 px-2.5 py-0.5 rounded-md">
                      <span class="text-[#c8102e] font-bold">1:</span> {{ $banner->primary_button_text }}
                    </span>
                    @if($banner->secondary_button_text)
                      <br>
                      <span class="inline-flex items-center gap-1 font-semibold text-gray-600 bg-gray-50 px-2.5 py-0.5 rounded-md border border-gray-100">
                        <span class="text-[#0b4622] font-bold">2:</span> {{ $banner->secondary_button_text }}
                      </span>
                    @endif
                  </div>
                </td>

                <!-- Order -->
                <td class="py-3.5 px-5 text-center font-bold text-gray-800">
                  {{ $banner->order }}
                </td>

                <!-- Status On/Off Toggle Switch (AJAX) -->
                <td class="py-3.5 px-5 text-center">
                  <label class="relative inline-flex items-center cursor-pointer select-none">
                    <input
                      type="checkbox"
                      value="1"
                      {{ $banner->status ? 'checked' : '' }}
                      onchange="toggleBannerStatus({{ $banner->id }}, this)"
                      class="sr-only peer"
                    />
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0b4622]"></div>
                    <span class="ml-2 text-xs font-bold status-label {{ $banner->status ? 'text-[#0b4622]' : 'text-gray-400' }}">
                      {{ $banner->status ? 'ON' : 'OFF' }}
                    </span>
                  </label>
                </td>

                <!-- Actions -->
                <td class="py-3.5 px-5 text-right">
                  <div class="inline-flex items-center gap-1.5">
                    <a
                      href="{{ route('admin.hero-banners.edit', $banner->id) }}"
                      title="সম্পাদনা করুন"
                      class="w-8 h-8 rounded-lg border border-gray-200 text-gray-600 hover:text-[#0b4622] hover:bg-emerald-50 hover:border-emerald-200 flex items-center justify-center transition"
                    >
                      <i class="ri-edit-line text-sm"></i>
                    </a>

                    <!-- Custom Delete Modal Trigger -->
                    <button
                      type="button"
                      onclick="openDeleteModal({{ $banner->id }}, '{{ $banner->title }}')"
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

<!-- Custom Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4 backdrop-blur-2xs transition-opacity">
  <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl border border-gray-100 animate-fadeIn text-center">
    <div class="w-14 h-14 rounded-2xl bg-red-50 text-[#c8102e] border border-red-100 flex items-center justify-center text-2xl mx-auto mb-3.5 shadow-2xs">
      <i class="ri-delete-bin-line"></i>
    </div>
    <h3 class="text-base font-extrabold text-gray-900 leading-snug">
      ব্যানারটি মুছে ফেলতে চান?
    </h3>
    <p class="text-xs text-gray-500 mt-1.5 leading-relaxed">
      আপনি <span id="delete-item-title" class="font-bold text-gray-800"></span> ব্যানারটি ডিলিট করতে চলেছেন।
    </p>

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
@endsection

@push('scripts')
<script>
  function openDeleteModal(id, title) {
    const modal = document.getElementById('delete-modal');
    const form = document.getElementById('delete-form');
    form.action = `/admin/hero-banners/${id}`;
    document.getElementById('delete-item-title').textContent = `"${title}"`;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }

  function closeDeleteModal() {
    const modal = document.getElementById('delete-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }

  // AJAX Status Switch
  function toggleBannerStatus(bannerId, checkboxEl) {
    const isChecked = checkboxEl.checked;
    const labelSpan = checkboxEl.parentElement.querySelector('.status-label');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    fetch(`/admin/hero-banners/${bannerId}/status`, {
      method: 'PATCH',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken || '',
        'Accept': 'application/json'
      },
      body: JSON.stringify({ status: isChecked })
    })
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success') {
        if (labelSpan) {
          labelSpan.textContent = isChecked ? 'ON' : 'OFF';
          labelSpan.className = `ml-2 text-xs font-bold status-label ${isChecked ? 'text-[#0b4622]' : 'text-gray-400'}`;
        }
        if (typeof showToast === 'function') {
          showToast(data.message, 'success');
        }
      } else {
        checkboxEl.checked = !isChecked;
        if (typeof showToast === 'function') {
          showToast('স্ট্যাটাস আপডেট ব্যর্থ হয়েছে।', 'error');
        }
      }
    })
    .catch(err => {
      checkboxEl.checked = !isChecked;
      if (typeof showToast === 'function') {
        showToast('সার্ভারে সমস্যা হয়েছে।', 'error');
      }
    });
  }

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeDeleteModal();
  });
</script>
@endpush

