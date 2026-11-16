@extends('layouts.admin.admin-layout')

@section('title', "পারমিশন বরাদ্দ — {$role->name} | আগামীর শৈলকুপা")

@section('content')
<div class="space-y-6 max-w-7xl mx-auto pb-16">

  <!-- Breadcrumb & Top Bar -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-5 sm:p-6 rounded-2xl border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)]">
    <div>
      <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line"></i>
        <a href="{{ route('admin.roles.index') }}" class="hover:text-[#0b4622]">রোল ব্যবস্থাপনা</a>
        <i class="ri-arrow-right-s-line"></i>
        <span class="text-[#0b4622] font-semibold">{{ $role->name }} পারমিশন</span>
      </div>
      <div class="flex items-center gap-2.5">
        <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight">
          পারমিশন বরাদ্দ: <span class="text-[#0b4622] uppercase">{{ $role->name }}</span>
        </h1>
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-extrabold bg-emerald-50 text-emerald-800 border border-emerald-200">
          {{ count($rolePermissions) }} টি সক্রিয়
        </span>
      </div>
      <p class="text-xs text-gray-500 mt-1">
        এই রোলের অধীনে থাকা ব্যবহারকারীরা যে যে মডিউল ও অ্যাকশন দেখতে ও পরিচালনা করতে পারবেন তা নির্বাচন করুন।
      </p>
    </div>

    <!-- Role Switcher & Back Button -->
    <div class="flex items-center flex-wrap gap-2.5 shrink-0">
      <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-xl px-3 py-1.5">
        <label for="role-switcher" class="text-xs font-bold text-gray-500 flex items-center gap-1">
          <i class="ri-switch-line text-[#0b4622]"></i>
          <span>রোল পরিবর্তন:</span>
        </label>
        <select
          id="role-switcher"
          onchange="window.location.href=this.value"
          class="bg-transparent text-xs font-bold text-gray-900 focus:outline-none cursor-pointer uppercase"
        >
          @foreach($allRoles as $r)
            <option value="{{ route('admin.roles.permissions', $r->id) }}" {{ $r->id === $role->id ? 'selected' : '' }}>
              {{ $r->name }} ({{ $r->permissions()->count() }}টি পারমিশন)
            </option>
          @endforeach
        </select>
      </div>

      <a
        href="{{ route('admin.roles.index') }}"
        class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition"
      >
        <i class="ri-arrow-left-line"></i>
        <span>রোল তালিকা</span>
      </a>
    </div>
  </div>

  @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-2xl flex items-center justify-between shadow-2xs">
      <div class="flex items-center gap-2">
        <i class="ri-checkbox-circle-fill text-emerald-600 text-base"></i>
        <span>{{ session('success') }}</span>
      </div>
      <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
        <i class="ri-close-line"></i>
      </button>
    </div>
  @endif

  <!-- Main Permission Assignment Form -->
  <form action="{{ route('admin.roles.permissions.update', $role->id) }}" method="POST" id="permissions-form">
    @csrf
    @method('PUT')

    <!-- Quick Action Control Bar (Static, Normal flow — No floating/sticky obstruction) -->
    <div class="bg-white p-3.5 sm:p-4 rounded-xl border border-gray-200 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
      <div class="flex items-center gap-2 flex-wrap">
        <button
          type="button"
          onclick="selectAllPermissions()"
          class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 text-xs font-semibold transition cursor-pointer"
        >
          <i class="ri-checkbox-line text-sm text-[#0b4622]"></i>
          <span>সবগুলো নির্বাচন (Select All)</span>
        </button>

        <button
          type="button"
          onclick="deselectAllPermissions()"
          class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 text-xs font-semibold transition cursor-pointer"
        >
          <i class="ri-checkbox-blank-line text-sm text-red-500"></i>
          <span>সব বাতিল (Deselect All)</span>
        </button>

        <span id="selected-count-badge" class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200/60">
          <span id="selected-count">{{ count($rolePermissions) }}</span> টি পারমিশন নির্বাচিত
        </span>
      </div>

      <div class="flex items-center gap-2 self-end sm:self-auto">
        <a
          href="{{ route('admin.roles.index') }}"
          class="px-3.5 py-1.5 text-xs font-semibold text-gray-600 hover:text-gray-900 rounded-lg hover:bg-gray-50 transition"
        >
          বাতিল
        </a>
        <button
          type="submit"
          class="inline-flex items-center gap-1.5 px-4 py-1.5 text-xs font-semibold text-white bg-[#0b4622] hover:bg-[#08351a] rounded-lg shadow-2xs transition cursor-pointer"
        >
          <i class="ri-save-3-line text-sm"></i>
          <span>পারমিশন সংরক্ষণ করুন</span>
        </button>
      </div>
    </div>

    <!-- Module Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
      @foreach($modules as $modKey => $module)
        @php
          $modPermissions = array_keys($module['permissions']);
          $checkedInMod = array_intersect($modPermissions, $rolePermissions);
          $isAllChecked = (count($checkedInMod) === count($modPermissions) && count($modPermissions) > 0);
        @endphp

        <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)] hover:shadow-md transition flex flex-col justify-between overflow-hidden">
          
          <!-- Card Header with "Check All" Checkbox -->
          <div class="p-4 bg-gray-50/70 border-b border-gray-100 flex items-center justify-between gap-3">
            <div class="flex items-center gap-2.5 min-w-0">
              <span class="w-8 h-8 rounded-xl bg-emerald-50 text-[#0b4622] flex items-center justify-center text-base shrink-0 border border-emerald-100/60">
                <i class="{{ $module['icon'] ?? 'ri-shield-line' }}"></i>
              </span>
              <div class="truncate">
                <h3 class="text-xs sm:text-sm font-extrabold text-gray-900 truncate">
                  {{ $module['name_bn'] }}
                </h3>
                <span class="text-[10px] text-gray-400 block truncate font-mono">
                  {{ count($modPermissions) }} টি পারমিশন
                </span>
              </div>
            </div>

            <!-- "Check All" for this module -->
            <label class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-white border border-gray-200 hover:border-[#0b4622] transition cursor-pointer shrink-0 shadow-3xs select-none">
              <input
                type="checkbox"
                id="master-chk-{{ $modKey }}"
                class="module-master-chk w-3.5 h-3.5 rounded text-[#0b4622] focus:ring-[#0b4622] border-gray-300 cursor-pointer accent-[#0b4622]"
                onchange="toggleModulePermissions('{{ $modKey }}', this.checked)"
                {{ $isAllChecked ? 'checked' : '' }}
              />
              <span class="text-[11px] font-bold text-gray-700">সব নির্বাচন</span>
            </label>
          </div>

          <!-- Card Body: Permissions List -->
          <div class="p-4 space-y-2.5 flex-1">
            @foreach($module['permissions'] as $permKey => $permMeta)
              @php
                $isPermChecked = in_array($permKey, $rolePermissions);
                $isDelete = str_ends_with($permKey, '.delete');
              @endphp

              <label class="flex items-start gap-2.5 p-2 rounded-xl hover:bg-gray-50 transition cursor-pointer select-none group border border-transparent hover:border-gray-100">
                <input
                  type="checkbox"
                  name="permissions[]"
                  value="{{ $permKey }}"
                  class="mod-perm-chk mod-perm-{{ $modKey }} mt-0.5 w-4 h-4 rounded text-[#0b4622] focus:ring-[#0b4622] border-gray-300 cursor-pointer accent-[#0b4622]"
                  onchange="updateModuleMasterState('{{ $modKey }}')"
                  {{ $isPermChecked ? 'checked' : '' }}
                />
                <div class="min-w-0 flex-1">
                  <div class="flex items-center justify-between gap-1">
                    <span class="text-xs font-bold text-gray-900 group-hover:text-[#0b4622] transition leading-snug">
                      {{ $permMeta['title'] }}
                    </span>
                    @if($isDelete)
                      <span class="text-[10px] font-bold text-[#c8102e] bg-red-50 px-1.5 py-0.2 rounded shrink-0">
                        মুছে ফেলা
                      </span>
                    @endif
                  </div>
                  <span class="text-[10px] text-gray-400 font-mono block mt-0.5">
                    {{ $permKey }}
                  </span>
                </div>
              </label>
            @endforeach
          </div>

        </div>
      @endforeach
    </div>

    <!-- Bottom Save Action Bar -->
    <div class="mt-8 pt-4 border-t border-gray-200 flex items-center justify-between">
      <span class="text-xs text-gray-500 font-medium">
        পারমিশন পরিবর্তনের সাথে সাথে সংশ্লিষ্ট রোলের ব্যবহারকারীদের সাইডবার মেনু ও ক্ষমতা স্বয়ংক্রিয়ভাবে আপডেট হবে।
      </span>
      <button
        type="submit"
        class="inline-flex items-center gap-2 px-6 py-2.5 text-xs font-bold text-white bg-[#0b4622] hover:bg-[#08351a] rounded-xl shadow-md hover:shadow-lg transition cursor-pointer"
      >
        <i class="ri-save-3-line text-base"></i>
        <span>পারমিশন সংরক্ষণ করুন</span>
      </button>
    </div>

  </form>

</div>

<script>
// Toggle all checkboxes in a specific module card
function toggleModulePermissions(modKey, isChecked) {
  const checkboxes = document.querySelectorAll(`.mod-perm-${modKey}`);
  checkboxes.forEach(chk => {
    chk.checked = isChecked;
  });
  updateTotalSelectedCount();
}

// Update the module master checkbox state when individual item changes
function updateModuleMasterState(modKey) {
  const master = document.getElementById(`master-chk-${modKey}`);
  const checkboxes = document.querySelectorAll(`.mod-perm-${modKey}`);
  if (!master || checkboxes.length === 0) return;

  const allChecked = Array.from(checkboxes).every(chk => chk.checked);
  master.checked = allChecked;

  updateTotalSelectedCount();
}

// Global Select All
function selectAllPermissions() {
  document.querySelectorAll('.mod-perm-chk').forEach(chk => chk.checked = true);
  document.querySelectorAll('.module-master-chk').forEach(chk => chk.checked = true);
  updateTotalSelectedCount();
}

// Global Deselect All
function deselectAllPermissions() {
  document.querySelectorAll('.mod-perm-chk').forEach(chk => chk.checked = false);
  document.querySelectorAll('.module-master-chk').forEach(chk => chk.checked = false);
  updateTotalSelectedCount();
}

// Update counter badge
function updateTotalSelectedCount() {
  const total = document.querySelectorAll('.mod-perm-chk:checked').length;
  const badge = document.getElementById('selected-count');
  if (badge) {
    badge.innerText = total;
  }
}

document.addEventListener('DOMContentLoaded', function () {
  updateTotalSelectedCount();
});
</script>
@endsection
