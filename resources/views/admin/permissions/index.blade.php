@extends('layouts.admin.admin-layout')

@section('title', 'সিস্টেম পারমিশন ক্যাটালগ | আগামীর শৈলকুপা')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto pb-12">

  <!-- Breadcrumb & Top Bar -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 sm:p-6 rounded-2xl border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)]">
    <div>
      <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line"></i>
        <a href="{{ route('admin.users.index') }}" class="hover:text-[#0b4622]">ব্যবহারকারী</a>
        <i class="ri-arrow-right-s-line"></i>
        <span class="text-[#0b4622] font-semibold">পারমিশন ক্যাটালগ</span>
      </div>
      <div class="flex items-center gap-2.5">
        <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
          <i class="ri-key-2-line text-[#0b4622]"></i>
          <span>সিস্টেম পারমিশন ক্যাটালগ (System Permissions)</span>
        </h1>
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-emerald-50 text-emerald-800 border border-emerald-200">
          মোট {{ $permissions->count() }} টি পারমিশন
        </span>
      </div>
      <p class="text-xs text-gray-500 mt-1">
        ওয়েবসাইটের প্রতিটি ফিচার ও অ্যাকশন পরিচালনার জন্য নির্ধারিত গ্র্যানুলার পারমিশনসমূহের সংরক্ষিত তালিকা।
      </p>
    </div>

    <div class="flex items-center gap-2.5">
      <a
        href="{{ route('admin.roles.index') }}"
        class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-xs hover:shadow transition cursor-pointer"
      >
        <i class="ri-shield-user-line text-sm"></i>
        <span>রোল পারমিশন বরাদ্দ করুন</span>
      </a>
    </div>
  </div>

  <!-- Protected Notice Banner (Explaining why permissions are permanent without delete option) -->
  <div class="p-4 bg-emerald-50/70 border border-emerald-200/80 rounded-2xl flex items-start gap-3">
    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-[#0b4622] flex items-center justify-center shrink-0 text-base">
      <i class="ri-shield-check-line"></i>
    </div>
    <div class="text-xs text-emerald-900">
      <p class="font-extrabold text-sm mb-0.5">সুরক্ষিত সিস্টেম পারমিশন আর্কিটেকচার</p>
      <p class="text-emerald-700/90 leading-relaxed font-medium">
        প্ল্যাটফর্মের প্রতিটি রাউট, কন্ট্রোলার ও সাইডবার মেনু এই পারমিশনগুলোর সাথে সংযুক্ত। সিস্টেমের কাঠামোগত স্থিতিশীলতা ও নিরাপত্তার স্বার্থে এই পারমিশনগুলো স্থায়ীভাবে সংরক্ষিত এবং কোনো ডিলিট অপশন রাখা হয়নি। যেকোনো রোলের ক্ষমতা পরিবর্তন করতে <strong>রোল ব্যবস্থাপনা</strong> থেকে পারমিশন অন/অফ করুন।
      </p>
    </div>
  </div>

  <!-- Permissions Grouped by Module -->
  <div class="space-y-6">
    @foreach($modules as $modKey => $module)
      @php
        $modPermissions = $module['permissions'];
      @endphp

      <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)] overflow-hidden">
        
        <!-- Module Header -->
        <div class="p-4 bg-gray-50/80 border-b border-gray-100 flex items-center justify-between">
          <div class="flex items-center gap-2.5">
            <span class="w-8 h-8 rounded-xl bg-emerald-50 text-[#0b4622] flex items-center justify-center text-base shrink-0 border border-emerald-100">
              <i class="{{ $module['icon'] ?? 'ri-shield-line' }}"></i>
            </span>
            <div>
              <h2 class="text-sm font-extrabold text-gray-900">
                {{ $module['name_bn'] }}
              </h2>
              <span class="text-[11px] text-gray-400 font-medium">
                {{ $module['name_en'] }}
              </span>
            </div>
          </div>
          <span class="text-[11px] font-bold text-gray-600 bg-white border border-gray-200 px-2.5 py-0.5 rounded-lg shadow-3xs">
            {{ count($modPermissions) }} টি অ্যাকশন
          </span>
        </div>

        <!-- Permissions Table within this module -->
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse text-xs">
            <thead>
              <tr class="border-b border-gray-100 text-[10px] font-black text-gray-400 uppercase tracking-wider bg-white">
                <th class="py-2.5 px-4 w-12 text-center">#</th>
                <th class="py-2.5 px-4">পারমিশন কী (Permission Key)</th>
                <th class="py-2.5 px-4">বিবরণ ও উদ্দেশ্য (Description)</th>
                <th class="py-2.5 px-4">বরাদ্দকৃত সক্রিয় ভূমিকা (Assigned Roles)</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 font-medium">
              @foreach($modPermissions as $permKey => $permMeta)
                @php
                  $dbPerm = $permissions->get($permKey);
                  $assignedRoles = $dbPerm ? $dbPerm->roles->filter(fn($r) => $r->name !== 'super-admin') : collect();
                @endphp
                <tr class="hover:bg-gray-50/60 transition">
                  <td class="py-3 px-4 text-center font-bold text-gray-400">
                    {{ $loop->iteration }}
                  </td>
                  <td class="py-3 px-4 font-mono font-bold text-gray-900">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-gray-100 text-gray-800 border border-gray-200 text-xs">
                      <i class="ri-key-line text-[#0b4622] text-xs"></i>
                      <span>{{ $permKey }}</span>
                    </span>
                  </td>
                  <td class="py-3 px-4">
                    <p class="font-bold text-gray-900 text-xs">{{ $permMeta['title'] }}</p>
                    <p class="text-[11px] text-gray-400 font-medium">{{ $permMeta['desc'] }}</p>
                  </td>
                  <td class="py-3 px-4">
                    <div class="flex flex-wrap gap-1">
                      @forelse($assignedRoles as $r)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $r->name === 'admin' ? 'bg-emerald-50 text-[#0b4622] border border-emerald-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                          {{ $r->name }}
                        </span>
                      @empty
                        <span class="text-gray-400 italic text-[11px]">কোনো রোলে বরাদ্দ নেই</span>
                      @endforelse
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

      </div>
    @endforeach
  </div>

</div>
@endsection
