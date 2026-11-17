<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ডিজিটাল স্বেচ্ছাসেবী পরিচয়পত্র — {{ $volunteer->name }} — আগামীর শৈলকুপা</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    body {
      font-family: 'Hind Siliguri', 'SolaimanLipi', 'Noto Sans Bengali', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      background-color: #f1f5f9;
      margin: 0;
      padding: 0;
    }

    @media print {
      * {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        color-adjust: exact !important;
      }
      html, body {
        background-color: #ffffff !important;
        background: #ffffff !important;
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        height: auto !important;
      }
      .no-print {
        display: none !important;
      }
      #printContainer {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        padding: 20px 0 !important;
        margin: 0 auto !important;
        width: 100% !important;
      }
      #volunteerIdCardElement {
        box-shadow: none !important;
        border: 2px solid #0b4622 !important;
        margin: 0 auto !important;
        page-break-inside: avoid !important;
        break-inside: avoid !important;
      }
    }
  </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-4 sm:p-8">

@php
  $siteSetting = \App\Models\SiteSetting::first();
  $siteLogo = asset('assets/images/logo-icon.png');
  $publicProfileUrl = route('volunteers.card', $volunteer->uuid ?: $volunteer->slug);

  // Photo
  $photoUrl = $volunteer->photo_url;
  $signatureBase64 = null;
  if ($volunteer->signature && \Illuminate\Support\Facades\Storage::disk('public')->exists($volunteer->signature)) {
      $sigPath = storage_path('app/public/' . $volunteer->signature);
      $signatureBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($sigPath));
  }
@endphp

  {{-- Print & Control Topbar (No nav, No tab, Clean bar) --}}
  <div class="no-print w-full max-w-[420px] mb-5 flex items-center justify-between gap-3 bg-white p-3.5 rounded-2xl shadow-sm border border-gray-200">
    <a href="{{ $publicProfileUrl }}"
       class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold transition">
      <i class="ri-arrow-left-line text-sm"></i>
      <span>প্রোফাইলে ফিরুন</span>
    </a>

    <div class="flex items-center gap-2">
      <button type="button"
              onclick="window.print()"
              class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-xs transition cursor-pointer">
        <i class="ri-printer-line text-sm"></i>
        <span>প্রিন্ট / PDF</span>
      </button>

      <button type="button"
              id="btnDownloadPNG"
              onclick="downloadVolunteerCardAsPNG()"
              class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-xs transition cursor-pointer">
        <i class="ri-download-2-line text-sm"></i>
        <span>PNG ছবি</span>
      </button>
    </div>
  </div>

  {{-- Dedicated Card Canvas Container --}}
  <div id="printContainer" class="flex justify-center items-center">
    <div id="volunteerIdCardElement"
         style="width: 380px; max-width: 380px; background-color: #ffffff; border-radius: 24px; border: 2px solid rgba(11, 70, 34, 0.35); box-shadow: 0 20px 30px -10px rgba(0,0,0,0.18); overflow: hidden; position: relative; color: #111827; user-select: none;">

      {{-- Top Lanyard Slot --}}
      <div style="padding-top: 12px; padding-bottom: 6px; display: flex; justify-content: center; background-color: #07381b;">
        <div style="width: 56px; height: 14px; border-radius: 9999px; background-color: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.35);"></div>
      </div>

      {{-- ID Card Header with Dynamic Logo & Tagline --}}
      <div style="background: linear-gradient(135deg, #07381b 0%, #0b4622 55%, #042411 100%); padding: 16px 20px 18px; text-align: center; color: #ffffff; position: relative;">
        <div style="display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 8px;">
          <div style="width: 38px; height: 38px; border-radius: 10px; background-color: #ffffff; padding: 4px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.15);">
            <img src="{{ $siteLogo }}" alt="Logo" style="max-width: 100%; max-height: 100%; object-fit: contain;">
          </div>
          <div style="text-align: left;">
            <div style="font-size: 16px; font-weight: 800; letter-spacing: 0.2px; line-height: 1.2;">
              {{ $siteSetting?->site_title ?: 'আগামীর শৈলকুপা' }}
            </div>
            <div style="font-size: 10px; opacity: 0.85; font-weight: 500; line-height: 1.2;">
              {{ $siteSetting?->site_tagline ?: 'শৈলকুপার উন্নয়নে আমরা এক পরিবার' }}
            </div>
          </div>
        </div>

        <div style="display: inline-block; background-color: #c8102e; color: #ffffff; font-size: 11px; font-weight: 700; padding: 3px 18px; border-radius: 9999px; box-shadow: 0 1px 3px rgba(0,0,0,0.25);">
          স্বেচ্ছাসেবী পরিচয়পত্র (Volunteer Card)
        </div>
      </div>

      {{-- Profile Photo & ID Display --}}
      <div style="padding: 16px 20px 8px; text-align: center; background-color: #ffffff;">
        <div style="display: inline-block; position: relative;">
          <div style="width: 104px; height: 104px; border-radius: 9999px; border: 4px solid #ffffff; box-shadow: 0 8px 16px -2px rgba(0,0,0,0.2); overflow: hidden; background-color: #f3f4f6; margin: 0 auto;">
            <img src="{{ $photoUrl }}" alt="{{ $volunteer->name }}" style="width: 100%; height: 100%; object-fit: cover;">
          </div>
          <div style="margin-top: -14px; position: relative; z-index: 10;">
            <span style="display: inline-flex; align-items: center; gap: 5px; background-color: #047857; color: #ffffff; font-size: 11px; font-weight: 700; padding: 3px 12px; border-radius: 9999px; border: 2px solid #ffffff; box-shadow: 0 2px 6px rgba(0,0,0,0.25); line-height: 1.2;">
              Verified
            </span>
          </div>
        </div>

        <div style="margin-top: 12px; margin-bottom: 8px;">
          <h2 style="font-size: 20px; font-weight: 800; color: #111827; margin: 0; line-height: 1.3;">
            {{ $volunteer->name }}
          </h2>
          <div style="margin-top: 6px;">
            <span style="display: inline-block; font-family: 'Courier New', Courier, monospace; font-size: 13px; font-weight: 800; color: #1f2937; background-color: #f3f4f6; border: 1px solid #d1d5db; padding: 2px 14px; border-radius: 6px; letter-spacing: 1px;">
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
            <span style="font-weight: 700; color: #4b5563; font-size: 12px;">রক্তের গ্রুপ:</span>
            <span style="font-weight: 800; color: #dc2626; background-color: #fef2f2; padding: 2px 10px; border-radius: 6px; border: 1px solid #fecaca; font-size: 12px;">
              {{ $volunteer->blood_group ?: 'N/A' }}
            </span>
          </div>

          {{-- Mobile Number --}}
          <div style="display: flex; align-items: center; justify-content: space-between; padding: 7px 0; border-bottom: 1px solid #e5e7eb;">
            <span style="font-weight: 700; color: #4b5563; font-size: 12px;">মোবাইল নম্বর:</span>
            <span style="font-weight: 700; color: #111827; font-family: 'Courier New', Courier, monospace; font-size: 13px;">{{ $volunteer->phone }}</span>
          </div>

          {{-- Email Address --}}
          @if($volunteer->email)
          <div style="display: flex; align-items: center; justify-content: space-between; padding: 7px 0; border-bottom: 1px solid #e5e7eb;">
            <span style="font-weight: 700; color: #4b5563; font-size: 12px; flex-shrink: 0;">ইমেইল:</span>
            <span style="font-weight: 600; color: #1f2937; font-size: 11.5px; word-break: break-all; text-align: right; padding-left: 8px;">{{ $volunteer->email }}</span>
          </div>
          @endif

          {{-- Address --}}
          <div style="display: flex; align-items: flex-start; justify-content: space-between; padding: 7px 0; border-bottom: 1px solid #e5e7eb;">
            <span style="font-weight: 700; color: #4b5563; font-size: 12px; flex-shrink: 0;">ঠিকানা:</span>
            <span style="font-weight: 600; color: #1f2937; font-size: 12px; line-height: 1.3; text-align: right; padding-left: 8px;">{{ $volunteer->address ?: 'শৈলকুপা, ঝিনাইদহ' }}</span>
          </div>

          {{-- Issue Date --}}
          <div style="display: flex; align-items: center; justify-content: space-between; padding: 7px 0 2px;">
            <span style="font-weight: 700; color: #4b5563; font-size: 12px;">ইস্যু তারিখ:</span>
            <span style="font-weight: 700; color: #374151; font-size: 12px;">{{ $volunteer->approved_at ? $volunteer->approved_at->format('d M, Y') : now()->format('d M, Y') }}</span>
          </div>
        </div>
      </div>

      {{-- QR Code & Authorized Signature Section --}}
      <div style="padding: 10px 24px 16px; display: flex; align-items: center; justify-content: space-between; gap: 12px; background-color: #ffffff;">
        <div style="display: flex; align-items: center; gap: 10px;">
          <div style="padding: 6px; background-color: #ffffff; border: 1px solid #d1d5db; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); width: 72px; height: 72px; display: flex; align-items: center; justify-content: center;">
            <div id="printVolunteerQrContainer"></div>
          </div>
          <div style="font-size: 10px; color: #6b7280; line-height: 1.3;">
            <span style="font-weight: 700; color: #0b4622; display: block;">স্ক্যান করুন</span>
            <span>অনলাইন ভেরিফিকেশন</span>
          </div>
        </div>

        <div style="text-align: right; min-width: 110px;">
          <div style="display: inline-block; text-align: center;">
            @if($signatureBase64)
              <div style="height: 38px; display: flex; align-items: center; justify-content: center; border-bottom: 1px solid #9ca3af; padding-bottom: 2px;">
                <img src="{{ $signatureBase64 }}" alt="স্বাক্ষর" style="max-height: 100%; max-width: 120px; object-fit: contain;">
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
          এই পরিচয়পত্রটি আগামীর শৈলকুপা-এর অফিসিয়াল সম্পত্তি।
        </p>
      </div>
    </div>
  </div>

  {{-- Scripts for QR and Download --}}
  <script src="{{ asset('assets/js/qrcode.min.js') }}"></script>
  <script src="{{ asset('assets/js/html-to-image.min.js') }}"></script>
  <script src="{{ asset('assets/js/html2canvas.min.js') }}"></script>

  <script>
    function renderPrintVolunteerCardQr() {
      const qrEl = document.getElementById('printVolunteerQrContainer');
      if (!qrEl) return;
      qrEl.innerHTML = '';
      const url = "{{ $publicProfileUrl }}";

      if (typeof QRCode !== 'undefined') {
        try {
          new QRCode(qrEl, {
            text: url,
            width: 60,
            height: 60,
            colorDark: "#0b4622",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.M
          });
          return;
        } catch(e) {
          console.warn(e);
        }
      }

      // Fallback QR Image API
      const img = document.createElement('img');
      img.src = 'https://api.qrserver.com/v1/create-qr-code/?size=60x60&color=0b4622&bgcolor=ffffff&data=' + encodeURIComponent(url);
      img.alt = 'QR';
      img.width = 60;
      img.height = 60;
      qrEl.appendChild(img);
    }

    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', renderPrintVolunteerCardQr);
    } else {
      renderPrintVolunteerCardQr();
    }

    async function downloadVolunteerCardAsPNG() {
      const btn = document.getElementById('btnDownloadPNG');
      const originalText = btn.innerHTML;
      btn.innerHTML = '<i class="ri-loader-4-line animate-spin"></i> তৈরি হচ্ছে...';
      btn.disabled = true;

      try {
        const cardElement = document.getElementById('volunteerIdCardElement');
        let dataUrl = null;

        if (window.htmlToImage) {
          try {
            dataUrl = await htmlToImage.toPng(cardElement, {
              pixelRatio: 3,
              backgroundColor: '#ffffff'
            });
          } catch(e) {
            console.warn(e);
          }
        }

        if (!dataUrl && window.html2canvas) {
          const canvas = await html2canvas(cardElement, { scale: 3, backgroundColor: '#ffffff' });
          dataUrl = canvas.toDataURL('image/png');
        }

        if (dataUrl) {
          const a = document.createElement('a');
          a.download = 'Volunteer-ID-Card-{{ $volunteer->id_card_number }}.png';
          a.href = dataUrl;
          a.click();
        }
      } catch (err) {
        alert('ছবি ডাউনলোড করতে সমস্যা হয়েছে। দয়া করে আবার চেষ্টা করুন।');
      } finally {
        btn.innerHTML = originalText;
        btn.disabled = false;
      }
    }
  </script>
</body>
</html>
