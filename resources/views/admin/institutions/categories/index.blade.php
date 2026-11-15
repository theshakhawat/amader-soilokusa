@extends('layouts.admin.admin-layout')

@section('title', 'প্রতিষ্ঠানের ক্যাটাগরি ব্যবস্থাপনা')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
                <i class="ri-arrow-right-s-line"></i>
                <a href="{{ route('admin.institutions.index') }}" class="hover:text-[#0b4622]">প্রতিষ্ঠান সমূহ</a>
                <i class="ri-arrow-right-s-line"></i>
                <span class="text-[#0b4622] font-semibold">ক্যাটাগরি</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
                <i class="ri-price-tag-3-line text-[#0b4622]"></i>
                <span>প্রতিষ্ঠানের ক্যাটাগরি ব্যবস্থাপনা</span>
            </h1>
            <p class="text-xs text-gray-500 mt-0.5">মাধ্যমিক বিদ্যালয়, কলেজ, মাদ্রাসা ইত্যাদি ক্যাটাগরি পরিচালনা করুন।</p>
        </div>
        <a href="{{ route('admin.institutions.index') }}"
           class="inline-flex items-center gap-1.5 px-4 py-2 border border-gray-300 text-gray-700 text-xs font-bold rounded-xl hover:bg-gray-50 transition self-start sm:self-auto">
            <i class="ri-arrow-left-line"></i>
            <span>প্রতিষ্ঠান তালিকা</span>
        </a>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-2xl flex items-center gap-2">
            <i class="ri-checkbox-circle-fill text-emerald-600 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 bg-red-50 border border-red-200 text-red-800 text-xs font-bold rounded-2xl flex items-center gap-2">
            <i class="ri-error-warning-fill text-red-500 text-base"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        {{-- ===== ADD CATEGORY FORM ===== --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h2 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="ri-add-circle-line text-[#0b4622]"></i>
                    নতুন ক্যাটাগরি যুক্ত করুন
                </h2>
                <form action="{{ route('admin.institutions.categories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">ক্যাটাগরির নাম <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               placeholder="যেমন: মাধ্যমিক বিদ্যালয়"
                               class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">স্ল্যাগ (Slug)</label>
                        <input type="text" name="slug" value="{{ old('slug') }}"
                               placeholder="auto-generated (ফাঁকা রাখলে স্বয়ংক্রিয় তৈরি হবে)"
                               class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition">
                        @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex items-center gap-3">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="status" value="0">
                            <input type="checkbox" name="status" value="1" {{ old('status', '1') == '1' ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-10 h-5 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:bg-[#0b4622] transition-all after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-5"></div>
                        </label>
                        <span class="text-xs font-semibold text-gray-700">সক্রিয় (Active)</span>
                    </div>
                    <button type="submit"
                            class="w-full py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl transition flex items-center justify-center gap-2">
                        <i class="ri-add-line text-sm"></i>
                        ক্যাটাগরি যুক্ত করুন
                    </button>
                </form>
            </div>
        </div>

        {{-- ===== CATEGORIES TABLE ===== --}}
        <div class="lg:col-span-3">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-sm font-bold text-gray-800">সকল ক্যাটাগরি ({{ $categories->total() }}টি)</h2>
                    <form method="GET" action="{{ route('admin.institutions.categories.index') }}" class="flex items-center gap-2">
                        <div class="relative">
                            <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                            <input type="text" name="search" value="{{ $search }}" placeholder="খুঁজুন..."
                                   class="pl-8 pr-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] text-gray-700 w-44">
                        </div>
                        <button class="px-3 py-1.5 bg-[#0b4622] text-white text-xs font-bold rounded-xl">খুঁজুন</button>
                    </form>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <tr>
                            <th class="px-5 py-3 text-left">ক্যাটাগরির নাম</th>
                            <th class="px-5 py-3 text-center">প্রতিষ্ঠান</th>
                            <th class="px-5 py-3 text-center">স্ট্যাটাস</th>
                            <th class="px-5 py-3 text-right">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($categories as $category)
                        <tr class="hover:bg-gray-50/50 transition" id="cat-row-{{ $category->id }}">
                            <td class="px-5 py-3.5">
                                <div class="font-semibold text-gray-800 text-sm">{{ $category->name }}</div>
                                <div class="text-xs text-gray-400 font-mono mt-0.5">/{{ $category->slug }}</div>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="inline-flex items-center justify-center w-7 h-7 bg-[#0b4622]/10 text-[#0b4622] text-xs font-bold rounded-full">
                                    {{ $category->institutions_count }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <label class="relative inline-flex items-center cursor-pointer cat-toggle" data-id="{{ $category->id }}">
                                    <input type="checkbox" class="sr-only peer" {{ $category->status ? 'checked' : '' }}>
                                    <div class="w-9 h-5 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:bg-[#0b4622] transition-all after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-4"></div>
                                </label>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Edit Button (opens inline modal) --}}
                                    <button onclick="openEditModal({{ $category->id }}, '{{ addslashes($category->name) }}', '{{ $category->slug }}')"
                                            class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="সম্পাদনা">
                                        <i class="ri-pencil-line text-sm"></i>
                                    </button>
                                    {{-- Delete --}}
                                    <form action="{{ route('admin.institutions.categories.destroy', $category) }}" method="POST"
                                          onsubmit="return confirm('এই ক্যাটাগরিটি মুছে ফেলবেন? এতে এর অন্তর্গত প্রতিষ্ঠানগুলো ক্যাটাগরিবিহীন হয়ে যাবে।')">
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
                            <td colspan="4" class="px-5 py-12 text-center text-gray-400 text-sm">
                                <i class="ri-price-tag-3-line text-3xl block mb-2 text-gray-300"></i>
                                কোনো ক্যাটাগরি পাওয়া যায়নি।
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($categories->hasPages())
                <div class="px-5 py-4 border-t border-gray-100">
                    {{ $categories->withQueryString()->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ===== EDIT MODAL ===== --}}
<div id="editCatModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-bold text-gray-800">ক্যাটাগরি সম্পাদনা করুন</h3>
            <button onclick="closeEditModal()" class="p-1 text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition">
                <i class="ri-close-line text-lg"></i>
            </button>
        </div>
        <form id="editCatForm" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">ক্যাটাগরির নাম <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="editCatName" required
                       class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">স্ল্যাগ (Slug)</label>
                <input type="text" name="slug" id="editCatSlug"
                       class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition">
            </div>
            <div class="flex justify-end gap-2 mt-2">
                <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 text-xs font-bold border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 transition">বাতিল</button>
                <button type="submit"
                        class="px-4 py-2 text-xs font-bold bg-[#0b4622] text-white rounded-xl hover:bg-[#08351a] transition">আপডেট করুন</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Edit Modal
function openEditModal(id, name, slug) {
    document.getElementById('editCatName').value = name;
    document.getElementById('editCatSlug').value = slug;
    document.getElementById('editCatForm').action = `/admin/institutions/categories/${id}`;
    document.getElementById('editCatModal').classList.remove('hidden');
}
function closeEditModal() {
    document.getElementById('editCatModal').classList.add('hidden');
}

// Status Toggle AJAX
document.querySelectorAll('.cat-toggle').forEach(function(label) {
    label.addEventListener('click', function(e) {
        e.preventDefault();
        const id = label.dataset.id;
        const checkbox = label.querySelector('input[type="checkbox"]');
        fetch(`/admin/institutions/categories/${id}/status`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        }).then(res => res.json()).then(data => {
            if (data.success) {
                checkbox.checked = data.status;
            }
        }).catch(() => { checkbox.checked = !checkbox.checked; });
    });
});
</script>
@endpush

