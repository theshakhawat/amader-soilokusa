@extends('layouts.admin.admin-layout')

@section('title', 'সংগঠনের গঠনতন্ত্র ও বিধিমালা পরিচালনা | আগামীর শৈলকুপা')

@section('content')
<div class="space-y-6">

  <!-- Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line"></i>
        <span class="text-[#0b4622] font-semibold">বিধিমালা ও গঠনতন্ত্র</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
        <i class="ri-book-open-line text-[#0b4622]"></i>
        <span>গঠনতন্ত্র ও বিধিমালা (Constitution & By-laws)</span>
      </h1>
      <p class="text-xs text-gray-500 mt-0.5">
        ওয়েবসাইটের বিধিমালা পেজে প্রদর্শিত বিভিন্ন ভাগ/অধ্যায় এবং ধারাগুলো এখান থেকে যোগ ও সম্পাদন করুন।
      </p>
    </div>

    <div class="flex items-center gap-2">
      <a
        href="{{ route('rules.index') }}"
        target="_blank"
        class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition cursor-pointer"
      >
        <i class="ri-external-link-line"></i>
        <span>লাইভ পেজ দেখুন</span>
      </a>

      <a
        href="{{ route('admin.rules.create') }}"
        class="inline-flex items-center gap-2 px-4 py-2 bg-[#0b4622] hover:bg-[#146c32] text-white text-xs font-extrabold rounded-xl shadow-xs transition cursor-pointer"
      >
        <i class="ri-add-line text-sm"></i>
        <span>নতুন ভাগ যোগ করুন</span>
      </a>
    </div>
  </div>

  @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-2xl flex items-center justify-between">
      <div class="flex items-center gap-2">
        <i class="ri-checkbox-circle-fill text-emerald-600 text-base"></i>
        <span>{{ session('success') }}</span>
      </div>
    </div>
  @endif

  <!-- Rules Table Card -->
  <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-2xs">
    <div class="p-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
      <h2 class="text-xs font-black uppercase tracking-wider text-gray-700">সকল ভাগ ও নীতিমালার তালিকা (মোট: {{ $rules->count() }} টি)</h2>
      <span class="text-[11px] text-gray-400">সিরিয়াল ক্রম অনুযায়ী ওয়েবসাইটে প্রদর্শিত হবে</span>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-gray-50/80 border-b border-gray-100 text-[11px] font-black text-gray-500 uppercase tracking-wider">
            <th class="py-3 px-4 w-14 text-center">ক্রম</th>
            <th class="py-3 px-4">ভাগের নাম</th>
            <th class="py-3 px-4">শিরোনাম ও বিষয়</th>
            <th class="py-3 px-4 text-center">স্ট্যাটাস</th>
            <th class="py-3 px-4 text-right">অ্যাকশন</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-xs">
          @forelse($rules as $rule)
            <tr class="hover:bg-gray-50/60 transition group">
              <td class="py-3.5 px-4 text-center font-bold text-gray-400">
                #{{ $rule->order }}
              </td>
              <td class="py-3.5 px-4 font-extrabold text-[#0b4622] whitespace-nowrap">
                <span class="px-2.5 py-1 rounded-lg bg-emerald-50 border border-emerald-200 text-xs">
                  {{ $rule->part_no }}
                </span>
              </td>
              <td class="py-3.5 px-4">
                <div class="font-extrabold text-gray-900 group-hover:text-[#0b4622] transition">
                  {{ $rule->title }}
                </div>
                @if($rule->summary)
                  <p class="text-[11px] text-gray-500 line-clamp-1 mt-0.5">{{ $rule->summary }}</p>
                @endif
              </td>
              <td class="py-3.5 px-4 text-center">
                <form action="{{ route('admin.rules.status', $rule->id) }}" method="POST" class="inline-block">
                  @csrf
                  @method('PATCH')
                  <button
                    type="submit"
                    class="px-2.5 py-1 rounded-full text-[11px] font-bold transition cursor-pointer {{ $rule->status ? 'bg-emerald-50 text-[#0b4622] border border-emerald-200 hover:bg-emerald-100' : 'bg-red-50 text-red-600 border border-red-200 hover:bg-red-100' }}"
                    title="ক্লিক করে স্ট্যাটাস পরিবর্তন করুন"
                  >
                    {{ $rule->status ? 'সক্রিয় (Active)' : 'নিষ্ক্রিয় (Hidden)' }}
                  </button>
                </form>
              </td>
              <td class="py-3.5 px-4 text-right">
                <div class="flex items-center justify-end gap-1.5">
                  <a
                    href="{{ route('rules.index') }}#{{ $rule->slug }}"
                    target="_blank"
                    class="w-7 h-7 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 flex items-center justify-center transition cursor-pointer"
                    title="প্রিভিউ দেখুন"
                  >
                    <i class="ri-eye-line text-sm"></i>
                  </a>

                  <a
                    href="{{ route('admin.rules.edit', $rule->id) }}"
                    class="w-7 h-7 rounded-lg bg-emerald-50 hover:bg-[#0b4622] text-[#0b4622] hover:text-white flex items-center justify-center transition cursor-pointer"
                    title="সম্পাদনা করুন"
                  >
                    <i class="ri-edit-line text-sm"></i>
                  </a>

                  <form action="{{ route('admin.rules.destroy', $rule->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই ভাগটি মুছে ফেলতে চান?');" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button
                      type="submit"
                      class="w-7 h-7 rounded-lg bg-red-50 hover:bg-[#c8102e] text-[#c8102e] hover:text-white flex items-center justify-center transition cursor-pointer"
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
              <td colspan="5" class="py-12 text-center text-gray-400">
                <i class="ri-book-open-line text-3xl text-gray-300 block mb-2"></i>
                এখনও কোনো বিধিমালার ভাগ তৈরি করা হয়নি।
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection
