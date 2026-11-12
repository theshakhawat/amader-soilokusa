@extends('layouts.admin.admin-layout')

@section('title', 'কমিটি ব্যবস্থাপনা')

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
        <span class="text-[#0b4622]">কমিটি তালিকা</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-900 flex items-center gap-2.5">
        <span class="w-10 h-10 rounded-xl bg-emerald-50 text-[#0b4622] flex items-center justify-center text-xl shrink-0">
          <i class="ri-team-line"></i>
        </span>
        কমিটি ব্যবস্থাপনা
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-1">
        হোম পেজের কমিটি সেকশন এবং বিভিন্ন কার্যনির্বাহী কমিটির তালিকা ও মেয়াদকাল পরিচালনা করুন।
      </p>
    </div>

    <a
      href="{{ route('admin.committees.create') }}"
      class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#0b4622] hover:bg-[#08351a] text-white text-xs sm:text-sm font-bold shadow-sm hover:shadow transition shrink-0 cursor-pointer"
    >
      <i class="ri-add-line text-lg"></i>
      <span>নতুন কমিটি যুক্ত করুন</span>
    </a>
  </div>

  @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-2">
      <i class="ri-checkbox-circle-fill text-emerald-600 text-lg"></i>
      {{ session('success') }}
    </div>
  @endif

  <!-- Committees Table / List -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
    <div class="p-5 border-b border-gray-100 flex items-center justify-between flex-wrap gap-4">
      <h2 class="text-base font-extrabold text-gray-800 flex items-center gap-2">
        <i class="ri-list-check-2 text-[#0b4622]"></i>
        সকল কমিটি তালিকা ({{ $committees->total() }})
      </h2>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse text-xs sm:text-sm">
        <thead>
          <tr class="bg-gray-50/75 border-b border-gray-100 text-gray-600 uppercase text-[11px] font-extrabold tracking-wider">
            <th class="py-3.5 px-4">ছবি</th>
            <th class="py-3.5 px-4">কমিটির নাম ও শিরোনাম</th>
            <th class="py-3.5 px-4">মেয়াদকাল / সেশন</th>
            <th class="py-3.5 px-4">উপ-শিরোনাম</th>
            <th class="py-3.5 px-4 text-center">স্ট্যাটাস</th>
            <th class="py-3.5 px-4 text-center">ক্রম</th>
            <th class="py-3.5 px-4 text-right">অ্যাকশন</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-gray-700">
          @forelse($committees as $committee)
            <tr class="hover:bg-gray-50/60 transition">
              <!-- Image -->
              <td class="py-3.5 px-4">
                <div class="w-20 h-12 rounded-lg overflow-hidden border border-gray-200 shadow-2xs bg-gray-100">
                  <img src="{{ $committee->image_url }}" alt="{{ $committee->name }}" class="w-full h-full object-cover">
                </div>
              </td>

              <!-- Name & Title -->
              <td class="py-3.5 px-4 font-bold text-gray-900">
                <div class="flex flex-col">
                  <span class="text-sm font-extrabold text-gray-900">{{ $committee->name }}</span>
                  <span class="text-xs text-gray-500 font-medium line-clamp-1 mt-0.5">{{ $committee->description ?: 'কোনো বিবরণ নেই' }}</span>
                </div>
              </td>

              <!-- Session / Duration -->
              <td class="py-3.5 px-4">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 text-[#0b4622] font-bold text-xs border border-emerald-100">
                  <i class="ri-calendar-line text-xs"></i>
                  {{ $committee->session_duration }}
                </span>
              </td>

              <!-- Subtitle -->
              <td class="py-3.5 px-4 text-gray-600 font-medium">
                {{ $committee->subtitle ?: 'আগামীর শৈলকুপা' }}
              </td>

              <!-- Active Status Toggle -->
              <td class="py-3.5 px-4 text-center">
                <button
                  type="button"
                  onclick="toggleCommitteeStatus({{ $committee->id }}, this)"
                  class="cursor-pointer inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold transition {{ $committee->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-500' }}"
                >
                  <span class="w-2 h-2 rounded-full {{ $committee->is_active ? 'bg-emerald-600 animate-pulse' : 'bg-gray-400' }}"></span>
                  <span>{{ $committee->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}</span>
                </button>
              </td>

              <!-- Order -->
              <td class="py-3.5 px-4 text-center font-bold text-gray-600">
                {{ $committee->order }}
              </td>

              <!-- Actions -->
              <td class="py-3.5 px-4 text-right">
                <div class="inline-flex items-center gap-1.5">
                  <a
                    href="{{ route('admin.committees.edit', $committee) }}"
                    class="p-2 rounded-lg bg-gray-100 hover:bg-[#0b4622] hover:text-white text-gray-600 transition"
                    title="এডিট করুন"
                  >
                    <i class="ri-edit-line text-base"></i>
                  </a>

                  <form action="{{ route('admin.committees.destroy', $committee) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই কমিটির তথ্য মুছে ফেলতে চান?');" class="inline">
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
                <i class="ri-team-line text-4xl block mb-2 text-gray-300"></i>
                এখনও কোনো কমিটি যুক্ত করা হয়নি।
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($committees->hasPages())
      <div class="p-4 border-t border-gray-100">
        {{ $committees->links() }}
      </div>
    @endif
  </div>
</div>

<script>
function toggleCommitteeStatus(committeeId, btn) {
  fetch(`/admin/committees/${committeeId}/status`, {
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
      if(data.is_active) {
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

