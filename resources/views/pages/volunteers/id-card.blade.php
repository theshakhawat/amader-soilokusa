@extends('layouts.website.website-layout')

@section('title', 'ডিজিটাল পরিচয়পত্র — ' . $volunteer->name . ' — আগামীর শৈলকুপা')

@push('head')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  .bengali-card-font {
    font-family: 'Hind Siliguri', 'SolaimanLipi', 'Noto Sans Bengali', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
  }
</style>
@endpush

@php
  $siteSetting = \App\Models\SiteSetting::first();
  
  // Resilient disk file finder
  $findFile = function($path) {
      if (!$path) return null;
      $candidates = [
          storage_path('app/public/' . $path),
          public_path('storage/' . $path),
          public_path($path),
      ];
      foreach ($candidates as $cand) {
          if (file_exists($cand) && is_file($cand)) {
              return $cand;
          }
      }
      return null;
  };

  // 1. Dynamic Site Logo
  $siteLogo = asset('assets/images/logo-icon.png');
  if ($siteSetting && $siteSetting->header_logo) {
      if ($logoDiskPath = $findFile($siteSetting->header_logo)) {
          $mime = mime_content_type($logoDiskPath) ?: 'image/png';
          $siteLogo = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($logoDiskPath));
      } elseif ($siteSetting->header_logo_url) {
          $siteLogo = $siteSetting->header_logo_url;
      }
  }

  $siteTitle = $siteSetting?->site_title ?: 'আগামীর শৈলকুপা';
  $siteTagline = $siteSetting?->site_tagline ?: 'শৈলকুপার সার্বিক উন্নয়নে নিবেদিত সামাজিক উদ্যোগ';
  $publicCardUrl = route('volunteers.card', $volunteer->uuid ?: $volunteer->slug);

  // 2. Photo as base64 Data URI if exists on disk
  $photoBase64 = null;
  if ($volunteer->photo) {
      if ($photoDiskPath = $findFile($volunteer->photo)) {
          $mime = mime_content_type($photoDiskPath) ?: 'image/jpeg';
          $photoBase64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($photoDiskPath));
      } elseif (str_starts_with($volunteer->photo, 'http://') || str_starts_with($volunteer->photo, 'https://')) {
          $photoBase64 = $volunteer->photo;
      } else {
          $photoBase64 = asset('storage/' . $volunteer->photo);
      }
  }

  // 3. Signature as base64 Data URI if exists on disk
  $signatureBase64 = null;
  if ($volunteer->signature) {
      if ($sigDiskPath = $findFile($volunteer->signature)) {
          $mime = mime_content_type($sigDiskPath) ?: 'image/png';
          $signatureBase64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($sigDiskPath));
      }
  }
@endphp

@section('content')
<div class="bg-gray-100/70 min-h-screen py-8 sm:py-14 print:p-0 print:bg-white print:min-h-0 bengali-card-font">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 space-y-6 sm:space-y-8">

    {{-- Breadcrumb & Verification Badge (Hidden in Print) --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 print:hidden">
      <nav class="flex items-center gap-2 text-xs sm:text-sm font-medium text-gray-500">
        <a href="{{ route('home') }}" class="hover:text-[#0b4622] transition flex items-center gap-1.5">
          <i class="ri-home-4-line text-sm text-[#0b4622]"></i>
          <span>হোম</span>
        </a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <a href="{{ route('volunteers.apply') }}" class="hover:text-[#0b4622] transition">স্বেচ্ছাসেবী নিয়োগ</a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <span class="text-[#0b4622] font-semibold">ডিজিটাল পরিচয়পত্র</span>
      </nav>

      {{-- Top Verified Status --}}
      <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-50 border border-emerald-300 text-emerald-800 text-xs font-bold shadow-2xs">
        <i class="ri-shield-check-fill text-emerald-600 text-base"></i>
        <span>অফিসিয়াল ভেরিফায়েড পরিচয়পত্র (Verified)</span>
      </div>
    </div>

    {{-- Action Controls Toolbar (Hidden in Print) --}}
    <div class="bg-white rounded-2xl border border-gray-200/90 p-4 shadow-sm flex flex-wrap items-center justify-between gap-3 print:hidden">
      <div>
        <h2 class="text-sm font-black text-gray-800">স্বেচ্ছাসেবী ডিজিটাল আইডি কার্ড</h2>
        <p class="text-xs text-gray-500 mt-0.5">নিচের বাটনটি ব্যবহার করে কার্ডটি হাই-রেজোলিউশন ছবি (PNG) হিসেবে ডাউনলোড করুন</p>
      </div>

      <div class="flex flex-wrap items-center gap-2.5">
        {{-- Download PNG Button --}}
        <button type="button"
                id="btnDownloadPNG"
                onclick="downloadCardAsPNG()"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs sm:text-sm font-bold rounded-xl shadow-xs hover:shadow transition cursor-pointer">
          <i class="ri-download-2-line text-base"></i>
          <span>PNG ইমেজ ডাউনলোড</span>
        </button>

        {{-- Share / Copy Link --}}
        <button type="button"
                onclick="copyPublicUrl()"
                id="btnCopyUrl"
                class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-semibold rounded-xl transition cursor-pointer"
                title="ভেরিফিকেশন লিংক কপি করুন">
          <i class="ri-share-forward-line text-base"></i>
          <span id="copyUrlText">শেয়ার লিংক</span>
        </button>
      </div>
    </div>

    {{-- Main Volunteer ID Card Display Container --}}
    <div class="flex justify-center items-center py-2">
      {{-- The Downloadable & Printable Card Element --}}
      <div id="volunteerIdCardElement"
           style="width: 380px; max-width: 380px; background-color: #ffffff; border-radius: 24px; border: 2px solid rgba(11, 70, 34, 0.35); box-shadow: 0 20px 30px -10px rgba(0,0,0,0.18); overflow: hidden; position: relative; color: #111827; user-select: none; font-family: 'Hind Siliguri', 'SolaimanLipi', 'Noto Sans Bengali', sans-serif;">

        {{-- Top Lanyard Slot --}}
        <div style="padding-top: 12px; padding-bottom: 6px; display: flex; justify-content: center; background-color: #07381b;">
          <div style="width: 56px; height: 14px; border-radius: 9999px; background-color: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.35);"></div>
        </div>

        {{-- ID Card Header with Dynamic Logo & Tagline --}}
        <div style="background: linear-gradient(135deg, #07381b 0%, #0b4622 55%, #042411 100%); padding: 16px 20px 18px; text-align: center; color: #ffffff; position: relative;">
          {{-- Logo & Brand --}}
          <div style="display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 8px;">
            <img src="{{ $siteLogo }}"
                 alt="{{ $siteTitle }}"
                 style="width: 44px; height: 44px; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3)); flex-shrink: 0;">
            <div style="text-align: left;">
              <h3 style="font-size: 18px; font-weight: 800; line-height: 1.2; margin: 0; color: #ffffff; letter-spacing: -0.2px;">
                {{ $siteTitle }}
              </h3>
              <p style="font-size: 11px; font-weight: 500; color: #a7f3d0; margin: 3px 0 0 0; line-height: 1.3;">
                {{ $siteTagline }}
              </p>
            </div>
          </div>

          {{-- Card Type Ribbon --}}
          <div style="display: inline-flex; align-items: center; justify-content: center; background-color: #c8102e; color: #ffffff; font-size: 12px; font-weight: 700; padding: 4px 18px; border-radius: 9999px; line-height: 1.4; box-shadow: 0 2px 4px rgba(0,0,0,0.25); letter-spacing: 0.5px;">
            স্বেচ্ছাসেবী পরিচয়পত্র
          </div>
        </div>

        {{-- Photo & Identity Section --}}
        <div style="padding: 20px 24px 10px; text-align: center;">
          {{-- Portrait Photo with Frame & Centered Verified Badge --}}
          <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
            <div style="width: 124px; height: 124px; border-radius: 20px; border: 4px solid #0b4622; overflow: hidden; background-color: #f3f4f6; box-shadow: 0 4px 14px rgba(0,0,0,0.15); display: flex; align-items: center; justify-content: center;">
              @if($photoBase64)
                <img src="{{ $photoBase64 }}"
                     alt="{{ $volunteer->name }}"
                     style="width: 100%; height: 100%; object-fit: cover; display: block;">
              @else
                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);">
                  <img src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='70' height='70' fill='%230b4622'><path opacity='0.75' d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/></svg>" width="70" height="70" alt="Avatar" style="display: block;">
                </div>
              @endif
            </div>

            {{-- Centered Verified Badge --}}
            <div style="margin-top: -14px; position: relative; z-index: 10;">
              <span style="display: inline-flex; align-items: center; gap: 5px; background-color: #047857; color: #ffffff; font-size: 11px; font-weight: 700; padding: 3px 12px; border-radius: 9999px; border: 2px solid #ffffff; box-shadow: 0 2px 6px rgba(0,0,0,0.25); line-height: 1.2;">
                <svg style="width: 12px; height: 12px; fill: #a7f3d0;" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                <span>Verified</span>
              </span>
            </div>
          </div>

          {{-- Name & Unique ID Number --}}
          <div style="margin-top: 12px; margin-bottom: 8px;">
            <h2 style="font-size: 20px; font-weight: 800; color: #111827; margin: 0; line-height: 1.3;">
              {{ $volunteer->name }}
            </h2>
            <div style="margin-top: 6px;">
              <span style="display: inline-block; font-family: 'Courier New', Courier, monospace; font-size: 13px; font-weight: 800; color: #1f2937; background-color: #f3f4f6; border: 1px solid #d1d5db; padding: 2px 14px; border-radius: 6px; letter-spacing: 1px; line-height: 1.4;">
                ID: {{ $volunteer->card_id_number }}
              </span>
            </div>
          </div>
        </div>

        {{-- Details Information Grid --}}
        <div style="padding: 4px 24px 12px;">
          <div style="background-color: #f9fafb; border-radius: 16px; border: 1px solid #e5e7eb; padding: 12px 16px;">
            {{-- Blood Group --}}
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 7px 0; border-bottom: 1px solid #e5e7eb;">
              <span style="font-weight: 700; color: #4b5563; font-size: 12px; white-space: nowrap;">রক্তের গ্রুপ:</span>
              <span style="font-weight: 800; color: #dc2626; background-color: #fef2f2; padding: 2px 10px; border-radius: 6px; border: 1px solid #fecaca; font-size: 12px; display: inline-flex; align-items: center; gap: 4px;">
                <svg style="width: 10px; height: 10px; fill: #dc2626;" viewBox="0 0 24 24"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                <span>{{ $volunteer->blood_group ?: 'N/A' }}</span>
              </span>
            </div>

            {{-- Mobile Number --}}
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 7px 0; border-bottom: 1px solid #e5e7eb;">
              <span style="font-weight: 700; color: #4b5563; font-size: 12px; white-space: nowrap;">মোবাইল নম্বর:</span>
              <span style="font-weight: 700; color: #111827; font-family: 'Courier New', Courier, monospace; font-size: 13px;">{{ $volunteer->phone }}</span>
            </div>

            {{-- Email Address (No truncate / clipping!) --}}
            @if($volunteer->email)
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 7px 0; border-bottom: 1px solid #e5e7eb;">
              <span style="font-weight: 700; color: #4b5563; font-size: 12px; white-space: nowrap; flex-shrink: 0;">ইমেইল:</span>
              <span style="font-weight: 600; color: #1f2937; font-size: 11.5px; line-height: 1.3; word-break: break-all; text-align: right; padding-left: 8px;">{{ $volunteer->email }}</span>
            </div>
            @endif

            {{-- Address --}}
            <div style="display: flex; align-items: flex-start; justify-content: space-between; padding: 7px 0; border-bottom: 1px solid #e5e7eb;">
              <span style="font-weight: 700; color: #4b5563; font-size: 12px; white-space: nowrap; flex-shrink: 0;">ঠিকানা:</span>
              <span style="font-weight: 600; color: #1f2937; font-size: 12px; line-height: 1.3; text-align: right; padding-left: 8px;">{{ $volunteer->address ?: 'শৈলকুপা, ঝিনাইদহ' }}</span>
            </div>

            {{-- Issue Date --}}
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 7px 0 2px;">
              <span style="font-weight: 700; color: #4b5563; font-size: 12px; white-space: nowrap;">ইস্যু তারিখ:</span>
              <span style="font-weight: 700; color: #374151; font-size: 12px;">{{ $volunteer->approved_at ? $volunteer->approved_at->format('d M, Y') : now()->format('d M, Y') }}</span>
            </div>
          </div>
        </div>

        {{-- QR Code & Authorized Signature Section --}}
        <div style="padding: 10px 24px 16px; display: flex; align-items: center; justify-content: space-between; gap: 12px; background-color: #ffffff;">
          {{-- QR Code Container --}}
          <div style="display: flex; align-items: center; gap: 10px;">
            <div style="padding: 6px; background-color: #ffffff; border: 1px solid #d1d5db; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); width: 72px; height: 72px; display: flex; align-items: center; justify-content: center;">
              <div id="volunteerQrContainer"></div>
            </div>
            <div style="font-size: 10px; color: #6b7280; line-height: 1.3;">
              <span style="font-weight: 700; color: #0b4622; display: flex; align-items: center; gap: 4px;">
                <svg style="width: 12px; height: 12px; fill: #0b4622;" viewBox="0 0 24 24">
                  <path d="M4 4h6v6H4V4zm2 2v2h2V6H6zm8-2h6v6h-6V4zm2 2v2h2V6h-2zM4 14h6v6H4v-6zm2 2v2h2v-2H6zm10-2h2v2h-2v-2zm-2 2h2v2h-2v-2zm4 0h2v2h-2v-2zm-2 2h2v2h-2v-2zm2 2h2v2h-2v-2zm-4 0h2v2h-2v-2z"/>
                </svg>
                স্ক্যান করুন
              </span>
              <span>অনলাইন ভেরিফিকেশন</span>
            </div>
          </div>

          {{-- Authority Seal & Signature --}}
          <div style="text-align: right; min-width: 110px;">
            <div style="display: inline-block; text-align: center;">
              @if($signatureBase64)
                <div style="height: 38px; display: flex; align-items: center; justify-content: center; border-bottom: 1px solid #9ca3af; padding-bottom: 2px;">
                  <img src="{{ $signatureBase64 }}"
                       alt="স্বাক্ষর"
                       style="max-height: 100%; max-width: 120px; object-fit: contain;">
                </div>
              @else
                <div style="font-family: Georgia, serif; font-style: italic; font-size: 13px; font-weight: 800; color: #0b4622; letter-spacing: 0.5px; border-bottom: 1px solid #9ca3af; padding-bottom: 2px; padding-left: 8px; padding-right: 8px;">
                  Agamir Shoilokupa
                </div>
              @endif
              <span style="font-size: 9px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-top: 4px;">
                অনুমোদিত স্বাক্ষর
              </span>
            </div>
          </div>
        </div>

        {{-- ID Card Bottom Strip --}}
        <div style="background-color: #07381b; color: #ffffff; padding: 8px 16px; text-align: center; font-size: 10px; font-weight: 500; border-top: 2px solid #c8102e;">
          <p style="margin: 0; line-height: 1.4; color: rgba(255, 255, 255, 0.9);">
            এই পরিচয়পত্রটি আগামীর শৈলকুপা-এর অফিসিয়াল সম্পত্তি। জরুরি প্রয়োজনে: info@agamirshoilokuya.org
          </p>
        </div>
      </div>
    </div>

    {{-- Verification Security Note (Hidden in Print) --}}
    <div class="max-w-[380px] mx-auto bg-emerald-50 border border-emerald-200 rounded-2xl p-4 text-center space-y-1 print:hidden">
      <p class="text-xs font-bold text-emerald-950 flex items-center justify-center gap-1.5">
        <i class="ri-shield-check-fill text-emerald-600"></i>
        <span>অফিসিয়াল অনলাইন ভেরিফিকেশন সিস্টেম</span>
      </p>
      <p class="text-[11px] text-emerald-800">
        যেকোনো স্মার্টফোন দিয়ে কার্ডের কিউআর (QR) কোডটি স্ক্যান করলেই এই অনলাইন ভেরিফায়েড পেজটি ওপেন হবে এবং কার্ডটি ডাউনলোড করা যাবে।
      </p>
    </div>

  </div>
</div>

{{-- High-quality client-side rendering libraries: qrcode.js + html-to-image + html2canvas --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html-to-image/1.11.11/html-to-image.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
  // 1. Render Local Clean QR Code reliably
  function initVolunteerQrCode() {
    const qrContainer = document.getElementById('volunteerQrContainer');
    if (qrContainer && !qrContainer.hasChildNodes()) {
      new QRCode(qrContainer, {
        text: "{{ $publicCardUrl }}",
        width: 60,
        height: 60,
        colorDark: "#0b4622",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.M
      });
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initVolunteerQrCode);
  } else {
    initVolunteerQrCode();
  }

  // 2. High-Quality PNG Download without glitches, broken ligatures or cutoffs
  async function downloadCardAsPNG() {
    const btn = document.getElementById('btnDownloadPNG');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="ri-loader-4-line animate-spin text-base"></i> তৈরি হচ্ছে...';
    btn.disabled = true;

    try {
      if (document.fonts) {
        await document.fonts.ready;
      }

      const cardElement = document.getElementById('volunteerIdCardElement');
      let dataUrl = null;

      // 1. Primary engine: html-to-image (preserves Bengali ligatures natively via foreignObject)
      if (window.htmlToImage) {
        try {
          dataUrl = await htmlToImage.toPng(cardElement, {
            pixelRatio: 3,
            backgroundColor: '#ffffff',
            cacheBust: false,
            fontEmbedCSS: ''
          });
        } catch (h2iErr) {
          console.warn('htmlToImage attempt failed, falling back:', h2iErr);
        }
      }

      // 2. Secondary fallback: html2canvas
      if (!dataUrl && window.html2canvas) {
        const canvas = await html2canvas(cardElement, {
          scale: 3,
          useCORS: true,
          allowTaint: true,
          backgroundColor: '#ffffff',
          logging: false
        });
        dataUrl = canvas.toDataURL('image/png');
      }

      if (dataUrl) {
        const link = document.createElement('a');
        link.download = 'ID-Card-{{ $volunteer->uuid ?? $volunteer->slug }}.png';
        link.href = dataUrl;
        link.click();
      } else {
        throw new Error('Canvas render returned empty result');
      }
    } catch (err) {
      console.error('Canvas export error:', err);
      alert('ইমেজ তৈরিতে সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।');
    } finally {
      btn.innerHTML = originalText;
      btn.disabled = false;
    }
  }

  // 3. Copy Public Card URL
  function copyPublicUrl() {
    const url = "{{ $publicCardUrl }}";
    navigator.clipboard.writeText(url).then(() => {
      const textSpan = document.getElementById('copyUrlText');
      textSpan.textContent = 'কপি হয়েছে!';
      setTimeout(() => {
        textSpan.textContent = 'শেয়ার লিংক';
      }, 2500);
    });
  }
</script>

<style>
  @media print {
    body * {
      visibility: hidden;
    }
    #volunteerIdCardElement, #volunteerIdCardElement * {
      visibility: visible;
    }
    #volunteerIdCardElement {
      position: absolute;
      left: 50%;
      top: 50px;
      transform: translateX(-50%);
      box-shadow: none !important;
      border: 1px solid #0b4622 !important;
    }
    nav, header, footer {
      display: none !important;
    }
  }
</style>
@endsection
