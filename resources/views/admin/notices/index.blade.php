@extends('layouts.admin.admin-layout')

@section('title', 'নোটিশ ও বিজ্ঞপ্তি তালিকা | আগামী শৈলকুপা')

@section('content')
<div class="space-y-6">
  <!-- Top Bar -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
    <div>
      <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622] transition">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <span>কন্টেন্ট ও ব্যবস্থাপনা</span>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <span class="text-[#0b4622] font-semibold">নোটিশ ও বিজ্ঞপ্তি</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-800 tracking-tight flex items-center gap-2">
        <i class="ri-megaphone-line text-[#0b4622]"></i>
        <span>নোটিশ ও বিজ্ঞপ্তি তালিকা (Notices)</span>
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-0.5">হোমপেজে প্রদর্শিত নোটিশ ও অফিসিয়াল সার্কুলার ফাইলসহ পরিচালনা করুন।</p>
    </div>

    <div class="flex items-center gap-2.5">
      <a
        href="{{ route('admin.notices.create') }}"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-xs transition"
      >
        <i class="ri-add-line text-sm"></i>
        <span>নতুন নোটিশ যোগ করুন</span>
      </a>
      <a
        href="{{ route('home') }}#notice-section"
        target="_blank"
        class="inline-flex items-center gap-2 px-3.5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition"
      >
        <i class="ri-external-link-line"></i>
        <span>হোমপেজে দেখুন</span>
      </a>
    </div>
  </div>

  <!-- Success Notification Alert -->
  @if(session('success'))
    <div id="flash-alert" class="flex items-center justify-between p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-xs font-semibold">
      <div class="flex items-center gap-2.5">
        <i class="ri-checkbox-circle-fill text-emerald-600 text-lg"></i>
        <span>{{ session('success') }}</span>
      </div>
      <button type="button" onclick="document.getElementById('flash-alert').remove()" class="text-emerald-600 hover:text-emerald-800 cursor-pointer">
        <i class="ri-close-line text-base"></i>
      </button>
    </div>
  @endif

  <!-- Filter & Search Toolbar -->
  <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-3">
    <div class="flex items-center gap-2 w-full sm:w-auto">
      <a
        href="{{ route('admin.notices.index') }}"
        class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ !request()->filled('status') ? 'bg-[#0b4622] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
      >
        সবগুলো ({{ \App\Models\Notice::count() }})
      </a>
      <a
        href="{{ route('admin.notices.index', ['status' => 'active']) }}"
        class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === 'active' ? 'bg-[#0b4622] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
      >
        সক্রিয়
      </a>
      <a
        href="{{ route('admin.notices.index', ['status' => 'pinned']) }}"
        class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === 'pinned' ? 'bg-[#0b4622] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
      >
        জরুরি (Pinned)
      </a>
      <a
        href="{{ route('admin.notices.index', ['status' => 'inactive']) }}"
        class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === 'inactive' ? 'bg-[#0b4622] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
      >
        নিষ্ক্রিয়
      </a>
    </div>

    <!-- Search Form -->
    <form action="{{ route('admin.notices.index') }}" method="GET" class="w-full sm:w-72">
      <div class="relative">
        <input
          type="text"
          name="search"
          value="{{ request('search') }}"
          placeholder="নোটিশের শিরোনাম দিয়ে খুঁজুন..."
          class="w-full pl-9 pr-4 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
        >
        <i class="ri-search-line absolute left-3 top-2.5 text-gray-400 text-xs"></i>
      </div>
    </form>
  </div>

  <!-- Table Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-gray-50/70 border-b border-gray-100 text-[11px] font-bold text-gray-500 uppercase tracking-wider">
            <th class="py-3.5 px-4 text-center w-14">ক্রম</th>
            <th class="py-3.5 px-4">নোটিশ শিরোনাম</th>
            <th class="py-3.5 px-4">প্রকাশের তারিখ</th>
            <th class="py-3.5 px-4 text-center">সংযুক্ত ফাইল</th>
            <th class="py-3.5 px-4 text-center">স্ট্যাটাস</th>
            <th class="py-3.5 px-4 text-right">অ্যাকশন</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-xs text-gray-700">
          @forelse($notices as $notice)
            <tr class="hover:bg-gray-50/50 transition">
              <!-- Order -->
              <td class="py-3 px-4 text-center font-bold text-gray-400">
                #{{ $notice->order_index }}
              </td>

              <!-- Title -->
              <td class="py-3 px-4">
                <div class="flex items-center gap-2">
                  @if($notice->status === 'pinned')
                    <span class="text-[10px] font-bold text-red-600 bg-red-50 px-1.5 py-0.5 rounded border border-red-200 shrink-0">
                      জরুরি
                    </span>
                  @endif
                  <span class="font-bold text-gray-900 line-clamp-1 max-w-md">{{ $notice->title }}</span>
                </div>
                <div class="text-[11px] text-gray-400 mt-0.5">আইডি: #{{ $notice->id }}</div>
              </td>

              <!-- Date -->
              <td class="py-3 px-4 whitespace-nowrap">
                @if($notice->date)
                  <div class="font-semibold text-gray-800 flex items-center gap-1.5">
                    <i class="ri-calendar-line text-[#c8102e]"></i>
                    {{ $notice->bangla_formatted_date }}
                  </div>
                @else
                  <span class="text-gray-400 italic">—</span>
                @endif
              </td>

              <!-- File Count -->
              <td class="py-3 px-4 text-center">
                @if($notice->files->count() > 0)
                  <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                    <i class="ri-attachment-line"></i>
                    {{ $notice->files->count() }}টি ফাইল
                  </span>
                @else
                  <span class="text-gray-400 text-[11px]">নেই</span>
                @endif
              </td>

              <!-- Status Switch -->
              <td class="py-3 px-4 text-center">
                <label class="relative inline-flex items-center cursor-pointer">
                  <input
                    type="checkbox"
                    class="sr-only peer"
                    onchange="toggleNoticeStatus({{ $notice->id }}, this.checked)"
                    {{ in_array($notice->status, ['active', 'pinned']) ? 'checked' : '' }}
                  >
                  <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0b4622]"></div>
                </label>
              </td>

              <!-- Actions -->
              <td class="py-3 px-4 text-right whitespace-nowrap">
                <div class="flex items-center justify-end gap-1.5">
                  <a
                    href="{{ route('notices.details', $notice->id) }}"
                    target="_blank"
                    class="p-2 text-gray-400 hover:text-[#0b4622] hover:bg-emerald-50 rounded-lg transition"
                    title="লাইভ প্রিভিউ"
                  >
                    <i class="ri-external-link-line text-sm"></i>
                  </a>

                  <a
                    href="{{ route('admin.notices.edit', $notice->id) }}"
                    class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition"
                    title="সম্পাদনা করুন"
                  >
                    <i class="ri-edit-line text-sm"></i>
                  </a>

                  <form action="{{ route('admin.notices.destroy', $notice->id) }}" method="POST" class="inline-block" onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই নোটিশটি মুছে ফেলতে চান?');">
                    @csrf
                    @method('DELETE')
                    <button
                      type="submit"
                      class="p-2 text-gray-400 hover:text-[#c8102e] hover:bg-red-50 rounded-lg transition cursor-pointer"
                      title="মুছে ফেলুন"
                    >
                      <i class="ri-delete-bin-line text-sm"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="py-12 text-center text-gray-400 text-xs">
                <i class="ri-megaphone-line text-3xl text-gray-300 block mb-2"></i>
                কোনো নোটিশ পাওয়া যায়নি। নতুন নোটিশ যোগ করতে উপরের বাটনে ক্লিক করুন।
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($notices->hasPages())
      <div class="p-4 border-t border-gray-100">
        {{ $notices->links() }}
      </div>
    @endif
  </div>
</div>

<script>
function toggleNoticeStatus(noticeId, isChecked) {
  fetch(`/admin/notices/${noticeId}/status`, {
    method: 'PATCH',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'Accept': 'application/json'
    },
    body: JSON.stringify({
      status: isChecked ? 'active' : 'inactive'
    })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      if (typeof showToast === 'function') {
        showToast(data.message, 'success');
      }
    }
  })
  .catch(err => {
    console.error(err);
    alert('স্ট্যাটাস পরিবর্তন করা সম্ভব হয়নি।');
  });
}
</script>
@endsection

