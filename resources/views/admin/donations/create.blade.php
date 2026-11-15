@extends('layouts.admin.admin-layout')

@section('title', 'নতুন অনুদান এন্ট্রি')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
  {{-- Header --}}
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2.5">
        <span class="w-10 h-10 rounded-xl bg-emerald-50 text-[#0b4622] flex items-center justify-center text-xl shadow-2xs">
          <i class="ri-add-circle-line"></i>
        </span>
        <span>নতুন অনুদান এন্ট্রি (অফলাইন / ম্যানুয়াল)</span>
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-1 font-medium">অফলাইনে বা সরাসরি সংগৃহীত অনুদানের বিবরণ এন্ট্রি করুন</p>
    </div>

    <a href="{{ route('admin.donations.index') }}"
       class="inline-flex items-center gap-1.5 px-3.5 py-2 border border-gray-300 rounded-xl text-xs sm:text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 transition shadow-2xs">
      <i class="ri-arrow-left-line"></i>
      <span>তালিকায় ফিরে যান</span>
    </a>
  </div>

  @if(isset($errors) && $errors->any())
    <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs sm:text-sm">
      <p class="font-bold mb-1">অনুগ্রহ করে নিচের ত্রুটিগুলো সংশোধন করুন:</p>
      <ul class="list-disc list-inside space-y-0.5">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Form Card --}}
  <div class="bg-white rounded-2xl border border-gray-200 p-6 sm:p-8 shadow-2xs">
    <form action="{{ route('admin.donations.store') }}" method="POST" class="space-y-6">
      @csrf

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        {{-- Donor Name --}}
        <div>
          <label class="block text-xs font-bold text-gray-700 mb-1.5">
            দাতার নাম <span class="text-red-500">*</span>
          </label>
          <input type="text"
                 name="donor_name"
                 value="{{ old('donor_name') }}"
                 required
                 placeholder="দাতার পূর্ণ নাম লিখুন"
                 class="w-full px-3.5 py-2.5 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622] transition @error('donor_name') border-red-500 @enderror">
        </div>

        {{-- Donor Phone --}}
        <div>
          <label class="block text-xs font-bold text-gray-700 mb-1.5">
            মোবাইল নম্বর <span class="text-red-500">*</span>
          </label>
          <input type="text"
                 name="donor_phone"
                 value="{{ old('donor_phone') }}"
                 required
                 placeholder="017XXXXXXXX"
                 class="w-full px-3.5 py-2.5 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622] transition @error('donor_phone') border-red-500 @enderror">
        </div>

        {{-- Donor Email --}}
        <div>
          <label class="block text-xs font-bold text-gray-700 mb-1.5">
            ইমেইল (ঐচ্ছিক)
          </label>
          <input type="email"
                 name="donor_email"
                 value="{{ old('donor_email') }}"
                 placeholder="donor@example.com"
                 class="w-full px-3.5 py-2.5 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622] transition @error('donor_email') border-red-500 @enderror">
        </div>

        {{-- Amount --}}
        <div>
          <label class="block text-xs font-bold text-gray-700 mb-1.5">
            অনুদানের পরিমাণ (টাকা) <span class="text-red-500">*</span>
          </label>
          <div class="relative">
            <span class="absolute left-3.5 top-2.5 text-gray-500 font-bold text-sm">৳</span>
            <input type="number"
                   step="any"
                   min="1"
                   name="amount"
                   value="{{ old('amount', 1000) }}"
                   required
                   placeholder="1000"
                   class="w-full pl-8 pr-3.5 py-2.5 text-xs sm:text-sm font-bold border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622] transition @error('amount') border-red-500 @enderror">
          </div>
        </div>

        {{-- Payment Method --}}
        <div>
          <label class="block text-xs font-bold text-gray-700 mb-1.5">
            অনুদানের মাধ্যম <span class="text-red-500">*</span>
          </label>
          <select name="payment_method" required class="w-full px-3.5 py-2.5 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622] transition bg-white @error('payment_method') border-red-500 @enderror">
            <option value="নগদ (Cash)" {{ old('payment_method') === 'নগদ (Cash)' ? 'selected' : '' }}>নগদ (Cash)</option>
            <option value="ব্যাংক ডিপোজিট" {{ old('payment_method') === 'ব্যাংক ডিপোজিট' ? 'selected' : '' }}>ব্যাংক ডিপোজিট / ট্রান্সফার</option>
            <option value="বিকাশ (bKash Offline)" {{ old('payment_method') === 'বিকাশ (bKash Offline)' ? 'selected' : '' }}>বিকাশ (পার্সোনাল / অফলাইন)</option>
            <option value="নগদ (Nagad Offline)" {{ old('payment_method') === 'নগদ (Nagad Offline)' ? 'selected' : '' }}>নগদ (পার্সোনাল / অফলাইন)</option>
            <option value="চেক (Cheque)" {{ old('payment_method') === 'চেক (Cheque)' ? 'selected' : '' }}>চেক (Cheque)</option>
            <option value="অন্যান্য" {{ old('payment_method') === 'অন্যান্য' ? 'selected' : '' }}>অন্যান্য</option>
          </select>
        </div>

        {{-- Receipt / Voucher No --}}
        <div>
          <label class="block text-xs font-bold text-gray-700 mb-1.5">
            রসিদ / ভাউচার নম্বর (ঐচ্ছিক)
          </label>
          <input type="text"
                 name="receipt_no"
                 value="{{ old('receipt_no') }}"
                 placeholder="উদাঃ REC-2026-001"
                 class="w-full px-3.5 py-2.5 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622] transition">
        </div>

        {{-- Status --}}
        <div>
          <label class="block text-xs font-bold text-gray-700 mb-1.5">
            স্ট্যাটাস <span class="text-red-500">*</span>
          </label>
          <select name="status" required class="w-full px-3.5 py-2.5 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622] transition bg-white">
            <option value="success" {{ old('status', 'success') === 'success' ? 'selected' : '' }}>সফল (গৃহীত হয়েছে)</option>
            <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>পেন্ডিং</option>
            <option value="failed" {{ old('status') === 'failed' ? 'selected' : '' }}>ব্যর্থ</option>
          </select>
        </div>

        {{-- Date --}}
        <div>
          <label class="block text-xs font-bold text-gray-700 mb-1.5">
            অনুদানের তারিখ
          </label>
          <input type="datetime-local"
                 name="paid_at"
                 value="{{ old('paid_at', now()->format('Y-m-d\TH:i')) }}"
                 class="w-full px-3.5 py-2.5 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622] transition">
        </div>
      </div>

      {{-- Notes / Purpose --}}
      <div>
        <label class="block text-xs font-bold text-gray-700 mb-1.5">
          বিবরণ / মন্তব্য (ঐচ্ছিক)
        </label>
        <textarea name="notes"
                  rows="3"
                  placeholder="অনুদানের উদ্দেশ্য বা বিশেষ কোনো তথ্য..."
                  class="w-full px-3.5 py-2.5 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622] transition">{{ old('notes') }}</textarea>
      </div>

      {{-- Submit --}}
      <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
        <a href="{{ route('admin.donations.index') }}"
           class="px-5 py-2.5 border border-gray-300 text-gray-700 text-xs sm:text-sm font-bold rounded-xl hover:bg-gray-50 transition">
          বাতিল করুন
        </a>
        <button type="submit"
                class="px-6 py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs sm:text-sm font-bold rounded-xl shadow-xs transition flex items-center gap-2">
          <i class="ri-check-line text-base"></i>
          <span>অনুদান সংরক্ষণ করুন</span>
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
