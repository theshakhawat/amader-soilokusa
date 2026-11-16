@extends('layouts.website.website-layout')

@section('title', 'সদস্যপদ আবেদন পর্যালোচনাধীন — ' . $member->name)

@section('content')
<div class="bg-gray-50/70 min-h-[70vh] flex items-center justify-center py-12 px-4 sm:px-6">
  <div class="max-w-md w-full bg-white rounded-3xl border border-gray-200/90 shadow-sm p-6 sm:p-8 text-center space-y-5">
    <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-3xl mx-auto shadow-2xs">
      <i class="ri-time-line"></i>
    </div>

    <div class="space-y-2">
      <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
        আবেদনটি পর্যালোচনাধীন (Under Review)
      </span>
      <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight">
        {{ $member->name }}
      </h1>
      <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
        'আগামীর শৈলকুপা'-তে সদস্য হিসেবে এই আবেদনটি এখনো অ্যাডমিন কর্তৃক অনুমোদনের অপেক্ষায় রয়েছে। অনুমোদন সম্পন্ন হলে এখানে অফিসিয়াল ডিজিটাল সদস্য আইডি কার্ড প্রদর্শিত হবে।
      </p>
    </div>

    <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row gap-2 justify-center">
      <a href="{{ route('home') }}"
         class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs sm:text-sm font-bold rounded-xl shadow-xs transition">
        <i class="ri-home-4-line"></i>
        <span>হোম পেজে যান</span>
      </a>
    </div>
  </div>
</div>
@endsection
