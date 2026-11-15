@extends('layouts.admin.admin-layout')

@section('title', 'ব্যক্তিবর্গের বাণী ব্যবস্থাপনা | আগামীর শৈলকুপা')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb & Top Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
                <i class="ri-arrow-right-s-line"></i>
                <span class="text-[#0b4622] font-semibold">ব্যক্তিবর্গের বাণী</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
                <i class="ri-message-3-line text-[#0b4622]"></i>
                <span>ব্যক্তিবর্গের বাণী ব্যবস্থাপনা (Persons Messages)</span>
            </h1>
            <p class="text-xs text-gray-500 mt-0.5">
                উপদেষ্টা, পৃষ্ঠপোষক, সভাপতি ও কার্যনির্বাহী ব্যক্তিবর্গের বাণী ও বার্তা পরিচালনা করুন।
            </p>
        </div>

        <a href="{{ route('admin.person-messages.create') }}" 
           class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-xs hover:shadow transition cursor-pointer self-start sm:self-auto">
            <i class="ri-add-line text-base"></i>
            <span>নতুন বাণী যোগ করুন</span>
        </a>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-2xl flex items-center gap-2">
            <i class="ri-checkbox-circle-fill text-emerald-600 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Search & Filter Card -->
    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <form method="GET" action="{{ route('admin.person-messages.index') }}" class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
            <div class="relative flex-1 sm:w-64">
                <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="নাম, পদবি বা উদ্ধৃতি দিয়ে খুঁজুন..."
                       class="w-full pl-8 pr-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] text-gray-700">
            </div>

            <select name="type" onchange="this.form.submit()" 
                    class="px-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] text-gray-700 font-semibold cursor-pointer">
                <option value="">সকল বাণীর ধরন</option>
                @foreach($types as $key => $label)
                    <option value="{{ $key }}" {{ request('type') === $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            <select name="status" onchange="this.form.submit()" 
                    class="px-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] text-gray-700 font-semibold cursor-pointer">
                <option value="">সকল স্ট্যাটাস</option>
                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active (সক্রিয়)</option>
                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive (নিষ্ক্রিয়)</option>
            </select>

            @if(request()->hasAny(['search', 'type', 'status']))
                <a href="{{ route('admin.person-messages.index') }}" class="px-2.5 py-1.5 text-xs text-red-600 hover:text-red-800 font-bold">
                    রিসেট
                </a>
            @endif
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-100 text-[11px] font-black text-gray-500 uppercase tracking-wider">
                        <th class="py-3 px-4 text-center w-12">#</th>
                        <th class="py-3 px-4">ছবি ও নাম</th>
                        <th class="py-3 px-4">বাণীর ধরন</th>
                        <th class="py-3 px-4">উদ্ধৃতি / বাণী হাইলাইট</th>
                        <th class="py-3 px-4 text-center">ক্রম</th>
                        <th class="py-3 px-4 text-center">স্ট্যাটাস</th>
                        <th class="py-3 px-4 text-center w-28">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs text-gray-700">
                    @forelse($messages as $msg)
                        <tr class="hover:bg-gray-50/70 transition">
                            <td class="py-3 px-4 text-center font-bold text-gray-400">
                                {{ $loop->iteration + ($messages->currentPage() - 1) * $messages->perPage() }}
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $msg->image_url }}" alt="{{ $msg->name }}" 
                                         class="w-10 h-10 rounded-full object-cover border border-gray-200 shrink-0">
                                    <div>
                                        <div class="font-extrabold text-gray-900 leading-tight">{{ $msg->name }}</div>
                                        <div class="text-[11px] text-gray-500 mt-0.5">{{ $msg->designation }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 font-semibold">
                                @php
                                    $badgeStyle = match($msg->type) {
                                        'adviser'   => 'bg-purple-50 text-purple-700 border-purple-200',
                                        'patron'    => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'president' => 'bg-emerald-50 text-[#0b4622] border-emerald-200',
                                        'executive' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        default     => 'bg-gray-50 text-gray-700 border-gray-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[10px] font-black border uppercase {{ $badgeStyle }}">
                                    {{ $msg->type_label }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-gray-600 max-w-xs truncate">
                                {{ $msg->quote ? '"' . Str::limit($msg->quote, 60) . '"' : '—' }}
                            </td>
                            <td class="py-3 px-4 text-center font-mono font-bold text-gray-500">
                                {{ $msg->order }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" value="1" {{ $msg->status ? 'checked' : '' }}
                                           onchange="toggleMessageStatus({{ $msg->id }}, this)"
                                           class="sr-only peer">
                                    <div class="w-8 h-4 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[1px] after:left-[1px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-3.5 after:w-3.5 after:transition-all peer-checked:bg-[#0b4622]"></div>
                                </label>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('person-message.show', $msg->type) }}" target="_blank"
                                       class="w-7 h-7 rounded-lg bg-gray-100 hover:bg-[#0b4622] text-gray-600 hover:text-white flex items-center justify-center transition"
                                       title="ওয়েবসাইটে দেখুন">
                                        <i class="ri-external-link-line text-xs"></i>
                                    </a>
                                    <a href="{{ route('admin.person-messages.edit', $msg) }}" 
                                       class="w-7 h-7 rounded-lg bg-emerald-50 hover:bg-[#0b4622] text-[#0b4622] hover:text-white flex items-center justify-center transition"
                                       title="সম্পাদনা করুন">
                                        <i class="ri-edit-line text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.person-messages.destroy', $msg) }}" method="POST" 
                                          onsubmit="return confirm('আপনি কি নিশ্চিত যে এই বাণীটি মুছে ফেলতে চান?');" 
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="w-7 h-7 rounded-lg bg-red-50 hover:bg-[#c8102e] text-[#c8102e] hover:text-white flex items-center justify-center transition cursor-pointer"
                                                title="মুছে ফেলুন">
                                            <i class="ri-delete-bin-line text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-gray-400">
                                <i class="ri-message-3-line text-3xl block mb-2 text-gray-300"></i>
                                কোনো বাণী পাওয়া যায়নি।
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
</div>

<script>
function toggleMessageStatus(id, checkbox) {
    fetch(`/admin/person-messages/${id}/status`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            checkbox.checked = !checkbox.checked;
            alert(data.message || 'স্ট্যাটাস পরিবর্তন ব্যর্থ হয়েছে!');
        }
    })
    .catch(() => {
        checkbox.checked = !checkbox.checked;
        alert('সার্ভারে সমস্যা হয়েছে!');
    });
}
</script>
@endsection

