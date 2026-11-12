@extends('layouts.admin.admin-layout')

@section('title', 'বার্তা বিবরণ')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

  <!-- Header / Breadcrumb -->
  <div class="flex items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
    <div>
      <div class="flex items-center gap-2 text-xs font-semibold text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <a href="{{ route('admin.contact-messages.index') }}" class="hover:text-[#0b4622]">যোগাযোগ বার্তা</a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <span class="text-[#0b4622]">বার্তা বিবরণ</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-900">বার্তার বিস্তারিত তথ্য</h1>
    </div>

    <div class="flex items-center gap-2">
      <a
        href="{{ route('admin.contact-messages.index') }}"
        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-gray-200 text-gray-600 hover:text-gray-900 hover:bg-gray-50 text-xs sm:text-sm font-bold transition"
      >
        <i class="ri-arrow-left-line"></i>
        <span>তালিকায় ফিরে যান</span>
      </a>

      <form action="{{ route('admin.contact-messages.destroy', $contactMessage) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই বার্তাটি মুছে ফেলতে চান?');" class="inline">
        @csrf
        @method('DELETE')
        <button
          type="submit"
          class="inline-flex items-center gap-1 px-3 py-2 rounded-xl bg-red-50 hover:bg-red-600 text-red-600 hover:text-white text-xs sm:text-sm font-bold transition cursor-pointer"
        >
          <i class="ri-delete-bin-line"></i>
          <span>মুছে ফেলুন</span>
        </button>
      </form>
    </div>
  </div>

  <!-- Message Detail Card -->
  <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-xs space-y-6">

    <!-- Sender Details Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-gray-100 gap-4">
      <div class="flex items-center gap-4">
        <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-[#0b4622] flex items-center justify-center text-2xl font-black shrink-0 border border-emerald-100">
          {{ mb_substr($contactMessage->name, 0, 1) }}
        </div>
        <div>
          <h2 class="text-lg sm:text-xl font-black text-gray-900">{{ $contactMessage->name }}</h2>
          <div class="flex items-center gap-3 text-xs sm:text-sm text-gray-500 mt-0.5 flex-wrap">
            <a href="mailto:{{ $contactMessage->email }}" class="hover:text-[#0b4622] flex items-center gap-1">
              <i class="ri-mail-line"></i>
              <span>{{ $contactMessage->email }}</span>
            </a>
            @if($contactMessage->phone)
              <span>•</span>
              <a href="tel:{{ $contactMessage->phone }}" class="hover:text-[#0b4622] flex items-center gap-1">
                <i class="ri-phone-line"></i>
                <span>{{ $contactMessage->phone }}</span>
              </a>
            @endif
          </div>
        </div>
      </div>

      <div class="text-left sm:text-right">
        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
          <i class="ri-check-double-line"></i>
          <span>পঠিত বার্তা</span>
        </span>
        <p class="text-xs text-gray-400 mt-1.5">
          {{ $contactMessage->created_at->format('d F, Y — h:i A') }}
        </p>
      </div>
    </div>

    <!-- Subject -->
    <div>
      <span class="text-xs font-extrabold uppercase tracking-wider text-gray-400 block mb-1">বিষয় / Subject:</span>
      <h3 class="text-base sm:text-lg font-black text-gray-900 bg-gray-50 px-4 py-3 rounded-xl border border-gray-200/80">
        {{ $contactMessage->subject ?: 'কোনো বিষয় উল্লেখ নেই' }}
      </h3>
    </div>

    <!-- Message Body -->
    <div>
      <span class="text-xs font-extrabold uppercase tracking-wider text-gray-400 block mb-2">বার্তা / Message Content:</span>
      <div class="p-5 sm:p-6 rounded-2xl bg-gray-50/70 border border-gray-100 text-gray-800 text-sm leading-relaxed whitespace-pre-wrap font-medium">
{{ $contactMessage->message }}
      </div>
    </div>

    <!-- Meta / Actions -->
    <div class="pt-4 border-t border-gray-100 flex items-center justify-between flex-wrap gap-4 text-xs text-gray-500">
      <div>
        <span>আইপি ঠিকানা: <strong class="text-gray-700">{{ $contactMessage->ip_address ?: 'অজানা' }}</strong></span>
      </div>

      <div class="flex items-center gap-3">
        <a
          href="mailto:{{ $contactMessage->email }}?subject={{ rawurlencode('Re: ' . ($contactMessage->subject ?: 'যোগাযোগ বার্তা')) }}"
          class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#0b4622] hover:bg-[#08351a] text-white font-bold transition shadow-xs cursor-pointer"
        >
          <i class="ri-reply-line text-base"></i>
          <span>ইমেইলে উত্তর দিন</span>
        </a>
      </div>
    </div>

  </div>

</div>
@endsection

