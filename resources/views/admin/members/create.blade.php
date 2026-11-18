@extends('layouts.admin.admin-layout')

@section('title', 'নতুন সদস্য নিয়োগ')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
  {{-- Header with Back Button --}}
  <div class="flex items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight flex items-center gap-2.5">
        <span class="w-10 h-10 rounded-xl bg-emerald-50 text-[#0b4622] flex items-center justify-center text-xl shadow-2xs">
          <i class="ri-user-add-line"></i>
        </span>
        <span>নতুন সদস্য নিয়োগ (ম্যানুয়াল এন্ট্রি)</span>
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-1 font-medium">অ্যাডমিন প্যানেল থেকে সরাসরি নতুন সদস্য তথ্য যুক্ত করুন</p>
    </div>

    <a href="{{ route('admin.members.index') }}"
       class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-gray-50 text-gray-700 text-xs sm:text-sm font-bold rounded-xl border border-gray-300 shadow-2xs transition">
      <i class="ri-arrow-left-line"></i>
      <span>তালিকায় ফিরে যান</span>
    </a>
  </div>

  {{-- Form Card --}}
  <div class="bg-white rounded-2xl border border-gray-200 p-6 sm:p-8 shadow-2xs">
    <form action="{{ route('admin.members.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
      @csrf

      {{-- Photo Upload with Live Preview --}}
      <div class="bg-gray-50/70 border border-dashed border-gray-300 rounded-2xl p-5 text-center space-y-3">
        <label class="block text-xs sm:text-sm font-bold text-gray-800">
          সদস্যের ছবি (প্রোফাইল ফটো):
        </label>

        <div class="flex flex-col items-center justify-center">
          <div class="relative w-28 h-28 rounded-full border-4 border-white shadow-md overflow-hidden bg-gray-200 group">
            <img id="adminMemberPhotoPreview"
                 src="https://ui-avatars.com/api/?name=Member&background=0b4622&color=ffffff&size=150"
                 alt="ছবি প্রিভিউ"
                 class="w-full h-full object-cover">
            
            <label for="adminMemberPhotoInput"
                   class="absolute inset-0 bg-black/40 text-white flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition cursor-pointer">
              <i class="ri-camera-switch-line text-2xl"></i>
              <span class="text-[10px] font-semibold mt-1">পরিবর্তন করুন</span>
            </label>
          </div>

          <div class="mt-3">
            <input type="file"
                   id="adminMemberPhotoInput"
                   name="photo"
                   accept="image/*"
                   class="hidden"
                   onchange="previewAdminMemberImage(event)">

            <button type="button"
                    onclick="document.getElementById('adminMemberPhotoInput').click()"
                    class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-white hover:bg-gray-100 text-gray-700 text-xs font-bold rounded-xl border border-gray-300 shadow-2xs transition">
              <i class="ri-upload-cloud-2-line text-base text-[#0b4622]"></i>
              <span>ছবি সিলেক্ট করুন</span>
            </button>
          </div>

          <p class="text-[11px] text-gray-400 mt-1.5">
            পাসপোর্ট সাইজ বা স্পষ্ট পোর্ট্রেট ছবি দিন (JPG, PNG, WebP সর্বোচ্চ ৩MB)
          </p>
        </div>
      </div>

      {{-- Fields Grid --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        {{-- Full Name --}}
        <div class="space-y-1">
          <label for="name" class="block text-xs font-bold text-gray-700">
            পূর্ণ নাম <span class="text-red-500">*</span>
          </label>
          <input type="text"
                 id="name"
                 name="name"
                 value="{{ old('name') }}"
                 required
                 placeholder="উদা: মোঃ নাজমুল হাসান"
                 class="w-full px-3.5 py-2.5 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622]">
          @error('name')
            <p class="text-xs text-red-500 mt-0.5">{{ $message }}</p>
          @enderror
        </div>

        {{-- ID Card Number --}}
        <div class="space-y-1">
          <label for="id_card_number" class="block text-xs font-bold text-gray-700">
            আইডি কার্ড নম্বর (ঐচ্ছিক)
          </label>
          <input type="text"
                 id="id_card_number"
                 name="id_card_number"
                 value="{{ old('id_card_number') }}"
                 placeholder="ফাঁকা রাখলে স্বয়ংক্রিয় তৈরি হবে (উদা: ASM-2026-0001)"
                 class="w-full px-3.5 py-2.5 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622]">
          <p class="text-[11px] text-gray-400">ফাঁকা রাখলে সিস্টেম ইউনিক সদস্য আইডি বরাদ্দ করবে</p>
          @error('id_card_number')
            <p class="text-xs text-red-500 mt-0.5">{{ $message }}</p>
          @enderror
        </div>

        {{-- Phone Number (11 digits) --}}
        <div class="space-y-1">
          <label for="phone" class="block text-xs font-bold text-gray-700">
            মোবাইল নম্বর (১১ ডিজিট) <span class="text-red-500">*</span>
          </label>
          <input type="tel"
                 id="phone"
                 name="phone"
                 value="{{ old('phone') }}"
                 required
                 maxlength="14"
                 placeholder="উদা: 017xxxxxxxx"
                 class="w-full px-3.5 py-2.5 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622]">
          @error('phone')
            <p class="text-xs text-red-500 mt-0.5">{{ $message }}</p>
          @enderror
        </div>

        {{-- Email Address --}}
        <div class="space-y-1">
          <label for="email" class="block text-xs font-bold text-gray-700">
            ইমেইল অ্যাড্রেস <span class="text-red-500">*</span>
          </label>
          <input type="email"
                 id="email"
                 name="email"
                 value="{{ old('email') }}"
                 required
                 placeholder="উদা: member@gmail.com"
                 class="w-full px-3.5 py-2.5 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622]">
          @error('email')
            <p class="text-xs text-red-500 mt-0.5">{{ $message }}</p>
          @enderror
        </div>

        {{-- Blood Group --}}
        <div class="space-y-1">
          <label for="blood_group" class="block text-xs font-bold text-gray-700">
            রক্তের গ্রুপ
          </label>
          <select id="blood_group"
                  name="blood_group"
                  class="w-full px-3.5 py-2.5 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622] bg-white">
            <option value="">-- নির্বাচন করুন --</option>
            <option value="A+" {{ old('blood_group') === 'A+' ? 'selected' : '' }}>A+ (পজিটিভ)</option>
            <option value="A-" {{ old('blood_group') === 'A-' ? 'selected' : '' }}>A- (নেগেটিভ)</option>
            <option value="B+" {{ old('blood_group') === 'B+' ? 'selected' : '' }}>B+ (পজিটিভ)</option>
            <option value="B-" {{ old('blood_group') === 'B-' ? 'selected' : '' }}>B- (নেগেটিভ)</option>
            <option value="AB+" {{ old('blood_group') === 'AB+' ? 'selected' : '' }}>AB+ (পজিটিভ)</option>
            <option value="AB-" {{ old('blood_group') === 'AB-' ? 'selected' : '' }}>AB- (নেগেটিভ)</option>
            <option value="O+" {{ old('blood_group') === 'O+' ? 'selected' : '' }}>O+ (পজিটিভ)</option>
            <option value="O-" {{ old('blood_group') === 'O-' ? 'selected' : '' }}>O- (নেগেটিভ)</option>
          </select>
        </div>

        {{-- Occupation --}}
        <div class="space-y-1">
          <label for="occupation" class="block text-xs font-bold text-gray-700">
            পেশা (Occupation)
          </label>
          <input type="text"
                 id="occupation"
                 name="occupation"
                 value="{{ old('occupation') }}"
                 placeholder="উদা: শিক্ষক, ব্যবসায়ী, চাকরিজীবী"
                 class="w-full px-3.5 py-2.5 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622]">
        </div>

        {{-- Status --}}
        <div class="space-y-1 sm:col-span-2">
          <label for="status" class="block text-xs font-bold text-gray-700">
            সদস্যপদ স্ট্যাটাস <span class="text-red-500">*</span>
          </label>
          <select id="status"
                  name="status"
                  class="w-full px-3.5 py-2.5 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622] bg-white">
            <option value="1" {{ old('status', '1') === '1' ? 'selected' : '' }}>Active (অনুমোদিত ও সক্রিয়)</option>
            <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Inactive (অপেক্ষমাণ / পেন্ডিং)</option>
          </select>
        </div>

        {{-- Address --}}
        <div class="space-y-1 sm:col-span-2">
          <label for="address" class="block text-xs font-bold text-gray-700">
            বর্তমান ঠিকানা <span class="text-red-500">*</span>
          </label>
          <textarea id="address"
                    name="address"
                    rows="2"
                    required
                    placeholder="বর্তমান বিস্তারিত ঠিকানা লিখুন..."
                    class="w-full px-3.5 py-2 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622]">{{ old('address') }}</textarea>
          @error('address')
            <p class="text-xs text-red-500 mt-0.5">{{ $message }}</p>
          @enderror
        </div>

        {{-- Permanent Address --}}
        <div class="space-y-1 sm:col-span-2">
          <label for="permanent_address" class="block text-xs font-bold text-gray-700">
            স্থায়ী ঠিকানা (ঐচ্ছিক)
          </label>
          <textarea id="permanent_address"
                    name="permanent_address"
                    rows="2"
                    placeholder="স্থায়ী বিস্তারিত ঠিকানা লিখুন..."
                    class="w-full px-3.5 py-2 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622]">{{ old('permanent_address') }}</textarea>
          @error('permanent_address')
            <p class="text-xs text-red-500 mt-0.5">{{ $message }}</p>
          @enderror
        </div>
          </label>
          <textarea id="address"
                    name="address"
                    rows="3"
                    required
                    placeholder="গ্রাম, ওয়ার্ড, ইউনিয়ন, উপজেলা, জেলা..."
                    class="w-full px-3.5 py-2 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622]">{{ old('address') }}</textarea>
          @error('address')
            <p class="text-xs text-red-500 mt-0.5">{{ $message }}</p>
          @enderror
        </div>

        {{-- Authorized Signature Upload --}}
        <div class="space-y-1 sm:col-span-2 bg-gray-50/70 p-4 rounded-xl border border-dashed border-gray-300">
          <label class="block text-xs font-bold text-gray-700 mb-1">
            অনুমোদিত কর্মকর্তার স্বাক্ষর (ঐচ্ছিক - সদস্য কার্ডে প্রদর্শনের জন্য)
          </label>
          <div class="flex items-center gap-4">
            <div class="w-36 h-14 bg-white border border-gray-200 rounded-lg flex items-center justify-center overflow-hidden p-1 shadow-2xs">
              <img id="adminMemberSignaturePreview" src="" alt="স্বাক্ষর প্রিভিউ" class="max-h-full max-w-full object-contain hidden">
              <span id="adminMemberSignaturePlaceholder" class="text-[11px] text-gray-400 font-medium">স্বাক্ষর নেই</span>
            </div>
            <div>
              <input type="file" id="adminMemberSignatureInput" name="signature" accept="image/*" class="hidden" onchange="previewAdminMemberSignature(event)">
              <button type="button" onclick="document.getElementById('adminMemberSignatureInput').click()" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-gray-100 text-gray-700 text-xs font-semibold rounded-lg border border-gray-300 shadow-2xs">
                <i class="ri-file-upload-line text-[#0b4622]"></i>
                <span>স্বাক্ষর নির্বাচন করুন</span>
              </button>
              <p class="text-[10px] text-gray-400 mt-1">স্বচ্ছ ব্যাকগ্রাউন্ডের PNG বা স্পষ্ট স্বাক্ষর ছবি দিন (সর্বোচ্চ ২MB)</p>
            </div>
          </div>
          @error('signature')
            <p class="text-xs text-red-500 mt-0.5">{{ $message }}</p>
          @enderror
        </div>

        {{-- Admin Notes --}}
        <div class="space-y-1 sm:col-span-2">
          <label for="notes" class="block text-xs font-bold text-gray-700">
            অ্যাডমিন মন্তব্য / বিশেষ নোট (ঐচ্ছিক)
          </label>
          <textarea id="notes"
                    name="notes"
                    rows="2"
                    placeholder="সদস্য সম্পর্কে কোনো মন্তব্য বা পরিচয়..."
                    class="w-full px-3.5 py-2 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622]">{{ old('notes') }}</textarea>
        </div>
      </div>

      {{-- Action Buttons --}}
      <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
        <a href="{{ route('admin.members.index') }}"
           class="px-5 py-2.5 rounded-xl border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs sm:text-sm font-semibold transition">
          বাতিল
        </a>
        <button type="submit"
                class="px-6 py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs sm:text-sm font-bold rounded-xl shadow-md transition flex items-center gap-1.5 cursor-pointer">
          <i class="ri-save-line text-base"></i>
          <span>সদস্য তথ্য সংরক্ষণ করুন</span>
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  function previewAdminMemberImage(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('adminMemberPhotoPreview').src = e.target.result;
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  function previewAdminMemberSignature(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        const preview = document.getElementById('adminMemberSignaturePreview');
        const placeholder = document.getElementById('adminMemberSignaturePlaceholder');
        preview.src = e.target.result;
        preview.classList.remove('hidden');
        if (placeholder) placeholder.classList.add('hidden');
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
@endsection
