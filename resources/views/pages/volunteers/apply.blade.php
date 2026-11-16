@extends('layouts.website.website-layout')

@section('title', 'স্বেচ্ছাসেবী কর্মী নিয়োগ — আগামীর শৈলকুপা')

@section('content')
<div class="bg-gray-50/70 min-h-screen py-8 sm:py-14">
  <div class="max-w-[850px] mx-auto px-4 sm:px-6 space-y-6 sm:space-y-8">

    {{-- Breadcrumb Navigation --}}
    <nav class="flex items-center gap-2 text-xs sm:text-sm font-medium text-gray-500">
      <a href="{{ route('home') }}" class="hover:text-[#0b4622] transition flex items-center gap-1.5">
        <i class="ri-home-4-line text-sm text-[#0b4622]"></i>
        <span>হোম</span>
      </a>
      <i class="ri-arrow-right-s-line text-gray-400"></i>
      <span class="text-[#0b4622] font-semibold">স্বেচ্ছাসেবী কর্মী নিয়োগ</span>
    </nav>

    {{-- Page Header --}}
    <div class="text-center space-y-3">
      <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-50 border border-emerald-200/80 text-[#0b4622] text-xs font-bold tracking-wide">
        <i class="ri-hand-heart-line text-base"></i>
        <span>সমাজকল্যাণে আপনার অংশগ্রহণ</span>
      </div>
      <h1 class="text-2xl sm:text-4xl font-black text-gray-900 tracking-tight">
        স্বেচ্ছাসেবী কর্মী হিসেবে নিবন্ধন করুন
      </h1>
      <p class="text-xs sm:text-sm text-gray-600 max-w-xl mx-auto leading-relaxed">
        শৈলকুপার সামাজিক উন্নয়ন, রক্তদান, পরিবেশ সংরক্ষণ ও মানবকল্যাণে আগামীর শৈলকুপা পরিবারের সাথে স্বেচ্ছাসেবী হিসেবে যুক্ত হতে নিচের তথ্যগুলো দিয়ে আবেদন করুন।
      </p>
    </div>

    {{-- Success Notification --}}
    @if(session('success'))
      <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5 sm:p-6 shadow-sm flex items-start gap-4 animate-fade-in">
        <div class="w-12 h-12 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-2xl shrink-0 shadow-2xs">
          <i class="ri-checkbox-circle-fill"></i>
        </div>
        <div class="space-y-1.5">
          <h3 class="text-sm sm:text-base font-bold text-emerald-950">
            আবেদনটি সফলভাবে জমা হয়েছে!
          </h3>
          <p class="text-xs sm:text-sm text-emerald-800 leading-relaxed">
            {{ session('success') }}
          </p>
        </div>
      </div>
    @endif

    {{-- Error Summary --}}
    @if(isset($errors) && $errors->any())
      <div class="bg-red-50 border border-red-200 rounded-2xl p-4 sm:p-5 shadow-sm flex items-start gap-3">
        <div class="w-9 h-9 rounded-xl bg-red-600 text-white flex items-center justify-center text-lg shrink-0">
          <i class="ri-error-warning-fill"></i>
        </div>
        <div>
          <h4 class="text-xs sm:text-sm font-bold text-red-900 mb-1">দয়া করে নিচের ত্রুটিগুলো সংশোধন করুন:</h4>
          <ul class="list-disc list-inside text-xs text-red-700 space-y-0.5">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    @endif

    {{-- Registration Form Card --}}
    <div class="bg-white rounded-3xl border border-gray-200/90 shadow-sm overflow-hidden p-6 sm:p-10">
      <form action="{{ route('volunteers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-7">
        @csrf

        {{-- Section 1: Photo Upload with Live Preview (At the Beginning / Top) --}}
        <div class="bg-gray-50/70 border border-dashed border-gray-300 rounded-2xl p-5 sm:p-6 text-center space-y-4">
          <label class="block text-xs sm:text-sm font-bold text-gray-800">
            <span class="text-red-500">*</span> আবেদনকারীর ছবি (প্রোফাইল ফটো):
          </label>

          <div class="flex flex-col items-center justify-center">
            {{-- Preview Image Container --}}
            <div class="relative w-28 h-28 sm:w-32 sm:h-32 rounded-full border-4 border-white shadow-md overflow-hidden bg-gray-200 group">
              <img id="volunteerPhotoPreview"
                   src="https://ui-avatars.com/api/?name=Volunteer&background=0b4622&color=ffffff&size=150"
                   alt="প্রোফাইল ছবি প্রিভিউ"
                   class="w-full h-full object-cover">
              
              {{-- Hover Overlay --}}
              <label for="volunteerPhotoInput"
                     class="absolute inset-0 bg-black/40 text-white flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition cursor-pointer">
                <i class="ri-camera-switch-line text-2xl"></i>
                <span class="text-[10px] font-semibold mt-1">পরিবর্তন করুন</span>
              </label>
            </div>

            {{-- File Input & Upload Controls --}}
            <div class="mt-4">
              <input type="file"
                     id="volunteerPhotoInput"
                     name="photo"
                     accept="image/*"
                     class="hidden"
                     onchange="previewVolunteerImage(event)">

              <button type="button"
                      onclick="document.getElementById('volunteerPhotoInput').click()"
                      class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-100 text-gray-700 text-xs sm:text-sm font-bold rounded-xl border border-gray-300 shadow-2xs transition">
                <i class="ri-upload-cloud-2-line text-base text-[#0b4622]"></i>
                <span>ছবি সিলেক্ট করুন</span>
              </button>
            </div>

            <p class="text-[11px] text-gray-500 mt-2">
              ছবি অবশ্যই পাসপোর্ট সাইজ বা স্পষ্ট ফেস পোর্ট্রেট হতে হবে (JPG, PNG বা WebP, সর্বোচ্চ ৩ মেগাবাইট)
            </p>
          </div>
        </div>

        {{-- Section 2: Personal Information Fields --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
          {{-- Full Name --}}
          <div class="space-y-1.5 sm:col-span-2">
            <label for="name" class="block text-xs sm:text-sm font-bold text-gray-800">
              পূর্ণ নাম <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <input type="text"
                     id="name"
                     name="name"
                     value="{{ old('name') }}"
                     required
                     placeholder="উদা: মোঃ আরিফুল ইসলাম"
                     class="w-full pl-10 pr-4 py-2.5 sm:py-3 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622] focus:ring-2 focus:ring-[#0b4622]/15 transition">
              <i class="ri-user-3-line absolute left-3.5 top-3 sm:top-3.5 text-gray-400 text-base"></i>
            </div>
          </div>

          {{-- Phone Number --}}
          <div class="space-y-1.5">
            <label for="phone" class="block text-xs sm:text-sm font-bold text-gray-800">
              মোবাইল নম্বর <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <input type="tel"
                     id="phone"
                     name="phone"
                     value="{{ old('phone') }}"
                     required
                     placeholder="উদা: 017xxxxxxxx"
                     class="w-full pl-10 pr-4 py-2.5 sm:py-3 text-xs sm:text-sm border {{ $errors->has('phone') ? 'border-red-500 ring-2 ring-red-500/20' : 'border-gray-300 focus:border-[#0b4622] focus:ring-[#0b4622]/15' }} rounded-xl focus:outline-none focus:ring-2 transition">
              <i class="ri-phone-line absolute left-3.5 top-3 sm:top-3.5 {{ $errors->has('phone') ? 'text-red-500' : 'text-gray-400' }} text-base"></i>
            </div>
            @error('phone')
              <p class="text-xs text-red-600 font-semibold flex items-center gap-1 mt-1">
                <i class="ri-error-warning-line"></i> {{ $message }}
              </p>
            @enderror
          </div>

          {{-- Email Address --}}
          <div class="space-y-1.5">
            <label for="email" class="block text-xs sm:text-sm font-bold text-gray-800">
              ইমেইল অ্যাড্রেস <span class="text-xs font-normal text-gray-400">(যদি থাকে)</span>
            </label>
            <div class="relative">
              <input type="email"
                     id="email"
                     name="email"
                     value="{{ old('email') }}"
                     placeholder="উদা: yourname@gmail.com"
                     class="w-full pl-10 pr-4 py-2.5 sm:py-3 text-xs sm:text-sm border {{ $errors->has('email') ? 'border-red-500 ring-2 ring-red-500/20' : 'border-gray-300 focus:border-[#0b4622] focus:ring-[#0b4622]/15' }} rounded-xl focus:outline-none focus:ring-2 transition">
              <i class="ri-mail-line absolute left-3.5 top-3 sm:top-3.5 {{ $errors->has('email') ? 'text-red-500' : 'text-gray-400' }} text-base"></i>
            </div>
            @error('email')
              <p class="text-xs text-red-600 font-semibold flex items-center gap-1 mt-1">
                <i class="ri-error-warning-line"></i> {{ $message }}
              </p>
            @else
              <p class="text-[10px] text-gray-400">অনুমোদন সংক্রান্ত ইমেইল পেতে সঠিক ইমেইল দিন।</p>
            @enderror
          </div>

          {{-- Blood Group --}}
          <div class="space-y-1.5 sm:col-span-2">
            <label for="blood_group" class="block text-xs sm:text-sm font-bold text-gray-800">
              রক্তের গ্রুপ (Blood Group)
            </label>
            <div class="relative">
              <select id="blood_group"
                      name="blood_group"
                      class="w-full pl-10 pr-4 py-2.5 sm:py-3 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622] focus:ring-2 focus:ring-[#0b4622]/15 transition bg-white appearance-none">
                <option value="">-- রক্তের গ্রুপ নির্বাচন করুন --</option>
                <option value="A+" {{ old('blood_group') === 'A+' ? 'selected' : '' }}>A+ (পজিটিভ)</option>
                <option value="A-" {{ old('blood_group') === 'A-' ? 'selected' : '' }}>A- (নেগেটিভ)</option>
                <option value="B+" {{ old('blood_group') === 'B+' ? 'selected' : '' }}>B+ (পজিটিভ)</option>
                <option value="B-" {{ old('blood_group') === 'B-' ? 'selected' : '' }}>B- (নেগেটিভ)</option>
                <option value="AB+" {{ old('blood_group') === 'AB+' ? 'selected' : '' }}>AB+ (পজিটিভ)</option>
                <option value="AB-" {{ old('blood_group') === 'AB-' ? 'selected' : '' }}>AB- (নেগেটিভ)</option>
                <option value="O+" {{ old('blood_group') === 'O+' ? 'selected' : '' }}>O+ (পজিটিভ)</option>
                <option value="O-" {{ old('blood_group') === 'O-' ? 'selected' : '' }}>O- (নেগেটিভ)</option>
              </select>
              <i class="ri-drop-line absolute left-3.5 top-3 sm:top-3.5 text-red-500 text-base"></i>
              <i class="ri-arrow-down-s-line absolute right-3.5 top-3 sm:top-3.5 text-gray-400 pointer-events-none"></i>
            </div>
          </div>

          {{-- Address --}}
          <div class="space-y-1.5 sm:col-span-2">
            <label for="address" class="block text-xs sm:text-sm font-bold text-gray-800">
              বর্তমান ঠিকানা (গ্রাম / ওয়ার্ড / উপজেলা / জেলা) <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <textarea id="address"
                        name="address"
                        rows="3"
                        required
                        placeholder="আপনার বিস্তারিত ঠিকানা লিখুন..."
                        class="w-full pl-10 pr-4 py-2.5 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622] focus:ring-2 focus:ring-[#0b4622]/15 transition">{{ old('address') }}</textarea>
              <i class="ri-map-pin-line absolute left-3.5 top-3 text-gray-400 text-base"></i>
            </div>
          </div>
        </div>

        {{-- Notice Box --}}
        <div class="bg-amber-50/80 border border-amber-200/80 rounded-2xl p-4 flex items-start gap-3 text-xs text-amber-900">
          <i class="ri-information-fill text-amber-600 text-base shrink-0 mt-0.5"></i>
          <p class="leading-relaxed">
            <strong>বিজ্ঞপ্তি:</strong> আপনার আবেদনটি জমা দেওয়ার পর তা পর্যালোচনায় থাকবে। অ্যাডমিন কর্তৃক যাচাই-বাছাই করে অনুমোদন (Approve) করার পর আপনি আমাদের অফিসিয়াল স্বেচ্ছাসেবী দলের অংশ হিসেবে বিবেচিত হবেন।
          </p>
        </div>

        {{-- Submit Button --}}
        <div class="pt-2 text-center">
          <button type="submit"
                  class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-[#0b4622] hover:bg-[#08351a] text-white rounded-xl text-sm sm:text-base font-bold shadow-md hover:shadow-lg transition">
            <i class="ri-send-plane-fill text-lg"></i>
            <span>স্বেচ্ছাসেবী হিসেবে আবেদন জমা দিন</span>
          </button>
        </div>
      </form>
    </div>

  </div>
</div>

{{-- Image Live Preview Script --}}
<script>
  function previewVolunteerImage(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('volunteerPhotoPreview').src = e.target.result;
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
@endsection
