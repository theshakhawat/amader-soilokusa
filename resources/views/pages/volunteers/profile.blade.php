@extends('layouts.website.website-layout')

@section('title', $volunteer->name . ' — স্বেচ্ছাসেবী কর্মী বিবরণী — আগামীর শৈলকুপা')

@push('head')
<script src="{{ asset('assets/js/qrcode.min.js') }}"></script>
@endpush

@php
  $publicProfileUrl = route('volunteers.card', $volunteer->uuid ?: $volunteer->slug);
  $printCardUrl = route('volunteers.print-card', $volunteer->uuid ?: $volunteer->slug);
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
    <a href="{{ route('volunteers.index') }}" class="hover:text-[#0b4622] font-semibold text-gray-700 transition">স্বেচ্ছাসেবী কর্মীগণ</a>
    <i class="ri-arrow-right-s-line text-gray-400"></i>
    <span class="text-[#0b4622] font-semibold">{{ $volunteer->name }}</span>
  </nav>

  {{-- Action Controls Toolbar --}}
  <div class="bg-white rounded-2xl border border-gray-200/90 p-3 sm:p-4 shadow-xs flex items-center justify-between gap-2.5">
    <a href="{{ route('volunteers.index') }}"
       class="inline-flex items-center gap-1.5 px-3 sm:px-4 py-2 sm:py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-bold rounded-xl transition cursor-pointer"
       title="সকল কর্মী তালিকায় ফিরুন">
      <i class="ri-arrow-left-line text-sm sm:text-base"></i>
      <span class="hidden xs:inline sm:inline">সকল কর্মী</span>
    </a>

    <div class="flex items-center gap-2">
      {{-- ID Card Full-screen Print View Button --}}
      <a href="{{ $printCardUrl }}"
         target="_blank"
         class="inline-flex items-center gap-1.5 px-3.5 sm:px-4 py-2 sm:py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs sm:text-sm font-bold rounded-xl shadow-xs hover:shadow transition"
         title="আইডি কার্ড দেখুন ও প্রিন্ট করুন">
        <i class="ri-id-card-line text-base"></i>
        <span>আইডি কার্ড</span>
      </a>

      {{-- Share / Copy Link --}}
      <button type="button"
              onclick="copyVolunteerProfileUrl()"
              id="btnCopyVolunteerUrl"
              class="inline-flex items-center gap-1.5 px-3 sm:px-3.5 py-2 sm:py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-semibold rounded-xl transition cursor-pointer"
              title="প্রোফাইল লিংক কপি করুন">
        <i class="ri-share-forward-line text-base"></i>
        <span id="copyVolunteerUrlText" class="hidden xs:inline sm:inline">শেয়ার</span>
      </button>
    </div>
  </div>

  {{-- Volunteer Details Main Card --}}
  <div class="bg-white rounded-3xl border border-gray-200/90 shadow-sm overflow-hidden p-6 sm:p-9 space-y-7">
    
    {{-- Header: Centered Avatar, Name & ID (No top QR, clean centered layout) --}}
    <div class="flex flex-col items-center justify-center text-center gap-4 pb-6 border-b border-gray-100">
      {{-- Profile Photo Centered --}}
      <div class="w-32 h-32 sm:w-36 sm:h-36 rounded-3xl overflow-hidden border-2 border-[#0b4622]/20 shadow-lg ring-4 ring-emerald-50/80 shrink-0 bg-gray-100 mx-auto">
        <img src="{{ $volunteer->photo_url }}" alt="{{ $volunteer->name }}" class="w-full h-full object-cover">
      </div>

      {{-- Name & ID Below Image --}}
      <div class="space-y-2">
        <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
          {{ $volunteer->name }}
        </h1>
        <div>
          <span class="inline-block font-mono font-bold text-[#0b4622] bg-emerald-50 px-4 py-1.5 rounded-xl border border-emerald-200 text-xs sm:text-sm">
            ID: {{ $volunteer->card_id_number }}
          </span>
        </div>
      </div>
    </div>

    {{-- Details Table --}}
    <div class="space-y-3">
      <h2 class="text-sm sm:text-base font-bold text-gray-800 flex items-center gap-2">
        <i class="ri-information-line text-[#0b4622] text-base"></i>
        <span>স্বেচ্ছাসেবী কর্মী বিবরণী</span>
      </h2>

      <div class="overflow-hidden rounded-2xl border border-gray-200">
        <table class="w-full text-xs sm:text-sm text-left divide-y divide-gray-200">
          <tbody class="divide-y divide-gray-100 bg-white">
            <tr class="hover:bg-gray-50/70 transition">
              <td class="py-3.5 px-4 sm:px-5 font-bold text-gray-600 bg-gray-50/70 w-36 sm:w-48 whitespace-nowrap">
                পূর্ণ নাম
              </td>
              <td class="py-3.5 px-4 sm:px-5 font-bold text-gray-900">
                {{ $volunteer->name }}
              </td>
            </tr>

            <tr class="hover:bg-gray-50/70 transition">
              <td class="py-3.5 px-4 sm:px-5 font-bold text-gray-600 bg-gray-50/70 whitespace-nowrap">
                আইডি (ID)
              </td>
              <td class="py-3.5 px-4 sm:px-5 font-mono font-bold text-[#0b4622]">
                {{ $volunteer->card_id_number }}
              </td>
            </tr>

            <tr class="hover:bg-gray-50/70 transition">
              <td class="py-3.5 px-4 sm:px-5 font-bold text-gray-600 bg-gray-50/70 whitespace-nowrap">
                মোবাইল নম্বর
              </td>
              <td class="py-3.5 px-4 sm:px-5 font-semibold text-gray-800">
                <a href="tel:{{ $volunteer->phone }}" class="hover:text-[#0b4622] inline-flex items-center gap-1.5 transition">
                  <i class="ri-phone-line text-[#0b4622]"></i>
                  <span>{{ $volunteer->phone }}</span>
                </a>
              </td>
            </tr>

            @if(!empty($volunteer->email))
            <tr class="hover:bg-gray-50/70 transition">
              <td class="py-3.5 px-4 sm:px-5 font-bold text-gray-600 bg-gray-50/70 whitespace-nowrap">
                ইমেইল ঠিকানা
              </td>
              <td class="py-3.5 px-4 sm:px-5 text-gray-700">
                <a href="mailto:{{ $volunteer->email }}" class="hover:text-[#0b4622] inline-flex items-center gap-1.5 transition">
                  <i class="ri-mail-line text-blue-600"></i>
                  <span>{{ $volunteer->email }}</span>
                </a>
              </td>
            </tr>
            @endif

            <tr class="hover:bg-gray-50/70 transition">
              <td class="py-3.5 px-4 sm:px-5 font-bold text-gray-600 bg-gray-50/70 whitespace-nowrap">
                রক্তের গ্রুপ
              </td>
              <td class="py-3.5 px-4 sm:px-5">
                @if(!empty($volunteer->blood_group))
                  <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg bg-red-50 text-[#c8102e] border border-red-200 font-bold text-xs">
                    <i class="ri-drop-fill text-red-500"></i>
                    {{ $volunteer->blood_group }}
                  </span>
                @else
                  <span class="text-gray-400">তথ্য নেই</span>
                @endif
              </td>
            </tr>

            @if(!empty($volunteer->occupation))
            <tr class="hover:bg-gray-50/70 transition">
              <td class="py-3.5 px-4 sm:px-5 font-bold text-gray-600 bg-gray-50/70 whitespace-nowrap">
                পেশা
              </td>
              <td class="py-3.5 px-4 sm:px-5 font-semibold text-gray-800">
                <span class="inline-flex items-center gap-1.5">
                  <i class="ri-briefcase-line text-[#0b4622]"></i>
                  <span>{{ $volunteer->occupation }}</span>
                </span>
              </td>
            </tr>
            @endif

            <tr class="hover:bg-gray-50/70 transition">
              <td class="py-3.5 px-4 sm:px-5 font-bold text-gray-600 bg-gray-50/70 whitespace-nowrap align-top">
                বর্তমান ঠিকানা
              </td>
              <td class="py-3.5 px-4 sm:px-5 text-gray-700 leading-relaxed">
                <div class="flex items-start gap-1.5">
                  <i class="ri-map-pin-line text-amber-600 mt-0.5 shrink-0"></i>
                  <span>{{ $volunteer->address ?: 'শৈলকুপা, ঝিনাইদহ' }}</span>
                </div>
              </td>
            </tr>

            @if(!empty($volunteer->permanent_address))
            <tr class="hover:bg-gray-50/70 transition">
              <td class="py-3.5 px-4 sm:px-5 font-bold text-gray-600 bg-gray-50/70 whitespace-nowrap align-top">
                স্থায়ী ঠিকানা
              </td>
              <td class="py-3.5 px-4 sm:px-5 text-gray-700 leading-relaxed">
                <div class="flex items-start gap-1.5">
                  <i class="ri-home-office-line text-[#0b4622] mt-0.5 shrink-0"></i>
                  <span>{{ $volunteer->permanent_address }}</span>
                </div>
              </td>
            </tr>
            @endif

            <tr class="hover:bg-gray-50/70 transition">
              <td class="py-3.5 px-4 sm:px-5 font-bold text-gray-600 bg-gray-50/70 whitespace-nowrap">
                অনুমোদনের তারিখ
              </td>
              <td class="py-3.5 px-4 sm:px-5 text-gray-700 font-medium">
                {{ $volunteer->approved_at ? $volunteer->approved_at->format('d F, Y') : ($volunteer->created_at ? $volunteer->created_at->format('d F, Y') : '২০২৬') }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    {{-- Bottom Dedicated Large QR Code Card (Specially designed for Mobile & Overview) --}}
    <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col items-center justify-center text-center space-y-3 bg-gray-50/70 rounded-2xl p-6 border border-gray-200/80">
      <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-[#0b4622] text-xs font-bold">
        <i class="ri-qr-scan-2-line text-sm"></i>
        <span>ডিজিটাল প্রোফাইল কিউআর কোড</span>
      </div>

      {{-- Big QR Container --}}
      <div class="p-3 bg-white rounded-2xl shadow-md border-2 border-gray-200/90 inline-block">
        <div id="volunteerQrContainerBottom" style="min-width: 140px; min-height: 140px; display: flex; align-items: center; justify-content: center;"></div>
      </div>

      <div class="max-w-xs space-y-1">
        <p class="text-xs font-extrabold text-gray-800">
          যেকোনো স্মার্টফোন ক্যামেরা দিয়ে স্ক্যান করুন
        </p>
        <p class="text-[11px] text-gray-500 leading-relaxed">
          এই কিউআর কোডটি স্ক্যান করলে সরাসরি <strong>{{ $volunteer->name }}</strong>-এর অনলাইন ভেরিফায়েড প্রোফাইল পেজে নিয়ে আসবে।
        </p>
      </div>
    </div>

  </div>

</div>

<script>
  // Render Bottom Large QR Code pointing directly to this profile page
  function renderVolunteerProfileQr() {
    const profileUrl = "{{ $publicProfileUrl }}";
    const container = document.getElementById('volunteerQrContainerBottom');
    if (!container) return;
    container.innerHTML = '';
    const size = 140;

    // 1. Try local qrcode.js
    if (typeof QRCode !== 'undefined') {
      try {
        new QRCode(container, {
          text: profileUrl,
          width: size,
          height: size,
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
    img.src = 'https://api.qrserver.com/v1/create-qr-code/?size=' + size + 'x' + size + '&color=0b4622&bgcolor=ffffff&data=' + encodeURIComponent(profileUrl);
    img.alt = 'QR Code';
    img.width = size;
    img.height = size;
    img.className = 'rounded-lg mx-auto';
    container.appendChild(img);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', renderVolunteerProfileQr);
  } else {
    renderVolunteerProfileQr();
  }

  function copyVolunteerProfileUrl() {
    navigator.clipboard.writeText("{{ $publicProfileUrl }}").then(() => {
      const textSpan = document.getElementById('copyVolunteerUrlText');
      textSpan.textContent = 'কপি হয়েছে!';
      setTimeout(() => {
        textSpan.textContent = 'শেয়ার';
      }, 2500);
    });
  }
</script>
@endsection
