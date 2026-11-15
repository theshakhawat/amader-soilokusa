@extends('layouts.admin.admin-layout')

@section('title', 'নেভবার সেটিংস (Navbar Management) | আগামীর শৈলকুপা')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nestable2@1.6.0/jquery.nestable.min.css">
    <style>
        .dd { max-width: 100%; }
        .dd-item > button {
            height: 36px;
            font-size: 16px;
            color: #0b4622;
        }
        .dd-handle {
            border: 0;
            background: transparent;
            margin: 0;
            padding: 0;
        }
        .dd-handle:hover {
            background: transparent;
        }
        .dd-placeholder {
            border: 2px dashed #0b4622;
            background: #ecfdf5;
            border-radius: 12px;
            min-height: 48px;
            margin: 6px 0;
        }
    </style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb & Top Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
                <i class="ri-arrow-right-s-line"></i>
                <span class="text-gray-400">কাস্টমাইজেশন</span>
                <i class="ri-arrow-right-s-line"></i>
                <span class="text-[#0b4622] font-semibold">নেভবার সেটিংস</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
                <i class="ri-menu-search-line text-[#0b4622]"></i>
                <span>নেভবার মেন্যু সেটিংস (Navbar Management)</span>
            </h1>
            <p class="text-xs text-gray-500 mt-0.5">
                ওয়েবসাইটের মূল মেন্যু ও মাল্টি-লেভেল ড্রপডাউন ড্র্যাগ অ্যান্ড ড্রপ করে সাজান অথবা নতুন লিংক যুক্ত করুন।
            </p>
        </div>

        <button type="button" onclick="openNewNavModal()"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-xs hover:shadow transition cursor-pointer self-start sm:self-auto">
            <i class="ri-add-line text-base"></i>
            <span>নতুন মেন্যু আইটেম যোগ করুন</span>
        </button>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-2xl flex items-center gap-2">
            <i class="ri-checkbox-circle-fill text-emerald-600 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 bg-red-50 border border-red-200 text-red-800 text-xs font-bold rounded-2xl flex items-center gap-2">
            <i class="ri-error-warning-fill text-red-600 text-base"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Alert / Help Tip -->
    <div class="p-4 bg-blue-50 border border-blue-100 rounded-2xl flex items-start gap-3">
        <i class="ri-information-line text-blue-600 text-lg mt-0.5 shrink-0"></i>
        <div class="text-xs text-blue-900 leading-relaxed">
            <span class="font-bold">ড্র্যাগ অ্যান্ড ড্রপ (Drag & Drop) নির্দেশিকা:</span> যেকোনো মেন্যু আইটেমের বাম পাশের হ্যান্ডেল ধরে উপরে-নিচে টেনে ক্রম পরিবর্তন করুন, কিংবা ডানে টেনে যেকোনো আইটেমের সাব-মেন্যু (ড্রপডাউন) হিসেবে সেট করুন। সাজানো শেষ হলে <strong>"ক্রম সংরক্ষণ করুন"</strong> বাটনে ক্লিক করুন।
        </div>
    </div>

    <!-- Main Builder Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left: Nestable Menu List (8 Cols) -->
        <div class="lg:col-span-8 bg-white p-5 sm:p-6 rounded-2xl border border-gray-100 shadow-2xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h3 class="text-sm font-extrabold text-gray-900 flex items-center gap-2">
                    <i class="ri-list-ordered-2 text-[#0b4622]"></i>
                    <span>মেন্যু স্ট্রাকচার ও স্তরসমূহ</span>
                </h3>
                <button type="button" id="save-order-btn" onclick="saveNavOrder()"
                        class="px-4 py-1.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl transition shadow-xs flex items-center gap-1.5 cursor-pointer">
                    <i class="ri-save-line"></i>
                    <span>ক্রম সংরক্ষণ করুন</span>
                </button>
            </div>

            <!-- Nestable Container -->
            <div class="dd" id="nestable-menu">
                <ol class="dd-list">
                    @forelse($rootNavItems as $rootItem)
                        @include('admin.customization.partials.nav-item-tree', ['item' => $rootItem])
                    @empty
                        <li class="py-12 text-center text-gray-400">
                            <i class="ri-menu-line text-3xl block mb-2 text-gray-300"></i>
                            কোনো নেভবার আইটেম পাওয়া যায়নি।
                        </li>
                    @endforelse
                </ol>
            </div>
        </div>

        <!-- Right: Fast Add Link / Presets (4 Cols) -->
        <div class="lg:col-span-4 space-y-5">
            <!-- Fast Add Card -->
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-2xs space-y-4">
                <h3 class="text-sm font-extrabold text-gray-900 flex items-center gap-2 pb-2 border-b border-gray-100">
                    <i class="ri-add-circle-line text-[#0b4622]"></i>
                    <span>দ্রুত লিংক যুক্ত করুন</span>
                </h3>

                <form action="{{ route('admin.customization.navbar.store') }}" method="POST" class="space-y-3.5">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">মেন্যু শিরোনাম / নাম <span class="text-red-500">*</span></label>
                        <input type="text" name="title" required placeholder="উদাঃ আমাদের কার্যক্রম"
                               class="w-full px-3.5 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">লিংক বা ইউআরএল (URL) <span class="text-red-500">*</span></label>
                        <input type="text" name="url" required placeholder="উদাঃ /events অথবা #"
                               class="w-full px-3.5 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622]">
                        <p class="text-[10px] text-gray-400 mt-1">শুধুমাত্র ড্রপডাউনের মূল ক্যাটাগরি হলে <code class="bg-gray-100 px-1 py-0.5 rounded">#</code> দিন।</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">প্যারেন্ট মেন্যু (ঐচ্ছিক)</label>
                        <select name="parent_id" class="w-full px-3 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622]">
                            <option value="">— মূল মেন্যু হিসেবে থাকবে (Root) —</option>
                            @foreach($allPossibleParents as $p)
                                <option value="{{ $p->id }}">{{ $p->title }} ({{ $p->url }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">আইকন (ঐচ্ছিক)</label>
                            <input type="text" name="icon" placeholder="ri-home-line"
                                   class="w-full px-3 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622]">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">টার্গেট</label>
                            <select name="target" class="w-full px-3 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622]">
                                <option value="_self">একই ট্যাবে (_self)</option>
                                <option value="_blank">নতুন ট্যাবে (_blank)</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl transition shadow-xs cursor-pointer">
                        মেন্যু যোগ করুন
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal: New Nav Item (Top Button) -->
<div id="new-nav-modal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
            <h3 class="text-sm font-black text-gray-900 flex items-center gap-1.5">
                <i class="ri-add-line text-[#0b4622]"></i>
                <span>নতুন মেন্যু আইটেম যোগ করুন</span>
            </h3>
            <button type="button" onclick="closeNewNavModal()" class="text-gray-400 hover:text-gray-700">
                <i class="ri-close-line text-xl"></i>
            </button>
        </div>

        <form action="{{ route('admin.customization.navbar.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">মেন্যু শিরোনাম <span class="text-red-500">*</span></label>
                <input type="text" name="title" required placeholder="উদাঃ আমাদের সম্পর্কে"
                       class="w-full px-3.5 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622]">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">লিংক বা ইউআরএল (URL) <span class="text-red-500">*</span></label>
                <input type="text" name="url" required placeholder="উদাঃ /page/aboutus অথবা #"
                       class="w-full px-3.5 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622]">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">প্যারেন্ট মেন্যু</label>
                <select name="parent_id" class="w-full px-3 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622]">
                    <option value="">— মূল মেন্যু হিসেবে থাকবে (Root) —</option>
                    @foreach($allPossibleParents as $p)
                        <option value="{{ $p->id }}">{{ $p->title }} ({{ $p->url }})</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">আইকন</label>
                    <input type="text" name="icon" placeholder="ri-link"
                           class="w-full px-3 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">টার্গেট</label>
                    <select name="target" class="w-full px-3 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622]">
                        <option value="_self">একই ট্যাবে (_self)</option>
                        <option value="_blank">নতুন ট্যাবে (_blank)</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-gray-100">
                <button type="button" onclick="closeNewNavModal()"
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition">
                    বাতিল
                </button>
                <button type="submit" class="px-5 py-2 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-xs transition">
                    মেন্যু যোগ করুন
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Nav Item -->
<div id="edit-nav-modal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
            <h3 class="text-sm font-black text-gray-900 flex items-center gap-1.5">
                <i class="ri-edit-line text-[#0b4622]"></i>
                <span>মেন্যু আইটেম সম্পাদনা</span>
            </h3>
            <button type="button" onclick="closeEditNavModal()" class="text-gray-400 hover:text-gray-700">
                <i class="ri-close-line text-xl"></i>
            </button>
        </div>

        <form id="edit-nav-form" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">মেন্যু শিরোনাম <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="edit-title" required
                       class="w-full px-3.5 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622]">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">লিংক বা ইউআরএল (URL) <span class="text-red-500">*</span></label>
                <input type="text" name="url" id="edit-url" required
                       class="w-full px-3.5 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622]">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">প্যারেন্ট মেন্যু</label>
                <select name="parent_id" id="edit-parent-id" class="w-full px-3 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622]">
                    <option value="">— মূল মেন্যু হিসেবে থাকবে (Root) —</option>
                    @foreach($allPossibleParents as $p)
                        <option value="{{ $p->id }}">{{ $p->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">আইকন</label>
                    <input type="text" name="icon" id="edit-icon"
                       class="w-full px-3 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">টার্গেট</label>
                    <select name="target" id="edit-target" class="w-full px-3 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622]">
                        <option value="_self">একই ট্যাবে (_self)</option>
                        <option value="_blank">নতুন ট্যাবে (_blank)</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-between pt-2">
                <span class="text-xs font-bold text-gray-700">স্ট্যাটাস (সক্রিয়)</span>
                <input type="checkbox" name="status" id="edit-status" value="1" class="rounded text-[#0b4622]">
            </div>

            <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-gray-100">
                <button type="button" onclick="closeEditNavModal()"
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition">
                    বাতিল
                </button>
                <button type="submit" class="px-5 py-2 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-xs transition">
                    আপডেট সংরক্ষণ করুন
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/nestable2@1.6.0/jquery.nestable.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#nestable-menu').nestable({
                maxDepth: 4,
                group: 1,
                handleClass: 'dd-handle',
                noDragClass: 'dd-nodrag'
            });
        });

        function saveNavOrder() {
            const btn = document.getElementById('save-order-btn');
            btn.disabled = true;
            btn.innerHTML = '<i class="ri-loader-4-line animate-spin"></i> সংরক্ষণ হচ্ছে...';

            const serializedData = $('#nestable-menu').nestable('serialize');

            fetch('{{ route("admin.customization.navbar.order") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ items: serializedData })
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = '<i class="ri-check-line"></i> সংরক্ষিত হয়েছে!';
                setTimeout(() => {
                    btn.innerHTML = '<i class="ri-save-line"></i> ক্রম সংরক্ষণ করুন';
                }, 2000);
            })
            .catch(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="ri-save-line"></i> আবার চেষ্টা করুন';
                alert('ক্রম সংরক্ষণ করতে সমস্যা হয়েছে!');
            });
        }

        function openNewNavModal() {
            const modal = document.getElementById('new-nav-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeNewNavModal() {
            const modal = document.getElementById('new-nav-modal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        function openEditModal(id, title, url, parentId, icon, target, status) {
            document.getElementById('edit-nav-form').action = `/admin/customization/navbar/${id}`;
            document.getElementById('edit-title').value = title;
            document.getElementById('edit-url').value = url;
            document.getElementById('edit-parent-id').value = parentId || '';
            document.getElementById('edit-icon').value = icon || '';
            document.getElementById('edit-target').value = target || '_self';
            document.getElementById('edit-status').checked = (status == 1);

            const modal = document.getElementById('edit-nav-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEditNavModal() {
            const modal = document.getElementById('edit-nav-modal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        function toggleItemStatus(id, checkbox) {
            fetch(`/admin/customization/navbar/${id}/status`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    checkbox.checked = !checkbox.checked;
                    alert('স্ট্যাটাস আপডেট ব্যর্থ হয়েছে!');
                }
            })
            .catch(() => {
                checkbox.checked = !checkbox.checked;
                alert('সার্ভারে সমস্যা হয়েছে!');
            });
        }
    </script>
@endpush
