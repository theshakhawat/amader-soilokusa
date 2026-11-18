@extends('layouts.admin.admin-layout')

@section('title', 'সদস্য বিবরণ — ' . $member->name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
  {{-- Header with Back Button & Actions --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight flex items-center gap-2.5">
        <span class="w-10 h-10 rounded-xl bg-emerald-50 text-[#0b4622] flex items-center justify-center text-xl shadow-2xs">
          <i class="ri-user-star-line"></i>
        </span>
        <span>সদস্য প্রোফাইল বিবরণ</span>
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-1 font-medium">সদস্যের ব্যক্তিগত তথ্য, যোগাযোগের বিবরণ ও বর্তমান সদস্যপদ অবস্থা</p>
    </div>

    <div class="flex items-center gap-2">
      @if($member->status)
        <a href="{{ $member->public_card_url }}"
           target="_blank"
           class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-xs sm:text-sm font-bold rounded-xl shadow-2xs transition">
          <i class="ri-id-card-line"></i>
          <span>ডিজিটাল সদস্য আইডি কার্ড দেখুন</span>
        </a>
      @endif

      <a href="{{ route('admin.members.edit', $member->id) }}"
         class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-bold rounded-xl shadow-2xs transition">
        <i class="ri-edit-line"></i>
        <span>সম্পাদনা</span>
      </a>

      <a href="{{ route('admin.members.index') }}"
         class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-gray-50 text-gray-700 text-xs sm:text-sm font-bold rounded-xl border border-gray-300 shadow-2xs transition">
        <i class="ri-arrow-left-line"></i>
        <span>তালিকায় ফিরে যান</span>
      </a>
    </div>
  </div>

  {{-- Main Profile Card --}}
  <div class="bg-white rounded-3xl border border-gray-200 overflow-hidden shadow-2xs">
    {{-- Banner / Top Profile Section --}}
    <div class="bg-gradient-to-r from-[#0b4622] to-[#07381b] p-6 sm:p-8 text-white relative">
      <div class="flex flex-col sm:flex-row sm:items-center gap-5 sm:gap-6">
        <div class="relative w-24 h-24 sm:w-28 sm:h-28 rounded-full border-4 border-white/30 overflow-hidden shadow-md shrink-0 bg-white">
          <img src="{{ $member->photo_url }}"
               alt="{{ $member->name }}"
               class="w-full h-full object-cover">
        </div>

        <div class="space-y-1.5 flex-1">
          <div class="flex flex-wrap items-center gap-2.5">
            <h2 class="text-xl sm:text-2xl font-black tracking-tight">{{ $member->name }}</h2>
            @if($member->status)
              <span class="px-3 py-0.5 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-400/40 inline-flex items-center gap-1">
                <i class="ri-checkbox-circle-fill"></i> Active (অনুমোদিত সদস্য)
              </span>
            @else
              <span class="px-3 py-0.5 rounded-full text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-400/40 inline-flex items-center gap-1">
                <i class="ri-time-line"></i> Inactive (অপেক্ষমাণ আবেদন)
              </span>
            @endif
          </div>

          <p class="text-xs sm:text-sm text-emerald-200 font-mono font-bold">
            সদস্য আইডি: {{ $member->card_id_number }}
          </p>

          <p class="text-xs text-white/80 font-mono">
            স্লাগ / URL: {{ $member->slug }}
          </p>

          <p class="text-xs text-emerald-200/90 flex items-center gap-1 pt-1">
            <i class="ri-calendar-line"></i> আবেদনের তারিখ: {{ $member->created_at->format('d F, Y - h:i A') }}
          </p>
        </div>

        {{-- Approve Action Button --}}
        <div class="shrink-0 pt-2 sm:pt-0">
          @if(!$member->status)
            <form action="{{ route('admin.members.approve', $member->id) }}" method="POST">
              @csrf
              @method('PATCH')
              <button type="submit"
                      class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-400 text-gray-950 text-xs sm:text-sm font-black rounded-xl shadow-md transition flex items-center gap-1.5 cursor-pointer">
                <i class="ri-checkbox-circle-line text-base"></i>
                <span>অনুমোদন করুন ও ইমেইল পাঠান</span>
              </button>
            </form>
          @else
            <form action="{{ route('admin.members.status', $member->id) }}" method="POST">
              @csrf
              @method('PATCH')
              <button type="submit"
                      class="px-4 py-2 bg-red-500/20 hover:bg-red-500/30 text-red-200 border border-red-400/30 text-xs font-bold rounded-xl transition cursor-pointer">
                নিষ্ক্রিয় করুন
              </button>
            </form>
          @endif
        </div>
      </div>
    </div>

    {{-- Details Grid --}}
    <div class="p-6 sm:p-8 space-y-6">
      <h3 class="text-sm sm:text-base font-extrabold text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
        <i class="ri-information-line text-[#0b4622]"></i>
        <span>ব্যক্তিগত ও যোগাযোগের বিবরণ</span>
      </h3>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs sm:text-sm">
        {{-- Phone --}}
        <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
          <p class="text-gray-500 text-[11px] font-semibold">মোবাইল নম্বর:</p>
          <a href="tel:{{ $member->phone }}" class="text-sm font-bold text-[#0b4622] hover:underline flex items-center gap-1 mt-1 font-mono">
            <i class="ri-phone-line"></i> {{ $member->phone }}
          </a>
        </div>

        {{-- Email --}}
        <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
          <p class="text-gray-500 text-[11px] font-semibold">ইমেইল ঠিকানা:</p>
          <a href="mailto:{{ $member->email }}" class="text-sm font-bold text-gray-800 hover:underline flex items-center gap-1 mt-1">
            <i class="ri-mail-line text-gray-400"></i> {{ $member->email }}
          </a>
        </div>

        {{-- Blood Group --}}
        <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
          <p class="text-gray-500 text-[11px] font-semibold">রক্তের গ্রুপ:</p>
          @if($member->blood_group)
            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-black bg-red-50 text-red-700 border border-red-200 mt-1">
              <i class="ri-drop-fill text-red-500"></i> {{ $member->blood_group }}
            </span>
          @else
            <span class="text-xs text-gray-400 mt-1 block">—</span>
          @endif
        </div>

        {{-- Occupation --}}
        <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
          <p class="text-gray-500 text-[11px] font-semibold">পেশা:</p>
          <p class="text-xs sm:text-sm font-bold text-gray-800 mt-1">
            {{ $member->occupation ?: '—' }}
          </p>
        </div>

        {{-- Current Address --}}
        <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
          <p class="text-gray-500 text-[11px] font-semibold">বর্তমান ঠিকানা:</p>
          <p class="text-xs sm:text-sm font-bold text-gray-800 mt-1 leading-relaxed">
            {{ $member->address ?: '—' }}
          </p>
        </div>

        {{-- Permanent Address --}}
        <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
          <p class="text-gray-500 text-[11px] font-semibold">স্থায়ী ঠিকানা:</p>
          <p class="text-xs sm:text-sm font-bold text-gray-800 mt-1 leading-relaxed">
            {{ $member->permanent_address ?: '—' }}
          </p>
        </div>

        {{-- Approval Meta --}}
        <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
          <p class="text-gray-500 text-[11px] font-semibold">অনুমোদনের তারিখ ও সময়:</p>
          @if($member->approved_at)
            <p class="text-xs sm:text-sm font-bold text-emerald-800 mt-1">
              ✓ {{ $member->approved_at->format('d M, Y - h:i A') }}
            </p>
            @if($member->approver)
              <p class="text-[11px] text-gray-500 mt-0.5">অনুমোদনকারী অ্যাডমিন: {{ $member->approver->name }}</p>
            @endif
          @else
            <span class="text-xs text-amber-600 font-semibold mt-1 block">এখনো অনুমোদন করা হয়নি (Inactive)</span>
          @endif
        </div>

        {{-- Registration Origin --}}
        <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
          <p class="text-gray-500 text-[11px] font-semibold">নিবন্ধনের মাধ্যম:</p>
          <p class="text-xs sm:text-sm font-bold text-gray-800 mt-1">
            @if($member->created_by)
              <span class="text-blue-700">অ্যাডমিন প্যানেল থেকে ম্যানুয়াল এন্ট্রি ({{ $member->creator->name ?? 'Admin' }})</span>
            @else
              <span class="text-[#0b4622]">পাবলিক ওয়েবসাইট সদস্য আবেদন ফর্ম</span>
            @endif
          </p>
        </div>

        {{-- Authorized Signature --}}
        <div class="p-4 rounded-xl bg-gray-50 border border-gray-100 sm:col-span-2">
          <p class="text-gray-500 text-[11px] font-semibold">অনুমোদিত কর্মকর্তার স্বাক্ষর:</p>
          @if($member->signature_url)
            <div class="mt-2 inline-block bg-white p-2 rounded-lg border border-gray-200">
              <img src="{{ $member->signature_url }}" alt="স্বাক্ষর" class="h-12 max-w-[180px] object-contain">
            </div>
          @else
            <span class="text-xs text-gray-400 mt-1 block">কোনো আলাদা স্বাক্ষর আপলোড করা হয়নি (ডিফল্ট স্বাক্ষর ব্যবহৃত হচ্ছে)</span>
          @endif
        </div>
      </div>

      {{-- Admin Notes if present --}}
      @if($member->notes)
        <div class="p-4 rounded-xl bg-amber-50/70 border border-amber-200">
          <h4 class="text-xs font-bold text-amber-900 mb-1 flex items-center gap-1.5">
            <i class="ri-sticky-note-line"></i> অ্যাডমিন নোট / মন্তব্য:
          </h4>
          <p class="text-xs text-amber-800 leading-relaxed">{{ $member->notes }}</p>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
