@extends('layouts.admin.admin-layout')

@section('title', 'ফন্ট ও টাইপোগ্রাফি সেটিংস')

@section('content')
<div class="space-y-6">
  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
    <div class="flex items-center gap-3">
      <div class="w-11 h-11 rounded-xl bg-[#0b4622]/10 text-[#0b4622] flex items-center justify-center text-2xl font-bold">
        <i class="ri-font-size"></i>
      </div>
      <div>
        <h1 class="text-xl font-bold text-gray-800">ফন্ট ও টাইপোগ্রাফি সেটিংস</h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-0.5">অ্যাডমিন প্যানেল এবং পাবলিক ওয়েবসাইটের বাংলা ও ইংরেজি ফন্ট কনফিগারেশন করুন</p>
      </div>
    </div>
    <div class="flex items-center gap-2">
      <button type="submit" form="font-settings-form" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#0b4622] hover:bg-[#08351a] text-white text-xs sm:text-sm font-semibold shadow-sm transition cursor-pointer">
        <i class="ri-save-line text-base"></i>
        <span>সেটিংস সংরক্ষণ করুন</span>
      </button>
    </div>
  </div>

  @if(session('success'))
  <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between">
    <div class="flex items-center gap-2">
      <i class="ri-checkbox-circle-fill text-emerald-600 text-lg"></i>
      <span>{{ session('success') }}</span>
    </div>
  </div>
  @endif

  @if(isset($errors) && $errors->any())
  <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm">
    <ul class="list-disc pl-5 space-y-1">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form id="font-settings-form" action="{{ route('admin.settings.font.update') }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

      <!-- ========================================== -->
      <!-- 1. অ্যাডমিন প্যানেল ফন্ট সেটিংস (Admin Panel) -->
      <!-- ========================================== -->
      <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between">
        <div>
          <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-5">
            <div class="flex items-center gap-2.5">
              <span class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm">
                <i class="ri-dashboard-3-line"></i>
              </span>
              <div>
                <h2 class="text-base font-bold text-gray-800">অ্যাডমিন প্যানেল ফন্ট (Admin Panel)</h2>
                <p class="text-xs text-gray-400">অ্যাডমিন প্যানেলের জন্য ফন্ট নির্বাচন করুন</p>
              </div>
            </div>
            <span class="text-xs px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 font-medium">ড্যাশবোর্ড</span>
          </div>

          <div class="space-y-4">
            <!-- Admin Font Family -->
            <div>
              <label for="admin_font_family" class="block text-xs font-bold text-gray-700 mb-1.5">
                ফন্ট সিলেক্ট করুন (Font Family) <span class="text-red-500">*</span>
              </label>
              <select name="admin_font_family" id="admin_font_family" class="w-full text-base rounded-xl border border-gray-200 px-3.5 py-3 bg-white focus:ring-2 focus:ring-[#0b4622] focus:border-transparent transition font-bold">
                @foreach($bengaliFonts as $group => $fonts)
                  <optgroup label="{{ $group }}">
                    @foreach($fonts as $value => $label)
                      <option value="{{ $value }}" {{ old('admin_font_family', $fontSetting->admin_font_family) == $value ? 'selected' : '' }}>
                        {{ $label }}
                      </option>
                    @endforeach
                  </optgroup>
                @endforeach
              </select>
            </div>
          </div>
        </div>

        <!-- Live Preview: Admin -->
        <div class="mt-8 pt-5 border-t border-gray-100">
          <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-bold uppercase tracking-wider text-gray-400">লাইভ প্রিভিউ (Admin Preview)</span>
            <span class="text-[11px] text-blue-600 bg-blue-50 px-2.5 py-0.5 rounded font-mono font-bold" id="admin_preview_badge">SolaimanLipi</span>
          </div>
          <div id="admin_preview_box" class="p-5 rounded-xl bg-gray-50 border border-gray-200 transition-all duration-200">
            <h4 class="text-xl text-gray-900 mb-1.5 font-bold">অ্যাডমিন প্যানেল ড্যাশবোর্ড ও রিপোর্ট</h4>
            <p class="text-sm text-gray-700 leading-relaxed mb-2 font-bold">
              আমার সোনার বাংলা, আমি তোমায় ভালোবাসি। চিরদিন তোমার আকাশ, তোমার বাতাস, আমার প্রাণে বাজায় বাঁশি।
            </p>
            <div class="text-xs text-gray-500 font-mono font-semibold">
              The quick brown fox jumps over the lazy dog. 1234567890
            </div>
          </div>
        </div>
      </div>

      <!-- ========================================== -->
      <!-- 2. ওয়েবসাইট ফন্ট সেটিংস (Website / Public)  -->
      <!-- ========================================== -->
      <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between">
        <div>
          <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-5">
            <div class="flex items-center gap-2.5">
              <span class="w-8 h-8 rounded-lg bg-emerald-50 text-[#0b4622] flex items-center justify-center font-bold text-sm">
                <i class="ri-global-line"></i>
              </span>
              <div>
                <h2 class="text-base font-bold text-gray-800">পাবলিক ওয়েবসাইট ফন্ট (Website Font)</h2>
                <p class="text-xs text-gray-400">ওয়েবসাইটের ভিজিটরদের জন্য মূল ফন্ট</p>
              </div>
            </div>
            <span class="text-xs px-2.5 py-1 rounded-full bg-emerald-50 text-[#0b4622] font-medium">ভিজিটর ভিউ</span>
          </div>

          <div class="space-y-4">
            <!-- Website Font Family -->
            <div>
              <label for="website_font_family" class="block text-xs font-bold text-gray-700 mb-1.5">
                ফন্ট সিলেক্ট করুন (Font Family) <span class="text-red-500">*</span>
              </label>
              <select name="website_font_family" id="website_font_family" class="w-full text-base rounded-xl border border-gray-200 px-3.5 py-3 bg-white focus:ring-2 focus:ring-[#0b4622] focus:border-transparent transition font-bold">
                @foreach($bengaliFonts as $group => $fonts)
                  <optgroup label="{{ $group }}">
                    @foreach($fonts as $value => $label)
                      <option value="{{ $value }}" {{ old('website_font_family', $fontSetting->website_font_family) == $value ? 'selected' : '' }}>
                        {{ $label }}
                      </option>
                    @endforeach
                  </optgroup>
                @endforeach
              </select>
            </div>
          </div>
        </div>

        <!-- Live Preview: Website -->
        <div class="mt-8 pt-5 border-t border-gray-100">
          <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-bold uppercase tracking-wider text-gray-400">লাইভ প্রিভিউ (Website Preview)</span>
            <span class="text-[11px] text-emerald-600 bg-emerald-50 px-2.5 py-0.5 rounded font-mono font-bold" id="website_preview_badge">SolaimanLipi</span>
          </div>
          <div id="website_preview_box" class="p-5 rounded-xl bg-gray-50 border border-gray-200 transition-all duration-200">
            <h4 class="text-xl text-[#0b4622] mb-1.5 font-bold">ঐতিহ্যবাহী শৈলকুপার ইতিহাস ও সংস্কৃতি</h4>
            <p class="text-sm text-gray-800 leading-relaxed mb-2 font-bold">
              আগামীর শৈলকুপা একটি অরাজনৈতিক ও অলাভজনক মানবিক ও সামাজিক উন্নয়ন সংস্থা। শৈলকুপাকে একটি আধুনিক ও আদর্শ উপজেলা হিসেবে গড়ে তুলতে আমরা অঙ্গীকারবদ্ধ।
            </p>
            <div class="text-xs text-gray-500 font-mono font-semibold">
              Agamir Shailkupa - A Non-profit Humanitarian Organization. Est. 2026.
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Info Note -->
    <div class="p-4 rounded-2xl bg-amber-50/70 border border-amber-200/80 text-amber-900 text-xs sm:text-sm flex items-start gap-3">
      <i class="ri-lightbulb-line text-lg text-amber-600 mt-0.5"></i>
      <div>
        <span class="font-bold">টিপস ও তথ্য:</span>
        <p class="text-amber-800 text-xs mt-0.5 font-medium">
          আপনার পছন্দের ফন্টটি নির্বাচন করে "সেটিংস সংরক্ষণ করুন" বাটনে ক্লিক করুন। সাথে সাথে অ্যাডমিন প্যানেল ও পুরো ওয়েবসাইটে নির্বাচিত ফন্টটি স্বয়ংক্রিয়ভাবে কার্যকর হয়ে যাবে।
        </p>
      </div>
    </div>
  </form>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const adminFontFamily = document.getElementById('admin_font_family');
    const adminPreviewBox = document.getElementById('admin_preview_box');
    const adminPreviewBadge = document.getElementById('admin_preview_badge');

    const websiteFontFamily = document.getElementById('website_font_family');
    const websitePreviewBox = document.getElementById('website_preview_box');
    const websitePreviewBadge = document.getElementById('website_preview_badge');

    function updateAdminPreview() {
      const family = adminFontFamily.value;
      adminPreviewBox.style.fontFamily = `"${family}", 'Inter', sans-serif`;
      adminPreviewBadge.textContent = family;
    }

    function updateWebsitePreview() {
      const family = websiteFontFamily.value;
      websitePreviewBox.style.fontFamily = `"${family}", 'Inter', sans-serif`;
      websitePreviewBadge.textContent = family;
    }

    adminFontFamily.addEventListener('change', updateAdminPreview);
    websiteFontFamily.addEventListener('change', updateWebsitePreview);

    updateAdminPreview();
    updateWebsitePreview();
  });
</script>
@endsection
