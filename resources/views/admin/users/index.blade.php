@extends('layouts.admin.admin-layout')

@section('title', 'ব্যবহারকারী ব্যবস্থাপনা | আগামীর শৈলকুপা')

@section('content')
<div class="space-y-6">

  <!-- Breadcrumb & Top Bar -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line"></i>
        <span class="text-gray-400">ব্যবহারকারী তালিকা</span>
        <i class="ri-arrow-right-s-line"></i>
        <span class="text-[#0b4622] font-semibold">
          @if($filter === 'members') সক্রিয় সদস্য
          @elseif($filter === 'pending') অপেক্ষমাণ আবেদন
          @else সকল ব্যবহারকারী
          @endif
        </span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
        <i class="ri-user-settings-line text-[#0b4622]"></i>
        <span>
          @if($filter === 'members') সক্রিয় সদস্য তালিকা (Active Members)
          @elseif($filter === 'pending') অপেক্ষমাণ আবেদন (Pending Requests)
          @else সকল ব্যবহারকারী তালিকা (All Users)
          @endif
        </span>
      </h1>
      <p class="text-xs text-gray-500 mt-0.5">
        @if($filter === 'members')
          সংগঠনের সাধারণ ও সক্রিয় সদস্য যাদের রোল 'member' (এডমিন বা সুপার এডমিন নন)।
        @else
          সুপার এডমিন, এডমিন ও সাধারণ সদস্য সহ সকল নিবন্ধিত ব্যবহারকারীদের তথ্য ও রোল পরিচালনা করুন।
        @endif
      </p>
    </div>

    <div class="flex items-center gap-2.5">
      <a
        href="{{ route('admin.roles.index') }}"
        class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition cursor-pointer"
      >
        <i class="ri-shield-user-line"></i>
        <span>ভূমিকা ও পারমিশন</span>
      </a>

      <a
        href="{{ route('admin.users.create') }}"
        class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-xs hover:shadow transition cursor-pointer"
      >
        <i class="ri-user-add-line text-base"></i>
        <span>নতুন ব্যবহারকারী যোগ</span>
      </a>
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

  <!-- Quick Filter Tabs -->
  <div class="flex flex-wrap items-center bg-white p-2 rounded-2xl border border-gray-100 shadow-2xs gap-1.5">
    <a
      href="{{ route('admin.users.index') }}"
      class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold transition {{ $filter === 'all' ? 'bg-[#0b4622] text-white shadow-xs' : 'text-gray-600 hover:bg-gray-50' }}"
    >
      <i class="ri-team-line"></i>
      <span>সকল ব্যবহারকারী</span>
      <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $filter === 'all' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-700' }}">{{ $totalUsers }}</span>
    </a>

    <a
      href="{{ route('admin.users.index', ['filter' => 'members']) }}"
      class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold transition {{ $filter === 'members' ? 'bg-[#0b4622] text-white shadow-xs' : 'text-gray-600 hover:bg-gray-50' }}"
    >
      <i class="ri-user-follow-line"></i>
      <span>সক্রিয় সদস্য (Members)</span>
      <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $filter === 'members' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-700' }}">{{ $activeMembers }}</span>
    </a>

    <a
      href="{{ route('admin.users.index', ['filter' => 'pending']) }}"
      class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold transition {{ $filter === 'pending' ? 'bg-[#0b4622] text-white shadow-xs' : 'text-gray-600 hover:bg-gray-50' }}"
    >
      <i class="ri-user-shared-line"></i>
      <span>অপেক্ষমাণ আবেদন (Pending)</span>
      <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $filter === 'pending' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-700' }}">{{ $pendingUsers }}</span>
    </a>
  </div>

  <!-- Search & Filter Controls -->
  <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-2xs flex flex-col md:flex-row md:items-center justify-between gap-3">
    <!-- Status & Role Filters -->
    <div class="flex flex-wrap items-center gap-2">
      <form method="GET" action="{{ route('admin.users.index') }}" class="flex items-center gap-2">
        <input type="hidden" name="filter" value="{{ $filter }}">

        <!-- Role Select -->
        @if($filter !== 'members')
          <select
            name="role"
            onchange="this.form.submit()"
            class="px-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] text-gray-700 font-semibold cursor-pointer"
          >
            <option value="">সকল রোল</option>
            @foreach($roles as $r)
              <option value="{{ $r->name }}" {{ request('role') === $r->name ? 'selected' : '' }}>
                {{ strtoupper($r->name) }}
              </option>
            @endforeach
          </select>
        @endif

        <!-- Status Select -->
        <select
          name="status"
          onchange="this.form.submit()"
          class="px-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] text-gray-700 font-semibold cursor-pointer"
        >
          <option value="">সকল স্ট্যাটাস</option>
          <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active (সক্রিয়)</option>
          <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive (নিষ্ক্রিয়)</option>
          <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending (অপেক্ষমাণ)</option>
        </select>
      </form>
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex items-center gap-2">
      <input type="hidden" name="filter" value="{{ $filter }}">
      @if(request()->filled('role')) <input type="hidden" name="role" value="{{ request('role') }}"> @endif
      @if(request()->filled('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
      
      <div class="relative">
        <input
          type="text"
          name="search"
          value="{{ request('search') }}"
          placeholder="নাম, ইমেইল বা ফোন খুঁজুন..."
          class="pl-9 pr-3.5 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition w-56 sm:w-64"
        >
        <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
      </div>
      <button type="submit" class="px-3.5 py-1.5 bg-[#0b4622] text-white rounded-xl text-xs font-bold">
        খুঁজুন
      </button>
      @if(request()->filled('search') || request()->filled('role') || request()->filled('status'))
        <a href="{{ route('admin.users.index', ['filter' => $filter]) }}" class="text-xs text-gray-400 hover:text-gray-600">রিসেট</a>
      @endif
    </form>
  </div>

  <!-- Users Table -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-2xs overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-gray-50/80 border-b border-gray-100 text-[11px] font-black text-gray-500 uppercase tracking-wider">
            <th class="py-3 px-4 text-center w-12">ID</th>
            <th class="py-3 px-4">ব্যবহারকারী</th>
            <th class="py-3 px-4">যোগাযোগ</th>
            <th class="py-3 px-4 text-center">ভূমিকা (Role)</th>
            <th class="py-3 px-4 text-center">স্ট্যাটাস</th>
            <th class="py-3 px-4 text-center">যোগদানের তারিখ</th>
            <th class="py-3 px-4 text-center w-24">অ্যাকশন</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-xs text-gray-700">
          @forelse($users as $user)
            <tr class="hover:bg-gray-50/70 transition">
              <td class="py-3 px-4 text-center font-bold text-gray-400">
                #{{ $user->id }}
              </td>

              <!-- Name & Photo -->
              <td class="py-3 px-4">
                <div class="flex items-center gap-3">
                  <div class="w-9 h-9 rounded-full bg-emerald-50 border border-emerald-100 text-[#0b4622] font-black flex items-center justify-center overflow-hidden shrink-0">
                    @if($user->photo && file_exists(public_path('storage/' . $user->photo)))
                      <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                    @else
                      <span>{{ mb_substr($user->name, 0, 1) }}</span>
                    @endif
                  </div>
                  <div>
                    <span class="font-extrabold text-gray-900 block leading-tight">
                      {{ $user->name }}
                    </span>
                    <span class="text-[11px] text-gray-400">
                      {{ $user->email }}
                    </span>
                  </div>
                </div>
              </td>

              <!-- Contact Phone -->
              <td class="py-3 px-4 font-mono text-[11px] text-gray-600">
                {{ $user->phone ?? '—' }}
              </td>

              <!-- Roles -->
              <td class="py-3 px-4 text-center">
                @forelse($user->roles as $r)
                  @php
                    $roleStyle = match($r->name) {
                      'super-admin' => 'bg-purple-50 text-purple-700 border-purple-200',
                      'admin'       => 'bg-blue-50 text-blue-700 border-blue-200',
                      'member'      => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                      default       => 'bg-gray-50 text-gray-700 border-gray-200',
                    };
                  @endphp
                  <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-[10px] font-black border uppercase {{ $roleStyle }}">
                    <i class="ri-shield-check-line text-xs"></i>
                    <span>{{ $r->name }}</span>
                  </span>
                @empty
                  <span class="text-gray-400 italic">No Role</span>
                @endforelse
              </td>

              <!-- Status Toggle -->
              <td class="py-3 px-4 text-center">
                @if($user->status === 'pending')
                  <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                    <i class="ri-time-line"></i> অপেক্ষমাণ
                  </span>
                @else
                  <label class="relative inline-flex items-center cursor-pointer">
                    <input
                      type="checkbox"
                      value="1"
                      {{ $user->status === 'active' ? 'checked' : '' }}
                      onchange="toggleUserStatus({{ $user->id }}, this)"
                      class="sr-only peer"
                    >
                    <div class="w-8 h-4 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[1px] after:left-[1px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-3.5 after:w-3.5 after:transition-all peer-checked:bg-[#0b4622]"></div>
                  </label>
                @endif
              </td>

              <!-- Created At -->
              <td class="py-3 px-4 text-center text-gray-500 font-medium">
                {{ $user->created_at ? $user->created_at->format('d M, Y') : '—' }}
              </td>

              <!-- Actions -->
              <td class="py-3 px-4 text-center">
                <div class="flex items-center justify-center gap-1.5">
                  <a
                    href="{{ route('admin.users.edit', $user->id) }}"
                    class="w-7 h-7 rounded-lg bg-emerald-50 hover:bg-[#0b4622] text-[#0b4622] hover:text-white flex items-center justify-center transition cursor-pointer"
                    title="সম্পাদনা করুন"
                  >
                    <i class="ri-edit-line text-xs"></i>
                  </a>

                  @if($user->id !== auth()->id())
                    <form
                      action="{{ route('admin.users.destroy', $user->id) }}"
                      method="POST"
                      onsubmit="return confirm('আপনি কি নিশ্চিত যে এই ব্যবহারকারীকে মুছে ফেলতে চান?');"
                      class="inline"
                    >
                      @csrf
                      @method('DELETE')
                      <button
                        type="submit"
                        class="w-7 h-7 rounded-lg bg-red-50 hover:bg-[#c8102e] text-[#c8102e] hover:text-white flex items-center justify-center transition cursor-pointer"
                        title="মুছে ফেলুন"
                      >
                        <i class="ri-delete-bin-line text-xs"></i>
                      </button>
                    </form>
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="py-12 text-center text-gray-400">
                <i class="ri-team-line text-3xl block mb-2 text-gray-300"></i>
                কোনো ব্যবহারকারী পাওয়া যায়নি।
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($users->hasPages())
      <div class="p-4 border-t border-gray-100 flex justify-center">
        {{ $users->links() }}
      </div>
    @endif
  </div>

</div>

<script>
function toggleUserStatus(id, checkbox) {
  fetch(`/admin/users/${id}/status`, {
    method: 'PATCH',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json'
    }
  })
  .then(res => res.json())
  .then(data => {
    if (!data.success) {
      checkbox.checked = !checkbox.checked;
      alert('স্ট্যাটাস আপডেট করতে সমস্যা হয়েছে।');
    }
  })
  .catch(err => {
    checkbox.checked = !checkbox.checked;
    alert('সার্ভার এরর');
  });
}
</script>
@endsection

