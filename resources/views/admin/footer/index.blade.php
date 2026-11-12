@extends('layouts.admin.admin-layout')

@section('title', 'ফুটার কাস্টমাইজেশন | আগামী শৈলকুপা')

@section('content')
<div class="space-y-6">
  <!-- Top Navigation & Actions Bar -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
    <div>
      <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622] transition">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <span>কাস্টমাইজেশন</span>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <span class="text-[#0b4622] font-semibold">ফুটার সেটিংস</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-800 tracking-tight flex items-center gap-2">
        <i class="ri-layout-bottom-2-line text-[#0b4622]"></i>
        <span>ফুটার কন্টেন্ট ও কপিরাইট (Footer Customization)</span>
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-0.5">ওয়েবসাইটের ফুটারে প্রদর্শিত পরিচিতি, দ্রুত লিংক, গুরুত্বপূর্ণ লিংক ও কপিরাইট নিয়ন্ত্রণ করুন।</p>
    </div>

    <div>
      <a
        href="{{ route('home') }}#footer-section"
        target="_blank"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition cursor-pointer"
      >
        <i class="ri-external-link-line"></i>
        <span>লাইভ ফুটার দেখুন</span>
      </a>
    </div>
  </div>

  <!-- Success Notification Alert -->
  @if(session('success'))
    <div id="flash-alert" class="flex items-center justify-between p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-xs font-semibold animate-fade-in">
      <div class="flex items-center gap-2.5">
        <i class="ri-checkbox-circle-fill text-emerald-600 text-lg"></i>
        <span>{{ session('success') }}</span>
      </div>
      <button type="button" onclick="document.getElementById('flash-alert').remove()" class="text-emerald-600 hover:text-emerald-800 cursor-pointer">
        <i class="ri-close-line text-base"></i>
      </button>
    </div>
  @endif

  <!-- Form Card -->
  <form action="{{ route('admin.customization.footer.update') }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')

    <!-- Section 1: Col 1 - Brand & About -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6 space-y-5">
      <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
        <span class="w-9 h-9 rounded-xl bg-[#0b4622]/10 text-[#0b4622] flex items-center justify-center font-bold text-lg">
          <i class="ri-building-line"></i>
        </span>
        <div>
          <h2 class="text-sm font-bold text-gray-800">কলাম ১: ব্র্যান্ডিং ও পরিচিতি (Brand & About)</h2>
          <p class="text-xs text-gray-500">ফুটারে বাম পাশের লোগো, নাম, ট্যাগলাইন এবং সংক্ষিপ্ত পরিচিতি</p>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Brand Title -->
        <div>
          <label for="brand_title" class="block text-xs font-bold text-gray-700 mb-1.5">
            ব্র্যান্ড নাম (Brand Title) <span class="text-[#c8102e]">*</span>
          </label>
          <input
            type="text"
            id="brand_title"
            name="brand_title"
            value="{{ old('brand_title', $footer->brand_title) }}"
            placeholder="আগামীর শৈলকুপা"
            class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
            required
          >
        </div>

        <!-- Brand Subtitle -->
        <div>
          <label for="brand_subtitle" class="block text-xs font-bold text-gray-700 mb-1.5">
            ট্যাগলাইন (Brand Subtitle)
          </label>
          <input
            type="text"
            id="brand_subtitle"
            name="brand_subtitle"
            value="{{ old('brand_subtitle', $footer->brand_subtitle) }}"
            placeholder="শৈলকুপার উন্নয়নে আমরা এক পরিবার"
            class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
          >
        </div>
      </div>

      <!-- About Text -->
      <div>
        <label for="about_text" class="block text-xs font-bold text-gray-700 mb-1.5">
          সংক্ষিপ্ত পরিচিতি বার্তা (About Description)
        </label>
        <textarea
          id="about_text"
          name="about_text"
          rows="2"
          placeholder="শৈলকুপার সার্বিক উন্নয়ন, ঐতিহ্য সংরক্ষণ ও মানুষের কল্যাণে নিবেদিত একটি সামাজিক উদ্যোগ।"
          class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
        >{{ old('about_text', $footer->about_text) }}</textarea>
      </div>

      <!-- Show Social Links in Footer -->
      <div class="p-3.5 bg-gray-50 rounded-xl flex items-center justify-between">
        <div>
          <span class="text-xs font-bold text-gray-800 block">ফুটারে সোশ্যাল মিডিয়া আইকন প্রদর্শন</span>
          <span class="text-[11px] text-gray-500">চালু থাকলে সক্রিয় সোশ্যাল মিডিয়া আইকনগুলো ফুটারে প্রদর্শিত হবে</span>
        </div>
        <label class="relative inline-flex items-center cursor-pointer">
          <input
            type="checkbox"
            name="show_social_links"
            value="1"
            class="sr-only peer"
            {{ old('show_social_links', $footer->show_social_links) ? 'checked' : '' }}
          >
          <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0b4622]"></div>
        </label>
      </div>
    </div>

    <!-- Section 2: Col 2 & Col 3 - Links Management -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Col 2: Quick Links (দ্রুত লিংক) -->
      <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6 space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
          <div>
            <h2 class="text-sm font-bold text-gray-800">কলাম ২: দ্রুত লিংক (Quick Links)</h2>
            <p class="text-xs text-gray-500">মেনু আইটেম ও লিংকসমূহ</p>
          </div>
          <button
            type="button"
            onclick="addLinkRow('quick-links-container', 'quick_links')"
            class="px-3 py-1.5 bg-[#0b4622]/10 hover:bg-[#0b4622]/20 text-[#0b4622] rounded-lg text-xs font-bold transition flex items-center gap-1 cursor-pointer"
          >
            <i class="ri-add-line"></i> লিংক যোগ করুন
          </button>
        </div>

        <div>
          <label for="quick_links_title" class="block text-xs font-bold text-gray-700 mb-1">
            কলাম শিরোনাম <span class="text-[#c8102e]">*</span>
          </label>
          <input
            type="text"
            id="quick_links_title"
            name="quick_links_title"
            value="{{ old('quick_links_title', $footer->quick_links_title) }}"
            placeholder="দ্রুত লিংক"
            class="w-full px-3.5 py-2 text-xs bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#0b4622]"
            required
          >
        </div>

        <div id="quick-links-container" class="space-y-2.5 pt-2">
          @php
            $quickLinks = old('quick_links', $footer->quick_links ?? []);
          @endphp
          @foreach($quickLinks as $item)
            <div class="flex items-center gap-2 link-row">
              <input
                type="text"
                name="quick_links_labels[]"
                value="{{ $item['label'] ?? '' }}"
                placeholder="লেবেল (যেমন: হোম)"
                class="w-1/2 px-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#0b4622]"
              >
              <input
                type="text"
                name="quick_links_urls[]"
                value="{{ $item['url'] ?? '' }}"
                placeholder="ইউআরএল (যেমন: #hero-section)"
                class="w-1/2 px-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#0b4622]"
              >
              <button
                type="button"
                onclick="this.closest('.link-row').remove()"
                class="p-1.5 text-gray-400 hover:text-red-600 rounded-md hover:bg-red-50 transition cursor-pointer"
                title="মুছে ফেলুন"
              >
                <i class="ri-delete-bin-line text-sm"></i>
              </button>
            </div>
          @endforeach
        </div>
      </div>

      <!-- Col 3: Important Links (গুরুত্বপূর্ণ লিংক) -->
      <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6 space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
          <div>
            <h2 class="text-sm font-bold text-gray-800">কলাম ৩: গুরুত্বপূর্ণ লিংক (Important Links)</h2>
            <p class="text-xs text-gray-500">জরুরি পেজের লিংকসমূহ</p>
          </div>
          <button
            type="button"
            onclick="addLinkRow('important-links-container', 'important_links')"
            class="px-3 py-1.5 bg-[#0b4622]/10 hover:bg-[#0b4622]/20 text-[#0b4622] rounded-lg text-xs font-bold transition flex items-center gap-1 cursor-pointer"
          >
            <i class="ri-add-line"></i> লিংক যোগ করুন
          </button>
        </div>

        <div>
          <label for="important_links_title" class="block text-xs font-bold text-gray-700 mb-1">
            কলাম শিরোনাম <span class="text-[#c8102e]">*</span>
          </label>
          <input
            type="text"
            id="important_links_title"
            name="important_links_title"
            value="{{ old('important_links_title', $footer->important_links_title) }}"
            placeholder="গুরুত্বপূর্ণ লিংক"
            class="w-full px-3.5 py-2 text-xs bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#0b4622]"
            required
          >
        </div>

        <div id="important-links-container" class="space-y-2.5 pt-2">
          @php
            $importantLinks = old('important_links', $footer->important_links ?? []);
          @endphp
          @foreach($importantLinks as $item)
            <div class="flex items-center gap-2 link-row">
              <input
                type="text"
                name="important_links_labels[]"
                value="{{ $item['label'] ?? '' }}"
                placeholder="লেবেল (যেমন: কমিটি)"
                class="w-1/2 px-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#0b4622]"
              >
              <input
                type="text"
                name="important_links_urls[]"
                value="{{ $item['url'] ?? '' }}"
                placeholder="ইউআরএল (যেমন: #committee-section)"
                class="w-1/2 px-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#0b4622]"
              >
              <button
                type="button"
                onclick="this.closest('.link-row').remove()"
                class="p-1.5 text-gray-400 hover:text-red-600 rounded-md hover:bg-red-50 transition cursor-pointer"
                title="মুছে ফেলুন"
              >
                <i class="ri-delete-bin-line text-sm"></i>
              </button>
            </div>
          @endforeach
        </div>
      </div>
    </div>

    <!-- Section 3: Col 4 Title & Bottom Copyright/Policies -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6 space-y-5">
      <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
        <span class="w-9 h-9 rounded-xl bg-[#0b4622]/10 text-[#0b4622] flex items-center justify-center font-bold text-lg">
          <i class="ri-copyright-line"></i>
        </span>
        <div>
          <h2 class="text-sm font-bold text-gray-800">কলাম ৪ ও কপিরাইট বার (Contact Title & Copyright Bar)</h2>
          <p class="text-xs text-gray-500">যোগাযোগ কলামের শিরোনাম এবং ফুটারে সবার নিচের কপিরাইট ও পলিসি লিংক</p>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Contact Column Title -->
        <div>
          <label for="contact_title" class="block text-xs font-bold text-gray-700 mb-1.5">
            যোগাযোগ কলামের শিরোনাম <span class="text-[#c8102e]">*</span>
          </label>
          <input
            type="text"
            id="contact_title"
            name="contact_title"
            value="{{ old('contact_title', $footer->contact_title) }}"
            placeholder="যোগাযোগ"
            class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622]"
            required
          >
          <p class="text-[11px] text-gray-400 mt-1">যোগাযোগের ঠিকানা ও ফোন নম্বর <a href="{{ route('admin.customization.contact') }}" class="text-[#0b4622] font-semibold underline">যোগাযোগ ট্যাব</a> থেকে স্বয়ংক্রিয়ভাবে আসে।</p>
        </div>

        <!-- Copyright Text -->
        <div>
          <label for="copyright_text" class="block text-xs font-bold text-gray-700 mb-1.5">
            কপিরাইট টেক্সট (Copyright Text) <span class="text-[#c8102e]">*</span>
          </label>
          <input
            type="text"
            id="copyright_text"
            name="copyright_text"
            value="{{ old('copyright_text', $footer->copyright_text) }}"
            placeholder="© ২০২৬ আগামীর শৈলকুপা। সর্বস্বত্ব সংরক্ষিত।"
            class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622]"
            required
          >
        </div>
      </div>

      <!-- Policy Links -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
        <div class="p-3.5 bg-gray-50 rounded-xl space-y-2">
          <span class="text-xs font-bold text-gray-700 block">গোপনীয়তা নীতি (Privacy Policy)</span>
          <div class="flex items-center gap-2">
            <input
              type="text"
              name="privacy_policy_text"
              value="{{ old('privacy_policy_text', $footer->privacy_policy_text) }}"
              placeholder="গোপনীয়তা নীতি"
              class="w-1/2 px-3 py-1.5 text-xs bg-white border border-gray-200 rounded-lg focus:outline-none focus:border-[#0b4622]"
            >
            <input
              type="text"
              name="privacy_policy_link"
              value="{{ old('privacy_policy_link', $footer->privacy_policy_link) }}"
              placeholder="ইউআরএল (যেমন: #)"
              class="w-1/2 px-3 py-1.5 text-xs bg-white border border-gray-200 rounded-lg focus:outline-none focus:border-[#0b4622]"
            >
          </div>
        </div>

        <div class="p-3.5 bg-gray-50 rounded-xl space-y-2">
          <span class="text-xs font-bold text-gray-700 block">ব্যবহারের শর্তাবলী (Terms of Service)</span>
          <div class="flex items-center gap-2">
            <input
              type="text"
              name="terms_text"
              value="{{ old('terms_text', $footer->terms_text) }}"
              placeholder="ব্যবহারের শর্তাবলী"
              class="w-1/2 px-3 py-1.5 text-xs bg-white border border-gray-200 rounded-lg focus:outline-none focus:border-[#0b4622]"
            >
            <input
              type="text"
              name="terms_link"
              value="{{ old('terms_link', $footer->terms_link) }}"
              placeholder="ইউআরএল (যেমন: #)"
              class="w-1/2 px-3 py-1.5 text-xs bg-white border border-gray-200 rounded-lg focus:outline-none focus:border-[#0b4622]"
            >
          </div>
        </div>
      </div>
    </div>

    <!-- Submit Button -->
    <div class="flex items-center justify-end">
      <button
        type="submit"
        class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-sm hover:shadow transition cursor-pointer"
      >
        <i class="ri-check-line"></i>
        <span>ফুটার সেটিংস সংরক্ষণ করুন</span>
      </button>
    </div>
  </form>
</div>

<script>
function addLinkRow(containerId, fieldPrefix) {
  const container = document.getElementById(containerId);
  const div = document.createElement('div');
  div.className = 'flex items-center gap-2 link-row';
  div.innerHTML = `
    <input
      type="text"
      name="${fieldPrefix}_labels[]"
      placeholder="লেবেল"
      class="w-1/2 px-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#0b4622]"
    >
    <input
      type="text"
      name="${fieldPrefix}_urls[]"
      placeholder="ইউআরএল (# বা /page/...)"
      class="w-1/2 px-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#0b4622]"
    >
    <button
      type="button"
      onclick="this.closest('.link-row').remove()"
      class="p-1.5 text-gray-400 hover:text-red-600 rounded-md hover:bg-red-50 transition cursor-pointer"
      title="মুছে ফেলুন"
    >
      <i class="ri-delete-bin-line text-sm"></i>
    </button>
  `;
  container.appendChild(div);
}
</script>
@endsection

