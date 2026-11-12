@extends('layouts.admin.admin-layout')

@section('title', 'কৃতি সন্তান তালিকা | আগামী শৈলকুপা')

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
        <span class="text-[#0b4622] font-semibold">কৃতি সন্তান</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-800 tracking-tight flex items-center gap-2">
        <i class="ri-award-fill text-[#0b4622]"></i>
        <span>কৃতি সন্তান তালিকা (Our Pride)</span>
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-0.5">শৈলকুপার বিশিষ্ট ও কৃতি ব্যক্তিত্বদের নাম, পদবি, ছবি ও জীবনী পরিচালনা করুন।</p>
    </div>

    <div class="flex items-center gap-2.5">
      <a
        href="{{ route('admin.prides.create') }}"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-xs transition"
      >
        <i class="ri-add-line text-sm"></i>
        <span>নতুন কৃতি সন্তান যোগ করুন</span>
      </a>
      <a
        href="{{ route('our.pride') }}"
        target="_blank"
        class="inline-flex items-center gap-2 px-3.5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition"
      >
        <i class="ri-external-link-line"></i>
        <span>লাইভ পেজ দেখুন</span>
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
        href="{{ route('admin.prides.index') }}"
        class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ !request()->filled('status') ? 'bg-[#0b4622] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
      >
        সবগুলো ({{ \App\Models\Pride::count() }})
      </a>
      <a
        href="{{ route('admin.prides.index', ['status' => '1']) }}"
        class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === '1' ? 'bg-[#0b4622] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
      >
        সক্রিয়
      </a>
      <a
        href="{{ route('admin.prides.index', ['status' => '0']) }}"
        class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === '0' ? 'bg-[#0b4622] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
      >
        নিষ্ক্রিয়
      </a>
    </div>

    <!-- Search Form -->
    <form action="{{ route('admin.prides.index') }}" method="GET" class="w-full sm:w-72">
      <div class="relative">
        <input
          type="text"
          name="search"
          value="{{ request('search') }}"
          placeholder="নাম বা পদবি দিয়ে খুঁজুন..."
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
            <th class="py-3.5 px-4 text-center w-16">ক্রম</th>
            <th class="py-3.5 px-4">ছবি</th>
            <th class="py-3.5 px-4">নাম ও পরিচয়</th>
            <th class="py-3.5 px-4">পদবি</th>
            <th class="py-3.5 px-4 text-center">স্ট্যাটাস</th>
            <th class="py-3.5 px-4 text-right">অ্যাকশন</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-xs text-gray-700">
          @forelse($prides as $pride)
            <tr class="hover:bg-gray-50/50 transition">
              <!-- Order -->
              <td class="py-3 px-4 text-center">
                @if($pride->order_index == 1)
                  <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-300">
                    <i class="ri-vip-crown-fill text-amber-500"></i> #১ (শীর্ষ)
                  </span>
                @else
                  <span class="font-bold text-gray-500">#{{ $pride->order_index }}</span>
                @endif
              </td>

              <!-- Photo -->
              <td class="py-3 px-4">
                <div class="w-12 h-12 rounded-xl bg-gray-100 overflow-hidden border border-gray-200 shadow-2xs">
                  <img
                    src="{{ $pride->photo_url }}"
                    alt="{{ $pride->name }}"
                    class="w-full h-full object-cover"
                    onerror="this.src='https://placehold.co/100x100/0b4622/ffffff?text={{ urlencode($pride->name) }}'"
                  >
                </div>
              </td>

              <!-- Name -->
              <td class="py-3 px-4">
                <div class="font-bold text-gray-900 line-clamp-1">{{ $pride->name }}</div>
                <div class="text-[11px] text-gray-400 mt-0.5">আইডি: #{{ $pride->id }}</div>
              </td>

              <!-- Designation -->
              <td class="py-3 px-4">
                <span class="font-semibold text-gray-700 line-clamp-1 max-w-xs">{{ $pride->designation }}</span>
              </td>

              <!-- Status Toggle -->
              <td class="py-3 px-4 text-center">
                <label class="relative inline-flex items-center cursor-pointer">
                  <input
                    type="checkbox"
                    class="sr-only peer"
                    onchange="togglePrideStatus({{ $pride->id }})"
                    {{ $pride->status ? 'checked' : '' }}
                  >
                  <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0b4622]"></div>
                </label>
              </td>

              <!-- Actions -->
              <td class="py-3 px-4 text-right whitespace-nowrap">
                <div class="flex items-center justify-end gap-1.5">
                  <a
                    href="{{ route('admin.prides.edit', $pride->id) }}"
                    class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition"
                    title="সম্পাদনা করুন"
                  >
                    <i class="ri-edit-line text-sm"></i>
                  </a>

                  <form action="{{ route('admin.prides.destroy', $pride->id) }}" method="POST" class="inline-block" onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই তথ্যটি মুছে ফেলতে চান?');">
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
                <i class="ri-user-star-line text-3xl text-gray-300 block mb-2"></i>
                কোনো কৃতি সন্তানের তথ্য পাওয়া যায়নি। নতুন ব্যক্তি যোগ করতে উপরের বাটনে ক্লিক করুন।
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($prides->hasPages())
      <div class="p-4 border-t border-gray-100">
        {{ $prides->links() }}
      </div>
    @endif
  </div>
</div>

<script>
function togglePrideStatus(prideId) {
  fetch(`/admin/prides/${prideId}/status`, {
    method: 'PATCH',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'Accept': 'application/json'
    }
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

