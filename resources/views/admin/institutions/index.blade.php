@extends('layouts.admin.admin-layout')

@section('title', 'প্রতিষ্ঠান সমূহ ব্যবস্থাপনা')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
                <i class="ri-arrow-right-s-line"></i>
                <span class="text-[#0b4622] font-semibold">প্রতিষ্ঠান সমূহ</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
                <i class="ri-building-2-line text-[#0b4622]"></i>
                <span>প্রতিষ্ঠান সমূহ ব্যবস্থাপনা</span>
            </h1>
            <p class="text-xs text-gray-500 mt-0.5">শৈলকূপার সকল শিক্ষা প্রতিষ্ঠান, মসজিদ-মাদ্রাসা ও অন্যান্য প্রতিষ্ঠান পরিচালনা করুন।</p>
        </div>
        <div class="flex items-center gap-2 self-start sm:self-auto">
            <a href="{{ route('admin.institutions.categories.index') }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 border border-gray-300 text-gray-700 text-xs font-bold rounded-xl hover:bg-gray-50 transition">
                <i class="ri-price-tag-3-line"></i> ক্যাটাগরি
            </a>
            <a href="{{ route('admin.institutions.create') }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-sm transition">
                <i class="ri-add-line text-base"></i> নতুন প্রতিষ্ঠান যুক্ত করুন
            </a>
        </div>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-2xl flex items-center gap-2">
            <i class="ri-checkbox-circle-fill text-emerald-600 text-base"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 bg-red-50 border border-red-200 text-red-800 text-xs font-bold rounded-2xl flex items-center gap-2">
            <i class="ri-error-warning-fill text-red-500 text-base"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Filters --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex flex-wrap items-center gap-3">
        <form method="GET" action="{{ route('admin.institutions.index') }}" class="flex flex-wrap items-center gap-2">
            <div class="relative">
                <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="প্রতিষ্ঠানের নাম..."
                       class="pl-8 pr-3 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] text-gray-700 w-52">
            </div>
            <select name="category_id" onchange="this.form.submit()"
                    class="px-3 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#0b4622] text-gray-700 font-semibold cursor-pointer">
                <option value="">সকল ক্যাটাগরি</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-3 py-2 bg-[#0b4622] text-white text-xs font-bold rounded-xl">
                <i class="ri-search-line mr-1"></i>খুঁজুন
            </button>
            @if($search || $categoryId)
                <a href="{{ route('admin.institutions.index') }}" class="px-3 py-2 border border-gray-200 text-gray-600 text-xs font-semibold rounded-xl hover:bg-gray-50">
                    <i class="ri-refresh-line mr-1"></i>রিসেট
                </a>
            @endif
        </form>
        <div class="ml-auto text-xs text-gray-500 font-semibold">মোট: {{ $institutions->total() }}টি প্রতিষ্ঠান</div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-100">
                <tr>
                    <th class="px-5 py-3.5 text-left">প্রতিষ্ঠান</th>
                    <th class="px-5 py-3.5 text-left">ক্যাটাগরি</th>
                    <th class="px-5 py-3.5 text-center">ছবি</th>
                    <th class="px-5 py-3.5 text-center">ব্যক্তিবর্গ</th>
                    <th class="px-5 py-3.5 text-center">স্ট্যাটাস</th>
                    <th class="px-5 py-3.5 text-right">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($institutions as $institution)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            @if($institution->images->count() > 0)
                                <img src="{{ $institution->thumbnail_url }}" alt="{{ $institution->name }}"
                                     class="w-12 h-12 object-cover rounded-xl border border-gray-100 shrink-0">
                            @else
                                <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center shrink-0">
                                    <i class="ri-building-2-line text-gray-400 text-lg"></i>
                                </div>
                            @endif
                            <div>
                                <div class="font-semibold text-gray-800 text-sm">{{ $institution->name }}</div>
                                @if($institution->location)
                                    <div class="text-xs text-gray-500 flex items-center gap-1 mt-0.5">
                                        <i class="ri-map-pin-line text-[#0b4622]"></i> {{ $institution->location }}
                                    </div>
                                @endif
                                <div class="text-[11px] text-gray-400 font-mono mt-0.5">/{{ $institution->slug }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4">
                        @if($institution->category)
                            <span class="inline-flex items-center px-2.5 py-1 bg-blue-50 text-blue-700 text-xs font-semibold rounded-lg">
                                {{ $institution->category->name }}
                            </span>
                        @else
                            <span class="text-gray-400 text-xs">ক্যাটাগরিবিহীন</span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-center">
                        <span class="inline-flex items-center justify-center px-2 py-0.5 bg-gray-100 text-gray-700 text-xs font-bold rounded-lg">
                            <i class="ri-image-line mr-1"></i>{{ $institution->images_count }}টি
                        </span>
                    </td>
                    <td class="px-5 py-4 text-center">
                        <span class="inline-flex items-center justify-center px-2 py-0.5 bg-gray-100 text-gray-700 text-xs font-bold rounded-lg">
                            <i class="ri-user-line mr-1"></i>{{ $institution->members_count }}জন
                        </span>
                    </td>
                    <td class="px-5 py-4 text-center">
                        <label class="relative inline-flex items-center cursor-pointer status-toggle" data-id="{{ $institution->id }}">
                            <input type="checkbox" class="sr-only peer" {{ $institution->status ? 'checked' : '' }}>
                            <div class="w-9 h-5 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:bg-[#0b4622] transition-all after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-4"></div>
                        </label>
                    </td>
                    <td class="px-5 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.institutions.edit', $institution) }}"
                               class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="সম্পাদনা">
                                <i class="ri-pencil-line text-sm"></i>
                            </a>
                            <form action="{{ route('admin.institutions.destroy', $institution) }}" method="POST"
                                  onsubmit="return confirm('এই প্রতিষ্ঠানটি এবং এর সকল ছবি ও ব্যক্তিবর্গের তথ্য মুছে ফেলবেন?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition" title="মুছুন">
                                    <i class="ri-delete-bin-line text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-16 text-center text-gray-400">
                        <i class="ri-building-2-line text-4xl block mb-3 text-gray-300"></i>
                        <p class="text-sm font-semibold">কোনো প্রতিষ্ঠান পাওয়া যায়নি।</p>
                        <a href="{{ route('admin.institutions.create') }}"
                           class="mt-3 inline-flex items-center gap-1.5 px-4 py-2 bg-[#0b4622] text-white text-xs font-bold rounded-xl hover:bg-[#08351a] transition">
                            <i class="ri-add-line"></i> প্রথম প্রতিষ্ঠান যুক্ত করুন
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($institutions->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $institutions->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.status-toggle').forEach(function(label) {
    label.addEventListener('click', function(e) {
        e.preventDefault();
        const id = label.dataset.id;
        const checkbox = label.querySelector('input[type="checkbox"]');
        fetch(`/admin/institutions/${id}/status`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        }).then(res => res.json()).then(data => {
            if (data.success) checkbox.checked = data.status;
        });
    });
});
</script>
@endpush

