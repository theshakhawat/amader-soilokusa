<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>সদস্য হিসেবে নিবন্ধন অনুমোদিত — আগামীর শৈলকুপা</title>
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
      margin: 30px 0 15px;
    }
    .action-btn {
      display: inline-block;
      background: #0b4622;
      color: #ffffff !important;
      font-size: 15px;
      font-weight: 800;
      text-decoration: none;
      padding: 14px 34px;
      border-radius: 12px;
      box-shadow: 0 4px 14px rgba(11, 70, 34, 0.25);
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
        <p class="header-subtitle">সম্মানিত সাধারণ সদস্য হিসেবে স্বাগতম ও উষ্ণ অভিনন্দন</p>
      </div>

      {{-- Content --}}
      <div class="content-body">
        <div class="greeting">
          প্রিয় {{ $member->name }},
        </div>

        <p class="message-text">
          অত্যন্ত আনন্দের সাথে জানাচ্ছি যে, <strong>আগামীর শৈলকুপা</strong>-তে সাধারণ সদস্য (General Member) হিসেবে আপনার আবেদনটি সম্মানিত অ্যাডমিন কর্তৃক সফলভাবে <strong>অনুমোদিত (Approved)</strong> হয়েছে। শৈলকুপার শিক্ষা, স্বাস্থ্য, ঐতিহ্য সংরক্ষণ ও সমাজকল্যাণমূলক সার্বিক উন্নয়ন অভিযাত্রায় আপনাকে আমাদের সহযাত্রী সদস্য হিসেবে পেয়ে আমরা অত্যন্ত আনন্দিত।
        </p>

        {{-- Motivational Quote Box --}}
        <div class="quote-box">
          <div class="quote-icon">“</div>
          <p class="quote-text">
            “ঐক্যই শক্তি, সেবাই পরম ধর্ম — একটি সুন্দর, মানবিক ও সমৃদ্ধ শৈলকুপা বিনির্মাণে আপনার সক্রিয় অংশগ্রহণ ও নিঃস্বার্থ সহযোগিতা আমাদের শক্তি যোগাবে।”
          </p>
          <div class="quote-author">— আগামীর শৈলকুপা পরিষদ</div>
        </div>

        {{-- Member Summary --}}
        <div class="info-card">
          <div style="font-weight: 700; color: #0b4622; font-size: 14px; margin-bottom: 12px; border-bottom: 1px solid #e5e7eb; padding-bottom: 6px;">
            সদস্য পরিচিতি ও বিবরণী:
          </div>
          <div class="info-row">
            <span class="info-label">সদস্যের নাম:</span>
            <span class="info-val">{{ $member->name }}</span>
          </div>
          <div class="info-row">
            <span class="info-label">সদস্য আইডি (Member ID):</span>
            <span class="info-val" style="color: #0b4622;">{{ $member->card_id_number }}</span>
          </div>
          <div class="info-row">
            <span class="info-label">মোবাইল নম্বর:</span>
            <span class="info-val">{{ $member->phone }}</span>
          </div>
          <div class="info-row">
            <span class="info-label">ইমেইল ঠিকানা:</span>
            <span class="info-val">{{ $member->email }}</span>
          </div>
          @if($member->blood_group)
          <div class="info-row">
            <span class="info-label">রক্তের গ্রুপ:</span>
            <span class="info-val" style="color: #c8102e;">{{ $member->blood_group }}</span>
          </div>
          @endif
          @if($member->address)
          <div class="info-row">
            <span class="info-label">ঠিকানা:</span>
            <span class="info-val">{{ $member->address }}</span>
          </div>
          @endif
          <div class="info-row">
            <span class="info-label">সদস্যপদ স্ট্যাটাস:</span>
            <span class="info-val" style="color: #0b4622;">অনুমোদিত ও সক্রিয় (Active)</span>
          </div>
        </div>

        <p class="message-text">
          নিচের বাটনে ক্লিক করে আপনি আপনার অফিসিয়াল ডিজিটাল মেম্বার আইডি কার্ডটি দেখে নিতে পারেন এবং ছবি (PNG) বা PDF আকারে ডাউনলোড করতে পারেন।
        </p>

        {{-- ID Card Download Button --}}
        <div class="btn-container">
          <a href="{{ $member->public_card_url }}" class="action-btn">
            🪪 ডিজিটাল সদস্য পরিচয়পত্র ডাউনলোড করুন
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
