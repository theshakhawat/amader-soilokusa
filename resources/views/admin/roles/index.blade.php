@extends('layouts.admin.admin-layout')

@section('title', 'রোল ব্যবস্থাপনা (Roles) | আগামীর শৈলকুপা')

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
        <span class="text-[#0b4622] font-semibold">রোল ব্যবস্থাপনা</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
        <i class="ri-shield-user-line text-[#0b4622]"></i>
        <span>রোল ব্যবস্থাপনা (Role Management)</span>
      </h1>
      <p class="text-xs text-gray-500 mt-0.5">
        সিস্টেমের বিভিন্ন ভূমিকা (Roles) তৈরি করুন এবং মডিউলভিত্তিক গ্র্যানুলার পারমিশন বরাদ্দ করুন।
      </p>
    </div>

    <div class="flex items-center flex-wrap gap-2.5">
      <a
        href="{{ route('admin.permissions.index') }}"
        class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition cursor-pointer"
        title="সকল সিস্টেম পারমিশন ক্যাটালগ দেখুন"
      >
        <i class="ri-key-2-line text-sm text-[#0b4622]"></i>
        <span>পারমিশন ক্যাটালগ</span>
      </a>

      <button
        type="button"
        onclick="openNewRoleModal()"
        class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-xs hover:shadow transition cursor-pointer"
      >
        <i class="ri-add-line text-base"></i>
        <span>+ নতুন রোল তৈরি করুন</span>
      </button>
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

  @if(session('error'))
    <div class="p-4 bg-red-50 border border-red-200 text-red-800 text-xs font-bold rounded-2xl flex items-center justify-between shadow-2xs">
      <div class="flex items-center gap-2">
        <i class="ri-error-warning-fill text-red-600 text-base"></i>
        <span>{{ session('error') }}</span>
      </div>
      <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
        <i class="ri-close-line"></i>
      </button>
    </div>
  @endif

  <!-- Role List Table View (As specifically requested by user) -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)] overflow-hidden">
    <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
      <div>
        <h2 class="text-sm font-extrabold text-gray-900 flex items-center gap-2">
          <i class="ri-table-line text-[#0b4622]"></i>
          <span>সিস্টেম রোল তালিকা (Roles Table)</span>
        </h2>
        <p class="text-xs text-gray-400 mt-0.5">রোল অনুযায়ী বরাদ্দকৃত পারমিশন এবং ব্যবহারকারী সংখ্যা</p>
      </div>
      <span class="text-xs font-bold text-gray-500 bg-gray-100 px-3 py-1 rounded-full self-start sm:self-auto">
        মোট রোল: {{ $roles->count() }} টি
      </span>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse text-xs">
        <thead>
          <tr class="bg-gray-50/80 border-b border-gray-100 text-[11px] font-black text-gray-500 uppercase tracking-wider">
            <th class="py-3.5 px-4 text-center w-14">#</th>
            <th class="py-3.5 px-4">রোলের নাম (Role Name)</th>
            <th class="py-3.5 px-4 text-center">ব্যবহারকারী (Users)</th>
            <th class="py-3.5 px-4">অনুমোদিত পারমিশন (Permissions)</th>
            <th class="py-3.5 px-4 text-right">অ্যাকশন (Actions)</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 font-medium">
          @forelse($roles as $role)
            <tr class="hover:bg-gray-50/70 transition">
              <td class="py-3.5 px-4 text-center font-bold text-gray-400">
                {{ $loop->iteration }}
              </td>

              <!-- Role Name -->
              <td class="py-3.5 px-4">
                <div class="flex items-center gap-2.5">
                  <span class="w-8 h-8 rounded-xl bg-emerald-50 text-[#0b4622] font-black flex items-center justify-center shrink-0">
                    <i class="ri-shield-keyhole-line"></i>
                  </span>
                  <div>
                    <div class="flex items-center gap-2">
                      <span class="font-extrabold text-gray-900 uppercase tracking-wide text-xs sm:text-sm">
                        {{ $role->name }}
                      </span>
                      @if(in_array($role->name, ['admin', 'super-admin']))
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200">
                          সিস্টেম ডিফল্ট
                        </span>
                      @elseif($role->name === 'manager')
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                          ম্যানেজমেন্ট
                        </span>
                      @elseif($role->name === 'member')
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-700 border border-gray-200">
                          সাধারণ সদস্য
                        </span>
                      @endif
                    </div>
                    <span class="text-[11px] text-gray-400 font-mono">
                      গার্ড: {{ $role->guard_name }}
                    </span>
                  </div>
                </div>
              </td>

              <!-- Users Count -->
              <td class="py-3.5 px-4 text-center">
                <a
                  href="{{ route('admin.users.index', ['role' => $role->name]) }}"
                  class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold {{ $role->users_count > 0 ? 'bg-emerald-50 text-[#0b4622] hover:bg-emerald-100' : 'bg-gray-100 text-gray-400' }} transition"
                  title="এই রোলের ব্যবহারকারী তালিকা দেখুন"
                >
                  <i class="ri-user-line text-[11px]"></i>
                  <span>{{ $role->users_count }} জন</span>
                </a>
              </td>

              <!-- Permissions Progress / Count -->
              <td class="py-3.5 px-4">
                <div class="flex items-center gap-2">
                  <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold {{ $role->permissions_count > 0 ? 'bg-teal-50 text-teal-800 border border-teal-200/60' : 'bg-gray-100 text-gray-400' }}">
                    <i class="ri-key-line text-xs"></i>
                    <span>{{ $role->permissions_count }} টি পারমিশন সক্রিয়</span>
                  </span>
                  @if($role->name === 'admin')
                    <span class="text-[11px] text-emerald-700 font-bold">(সম্পূর্ণ অ্যাক্সেস)</span>
                  @endif
                </div>
              </td>

              <!-- Actions -->
              <td class="py-3.5 px-4 text-right">
                <div class="flex items-center justify-end gap-1.5">
                  <!-- Assign Permissions Button (Main Focus) -->
                  <a
                    href="{{ route('admin.roles.permissions', $role->id) }}"
                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold transition shadow-xs hover:shadow"
                    title="এই রোলের পারমিশন নির্বাচন ও বরাদ্দ করুন"
                  >
                    <i class="ri-checkbox-multiple-line text-xs"></i>
                    <span>পারমিশন বরাদ্দ</span>
                  </a>

                  <!-- Edit Role Name Modal Trigger (Custom roles only) -->
                  @if(!in_array($role->name, ['admin', 'super-admin', 'member']))
                    <button
                      type="button"
                      onclick="openEditRoleModal('{{ $role->id }}', '{{ $role->name }}')"
                      class="w-8 h-8 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-600 flex items-center justify-center transition cursor-pointer"
                      title="রোলের নাম পরিবর্তন করুন"
                    >
                      <i class="ri-edit-line text-sm"></i>
                    </button>

                    <!-- Delete Role (Disabled if active users) -->
                    <form
                      action="{{ route('admin.roles.destroy', $role->id) }}"
                      method="POST"
                      onsubmit="return confirm('আপনি কি নিশ্চিত যে \'{{ $role->name }}\' রোলটি মুছে ফেলতে চান?');"
                      class="inline"
                    >
                      @csrf
                      @method('DELETE')
                      <button
                        type="submit"
                        class="w-8 h-8 rounded-xl bg-red-50 hover:bg-[#c8102e] text-[#c8102e] hover:text-white flex items-center justify-center transition cursor-pointer"
                        title="রোল মুছে ফেলুন"
                      >
                        <i class="ri-delete-bin-line text-sm"></i>
                      </button>
                    </form>
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="py-12 text-center text-gray-400">
                <i class="ri-shield-user-line text-4xl block mb-2 text-gray-300"></i>
                কোনো রোল পাওয়া যায়নি।
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- Modal 1: Create New Role -->
<div id="new-role-modal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs hidden items-center justify-center p-4">
  <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4 animate-scaleUp">
    <div class="flex items-center justify-between pb-3 border-b border-gray-100">
      <div class="flex items-center gap-2">
        <span class="w-8 h-8 rounded-xl bg-emerald-50 text-[#0b4622] flex items-center justify-center font-bold">
          <i class="ri-shield-keyhole-line"></i>
        </span>
        <h3 class="text-base font-extrabold text-gray-900">নতুন রোল তৈরি করুন</h3>
      </div>
      <button type="button" onclick="closeNewRoleModal()" class="text-gray-400 hover:text-gray-600 transition">
        <i class="ri-close-line text-xl"></i>
      </button>
    </div>

    <form action="{{ route('admin.roles.store') }}" method="POST" class="space-y-4">
      @csrf
      <div>
        <label class="block text-xs font-bold text-gray-700 mb-1.5">
          রোলের নাম (Role Name) <span class="text-red-500">*</span>
        </label>
        <input
          type="text"
          name="name"
          required
          placeholder="উদা: manager, editor, volunteer-lead"
          class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs sm:text-sm focus:border-[#0b4622] focus:ring-2 focus:ring-[#0b4622]/10 transition outline-none"
        />
        <p class="text-[11px] text-gray-400 mt-1">
          রোলের নাম তৈরি করার পর আপনি সরাসরি এর পারমিশন বরাদ্দ পেজে চলে যাবেন।
        </p>
      </div>

      <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-100">
        <button
          type="button"
          onclick="closeNewRoleModal()"
          class="px-4 py-2 text-xs font-bold text-gray-600 hover:bg-gray-100 rounded-xl transition"
        >
          বাতিল
        </button>
        <button
          type="submit"
          class="px-4 py-2 text-xs font-bold text-white bg-[#0b4622] hover:bg-[#08351a] rounded-xl shadow-xs transition"
        >
          রোল তৈরি ও পারমিশন বরাদ্দ
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Modal 2: Edit Role Name -->
<div id="edit-role-modal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs hidden items-center justify-center p-4">
  <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4 animate-scaleUp">
    <div class="flex items-center justify-between pb-3 border-b border-gray-100">
      <div class="flex items-center gap-2">
        <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center font-bold">
          <i class="ri-edit-line"></i>
        </span>
        <h3 class="text-base font-extrabold text-gray-900">রোলের নাম পরিবর্তন</h3>
      </div>
      <button type="button" onclick="closeEditRoleModal()" class="text-gray-400 hover:text-gray-600 transition">
        <i class="ri-close-line text-xl"></i>
      </button>
    </div>

    <form id="edit-role-form" method="POST" class="space-y-4">
      @csrf
      @method('PUT')
      <div>
        <label class="block text-xs font-bold text-gray-700 mb-1.5">
          সংশোধিত রোলের নাম <span class="text-red-500">*</span>
        </label>
        <input
          type="text"
          id="edit-role-name"
          name="name"
          required
          class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs sm:text-sm focus:border-[#0b4622] focus:ring-2 focus:ring-[#0b4622]/10 transition outline-none"
        />
      </div>

      <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-100">
        <button
          type="button"
          onclick="closeEditRoleModal()"
          class="px-4 py-2 text-xs font-bold text-gray-600 hover:bg-gray-100 rounded-xl transition"
        >
          বাতিল
        </button>
        <button
          type="submit"
          class="px-4 py-2 text-xs font-bold text-white bg-[#0b4622] hover:bg-[#08351a] rounded-xl shadow-xs transition"
        >
          হালনাগাদ করুন
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function openNewRoleModal() {
  document.getElementById('new-role-modal').classList.remove('hidden');
  document.getElementById('new-role-modal').classList.add('flex');
}
function closeNewRoleModal() {
  document.getElementById('new-role-modal').classList.add('hidden');
  document.getElementById('new-role-modal').classList.remove('flex');
}

function openEditRoleModal(id, name) {
  document.getElementById('edit-role-name').value = name;
  document.getElementById('edit-role-form').action = `/admin/roles/${id}`;
  document.getElementById('edit-role-modal').classList.remove('hidden');
  document.getElementById('edit-role-modal').classList.add('flex');
}
function closeEditRoleModal() {
  document.getElementById('edit-role-modal').classList.add('hidden');
  document.getElementById('edit-role-modal').classList.remove('flex');
}
</script>
@endsection
