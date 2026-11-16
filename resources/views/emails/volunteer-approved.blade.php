<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>স্বেচ্ছাসেবী হিসেবে নিবন্ধন সফল ও অনুমোদিত — আগামীর শৈলকুপা</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #f4f5f7;
      font-family: 'Hind Siliguri', 'Noto Sans Bengali', Arial, sans-serif;
      color: #333333;
      -webkit-font-smoothing: antialiased;
    }
    .wrapper {
      width: 100%;
      table-layout: fixed;
      background-color: #f4f5f7;
      padding: 40px 15px;
    }
    .email-container {
      max-width: 600px;
      margin: 0 auto;
      background-color: #ffffff;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      border: 1px solid #e5e7eb;
    }
    .header-bar {
      background: linear-gradient(135deg, #0b4622 0%, #06381a 100%);
      padding: 35px 25px 30px;
      text-align: center;
      border-bottom: 4px solid #c8102e;
    }
    .badge-icon {
      width: 60px;
      height: 60px;
      line-height: 60px;
      background: rgba(255, 255, 255, 0.15);
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      margin: 0 auto 12px;
      font-size: 28px;
      color: #ffffff;
      text-align: center;
    }
    .header-title {
      color: #ffffff;
      font-size: 24px;
      font-weight: 800;
      margin: 0 0 6px;
      letter-spacing: -0.5px;
    }
    .header-subtitle {
      color: #a7f3d0;
      font-size: 14px;
      margin: 0;
      font-weight: 500;
    }
    .content-body {
      padding: 35px 30px;
    }
    .greeting {
      font-size: 18px;
      font-weight: 700;
      color: #111827;
      margin-bottom: 15px;
    }
    .message-text {
      font-size: 14.5px;
      line-height: 1.7;
      color: #4b5563;
      margin-bottom: 25px;
    }
    .quote-box {
      background: linear-gradient(135deg, #ecfdf5 0%, #f0fdf4 100%);
      border-left: 4px solid #0b4622;
      border-radius: 12px;
      padding: 20px 22px;
      margin: 25px 0;
      box-shadow: 0 2px 6px rgba(11, 70, 34, 0.05);
    }
    .quote-icon {
      font-size: 26px;
      color: #0b4622;
      line-height: 1;
      margin-bottom: 6px;
    }
    .quote-text {
      font-size: 15px;
      font-style: italic;
      color: #064e3b;
      line-height: 1.6;
      font-weight: 600;
      margin: 0;
    }
    .quote-author {
      font-size: 12px;
      color: #047857;
      margin-top: 8px;
      font-weight: 600;
      text-align: right;
    }
    .info-card {
      background: #f9fafb;
      border: 1px solid #e5e7eb;
      border-radius: 12px;
      padding: 20px;
      margin: 25px 0;
    }
    .info-row {
      display: flex;
      justify-content: space-between;
      padding: 8px 0;
      border-bottom: 1px dashed #e5e7eb;
      font-size: 13.5px;
    }
    .info-row:last-child {
      border-bottom: none;
      padding-bottom: 0;
    }
    .info-label {
      color: #6b7280;
      font-weight: 600;
    }
    .info-val {
      color: #111827;
      font-weight: 700;
      text-align: right;
    }
    .btn-container {
      text-align: center;
      margin: 30px 0 10px;
    }
    .action-btn {
      display: inline-block;
      background: #0b4622;
      color: #ffffff !important;
      font-size: 14px;
      font-weight: 700;
      text-decoration: none;
      padding: 12px 30px;
      border-radius: 10px;
      transition: background 0.2s;
    }
    .footer-bar {
      background: #f9fafb;
      padding: 22px 25px;
      text-align: center;
      border-top: 1px solid #e5e7eb;
      font-size: 12px;
      color: #6b7280;
    }
    .footer-bar p {
      margin: 4px 0;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="email-container">
      {{-- Header --}}
      <div class="header-bar">
        <div class="badge-icon">✓</div>
        <h1 class="header-title">আগামীর শৈলকুপা</h1>
        <p class="header-subtitle">স্বেচ্ছাসেবী কর্মী হিসেবে স্বাগতম ও অভিনন্দন</p>
      </div>

      {{-- Content --}}
      <div class="content-body">
        <div class="greeting">
          প্রিয় {{ $volunteer->name }},
        </div>

        <p class="message-text">
          আনন্দঘন চিত্তে জানাচ্ছি যে, <strong>আগামীর শৈলকুপা</strong>-তে স্বেচ্ছাসেবী কর্মী হিসেবে আপনার আবেদনটি সম্মানিত অ্যাডমিন কর্তৃক সফলভাবে <strong>অনুমোদিত (Approved)</strong> হয়েছে। শৈলকুপার উন্নয়ন, ঐতিহ্য রক্ষা ও সমাজসেবামূলক কার্যক্রমে আপনার মতো নিবেদিতপ্রাণ মানুষকে পাশে পেয়ে আমরা গর্বিত।
        </p>

        {{-- Motivational Quote Box --}}
        <div class="quote-box">
          <div class="quote-icon">“</div>
          <p class="quote-text">
            “মানুষ মানুষের জন্য, জীবন জীবনের জন্য — আপনার একটি ক্ষুদ্র নিঃস্বার্থ প্রচেষ্টা ও সহানুভূতি বদলে দিতে পারে অনেকের জীবন, গড়ে তুলতে পারে একটি সমৃদ্ধ ও মানবিক শৈলকুপা।”
          </p>
          <div class="quote-author">— আগামীর শৈলকুপা পরিবার</div>
        </div>

        {{-- Volunteer Summary --}}
        <div class="info-card">
          <div style="font-weight: 700; color: #0b4622; font-size: 14px; margin-bottom: 12px; border-bottom: 1px solid #e5e7eb; padding-bottom: 6px;">
            স্বেচ্ছাসেবী কর্মী বিবরণী:
          </div>
          <div class="info-row">
            <span class="info-label">আইডি নম্বর:</span>
            <span class="info-val" style="color: #0b4622; font-family: monospace;">{{ $volunteer->card_id_number }}</span>
          </div>
          <div class="info-row">
            <span class="info-label">দাতার / কর্মীর নাম:</span>
            <span class="info-val">{{ $volunteer->name }}</span>
          </div>
          <div class="info-row">
            <span class="info-label">মোবাইল নম্বর:</span>
            <span class="info-val">{{ $volunteer->phone }}</span>
          </div>
          @if($volunteer->email)
          <div class="info-row">
            <span class="info-label">ইমেইল অ্যাড্রেস:</span>
            <span class="info-val">{{ $volunteer->email }}</span>
          </div>
          @endif
          @if($volunteer->blood_group)
          <div class="info-row">
            <span class="info-label">রক্তের গ্রুপ:</span>
            <span class="info-val" style="color: #c8102e;">{{ $volunteer->blood_group }}</span>
          </div>
          @endif
          @if($volunteer->address)
          <div class="info-row">
            <span class="info-label">ঠিকানা:</span>
            <span class="info-val">{{ $volunteer->address }}</span>
          </div>
          @endif
          <div class="info-row">
            <span class="info-label">স্ট্যাটাস:</span>
            <span class="info-val" style="color: #0b4622;">সক্রিয় ও অনুমোদিত (Active)</span>
          </div>
        </div>

        <p class="message-text">
          আমাদের যেকোনো সামাজিক উন্নয়ন কর্মসূচি, জরুরি রক্তদান সহায়তা কিংবা সামাজিক কার্যক্রমে সমন্বয়ক দল সরাসরি আপনার সাথে যোগাযোগ করবে।
        </p>

        <div class="btn-container" style="text-align: center; margin: 30px 0 15px;">
          <a href="{{ $volunteer->public_card_url }}" class="action-btn" style="background: #0b4622; color: #ffffff !important; font-size: 15px; font-weight: 800; text-decoration: none; padding: 14px 34px; border-radius: 12px; display: inline-block; box-shadow: 0 4px 14px rgba(11, 70, 34, 0.25);">
            🪪 ডিজিটাল আইডি কার্ড দেখুন ও ডাউনলোড করুন
          </a>
        </div>
      </div>

      {{-- Footer --}}
      <div class="footer-bar">
        <p><strong>আগামীর শৈলকুপা</strong> — শৈলকুপার সার্বিক উন্নয়নে নিবেদিত একটি সামাজিক উদ্যোগ</p>
        <p>© {{ date('Y') }} আগামীর শৈলকুপা। সর্বস্বত্ব সংরক্ষিত।</p>
      </div>
    </div>
  </div>
</body>
</html>
