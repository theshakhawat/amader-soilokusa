@extends('layouts.admin.admin-layout')

@section('title', 'অফিস সমূহ ব্যবস্থাপনা')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
                <i class="ri-arrow-right-s-line"></i>
                <span class="text-[#0b4622] font-semibold">অফিস সমূহ</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
                <i class="ri-government-line text-[#0b4622]"></i>
                <span>প্রশাসনিক ও সরকারি অফিস সমূহ</span>
            </h1>
            <p class="text-xs text-gray-500 mt-0.5">UNO অফিস, কৃষি অফিস, থানা, ভূমি অফিস ইত্যাদি প্রশাসনিক অফিস ও কর্মকর্তাদের তথ্য পরিচালনা করুন।</p>
        </div>
        <a href="{{ route('admin.offices.create') }}"
           class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-sm transition self-start sm:self-auto">
            <i class="ri-add-line text-base"></i> নতুন অফিস যোগ করুন
        </a>
    </div>

    {{-- Flash Messages --}}
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

    {{-- Search Filter --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex flex-wrap items-center justify-between gap-3">
        <form method="GET" action="{{ route('admin.offices.index') }}" class="flex flex-wrap items-center gap-2">
            <div class="relative">
                <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="অফিসের নাম বা ঠিকানা..."
                       class="pl-8 pr-3 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] text-gray-700 w-64">
            </div>
            <button type="submit" class="px-3.5 py-2 bg-[#0b4622] text-white text-xs font-bold rounded-xl">
                <i class="ri-search-line mr-1"></i>খুঁজুন
            </button>
            @if($search)
                <a href="{{ route('admin.offices.index') }}" class="px-3 py-2 border border-gray-200 text-gray-600 text-xs font-semibold rounded-xl hover:bg-gray-50">
                    <i class="ri-refresh-line mr-1"></i>রিসেট
                </a>
            @endif
        </form>
        <div class="text-xs text-gray-500 font-semibold">মোট: {{ $offices->total() }}টি অফিস</div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-100">
                <tr>
                    <th class="px-5 py-3.5 text-left">অফিসের নাম ও অবস্থান</th>
                    <th class="px-5 py-3.5 text-center">কর্মকর্তা</th>
                    <th class="px-5 py-3.5 text-center">স্ট্যাটাস</th>
                    <th class="px-5 py-3.5 text-right">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($offices as $office)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $office->image_url }}" alt="{{ $office->name }}"
                                 class="w-14 h-12 object-cover rounded-xl border border-gray-200 shrink-0">
                            <div>
                                <div class="font-bold text-gray-800 text-sm">{{ $office->name }}</div>
                                @if($office->location)
                                    <div class="text-xs text-gray-500 flex items-center gap-1 mt-0.5">
                                        <i class="ri-map-pin-line text-[#0b4622]"></i> {{ $office->location }}
                                    </div>
                                @endif
                                <div class="text-[11px] text-gray-400 font-mono mt-0.5">/offices/{{ $office->slug }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 text-center">
                        <span class="inline-flex items-center justify-center px-2.5 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded-lg">
                            <i class="ri-team-line mr-1 text-[#0b4622]"></i>{{ $office->members_count }} জন
                        </span>
                    </td>
                    <td class="px-5 py-4 text-center">
                        <label class="relative inline-flex items-center cursor-pointer status-toggle" data-id="{{ $office->id }}">
                            <input type="checkbox" class="sr-only peer" {{ $office->status ? 'checked' : '' }}>
                            <div class="w-9 h-5 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:bg-[#0b4622] transition-all after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-4"></div>
                        </label>
                    </td>
                    <td class="px-5 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('offices.detail', $office->slug) }}" target="_blank"
                               class="p-1.5 text-gray-500 hover:text-[#0b4622] hover:bg-gray-100 rounded-lg transition" title="লাইভ পেজ দেখুন">
                                <i class="ri-external-link-line text-sm"></i>
                            </a>
                            <a href="{{ route('admin.offices.edit', $office) }}"
                               class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="সম্পাদনা">
                                <i class="ri-pencil-line text-sm"></i>
                            </a>
                            <form action="{{ route('admin.offices.destroy', $office) }}" method="POST"
                                  onsubmit="return confirm('এই অফিসটি এবং এর সকল কর্মকর্তার তথ্য মুছে ফেলতে চান?')">
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
                    <td colspan="4" class="px-5 py-16 text-center text-gray-400">
                        <i class="ri-government-line text-4xl block mb-3 text-gray-300"></i>
                        <p class="text-sm font-semibold">কোনো অফিস পাওয়া যায়নি।</p>
                        <a href="{{ route('admin.offices.create') }}"
                           class="mt-3 inline-flex items-center gap-1.5 px-4 py-2 bg-[#0b4622] text-white text-xs font-bold rounded-xl hover:bg-[#08351a] transition">
                            <i class="ri-add-line"></i> প্রথম অফিস যুক্ত করুন
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($offices->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $offices->withQueryString()->links() }}
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
        fetch(`/admin/offices/${id}/status`, {
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

