@extends('layouts.admin.admin-layout')

@section('title', 'আমার প্রোফাইল — আগামীর শৈলকুপা')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

  <!-- Breadcrumb & Header -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
      <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">আমার প্রোফাইল</h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-0.5">আপনার ব্যক্তিগত তথ্য ও প্রোফাইল ছবি আপডেট করুন</p>
    </div>
    <div class="flex items-center gap-2">
      <a
        href="{{ route('admin.profile.password') }}"
        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 text-xs font-bold transition shadow-2xs"
      >
        <i class="ri-lock-password-line text-sm text-[#0b4622]"></i>
        <span>পাসওয়ার্ড পরিবর্তন</span>
      </a>
    </div>
  </div>

  {{-- Success Alert --}}
  @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold flex items-center gap-2.5">
      <i class="ri-checkbox-circle-fill text-lg text-emerald-600"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <!-- Main Profile Card -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)] overflow-hidden">
    <div class="h-28 sm:h-32 bg-gradient-to-r from-[#0b4622] via-[#0f5426] to-[#146c32] relative">
      <div class="absolute -right-6 -bottom-6 w-32 h-32 rounded-full bg-white/10 pointer-events-none"></div>
    </div>

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 pt-0">
      @csrf
      @method('PUT')

      <!-- Profile Photo Upload -->
      <div class="flex flex-col sm:flex-row items-center sm:items-end gap-5 -mt-14 sm:-mt-16 mb-8 pb-6 border-b border-gray-100">
        <div class="flex flex-col items-center">
          <div class="relative group">
            <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-full border-4 border-white shadow-md bg-gray-100 overflow-hidden shrink-0">
              @if($user->photo)
                <img id="admin-photo-preview" src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" class="w-full h-full object-cover" />
              @else
                <img id="admin-photo-preview" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%239ca3af'%3E%3Cpath d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/%3E%3C/svg%3E" alt="{{ $user->name }}" class="w-full h-full object-cover" />
              @endif
            </div>
            <label
              for="photo-input"
              class="absolute bottom-1 right-1 w-9 h-9 rounded-full bg-[#0b4622] hover:bg-[#083519] text-white flex items-center justify-center shadow-md cursor-pointer transition transform hover:scale-105"
              title="ছবি পরিবর্তন করুন"
            >
              <i class="ri-camera-fill text-sm"></i>
            </label>
            <input
              type="file"
              id="photo-input"
              name="photo"
              class="hidden"
              onchange="previewAdminPhoto(event)"
            />
          </div>
          <!-- Validation error right below the photo -->
          @error('photo')
            <p class="text-xs text-[#c8102e] font-semibold mt-2 text-center flex items-center gap-1">
              <i class="ri-error-warning-line"></i>
              <span>{{ $message }}</span>
            </p>
          @enderror
        </div>

        <div class="text-center sm:text-left min-w-0 flex-1">
          <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 leading-tight truncate">{{ $user->name }}</h2>
          <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $user->email }}</p>
          <div class="mt-2 flex items-center justify-center sm:justify-start gap-2">
            <span class="inline-flex items-center text-[10px] font-extrabold px-2.5 py-0.5 rounded-full bg-emerald-50 text-[#0b4622] border border-emerald-100">
              {{ strtoupper($user->roles->first()?->name ?? 'SUPER-ADMIN') }}
            </span>
            <span class="text-[11px] text-gray-400">ছবি পরিবর্তন করতে ক্যামেরায় ক্লিক করুন</span>
          </div>
        </div>
      </div>

      <!-- Form Fields Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        
        <!-- Full Name -->
        <div>
          <label for="name" class="block text-xs font-bold text-gray-700 mb-1.5">
            পূর্ণ নাম <span class="text-[#c8102e]">*</span>
          </label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
              <i class="ri-user-line text-sm"></i>
            </span>
            <input
              type="text"
              id="name"
              name="name"
              value="{{ old('name', $user->name) }}"
              required
              class="w-full pl-10 pr-4 py-2.5 rounded-xl border {{ $errors->has('name') ? 'border-red-300 bg-red-50/20' : 'border-gray-200 bg-gray-50/40' }} text-xs sm:text-sm text-gray-900 focus:outline-none focus:border-[#0b4622] focus:bg-white transition"
            />
          </div>
          @error('name')
            <p class="text-xs text-[#c8102e] mt-1 font-semibold flex items-center gap-1">
              <i class="ri-error-warning-line"></i>
              <span>{{ $message }}</span>
            </p>
          @enderror
        </div>

        <!-- Mobile Phone -->
        <div>
          <label for="phone" class="block text-xs font-bold text-gray-700 mb-1.5">
            মোবাইল নম্বর <span class="text-[#c8102e]">*</span>
          </label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
              <i class="ri-phone-line text-sm"></i>
            </span>
            <input
              type="tel"
              id="phone"
              name="phone"
              value="{{ old('phone', $user->phone) }}"
              required
              placeholder="017XXXXXXXX"
              class="w-full pl-10 pr-4 py-2.5 rounded-xl border {{ $errors->has('phone') ? 'border-red-300 bg-red-50/20' : 'border-gray-200 bg-gray-50/40' }} text-xs sm:text-sm text-gray-900 focus:outline-none focus:border-[#0b4622] focus:bg-white transition"
            />
          </div>
          @error('phone')
            <p class="text-xs text-[#c8102e] mt-1 font-semibold flex items-center gap-1">
              <i class="ri-error-warning-line"></i>
              <span>{{ $message }}</span>
            </p>
          @enderror
        </div>

        <!-- Email Address -->
        <div class="sm:col-span-2">
          <label for="email" class="block text-xs font-bold text-gray-700 mb-1.5">
            ইমেইল ঠিকানা <span class="text-[#c8102e]">*</span>
          </label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
              <i class="ri-mail-line text-sm"></i>
            </span>
            <input
              type="email"
              id="email"
              name="email"
              value="{{ old('email', $user->email) }}"
              required
              class="w-full pl-10 pr-4 py-2.5 rounded-xl border {{ $errors->has('email') ? 'border-red-300 bg-red-50/20' : 'border-gray-200 bg-gray-50/40' }} text-xs sm:text-sm text-gray-900 focus:outline-none focus:border-[#0b4622] focus:bg-white transition"
            />
          </div>
          @error('email')
            <p class="text-xs text-[#c8102e] mt-1 font-semibold flex items-center gap-1">
              <i class="ri-error-warning-line"></i>
              <span>{{ $message }}</span>
            </p>
          @enderror
        </div>

      </div>

      <!-- Action Button -->
      <div class="mt-8 pt-5 border-t border-gray-100 flex items-center justify-end gap-3">
        <button
          type="submit"
          class="inline-flex items-center gap-2 bg-[#0b4622] hover:bg-[#083519] text-white text-xs sm:text-sm font-bold px-5 py-2.5 rounded-xl shadow-xs transition cursor-pointer"
        >
          <i class="ri-save-line text-sm"></i>
          <span>প্রোফাইল সংরক্ষণ করুন</span>
        </button>
      </div>

    </form>
  </div>

</div>
@endsection

@push('scripts')
<script>
  function previewAdminPhoto(event) {
    const file = event.target.files && event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        const preview = document.getElementById('admin-photo-preview');
        if (preview) {
          preview.src = e.target.result;
        }
      };
      reader.readAsDataURL(file);
    }
  }
</script>
@endpush
