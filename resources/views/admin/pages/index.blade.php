@extends('layouts.admin.admin-layout')

@section('title', 'পেজ ব্যবস্থাপনা')

@section('content')
<div class="space-y-6">

  <!-- Header / Breadcrumb -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
    <div>
      <div class="flex items-center gap-2 text-xs font-semibold text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <span>কন্টেন্ট ও ব্যবস্থাপনা</span>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <span class="text-[#0b4622]">পেজ তালিকা</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-900 flex items-center gap-2.5">
        <span class="w-10 h-10 rounded-xl bg-emerald-50 text-[#0b4622] flex items-center justify-center text-xl shrink-0">
          <i class="ri-pages-line"></i>
        </span>
        পেজ ব্যবস্থাপনা (Dynamic Pages)
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-1">
        ওয়েবসাইটের যেকোনো কাস্টম পেজ তৈরি, এডিট এবং পরিচালনা করুন।
      </p>
    </div>

    <a
      href="{{ route('admin.pages.create') }}"
      class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#0b4622] hover:bg-[#08351a] text-white text-xs sm:text-sm font-bold shadow-sm hover:shadow transition shrink-0 cursor-pointer"
    >
      <i class="ri-add-line text-lg"></i>
      <span>নতুন পেজ তৈরি করুন</span>
    </a>
  </div>

  @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-2">
      <i class="ri-checkbox-circle-fill text-emerald-600 text-lg"></i>
      {{ session('success') }}
    </div>
  @endif

  <!-- Filters & Search -->
  <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-xs">
    <form action="{{ route('admin.pages.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
      <!-- Search Input -->
      <div class="sm:col-span-2 relative">
        <input
          type="text"
          name="search"
          value="{{ request('search') }}"
          placeholder="পেজের নাম বা কন্টেন্ট দিয়ে খুঁজুন..."
          class="w-full pl-9 pr-4 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0b4622] text-xs sm:text-sm text-gray-800"
        />
        <i class="ri-search-line absolute left-3 top-2.5 text-gray-400 text-sm"></i>
      </div>

      <!-- Status Filter -->
      <div>
        <select
          name="status"
          onchange="this.form.submit()"
          class="w-full px-3 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0b4622] text-xs sm:text-sm text-gray-700"
        >
          <option value="">সকল পেজ</option>
          <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>সক্রিয়</option>
          <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>নিষ্ক্রিয়</option>
        </select>
      </div>
    </form>
  </div>

  <!-- Pages Table -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse text-xs sm:text-sm">
        <thead>
          <tr class="bg-gray-50/75 border-b border-gray-100 text-gray-600 uppercase text-[11px] font-extrabold tracking-wider">
            <th class="py-3.5 px-4">পেজের নাম / টাইটেল</th>
            <th class="py-3.5 px-4">অটো স্লাগ (URL Slug)</th>
            <th class="py-3.5 px-4 text-center">স্ট্যাটাস</th>
            <th class="py-3.5 px-4">তৈরির তারিখ</th>
            <th class="py-3.5 px-4 text-right">অ্যাকশন</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-gray-700">
          @forelse($pages as $p)
            <tr class="hover:bg-gray-50/60 transition">
              <!-- Title -->
              <td class="py-3.5 px-4 font-bold text-gray-900">
                <span class="text-sm font-extrabold text-gray-900">{{ $p->title }}</span>
              </td>

              <!-- Slug / Public URL -->
              <td class="py-3.5 px-4">
                <a
                  href="{{ route('custom-page.show', $p->slug) }}"
                  target="_blank"
                  class="inline-flex items-center gap-1 font-mono text-xs text-[#0b4622] hover:underline bg-emerald-50/70 px-2 py-1 rounded-lg border border-emerald-100"
                >
                  <span>/page/{{ $p->slug }}</span>
                  <i class="ri-external-link-line text-[11px]"></i>
                </a>
              </td>

              <!-- Status -->
              <td class="py-3.5 px-4 text-center">
                <button
                  type="button"
                  onclick="togglePageStatus({{ $p->id }}, this)"
                  class="cursor-pointer inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold transition {{ $p->status ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-500' }}"
                >
                  <span class="w-2 h-2 rounded-full {{ $p->status ? 'bg-emerald-600 animate-pulse' : 'bg-gray-400' }}"></span>
                  <span>{{ $p->status ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}</span>
                </button>
              </td>

              <!-- Created At -->
              <td class="py-3.5 px-4 text-gray-500 text-xs whitespace-nowrap">
                {{ $p->created_at->format('d M, Y') }}
              </td>

              <!-- Actions -->
              <td class="py-3.5 px-4 text-right">
                <div class="inline-flex items-center gap-1.5">
                  <a
                    href="{{ route('custom-page.show', $p->slug) }}"
                    target="_blank"
                    class="p-2 rounded-lg bg-gray-100 hover:bg-[#0b4622] hover:text-white text-gray-600 transition"
                    title="লাইভ দেখুন"
                  >
                    <i class="ri-eye-line text-base"></i>
                  </a>

                  <a
                    href="{{ route('admin.pages.edit', $p) }}"
                    class="p-2 rounded-lg bg-gray-100 hover:bg-[#0b4622] hover:text-white text-gray-600 transition"
                    title="সম্পাদনা করুন"
                  >
                    <i class="ri-edit-line text-base"></i>
                  </a>

                  <form action="{{ route('admin.pages.destroy', $p) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই পেজটি মুছে ফেলতে চান?');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button
                      type="submit"
                      class="p-2 rounded-lg bg-gray-100 hover:bg-red-600 hover:text-white text-red-500 transition cursor-pointer"
                      title="মুছে ফেলুন"
                    >
                      <i class="ri-delete-bin-line text-base"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="py-12 text-center text-gray-400">
                <i class="ri-pages-line text-4xl block mb-2 text-gray-300"></i>
                বর্তমানে কোনো পেজ যুক্ত করা হয়নি।
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($pages->hasPages())
      <div class="p-4 border-t border-gray-100">
        {{ $pages->links() }}
      </div>
    @endif
  </div>

</div>

<script>
function togglePageStatus(pageId, btn) {
  fetch(`/admin/pages/${pageId}/status`, {
    method: 'PATCH',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    }
  })
  .then(res => res.json())
  .then(data => {
    if(data.success) {
      if(data.status) {
        btn.className = "cursor-pointer inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold transition bg-emerald-100 text-emerald-800";
        btn.innerHTML = '<span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span><span>সক্রিয়</span>';
      } else {
        btn.className = "cursor-pointer inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold transition bg-gray-100 text-gray-500";
        btn.innerHTML = '<span class="w-2 h-2 rounded-full bg-gray-400"></span><span>নিষ্ক্রিয়</span>';
      }
    }
  })
  .catch(err => {
    console.error(err);
    alert('স্ট্যাটাস পরিবর্তন করতে সমস্যা হয়েছে!');
  });
}
</script>
@endsection

