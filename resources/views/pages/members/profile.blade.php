@extends('layouts.website.website-layout')

@section('title', $member->name . ' — সদস্য বিবরণী — আগামীর শৈলকুপা')

@push('head')
<script src="{{ asset('assets/js/qrcode.min.js') }}"></script>
@endpush

@php
  $publicProfileUrl = route('members.card', $member->uuid ?: $member->slug);
  $printCardUrl = route('members.print-card', $member->uuid ?: $member->slug);
@endphp

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-8 sm:py-12 space-y-6 sm:space-y-8">

  {{-- Top Breadcrumb --}}
  <nav class="flex items-center gap-2 text-xs sm:text-sm font-medium text-gray-500 bg-white px-4 py-2.5 rounded-2xl border border-gray-100 shadow-2xs">
    <a href="{{ route('home') }}" class="hover:text-[#0b4622] transition flex items-center gap-1.5">
      <i class="ri-home-4-line text-sm text-[#0b4622]"></i>
      <span>হোম</span>
    </a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <a href="{{ route('members.index') }}" class="hover:text-[#0b4622] font-semibold text-gray-700 transition">সদস্যগণ</a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <span class="text-[#0b4622] font-semibold">{{ $member->name }}</span>
  </nav>

  {{-- Action Controls Toolbar --}}
  <div class="bg-white rounded-2xl border border-gray-200/90 p-4 shadow-xs flex flex-wrap items-center justify-between gap-3">
    <a href="{{ route('members.index') }}"
       class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-semibold rounded-xl transition cursor-pointer">
      <i class="ri-arrow-left-line text-base"></i>
      <span>সকল সদস্য</span>
    </a>

    <div class="flex items-center gap-2.5">
      {{-- ID Card Full-screen Print View Button --}}
      <a href="{{ $printCardUrl }}"
         target="_blank"
         class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs sm:text-sm font-bold rounded-xl shadow-xs hover:shadow transition">
        <i class="ri-id-card-line text-base"></i>
        <span>ডিজিটাল আইডি কার্ড দেখুন ও প্রিন্ট করুন</span>
      </a>

      {{-- Share / Copy Link --}}
      <button type="button"
              onclick="copyMemberProfileUrl()"
              id="btnCopyMemberUrl"
              class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-semibold rounded-xl transition cursor-pointer"
              title="প্রোফাইল লিংক কপি করুন">
        <i class="ri-share-forward-line text-base"></i>
        <span id="copyMemberUrlText">শেয়ার লিংক</span>
      </button>
    </div>
  </div>

  {{-- Member Details Main Card --}}
  <div class="bg-white rounded-3xl border border-gray-200/90 shadow-sm overflow-hidden p-6 sm:p-9 space-y-7">
    
    {{-- Header: Avatar, Name & ID (Clean, No extra badges) --}}
    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 pb-6 border-b border-gray-100 text-center sm:text-left">
      {{-- Profile Photo --}}
      <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl overflow-hidden border-2 border-[#0b4622]/20 shadow-md ring-4 ring-gray-50 shrink-0 bg-gray-100">
        <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
      </div>

      {{-- Name & ID --}}
      <div class="flex-1 space-y-1.5">
        <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
          {{ $member->name }}
        </h1>
        <p class="text-xs sm:text-sm font-mono">
          <span class="font-bold text-[#0b4622] bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-200">ID: {{ $member->card_id_number }}</span>
        </p>
      </div>

      {{-- QR Code (Directly links to this public page) --}}
      <div class="flex flex-col items-center justify-center p-3 bg-gray-50 rounded-2xl border border-gray-200 shrink-0">
        <div id="memberQrContainer" class="p-1 bg-white rounded-xl shadow-2xs border border-gray-200" style="min-width: 84px; min-height: 84px; display: flex; align-items: center; justify-content: center;"></div>
        <span class="text-[10px] font-bold text-gray-500 mt-1.5 flex items-center gap-1">
          <i class="ri-qr-code-line text-xs text-[#0b4622]"></i>
          প্রোফাইল কিউআর কোড
        </span>
      </div>
    </div>

    {{-- Details Table --}}
    <div class="space-y-3">
      <h2 class="text-sm sm:text-base font-bold text-gray-800 flex items-center gap-2">
        <i class="ri-information-line text-[#0b4622] text-base"></i>
        <span>সদস্য বিবরণী</span>
      </h2>

      <div class="overflow-hidden rounded-2xl border border-gray-200">
        <table class="w-full text-xs sm:text-sm text-left divide-y divide-gray-200">
          <tbody class="divide-y divide-gray-100 bg-white">
            <tr class="hover:bg-gray-50/70 transition">
              <td class="py-3.5 px-4 sm:px-5 font-bold text-gray-600 bg-gray-50/70 w-36 sm:w-48 whitespace-nowrap">
                পূর্ণ নাম
              </td>
              <td class="py-3.5 px-4 sm:px-5 font-bold text-gray-900">
                {{ $member->name }}
              </td>
            </tr>

            <tr class="hover:bg-gray-50/70 transition">
              <td class="py-3.5 px-4 sm:px-5 font-bold text-gray-600 bg-gray-50/70 whitespace-nowrap">
                আইডি (ID)
              </td>
              <td class="py-3.5 px-4 sm:px-5 font-mono font-bold text-[#0b4622]">
                {{ $member->card_id_number }}
              </td>
            </tr>

            <tr class="hover:bg-gray-50/70 transition">
              <td class="py-3.5 px-4 sm:px-5 font-bold text-gray-600 bg-gray-50/70 whitespace-nowrap">
                মোবাইল নম্বর
              </td>
              <td class="py-3.5 px-4 sm:px-5 font-semibold text-gray-800">
                <a href="tel:{{ $member->phone }}" class="hover:text-[#0b4622] inline-flex items-center gap-1.5 transition">
                  <i class="ri-phone-line text-[#0b4622]"></i>
                  <span>{{ $member->phone }}</span>
                </a>
              </td>
            </tr>

            @if(!empty($member->email))
            <tr class="hover:bg-gray-50/70 transition">
              <td class="py-3.5 px-4 sm:px-5 font-bold text-gray-600 bg-gray-50/70 whitespace-nowrap">
                ইমেইল ঠিকানা
              </td>
              <td class="py-3.5 px-4 sm:px-5 text-gray-700">
                <a href="mailto:{{ $member->email }}" class="hover:text-[#0b4622] inline-flex items-center gap-1.5 transition">
                  <i class="ri-mail-line text-blue-600"></i>
                  <span>{{ $member->email }}</span>
                </a>
              </td>
            </tr>
            @endif

            <tr class="hover:bg-gray-50/70 transition">
              <td class="py-3.5 px-4 sm:px-5 font-bold text-gray-600 bg-gray-50/70 whitespace-nowrap">
                রক্তের গ্রুপ
              </td>
              <td class="py-3.5 px-4 sm:px-5">
                @if(!empty($member->blood_group))
                  <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg bg-red-50 text-[#c8102e] border border-red-200 font-bold text-xs">
                    <i class="ri-drop-fill text-red-500"></i>
                    {{ $member->blood_group }}
                  </span>
                @else
                  <span class="text-gray-400">তথ্য নেই</span>
                @endif
              </td>
            </tr>

            <tr class="hover:bg-gray-50/70 transition">
              <td class="py-3.5 px-4 sm:px-5 font-bold text-gray-600 bg-gray-50/70 whitespace-nowrap align-top">
                বর্তমান ঠিকানা
              </td>
              <td class="py-3.5 px-4 sm:px-5 text-gray-700 leading-relaxed">
                <div class="flex items-start gap-1.5">
                  <i class="ri-map-pin-line text-amber-600 mt-0.5 shrink-0"></i>
                  <span>{{ $member->address ?: 'শৈলকুপা, ঝিনাইদহ' }}</span>
                </div>
              </td>
            </tr>

            <tr class="hover:bg-gray-50/70 transition">
              <td class="py-3.5 px-4 sm:px-5 font-bold text-gray-600 bg-gray-50/70 whitespace-nowrap">
                অনুমোদনের তারিখ
              </td>
              <td class="py-3.5 px-4 sm:px-5 text-gray-700 font-medium">
                {{ $member->approved_at ? $member->approved_at->format('d F, Y') : ($member->created_at ? $member->created_at->format('d F, Y') : '২০২৬') }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>

</div>

<script>
  // Render QR Code pointing directly to this profile page
  function renderMemberProfileQr() {
    const qrContainer = document.getElementById('memberQrContainer');
    if (!qrContainer) return;
    qrContainer.innerHTML = '';

    const profileUrl = "{{ $publicProfileUrl }}";

    // 1. Try local qrcode.js
    if (typeof QRCode !== 'undefined') {
      try {
        new QRCode(qrContainer, {
          text: profileUrl,
          width: 76,
          height: 76,
          colorDark: "#0b4622",
          colorLight: "#ffffff",
          correctLevel: QRCode.CorrectLevel.M
        });
        return;
      } catch (e) {
        console.warn('QRCode JS render error:', e);
      }
    }

    // 2. Reliable fallback image QR API
    const img = document.createElement('img');
    img.src = 'https://api.qrserver.com/v1/create-qr-code/?size=76x76&color=0b4622&bgcolor=ffffff&data=' + encodeURIComponent(profileUrl);
    img.alt = 'QR Code';
    img.width = 76;
    img.height = 76;
    img.className = 'rounded-lg';
    qrContainer.appendChild(img);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', renderMemberProfileQr);
  } else {
    renderMemberProfileQr();
  }

  function copyMemberProfileUrl() {
    navigator.clipboard.writeText("{{ $publicProfileUrl }}").then(() => {
      const textSpan = document.getElementById('copyMemberUrlText');
      textSpan.textContent = 'কপি হয়েছে!';
      setTimeout(() => {
        textSpan.textContent = 'শেয়ার লিংক';
      }, 2500);
    });
  }
</script>
@endsection
