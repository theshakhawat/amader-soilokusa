@extends('layouts.admin.admin-layout')

@section('title', 'ভূমিকা ও পারমিশন ব্যবস্থাপনা (Roles & Permissions) | আগামীর শৈলকুপা')

@section('content')
<div class="space-y-6">

  <!-- Breadcrumb & Top Bar -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line"></i>
        <a href="{{ route('admin.users.index') }}" class="hover:text-[#0b4622]">ব্যবহারকারী</a>
        <i class="ri-arrow-right-s-line"></i>
        <span class="text-[#0b4622] font-semibold">ভূমিকা ও পারমিশন</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
        <i class="ri-shield-user-line text-[#0b4622]"></i>
        <span>ভূমিকা ও পারমিশন ব্যবস্থাপনা (Roles & Permissions)</span>
      </h1>
      <p class="text-xs text-gray-500 mt-0.5">
        সিস্টেমের রোলসমূহ (Role) এবং কোন রোলের কী কী পারমিশন (Permission) থাকবে তা ডাইনামিকভাবে নিয়ন্ত্রণ করুন।
      </p>
    </div>

    <div class="flex items-center gap-2.5">
      <a
        href="{{ route('admin.users.index') }}"
        class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition cursor-pointer"
      >
        <i class="ri-team-line"></i>
        <span>ব্যবহারকারী তালিকা</span>
      </a>

      <button
        type="button"
        onclick="openNewRoleModal()"
        class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-xs hover:shadow transition cursor-pointer"
      >
        <i class="ri-add-line text-base"></i>
        <span>নতুন ভূমিকা যোগ করুন</span>
      </button>
    </div>
  </div>

  @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-2xl flex items-center justify-between">
      <div class="flex items-center gap-2">
        <i class="ri-checkbox-circle-fill text-emerald-600 text-base"></i>
        <span>{{ session('success') }}</span>
      </div>
    </div>
  @endif

  @if(session('error'))
    <div class="p-4 bg-red-50 border border-red-200 text-red-800 text-xs font-bold rounded-2xl flex items-center justify-between">
      <div class="flex items-center gap-2">
        <i class="ri-error-warning-fill text-red-600 text-base"></i>
        <span>{{ session('error') }}</span>
      </div>
    </div>
  @endif

  <!-- Role Cards Grid with Permissions -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($roles as $role)
      <div class="bg-white rounded-2xl border border-gray-100 shadow-2xs p-5 flex flex-col justify-between space-y-4">
        <div>
          <!-- Header -->
          <div class="flex items-center justify-between pb-3 border-b border-gray-100">
            <div class="flex items-center gap-2">
              <span class="w-8 h-8 rounded-xl bg-emerald-50 text-[#0b4622] font-black flex items-center justify-center">
                <i class="ri-shield-keyhole-line"></i>
              </span>
              <div>
                <h3 class="text-sm font-extrabold text-gray-900 uppercase">
                  {{ $role->name }}
                </h3>
                <span class="text-[11px] text-gray-400">
                  {{ $role->users_count }} জন ব্যবহারকারী
                </span>
              </div>
            </div>

            @if(!in_array($role->name, ['super-admin', 'admin', 'member']))
              <form
                action="{{ route('admin.roles.destroy', $role->id) }}"
                method="POST"
                onsubmit="return confirm('আপনি কি নিশ্চিত যে এই রোলটি মুছে ফেলতে চান?');"
              >
                @csrf
                @method('DELETE')
                <button
                  type="submit"
                  class="w-7 h-7 rounded-lg bg-red-50 hover:bg-[#c8102e] text-[#c8102e] hover:text-white flex items-center justify-center transition cursor-pointer"
                  title="রোল ডিলিট"
                >
                  <i class="ri-delete-bin-line text-xs"></i>
                </button>
              </form>
            @endif
          </div>

          <!-- Permissions Form for this role -->
          <form id="role-perm-form-{{ $role->id }}" action="{{ route('admin.roles.permissions.update', $role->id) }}" method="POST" class="pt-3 space-y-3">
            @csrf
            @method('PUT')

            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider block">বরাদ্দকৃত পারমিশনসমূহ:</span>

            <div class="space-y-1.5 max-h-64 overflow-y-auto pr-1">
              @foreach($permissions as $perm)
                @php $hasPerm = $role->hasPermissionTo($perm->name); @endphp
                <label class="flex items-center justify-between p-2 rounded-xl border {{ $hasPerm ? 'border-emerald-200 bg-emerald-50/40 text-[#0b4622]' : 'border-gray-100 bg-gray-50/50 text-gray-600' }} hover:border-emerald-300 cursor-pointer transition">
                  <span class="text-xs font-semibold">{{ $perm->name }}</span>
                  <input
                    type="checkbox"
                    name="permissions[]"
                    value="{{ $perm->name }}"
                    {{ $hasPerm ? 'checked' : '' }}
                    class="rounded text-[#0b4622] focus:ring-[#0b4622]"
                  >
                </label>
              @endforeach
            </div>

            <div class="pt-3 border-t border-gray-100 flex justify-end">
              <button
                type="submit"
                class="px-4 py-2 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-xs transition cursor-pointer"
              >
                পারমিশন সেভ করুন
              </button>
            </div>
          </form>
        </div>
      </div>
    @endforeach
  </div>

</div>

<!-- New Role Modal -->
<div id="new-role-modal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs hidden items-center justify-center p-4">
  <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl space-y-4">
    <div class="flex items-center justify-between pb-3 border-b border-gray-100">
      <h3 class="text-sm font-black text-gray-900 flex items-center gap-1.5">
        <i class="ri-shield-user-line text-[#0b4622]"></i>
        <span>নতুন ভূমিকা (Role) যোগ করুন</span>
      </h3>
      <button type="button" onclick="closeNewRoleModal()" class="text-gray-400 hover:text-gray-700">
        <i class="ri-close-line text-xl"></i>
      </button>
    </div>

    <form action="{{ route('admin.roles.store') }}" method="POST" class="space-y-4">
      @csrf

      <div>
        <label for="new_role_name" class="block text-xs font-bold text-gray-700 mb-1">
          ভূমিকার নাম (Role Name) <span class="text-[#c8102e]">*</span>
        </label>
        <input
          type="text"
          id="new_role_name"
          name="name"
          placeholder="উদাঃ editor বা moderator"
          class="w-full px-3.5 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
          required
        >
        <p class="text-[10px] text-gray-400 mt-1">ইংরেজি ছোট অক্ষরে লিখুন (উদাঃ editor, manager)।</p>
      </div>

      <div>
        <label class="block text-xs font-bold text-gray-700 mb-1.5">
          প্রাথমিক পারমিশন নির্বাচন করুন (ঐচ্ছিক)
        </label>
        <div class="space-y-1.5 max-h-48 overflow-y-auto pr-1">
          @foreach($permissions as $perm)
            <label class="flex items-center justify-between p-2 rounded-xl border border-gray-100 bg-gray-50/50 hover:bg-white text-gray-700 cursor-pointer text-xs">
              <span>{{ $perm->name }}</span>
              <input type="checkbox" name="permissions[]" value="{{ $perm->name }}" class="rounded text-[#0b4622]">
            </label>
          @endforeach
        </div>
      </div>

      <div class="flex items-center justify-end gap-2.5 pt-2">
        <button
          type="button"
          onclick="closeNewRoleModal()"
          class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition"
        >
          বাতিল
        </button>
        <button
          type="submit"
          class="px-5 py-2 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-xs transition"
        >
          রোল তৈরি করুন
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function openNewRoleModal() {
  const modal = document.getElementById('new-role-modal');
  modal.classList.remove('hidden');
  modal.classList.add('flex');
}

function closeNewRoleModal() {
  const modal = document.getElementById('new-role-modal');
  modal.classList.remove('flex');
  modal.classList.add('hidden');
}
</script>
@endsection

