@extends('layouts.website.website-layout')

@section('title', 'যোগাযোগ - আগামীর শৈলকুপা')

@section('content')
<main class="py-8 sm:py-14 bg-gray-50/60 min-h-screen">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 sm:space-y-12">

    <!-- Header Section -->
    <div class="text-center max-w-3xl mx-auto">
      <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-50 text-[#0b4622] text-xs sm:text-sm font-extrabold mb-3 border border-emerald-100 shadow-2xs">
        <i class="ri-mail-send-line text-base"></i>
        <span>আমাদের সাথে যোগাযোগ</span>
      </div>
      <h1 class="text-2xl sm:text-4xl font-black text-gray-900 tracking-tight">
        আপনার যেকোনো জিজ্ঞাসা বা মতামতে <span class="text-[#c8102e]">আমরা পাশে আছি</span>
      </h1>
      <p class="text-xs sm:text-base text-gray-600 mt-2 font-medium">
        শৈলকুপার উন্নয়ন, যেকোনো প্রকল্প, অনুদান বা পরামর্শের জন্য আমাদের সাথে সরাসরি যোগাযোগ করতে পারেন অথবা নিচের ফর্মে বার্তা পাঠাতে পারেন।
      </p>
    </div>

    <!-- Top Grid: Left Side (Contact Details) & Right Side (Interactive Google Map) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 items-stretch">

      <!-- Left Side (5 Cols): Office Info Cards -->
      <div class="lg:col-span-5 flex flex-col justify-between space-y-4">

        <!-- Card: Office & Location -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-gray-100 shadow-xs hover:shadow-md transition">
          <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-red-50 text-[#c8102e] flex items-center justify-center text-xl shrink-0 border border-red-100">
              <i class="fa-solid fa-location-dot"></i>
            </div>
            <div class="flex-1 min-w-0">
              <span class="text-[11px] font-extrabold uppercase tracking-wider text-gray-400">অফিস ও অবস্থান</span>
              <h3 class="text-base sm:text-lg font-black text-gray-900 mt-0.5">
                {{ $contact->office_name ?: 'আগামীর শৈলকুপা কেন্দ্রীয় কার্যালয়' }}
              </h3>
              <p class="text-xs sm:text-sm text-gray-600 mt-1 leading-relaxed">
                {{ $contact->address ?: 'শৈলকুপা পৌরসভা মোড়, শৈলকুপা, ঝিনাইদহ, বাংলাদেশ' }}
              </p>
              <div class="mt-2 text-[11px] font-bold text-emerald-700 flex items-center gap-1.5">
                <i class="ri-map-pin-2-fill"></i>
                <span>{{ $contact->location ?: 'শৈলকুপা' }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Card: Phone / Helpline -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-gray-100 shadow-xs hover:shadow-md transition">
          <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#0b4622] flex items-center justify-center text-xl shrink-0 border border-emerald-100">
              <i class="fa-solid fa-phone"></i>
            </div>
            <div class="flex-1 min-w-0">
              <span class="text-[11px] font-extrabold uppercase tracking-wider text-gray-400">টেলিফোন ও হেল্পলাইন</span>
              <h3 class="text-base sm:text-lg font-black text-gray-900 mt-0.5">
                {{ $contact->phone ?: '+880 1700-123456' }}
              </h3>
              @if($contact->alt_phone)
                <p class="text-xs text-gray-500 mt-0.5 font-medium">
                  বিকল্প নম্বর: <span class="font-bold text-gray-700">{{ $contact->alt_phone }}</span>
                </p>
              @endif
              <p class="text-[11px] text-gray-400 mt-1.5">সকাল ৯:০০ - রাত ৮:০০ (যেকোনো দিন)</p>
            </div>
          </div>
        </div>

        <!-- Card: Email -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-gray-100 shadow-xs hover:shadow-md transition">
          <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-xl shrink-0 border border-amber-100">
              <i class="fa-regular fa-envelope"></i>
            </div>
            <div class="flex-1 min-w-0">
              <span class="text-[11px] font-extrabold uppercase tracking-wider text-gray-400">অফিসিয়াল ইমেইল</span>
              <h3 class="text-base sm:text-lg font-black text-gray-900 mt-0.5 break-all">
                {{ $contact->email ?: 'info@agamirshailkupa.org' }}
              </h3>
              <p class="text-[11px] text-gray-400 mt-1">যেকোনো প্রশ্ন বা তথ্যের জন্য ইমেইল পাঠাতে পারেন</p>
            </div>
          </div>
        </div>

      </div>

      <!-- Right Side (7 Cols): Google Map iframe -->
      <div class="lg:col-span-7">
        <div class="bg-white rounded-2xl p-3 sm:p-4 border border-gray-100 shadow-xs h-full min-h-[340px] flex flex-col justify-between">
          <div class="flex items-center justify-between pb-2.5 px-2">
            <span class="text-xs sm:text-sm font-extrabold text-gray-800 flex items-center gap-2">
              <i class="ri-map-2-line text-[#0b4622] text-base"></i>
              <span>গুগল ম্যাপে আমাদের অবস্থান (Map Location)</span>
            </span>
            <span class="text-[11px] text-gray-400 font-semibold">শৈলকুপা, ঝিনাইদহ</span>
          </div>

          <div class="w-full flex-1 min-h-[300px] sm:min-h-[360px] rounded-xl overflow-hidden border border-gray-200 bg-gray-100 relative">
            @if($contact->map_iframe)
              <div class="w-full h-full [&>iframe]:w-full [&>iframe]:h-full [&>iframe]:min-h-[300px] [&>iframe]:border-0">
                {!! $contact->map_iframe !!}
              </div>
            @else
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d58548.86811211728!2d89.21376878206899!3d23.68962635959954!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39fed5b3d6d061f5%3A0xc07a829f03224b7!2sShailkupa!5e0!3m2!1sen!2sbd!4v1700000000000!5m2!1sen!2sbd"
                width="100%"
                height="100%"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                class="w-full h-full min-h-[320px]"
              ></iframe>
            @endif
          </div>
        </div>
      </div>

    </div>

    <!-- Bottom Section: Contact Message Form (AJAX Powered) -->
    <div class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-100 shadow-sm max-w-4xl mx-auto">
      <div class="text-center max-w-xl mx-auto mb-8">
        <h2 class="text-xl sm:text-2xl font-black text-gray-900">
          সরাসরি বার্তা বা প্রশ্ন পাঠান
        </h2>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">
          ফর্মটি পূরণ করে বার্তা পাঠালে আমাদের দায়িত্বশীল টিম দ্রুত পর্যালোচনা করে আপনার সাথে যোগাযোগ করবেন।
        </p>
      </div>

      <!-- AJAX Feedback Alert Box -->
      <div id="contact-alert" class="hidden mb-6 p-4 rounded-2xl text-xs sm:text-sm font-semibold transition"></div>

      <form id="contact-form" onsubmit="submitContactForm(event)" class="space-y-5">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
          <!-- Name -->
          <div>
            <label for="name" class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">
              আপনার নাম <span class="text-[#c8102e]">*</span>
            </label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                <i class="ri-user-line text-base"></i>
              </span>
              <input
                type="text"
                id="name"
                name="name"
                required
                placeholder="যেমন: মোঃ সাকিব হোসেন"
                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0b4622] text-xs sm:text-sm text-gray-900 bg-gray-50/30"
              />
            </div>
            <p id="error-name" class="text-xs text-[#c8102e] mt-1 font-semibold hidden"></p>
          </div>

          <!-- Email -->
          <div>
            <label for="email" class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">
              আপনার ইমেইল <span class="text-[#c8102e]">*</span>
            </label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                <i class="ri-mail-line text-base"></i>
              </span>
              <input
                type="email"
                id="email"
                name="email"
                required
                placeholder="sakib@example.com"
                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0b4622] text-xs sm:text-sm text-gray-900 bg-gray-50/30"
              />
            </div>
            <p id="error-email" class="text-xs text-[#c8102e] mt-1 font-semibold hidden"></p>
          </div>

          <!-- Phone Number -->
          <div>
            <label for="phone" class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">
              মোবাইল নম্বর <span class="text-gray-400 font-normal">(ঐচ্ছিক)</span>
            </label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                <i class="ri-phone-line text-base"></i>
              </span>
              <input
                type="text"
                id="phone"
                name="phone"
                placeholder="017XXXXXXXX"
                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0b4622] text-xs sm:text-sm text-gray-900 bg-gray-50/30"
              />
            </div>
            <p id="error-phone" class="text-xs text-[#c8102e] mt-1 font-semibold hidden"></p>
          </div>

          <!-- Subject -->
          <div>
            <label for="subject" class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">
              বিষয় (Subject) <span class="text-gray-400 font-normal">(ঐচ্ছিক)</span>
            </label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                <i class="ri-chat-1-line text-base"></i>
              </span>
              <input
                type="text"
                id="subject"
                name="subject"
                placeholder="যেমন: উন্নয়ন প্রকল্পের পরামর্শ বা সদস্য সংক্রান্ত"
                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0b4622] text-xs sm:text-sm text-gray-900 bg-gray-50/30"
              />
            </div>
            <p id="error-subject" class="text-xs text-[#c8102e] mt-1 font-semibold hidden"></p>
          </div>
        </div>

        <!-- Message -->
        <div>
          <label for="message" class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">
            আপনার বার্তা বা মেসেজ <span class="text-[#c8102e]">*</span>
          </label>
          <textarea
            id="message"
            name="message"
            rows="5"
            required
            placeholder="আপনার মতামত, জিজ্ঞাসা বা যেকোনো বিস্তারিত তথ্য এখানে বিস্তারিত লিখুন..."
            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0b4622] text-xs sm:text-sm text-gray-900 bg-gray-50/30"
          ></textarea>
          <p id="error-message" class="text-xs text-[#c8102e] mt-1 font-semibold hidden"></p>
        </div>

        <!-- Submit Button -->
        <div class="text-center pt-2">
          <button
            type="submit"
            id="submit-btn"
            class="w-full sm:w-auto px-8 py-3 rounded-xl bg-[#0b4622] hover:bg-[#08351a] text-white font-extrabold text-sm shadow-md hover:shadow-lg transition-all duration-200 inline-flex items-center justify-center gap-2 cursor-pointer"
          >
            <i class="ri-send-plane-fill"></i>
            <span>বার্তা পাঠান (Send Message)</span>
          </button>
        </div>
      </form>
    </div>

  </div>
</main>

<script>
function submitContactForm(event) {
  event.preventDefault();
  const form = document.getElementById('contact-form');
  const alertBox = document.getElementById('contact-alert');
  const submitBtn = document.getElementById('submit-btn');

  // Clear previous field errors
  ['name', 'email', 'phone', 'subject', 'message'].forEach(field => {
    const errEl = document.getElementById(`error-${field}`);
    if (errEl) {
      errEl.textContent = '';
      errEl.classList.add('hidden');
    }
  });

  // Loading state
  const originalBtnHtml = submitBtn.innerHTML;
  submitBtn.disabled = true;
  submitBtn.innerHTML = '<i class="ri-loader-4-line animate-spin"></i><span>পাঠানো হচ্ছে...</span>';

  const formData = new FormData(form);

  fetch("{{ route('contact.store') }}", {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json'
    },
    body: formData
  })
  .then(async response => {
    const data = await response.json();
    if (!response.ok) {
      if (response.status === 422 && data.errors) {
        // Show validation errors below fields
        Object.keys(data.errors).forEach(key => {
          const errEl = document.getElementById(`error-${key}`);
          if (errEl) {
            errEl.textContent = data.errors[key][0];
            errEl.classList.remove('hidden');
          }
        });
        throw new Error('অনুগ্রহ করে ফর্মে প্রদত্ত তথ্যগুলো সঠিকভাবে পূরণ করুন।');
      }
      throw new Error(data.message || 'বার্তা পাঠাতে ত্রুটি হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।');
    }
    return data;
  })
  .then(data => {
    alertBox.className = "mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold flex items-center gap-2.5";
    alertBox.innerHTML = '<i class="ri-checkbox-circle-fill text-lg text-emerald-600 shrink-0"></i><span>' + data.message + '</span>';
    alertBox.classList.remove('hidden');
    form.reset();

    // Scroll to alert
    alertBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
  })
  .catch(err => {
    alertBox.className = "mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-[#c8102e] text-xs sm:text-sm font-semibold flex items-center gap-2.5";
    alertBox.innerHTML = '<i class="ri-error-warning-fill text-lg text-[#c8102e] shrink-0"></i><span>' + err.message + '</span>';
    alertBox.classList.remove('hidden');
  })
  .finally(() => {
    submitBtn.disabled = false;
    submitBtn.innerHTML = originalBtnHtml;
  });
}
</script>
@endsection

