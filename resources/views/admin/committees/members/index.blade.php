@extends('layouts.admin.admin-layout')

@section('title', 'কমিটি সদস্য তালিকা')

@section('content')
<div class="space-y-6">
  <!-- Header / Breadcrumb -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
    <div>
      <div class="flex items-center gap-2 text-xs font-semibold text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <a href="{{ route('admin.committees.index') }}" class="hover:text-[#0b4622]">কমিটি</a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <span class="text-[#0b4622]">সদস্য তালিকা</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-900 flex items-center gap-2.5">
        <span class="w-10 h-10 rounded-xl bg-emerald-50 text-[#0b4622] flex items-center justify-center text-xl shrink-0">
          <i class="ri-user-settings-line"></i>
        </span>
        কমিটি সদস্য ব্যবস্থাপনা
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-1">
        কমিটির সদস্যদের নাম, পদবী, ছবি, প্রদর্শনের ক্রম (Order ১ = সভাপতি, ২, ৩ = দ্বিতীয় রো) এবং স্ট্যাটাস পরিচালনা করুন।
      </p>
    </div>

    <div class="flex items-center gap-2.5 flex-wrap">
      <a
        href="{{ route('committee.index') }}"
        target="_blank"
        class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl border border-gray-200 text-gray-700 hover:text-[#0b4622] hover:bg-gray-50 text-xs sm:text-sm font-bold transition"
      >
        <i class="ri-external-link-line"></i>
        <span>লাইভ পেজ দেখুন</span>
      </a>

      <a
        href="{{ route('admin.committee-members.create') }}"
        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#0b4622] hover:bg-[#08351a] text-white text-xs sm:text-sm font-bold shadow-sm hover:shadow transition shrink-0 cursor-pointer"
      >
        <i class="ri-add-line text-lg"></i>
        <span>নতুন সদস্য যুক্ত করুন</span>
      </a>
    </div>
  </div>

  @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-2">
      <i class="ri-checkbox-circle-fill text-emerald-600 text-lg"></i>
      {{ session('success') }}
    </div>
  @endif

  <!-- Filters & Search -->
  <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-xs">
    <form action="{{ route('admin.committee-members.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
      <!-- Search -->
      <div class="sm:col-span-2 relative">
        <input
          type="text"
          name="search"
          value="{{ request('search') }}"
          placeholder="সদস্যের নাম বা পদবী দিয়ে খুঁজুন..."
          class="w-full pl-9 pr-4 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0b4622] text-xs sm:text-sm"
        />
        <i class="ri-search-line absolute left-3 top-2.5 text-gray-400 text-sm"></i>
      </div>

      <!-- Committee Filter -->
      <div>
        <select
          name="committee_id"
          onchange="this.form.submit()"
          class="w-full px-3 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0b4622] text-xs sm:text-sm text-gray-700"
        >
          <option value="">সকল কমিটি</option>
          @foreach($committees as $c)
            <option value="{{ $c->id }}" {{ request('committee_id') == $c->id ? 'selected' : '' }}>
              {{ $c->name }} ({{ $c->session_duration }})
            </option>
          @endforeach
        </select>
      </div>

      <!-- Status Filter -->
      <div>
        <select
          name="status"
          onchange="this.form.submit()"
          class="w-full px-3 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0b4622] text-xs sm:text-sm text-gray-700"
        >
          <option value="">সকল স্ট্যাটাস</option>
          <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>সক্রিয়</option>
          <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>নিষ্ক্রিয়</option>
        </select>
      </div>
    </form>
  </div>

  <!-- Table -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse text-xs sm:text-sm">
        <thead>
          <tr class="bg-gray-50/75 border-b border-gray-100 text-gray-600 uppercase text-[11px] font-extrabold tracking-wider">
            <th class="py-3.5 px-4 text-center">ক্রম (Order)</th>
            <th class="py-3.5 px-4">ছবি</th>
            <th class="py-3.5 px-4">সদস্যের নাম</th>
            <th class="py-3.5 px-4">পদবী (Title)</th>
            <th class="py-3.5 px-4">কমিটি</th>
            <th class="py-3.5 px-4 text-center">স্ট্যাটাস</th>
            <th class="py-3.5 px-4 text-right">অ্যাকশন</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-gray-700">
          @forelse($members as $m)
            <tr class="hover:bg-gray-50/60 transition">
              <!-- Order badge -->
              <td class="py-3.5 px-4 text-center">
                @if($m->order === 1)
                  <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-amber-100 text-amber-800 font-extrabold text-xs shadow-2xs" title="১ম রো (সভাপতি)">
                    1
                  </span>
                @elseif($m->order === 2 || $m->order === 3)
                  <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-blue-100 text-blue-800 font-extrabold text-xs shadow-2xs" title="২য় রো (২ জন)">
                    {{ $m->order }}
                  </span>
                @else
                  <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-gray-100 text-gray-700 font-bold text-xs">
                    {{ $m->order }}
                  </span>
                @endif
              </td>

              <!-- Photo -->
              <td class="py-3.5 px-4">
                <div class="w-11 h-11 rounded-full overflow-hidden border border-gray-200 shadow-2xs bg-gray-100 shrink-0">
                  <img src="{{ $m->photo_url }}" alt="{{ $m->name }}" class="w-full h-full object-cover">
                </div>
              </td>

              <!-- Name -->
              <td class="py-3.5 px-4 font-extrabold text-gray-900">
                {{ $m->name }}
              </td>

              <!-- Title -->
              <td class="py-3.5 px-4">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $m->order === 1 ? 'bg-amber-50 text-amber-800 border border-amber-200' : 'bg-emerald-50 text-[#0b4622] border border-emerald-100' }}">
                  {{ $m->title }}
                </span>
              </td>

              <!-- Committee -->
              <td class="py-3.5 px-4 text-gray-600 font-medium">
                {{ $m->committee ? $m->committee->name : 'ডিফল্ট' }}
              </td>

              <!-- Status Toggle -->
              <td class="py-3.5 px-4 text-center">
                <button
                  type="button"
                  onclick="toggleMemberStatus({{ $m->id }}, this)"
                  class="cursor-pointer inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold transition {{ $m->status ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-500' }}"
                >
                  <span class="w-2 h-2 rounded-full {{ $m->status ? 'bg-emerald-600 animate-pulse' : 'bg-gray-400' }}"></span>
                  <span>{{ $m->status ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}</span>
                </button>
              </td>

              <!-- Actions -->
              <td class="py-3.5 px-4 text-right">
                <div class="inline-flex items-center gap-1.5">
                  <a
                    href="{{ route('admin.committee-members.edit', $m) }}"
                    class="p-2 rounded-lg bg-gray-100 hover:bg-[#0b4622] hover:text-white text-gray-600 transition"
                    title="এডিট করুন"
                  >
                    <i class="ri-edit-line text-base"></i>
                  </a>

                  <form action="{{ route('admin.committee-members.destroy', $m) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই সদস্যের তথ্য মুছে ফেলতে চান?');" class="inline">
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
              <td colspan="7" class="py-12 text-center text-gray-400">
                <i class="ri-user-unfollow-line text-4xl block mb-2 text-gray-300"></i>
                কোনো সদস্য পাওয়া যায়নি।
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($members->hasPages())
      <div class="p-4 border-t border-gray-100">
        {{ $members->links() }}
      </div>
    @endif
  </div>
</div>

<script>
function toggleMemberStatus(memberId, btn) {
  fetch(`/admin/committee-members/${memberId}/status`, {
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

