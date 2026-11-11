<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>পাসওয়ার্ড রিসেট — আগামীর শৈলকুপা</title>
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
      border-radius: 14px;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      border: 1px solid #e5e7eb;
    }
    .header-bar {
      background: linear-gradient(135deg, #0b4622 0%, #06381a 100%);
      padding: 30px 25px;
      text-align: center;
      border-bottom: 4px solid #c8102e;
    }
    .header-title {
      color: #ffffff;
      font-size: 24px;
      font-weight: 800;
      margin: 12px 0 4px;
      letter-spacing: -0.5px;
    }
    .header-subtitle {
      color: #a7f3d0;
      font-size: 13px;
      margin: 0;
      font-weight: 500;
    }
    .content-body {
      padding: 35px 30px;
      line-height: 1.8;
      font-size: 15px;
      color: #374151;
    }
    .greeting {
      font-size: 18px;
      font-weight: 700;
      color: #0b4622;
      margin-bottom: 16px;
    }
    .btn-container {
      text-align: center;
      margin: 32px 0;
    }
    .reset-btn {
      display: inline-block;
      background-color: #c8102e;
      color: #ffffff !important;
      text-decoration: none;
      font-size: 16px;
      font-weight: 700;
      padding: 14px 34px;
      border-radius: 50px;
      box-shadow: 0 4px 12px rgba(200, 16, 46, 0.35);
    }
    .link-box {
      background-color: #f9fafb;
      border: 1px dashed #d1d5db;
      border-radius: 8px;
      padding: 14px;
      margin-top: 24px;
      font-size: 12px;
      word-break: break-all;
      color: #6b7280;
    }
    .footer {
      background-color: #07381b;
      color: #9ca3af;
      padding: 24px;
      text-align: center;
      font-size: 12px;
      line-height: 1.6;
    }
    .footer a {
      color: #34d399;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <table role="presentation" class="email-container" width="100%" cellspacing="0" cellpadding="0">
      <!-- Header with Red-Green Theme -->
      <tr>
        <td class="header-bar">
          <div style="display: inline-block; width: 56px; height: 56px; background: rgba(255,255,255,0.15); border-radius: 50%; padding: 8px; border: 1px solid rgba(255,255,255,0.25);">
            <img src="{{ asset('assets/images/logo-icon.png') }}" alt="আগামীর শৈলকুপা" style="width: 100%; height: 100%; object-fit: contain;">
          </div>
          <h1 class="header-title">আগামীর শৈলকুপা</h1>
          <p class="header-subtitle">শৈলকুপার উন্নয়নে আমরা এক পরিবার</p>
        </td>
      </tr>

      <!-- Body Content -->
      <tr>
        <td class="content-body">
          <p class="greeting">আসসালামু আলাইকুম, {{ $user->name }}!</p>
          <p>
            আপনার <strong>আগামীর শৈলকুপা</strong> অ্যাকাউন্টের পাসওয়ার্ড রিসেট করার জন্য একটি অনুরোধ পাওয়া গেছে। আপনার অ্যাকাউন্টের নতুন পাসওয়ার্ড সেট করতে নিচের বাটনে ক্লিক করুন:
          </p>

          <!-- Call To Action Button -->
          <div class="btn-container">
            <a href="{{ $resetUrl }}" class="reset-btn" target="_blank">
              🔒 পাসওয়ার্ড রিসেট করুন
            </a>
          </div>

          <p style="color: #6b7280; font-size: 13.5px;">
            ⚠️ এই পাসওয়ার্ড রিসেট লিংকটির মেয়াদ আগামী <strong>৬০ মিনিট</strong> পর্যন্ত কার্যকর থাকবে।
          </p>

          <p style="color: #6b7280; font-size: 13.5px;">
            আপনি যদি এই পাসওয়ার্ড রিসেটের অনুরোধ না করে থাকেন, তবে কোনো পদক্ষেপ নেওয়ার প্রয়োজন নেই; আপনার অ্যাকাউন্ট সম্পূর্ণ সুরক্ষিত রয়েছে।
          </p>

          <!-- Alternative Link -->
          <div class="link-box">
            বাটনে কাজ না করলে নিচের লিংকটি কপি করে আপনার ব্রাউজারের অ্যাড্রেস বারে পেস্ট করুন:<br>
            <a href="{{ $resetUrl }}" style="color: #c8102e;">{{ $resetUrl }}</a>
          </div>
        </td>
      </tr>

      <!-- Footer Section -->
      <tr>
        <td class="footer">
          <p style="margin: 0 0 6px; color: #e5e7eb; font-weight: 600;">
            আগামীর শৈলকুপা — একটি অরাজনৈতিক সামাজিক উদ্যোগ
          </p>
          <p style="margin: 0; color: #9ca3af;">
            শৈলকুপা, ঝিনাইদহ | <a href="mailto:info@agamirshailkupa.org">info@agamirshailkupa.org</a>
          </p>
          <p style="margin: 8px 0 0; color: #6b7280; font-size: 11px;">
            © ২০২৬ আগামীর শৈলকুপা। সর্বস্বত্ব সংরক্ষিত।
          </p>
        </td>
      </tr>
    </table>
  </div>
</body>
</html>
