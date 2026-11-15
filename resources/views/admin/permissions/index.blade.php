@extends('layouts.admin.admin-layout')

@section('title', 'পারমিশন ব্যবস্থাপনা (Permissions) | আগামীর শৈলকুপা')

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
        <span class="text-[#0b4622] font-semibold">পারমিশন তালিকা</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
        <i class="ri-key-2-line text-[#0b4622]"></i>
        <span>পারমিশন ব্যবস্থাপনা (Permissions)</span>
      </h1>
      <p class="text-xs text-gray-500 mt-0.5">
        সিস্টেমের পারমিশনসমূহের তালিকা ও সংশ্লিষ্ট রোলসমূহ।
      </p>
    </div>

    <div class="flex items-center gap-2.5">
      <a
        href="{{ route('admin.roles.index') }}"
        class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition cursor-pointer"
      >
        <i class="ri-shield-user-line"></i>
        <span>রোল (Role) ব্যবস্থাপনা</span>
      </a>

      <button
        type="button"
        onclick="openNewPermModal()"
        class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-xs hover:shadow transition cursor-pointer"
      >
        <i class="ri-add-line text-base"></i>
        <span>নতুন পারমিশন যোগ করুন</span>
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

  <!-- Permissions Table -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-2xs overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-gray-50/80 border-b border-gray-100 text-[11px] font-black text-gray-500 uppercase tracking-wider">
            <th class="py-3 px-4 text-center w-12">#</th>
            <th class="py-3 px-4">পারমিশনের নাম (Permission Name)</th>
            <th class="py-3 px-4">গার্ড (Guard)</th>
            <th class="py-3 px-4">বরাদ্দকৃত রোলসমূহ (Assigned Roles)</th>
            <th class="py-3 px-4 text-center w-24">অ্যাকশন</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-xs text-gray-700">
          @forelse($permissions as $perm)
            <tr class="hover:bg-gray-50/70 transition">
              <td class="py-3 px-4 text-center font-bold text-gray-400">
                {{ $loop->iteration }}
              </td>
              <td class="py-3 px-4 font-mono font-bold text-gray-900">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 text-[#0b4622] border border-emerald-100">
                  <i class="ri-key-line text-xs"></i>
                  {{ $perm->name }}
                </span>
              </td>
              <td class="py-3 px-4 font-mono text-gray-500">
                {{ $perm->guard_name }}
              </td>
              <td class="py-3 px-4">
                <div class="flex flex-wrap gap-1">
                  @forelse($perm->roles->filter(fn($r) => $r->name !== 'super-admin') as $r)
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-gray-100 text-gray-700 border border-gray-200 uppercase">
                      {{ $r->name }}
                    </span>
                  @empty
                    <span class="text-gray-400 italic text-[11px]">—</span>
                  @endforelse
                </div>
              </td>
              <td class="py-3 px-4 text-center">
                <form
                  action="{{ route('admin.permissions.destroy', $perm->id) }}"
                  method="POST"
                  onsubmit="return confirm('আপনি কি নিশ্চিত যে এই পারমিশনটি মুছে ফেলতে চান?');"
                  class="inline"
                >
                  @csrf
                  @method('DELETE')
                  <button
                    type="submit"
                    class="w-7 h-7 rounded-lg bg-red-50 hover:bg-[#c8102e] text-[#c8102e] hover:text-white flex items-center justify-center transition cursor-pointer mx-auto"
                    title="পারমিশন ডিলিট"
                  >
                    <i class="ri-delete-bin-line text-xs"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="py-12 text-center text-gray-400">
                <i class="ri-key-line text-3xl block mb-2 text-gray-300"></i>
                কোনো পারমিশন পাওয়া যায়নি।
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- New Permission Modal -->
<div id="new-perm-modal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs hidden items-center justify-center p-4">
  <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl space-y-4">
    <div class="flex items-center justify-between pb-3 border-b border-gray-100">
      <h3 class="text-sm font-black text-gray-900 flex items-center gap-1.5">
        <i class="ri-key-line text-[#0b4622]"></i>
        <span>নতুন পারমিশন (Permission) যোগ করুন</span>
      </h3>
      <button type="button" onclick="closeNewPermModal()" class="text-gray-400 hover:text-gray-700">
        <i class="ri-close-line text-xl"></i>
      </button>
    </div>

    <form action="{{ route('admin.permissions.store') }}" method="POST" class="space-y-4">
      @csrf

      <div>
        <label for="new_perm_name" class="block text-xs font-bold text-gray-700 mb-1">
          পারমিশনের নাম (Permission Name) <span class="text-[#c8102e]">*</span>
        </label>
        <input
          type="text"
          id="new_perm_name"
          name="name"
          placeholder="উদাঃ manage-posts, export-reports"
          class="w-full px-3.5 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
          required
        >
        <p class="text-[10px] text-gray-400 mt-1">ইংরেজি ছোট অক্ষর ও হাইফেন দিয়ে লিখুন (উদাঃ view-reports)।</p>
      </div>

      <div class="flex items-center justify-end gap-2.5 pt-2">
        <button
          type="button"
          onclick="closeNewPermModal()"
          class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition"
        >
          বাতিল
        </button>
        <button
          type="submit"
          class="px-5 py-2 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-xs transition"
        >
          পারমিশন তৈরি করুন
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function openNewPermModal() {
  const modal = document.getElementById('new-perm-modal');
  modal.classList.remove('hidden');
  modal.classList.add('flex');
}

function closeNewPermModal() {
  const modal = document.getElementById('new-perm-modal');
  modal.classList.remove('flex');
  modal.classList.add('hidden');
}
</script>
@endsection

