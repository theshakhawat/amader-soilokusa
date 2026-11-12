@extends('layouts.admin.admin-layout')

@section('title', 'নতুন ব্যবহারকারী যোগ করুন | আগামীর শৈলকুপা')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

  <!-- Top bar -->
  <div class="flex items-center justify-between">
    <div>
      <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line"></i>
        <a href="{{ route('admin.users.index') }}" class="hover:text-[#0b4622]">ব্যবহারকারী</a>
        <i class="ri-arrow-right-s-line"></i>
        <span class="text-[#0b4622] font-semibold">নতুন যোগ</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
        <i class="ri-user-add-line text-[#0b4622]"></i>
        <span>নতুন ব্যবহারকারী যোগ করুন</span>
      </h1>
    </div>

    <a
      href="{{ route('admin.users.index') }}"
      class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition"
    >
      <i class="ri-arrow-left-line"></i>
      <span>তালিকায় ফিরুন</span>
    </a>
  </div>

  <!-- Form Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-2xs p-6 sm:p-8">
    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
      @csrf

      <!-- Name -->
      <div>
        <label for="name" class="block text-xs font-bold text-gray-700 mb-1.5">
          পূর্ণ নাম (Full Name) <span class="text-[#c8102e]">*</span>
        </label>
        <input
          type="text"
          id="name"
          name="name"
          value="{{ old('name') }}"
          placeholder="উদাঃ মোঃ শরিফুল ইসলাম"
          class="w-full px-4 py-2.5 text-xs bg-gray-50 border @error('name') border-[#c8102e] @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
          required
        >
        @error('name') <p class="text-xs text-[#c8102e] mt-1">{{ $message }}</p> @enderror
      </div>

      <!-- Email -->
      <div>
        <label for="email" class="block text-xs font-bold text-gray-700 mb-1.5">
          ইমেইল ঠিকানা (Email) <span class="text-[#c8102e]">*</span>
        </label>
        <input
          type="email"
          id="email"
          name="email"
          value="{{ old('email') }}"
          placeholder="user@example.com"
          class="w-full px-4 py-2.5 text-xs bg-gray-50 border @error('email') border-[#c8102e] @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
          required
        >
        @error('email') <p class="text-xs text-[#c8102e] mt-1">{{ $message }}</p> @enderror
      </div>

      <!-- Phone -->
      <div>
        <label for="phone" class="block text-xs font-bold text-gray-700 mb-1.5">
          মোবাইল নম্বর (Phone)
        </label>
        <input
          type="text"
          id="phone"
          name="phone"
          value="{{ old('phone') }}"
          placeholder="017XXXXXXXX"
          class="w-full px-4 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
        >
      </div>

      <!-- Role & Status Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Role -->
        <div>
          <label for="role" class="block text-xs font-bold text-gray-700 mb-1.5">
            ভূমিকা / রোল (Role) <span class="text-[#c8102e]">*</span>
          </label>
          <select
            id="role"
            name="role"
            class="w-full px-4 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition font-semibold text-gray-800 cursor-pointer"
            required
          >
            @foreach($roles as $r)
              <option value="{{ $r->name }}" {{ old('role', 'member') === $r->name ? 'selected' : '' }}>
                {{ strtoupper($r->name) }}
              </option>
            @endforeach
          </select>
        </div>

        <!-- Status -->
        <div>
          <label for="status" class="block text-xs font-bold text-gray-700 mb-1.5">
            স্ট্যাটাস (Status) <span class="text-[#c8102e]">*</span>
          </label>
          <select
            id="status"
            name="status"
            class="w-full px-4 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition font-semibold text-gray-800 cursor-pointer"
            required
          >
            <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active (সক্রিয়)</option>
            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive (নিষ্ক্রিয়)</option>
            <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending (অপেক্ষমাণ)</option>
          </select>
        </div>
      </div>

      <!-- Password -->
      <div>
        <label for="password" class="block text-xs font-bold text-gray-700 mb-1.5">
          পাসওয়ার্ড (Password) <span class="text-[#c8102e]">*</span>
        </label>
        <input
          type="password"
          id="password"
          name="password"
          placeholder="কমপক্ষে ৬ অক্ষরের পাসওয়ার্ড"
          class="w-full px-4 py-2.5 text-xs bg-gray-50 border @error('password') border-[#c8102e] @else border-gray-200 @enderror rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
          required
        >
        @error('password') <p class="text-xs text-[#c8102e] mt-1">{{ $message }}</p> @enderror
      </div>

      <!-- Photo -->
      <div>
        <label class="block text-xs font-bold text-gray-700 mb-1.5">
          প্রোফাইল ছবি (Photo - ঐচ্ছিক)
        </label>
        <input
          type="file"
          name="photo"
          accept="image/*"
          class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#0b4622]/10 file:text-[#0b4622] hover:file:bg-[#0b4622]/20 cursor-pointer"
        >
      </div>

      <!-- Submit button -->
      <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
        <a
          href="{{ route('admin.users.index') }}"
          class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition"
        >
          বাতিল
        </a>
        <button
          type="submit"
          class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-sm hover:shadow transition cursor-pointer"
        >
          <i class="ri-check-line text-base"></i>
          <span>সংরক্ষণ করুন</span>
        </button>
      </div>

    </form>
  </div>
</div>
@endsection

