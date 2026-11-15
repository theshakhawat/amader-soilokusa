@extends('layouts.admin.admin-layout')

@section('title', 'অনুদানের বিস্তারিত — ' . $donation->trx_id)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
  {{-- Header --}}
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2.5">
        <span class="w-10 h-10 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center text-xl shadow-2xs">
          <i class="ri-file-info-line"></i>
        </span>
        <span>অনুদানের বিবরণ — {{ $donation->trx_id }}</span>
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-1 font-medium">লেনদেনের বিস্তারিত তথ্য ও গেটওয়ে রেসপন্স</p>
    </div>

    <a href="{{ route('admin.donations.index') }}"
       class="inline-flex items-center gap-1.5 px-3.5 py-2 border border-gray-300 rounded-xl text-xs sm:text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 transition shadow-2xs">
      <i class="ri-arrow-left-line"></i>
      <span>তালিকায় ফিরে যান</span>
    </a>
  </div>

  {{-- Details Card --}}
  <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-2xs">
    <div class="p-6 border-b border-gray-100 flex flex-wrap items-center justify-between gap-4 bg-gray-50/60">
      <div>
        <span class="text-xs text-gray-500 font-semibold block">অনুদানের পরিমাণ</span>
        <span class="text-2xl sm:text-3xl font-black text-[#0b4622]">৳{{ number_format($donation->amount, 2) }}</span>
      </div>

      <div>
        @if($donation->status === 'success')
          <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
            <i class="ri-checkbox-circle-fill text-emerald-500 text-sm"></i> সফল (Success)
          </span>
        @elseif($donation->status === 'pending')
          <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
            <i class="ri-time-line text-amber-500 text-sm"></i> পেন্ডিং (Pending)
          </span>
        @elseif($donation->status === 'cancelled')
          <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold bg-gray-100 text-gray-700 border border-gray-200">
            <i class="ri-close-circle-line text-gray-500 text-sm"></i> বাতিল (Cancelled)
          </span>
        @else
          <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200">
            <i class="ri-error-warning-fill text-red-500 text-sm"></i> ব্যর্থ (Failed)
          </span>
        @endif
      </div>
    </div>

    <div class="p-6 space-y-4 text-xs sm:text-sm">
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        {{-- Trx ID --}}
        <div class="bg-gray-50/70 p-3.5 rounded-xl border border-gray-100">
          <span class="text-gray-400 block text-[11px] font-semibold">ট্রানজ্যাকশন আইডি (Internal Trx ID)</span>
          <span class="font-mono font-bold text-gray-900 text-sm">{{ $donation->trx_id }}</span>
        </div>

        {{-- Gateway Trx --}}
        <div class="bg-gray-50/70 p-3.5 rounded-xl border border-gray-100">
          <span class="text-gray-400 block text-[11px] font-semibold">গেটওয়ে ট্রানজ্যাকশন আইডি / রসিদ নং</span>
          <span class="font-mono font-bold text-gray-900 text-sm">{{ $donation->gateway_trx_id ?: '—' }}</span>
        </div>

        {{-- Donor Name --}}
        <div class="bg-gray-50/70 p-3.5 rounded-xl border border-gray-100">
          <span class="text-gray-400 block text-[11px] font-semibold">দাতার নাম</span>
          <span class="font-bold text-gray-900">{{ $donation->donor_name }}</span>
        </div>

        {{-- Donor Phone --}}
        <div class="bg-gray-50/70 p-3.5 rounded-xl border border-gray-100">
          <span class="text-gray-400 block text-[11px] font-semibold">মোবাইল নম্বর</span>
          <a href="tel:{{ $donation->donor_phone }}" class="font-bold text-[#0b4622] hover:underline">{{ $donation->donor_phone }}</a>
        </div>

        {{-- Donor Email --}}
        <div class="bg-gray-50/70 p-3.5 rounded-xl border border-gray-100">
          <span class="text-gray-400 block text-[11px] font-semibold">ইমেইল</span>
          <span class="text-gray-900">{{ $donation->donor_email ?: '—' }}</span>
        </div>

        {{-- Payment Method --}}
        <div class="bg-gray-50/70 p-3.5 rounded-xl border border-gray-100">
          <span class="text-gray-400 block text-[11px] font-semibold">অনুদানের মাধ্যম ও ধরন</span>
          <span class="font-bold text-gray-900">{{ $donation->payment_method }} ({{ $donation->is_manual ? 'ম্যানুয়াল/অফলাইন' : 'DGePay অনলাইন' }})</span>
        </div>

        {{-- Created At --}}
        <div class="bg-gray-50/70 p-3.5 rounded-xl border border-gray-100">
          <span class="text-gray-400 block text-[11px] font-semibold">রেকর্ড তৈরির সময়</span>
          <span class="text-gray-900 font-semibold">{{ $donation->created_at->format('d F, Y — h:i:s A') }}</span>
        </div>

        {{-- Paid At --}}
        <div class="bg-gray-50/70 p-3.5 rounded-xl border border-gray-100">
          <span class="text-gray-400 block text-[11px] font-semibold">পেমেন্টের সময়</span>
          <span class="text-gray-900 font-semibold">{{ $donation->paid_at ? $donation->paid_at->format('d F, Y — h:i:s A') : '—' }}</span>
        </div>
      </div>

      {{-- Notes --}}
      @if($donation->notes)
        <div class="bg-amber-50/50 p-4 rounded-xl border border-amber-200">
          <span class="text-amber-800 font-bold block mb-1">মন্তব্য / বিবরণ:</span>
          <p class="text-gray-700 whitespace-pre-line">{{ $donation->notes }}</p>
        </div>
      @endif

      {{-- Gateway Raw Payload --}}
      @if(!empty($donation->payment_response))
        <div class="mt-4">
          <span class="text-xs font-bold text-gray-600 block mb-1.5">গেটওয়ে রেসপন্স ডেটা (Raw Gateway Response):</span>
          <pre class="bg-gray-900 text-gray-100 text-[11px] p-4 rounded-xl overflow-x-auto font-mono leading-relaxed">{{ json_encode($donation->payment_response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        </div>
      @endif
    </div>

    {{-- Footer Actions --}}
    <div class="p-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
      <form action="{{ route('admin.donations.destroy', $donation->id) }}"
            method="POST"
            onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই অনুদানের তথ্যটি মুছে ফেলতে চান?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="px-3.5 py-2 text-xs font-bold text-red-600 hover:bg-red-50 rounded-xl transition">
          <i class="ri-delete-bin-line"></i> রেকর্ড মুছে ফেলুন
        </button>
      </form>

      <a href="{{ route('admin.donations.index') }}"
         class="px-5 py-2 bg-gray-900 hover:bg-black text-white text-xs sm:text-sm font-bold rounded-xl transition">
        তালিকায় ফিরে যান
      </a>
    </div>
  </div>
</div>
@endsection

