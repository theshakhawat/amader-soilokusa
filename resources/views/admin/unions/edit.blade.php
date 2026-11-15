@extends('layouts.admin.admin-layout')

@section('title', 'ইউনিয়ন পরিষদ সম্পাদনা — ' . $union->name)

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    <style>
        .ql-toolbar.ql-snow { border-color: #e5e7eb; border-top-left-radius: 0.75rem; border-top-right-radius: 0.75rem; background: #f9fafb; }
        .ql-container.ql-snow { border-color: #e5e7eb; border-bottom-left-radius: 0.75rem; border-bottom-right-radius: 0.75rem; font-size: 0.95rem; min-height: 240px; background: #fff; }
        .image-preview-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(110px, 1fr)); gap: 10px; }
        .image-preview-item { position: relative; aspect-ratio: 4/3; border-radius: 12px; overflow: hidden; border: 1px solid #e5e7eb; }
        .image-preview-item img { width: 100%; height: 100%; object-fit: cover; }
    </style>
@endpush

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
                <i class="ri-arrow-right-s-line"></i>
                <a href="{{ route('admin.unions.index') }}" class="hover:text-[#0b4622]">ইউনিয়ন পরিষদ</a>
                <i class="ri-arrow-right-s-line"></i>
                <span class="text-[#0b4622] font-semibold">সম্পাদনা</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
                <i class="ri-edit-line text-[#0b4622]"></i>
                <span>ইউনিয়ন পরিষদ সম্পাদনা — {{ $union->name }}</span>
            </h1>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('unions.detail', $union->slug) }}" target="_blank"
               class="inline-flex items-center gap-1.5 px-3.5 py-2 border border-gray-300 text-gray-700 text-xs font-bold rounded-xl hover:bg-gray-50 transition shadow-2xs">
                <i class="ri-external-link-line"></i> প্রিভিউ
            </a>
            <a href="{{ route('admin.unions.index') }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-900 hover:bg-black text-white text-xs font-bold rounded-xl transition shadow-2xs">
                <i class="ri-arrow-left-line"></i> তালিকায় ফিরুন
            </a>
        </div>
    </div>

    @if(isset($errors) && $errors->any())
        <div class="p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl">
            <ul class="list-disc list-inside text-xs text-red-700 space-y-0.5">
                @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.unions.update', $union->id) }}" method="POST" enctype="multipart/form-data" id="union-form" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- 1. BASIC INFORMATION --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-2xs p-6 space-y-5">
            <h2 class="text-sm font-bold text-gray-800 pb-3 border-b border-gray-100 flex items-center gap-2">
                <i class="ri-information-line text-[#0b4622]"></i> মৌলিক তথ্য ও অবস্থান
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Union Name --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">
                        ইউনিয়নের নাম <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', $union->name) }}"
                           required
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:outline-none focus:border-[#0b4622] transition text-xs sm:text-sm">
                </div>

                {{-- Status & Order --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">স্ট্যাটাস</label>
                        <select name="status" class="w-full px-3 py-2.5 rounded-xl border border-gray-300 text-xs sm:text-sm bg-white focus:outline-none focus:border-[#0b4622]">
                            <option value="1" {{ old('status', $union->status ? '1' : '0') == '1' ? 'selected' : '' }}>সক্রিয় (Active)</option>
                            <option value="0" {{ old('status', $union->status ? '1' : '0') == '0' ? 'selected' : '' }}>নিষ্ক্রিয় (Inactive)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">ক্রম / সিরিয়াল</label>
                        <input type="number"
                               name="order"
                               value="{{ old('order', $union->order) }}"
                               class="w-full px-3 py-2.5 rounded-xl border border-gray-300 text-xs sm:text-sm focus:outline-none focus:border-[#0b4622]">
                    </div>
                </div>

                {{-- Slug --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">স্লাগ (URL Slug)</label>
                    <input type="text"
                           name="slug"
                           value="{{ old('slug', $union->slug) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:outline-none focus:border-[#0b4622] transition text-xs sm:text-sm font-mono">
                </div>

                {{-- Location --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">কার্যালয়ের অবস্থান / ঠিকানা</label>
                    <input type="text"
                           name="location"
                           value="{{ old('location', $union->location) }}"
                           placeholder="যেমন: মির্জাপুর বাজার সংলগ্ন, শৈলকূপা"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:outline-none focus:border-[#0b4622] transition text-xs sm:text-sm">
                </div>

                {{-- Google Map URL --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">গুগল ম্যাপ লিংক (URL)</label>
                    <input type="url"
                           name="map_url"
                           value="{{ old('map_url', $union->map_url) }}"
                           placeholder="https://maps.google.com/?q=..."
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:outline-none focus:border-[#0b4622] transition text-xs sm:text-sm">
                </div>

                {{-- Phone --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">যোগাযোগের ফোন / হেল্পলাইন</label>
                    <input type="text"
                           name="phone"
                           value="{{ old('phone', $union->phone) }}"
                           placeholder="017XXXXXXXX"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:outline-none focus:border-[#0b4622] transition text-xs sm:text-sm">
                </div>

                {{-- Email --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">অফিসিয়াল ইমেইল</label>
                    <input type="email"
                           name="email"
                           value="{{ old('email', $union->email) }}"
                           placeholder="union@example.com"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:outline-none focus:border-[#0b4622] transition text-xs sm:text-sm">
                </div>
            </div>

            {{-- Short Description --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">সংক্ষিপ্ত পরিচিতি</label>
                <input type="text"
                       name="short_description"
                       value="{{ old('short_description', $union->short_description) }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:outline-none focus:border-[#0b4622] transition text-xs sm:text-sm">
            </div>
        </div>

        {{-- 2. QUICK STATISTICS BADGES --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-2xs p-6 space-y-4">
            <h2 class="text-sm font-bold text-gray-800 pb-3 border-b border-gray-100 flex items-center justify-between">
                <span class="flex items-center gap-2">
                    <i class="ri-bar-chart-box-line text-[#0b4622]"></i>
                    <span>এক নজরে ইউনিয়ন পরিসংখ্যান (Quick Statistics)</span>
                </span>
                <span class="text-xs text-gray-400 font-normal">ওয়েবসাইটে ব্যাজ আকারে প্রদর্শিত হবে</span>
            </h2>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">
                {{-- Area --}}
                <div>
                    <label class="block text-[11px] font-bold text-gray-600 mb-1">আয়তন (বর্গ কিমি)</label>
                    <input type="text"
                           name="area_sq_km"
                           value="{{ old('area_sq_km', $union->area_sq_km) }}"
                           class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs focus:outline-none focus:border-[#0b4622]">
                </div>

                {{-- Population --}}
                <div>
                    <label class="block text-[11px] font-bold text-gray-600 mb-1">মোট জনসংখ্যা</label>
                    <input type="text"
                           name="population"
                           value="{{ old('population', $union->population) }}"
                           class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs focus:outline-none focus:border-[#0b4622]">
                </div>

                {{-- Voters --}}
                <div>
                    <label class="block text-[11px] font-bold text-gray-600 mb-1">ভোটার সংখ্যা</label>
                    <input type="text"
                           name="voter_count"
                           value="{{ old('voter_count', $union->voter_count) }}"
                           class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs focus:outline-none focus:border-[#0b4622]">
                </div>

                {{-- Villages --}}
                <div>
                    <label class="block text-[11px] font-bold text-gray-600 mb-1">গ্রামের সংখ্যা</label>
                    <input type="text"
                           name="village_count"
                           value="{{ old('village_count', $union->village_count) }}"
                           class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs focus:outline-none focus:border-[#0b4622]">
                </div>

                {{-- Mouzas --}}
                <div>
                    <label class="block text-[11px] font-bold text-gray-600 mb-1">মৌজার সংখ্যা</label>
                    <input type="text"
                           name="mouza_count"
                           value="{{ old('mouza_count', $union->mouza_count) }}"
                           class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs focus:outline-none focus:border-[#0b4622]">
                </div>

                {{-- Literacy --}}
                <div>
                    <label class="block text-[11px] font-bold text-gray-600 mb-1">সাক্ষরতার হার (%)</label>
                    <input type="text"
                           name="literacy_rate"
                           value="{{ old('literacy_rate', $union->literacy_rate) }}"
                           class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs focus:outline-none focus:border-[#0b4622]">
                </div>
            </div>
        </div>

        {{-- 3. IMAGE SLIDER GALLERY --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-2xs p-6 space-y-4">
            <h2 class="text-sm font-bold text-gray-800 pb-3 border-b border-gray-100 flex items-center justify-between">
                <span class="flex items-center gap-2">
                    <i class="ri-image-2-line text-[#0b4622]"></i>
                    <span>ইউনিয়নের ছবিসমূহ (Slider Gallery)</span>
                </span>
                <span class="text-xs text-gray-400 font-normal">বিদ্যমান ছবি দেখুন বা নতুন যোগ করুন</span>
            </h2>

            {{-- Existing Images --}}
            @if($union->images->count() > 0)
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">বর্তমানে সংরক্ষিত ছবি:</label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3">
                        @foreach($union->images as $img)
                            <div class="relative group rounded-xl overflow-hidden border border-gray-200 aspect-4/3 bg-gray-100">
                                <img src="{{ $img->url }}" alt="Gallery Image" class="w-full h-full object-cover">
                                <label class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex flex-col items-center justify-center text-white text-xs cursor-pointer transition">
                                    <input type="checkbox" name="delete_images[]" value="{{ $img->id }}" class="rounded text-red-600 mb-1">
                                    <span class="text-[11px] font-semibold text-red-200">মুছতে টিক দিন</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div id="image-preview-grid" class="image-preview-grid"></div>

            <label for="imageUpload"
                   class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-[#0b4622] hover:bg-emerald-50/20 transition group">
                <i class="ri-upload-cloud-2-line text-2xl text-gray-400 group-hover:text-[#0b4622] transition mb-1"></i>
                <span class="text-xs font-bold text-gray-700 group-hover:text-[#0b4622]">নতুন ছবি যুক্ত করতে ক্লিক করুন</span>
                <span class="text-[10px] text-gray-400">JPG, PNG, WebP</span>
                <input id="imageUpload" type="file" name="images[]" multiple accept="image/*" class="hidden">
            </label>
        </div>

        {{-- 4. QUILL RICH TEXT DESCRIPTION --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-2xs p-6 space-y-3">
            <h2 class="text-sm font-bold text-gray-800 pb-2 border-b border-gray-100 flex items-center gap-2">
                <i class="ri-article-line text-[#0b4622]"></i>
                <span>ইউনিয়নের পূর্ণ বিবরণ ও ইতিহাস (Quill Text Editor)</span>
            </h2>

            <div id="quill-editor" class="bg-white rounded-xl"></div>
            <input type="hidden" name="description" id="description-input" value="{{ old('description', $union->description) }}">
        </div>

        {{-- 5. MEMBERS REPEATER (CHAIRMAN & MEMBERS) --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-2xs p-6 space-y-4" id="members-section">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <div>
                    <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                        <i class="ri-team-line text-[#0b4622]"></i>
                        <span>ইউনিয়ন পরিষদ ব্যক্তিবর্গ (চেয়ারম্যান, মেম্বার ও মহিলা মেম্বারগণ)</span>
                    </h2>
                    <p class="text-xs text-gray-400 mt-0.5">চেয়ারম্যান ও সকল সদস্যের তথ্য সম্পাদনা করুন</p>
                </div>
                <button type="button" onclick="addMemberRow()"
                        class="px-3.5 py-1.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl transition flex items-center gap-1.5 shadow-2xs">
                    <i class="ri-user-add-line"></i> সদস্য যোগ করুন
                </button>
            </div>

            <div id="members-container" class="space-y-4">
                {{-- Seeded or existing members injected via JS --}}
            </div>
        </div>

        {{-- Form Actions --}}
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
            <a href="{{ route('admin.unions.index') }}"
               class="px-5 py-2.5 border border-gray-300 text-gray-700 text-xs sm:text-sm font-bold rounded-xl hover:bg-gray-50 transition">
                বাতিল করুন
            </a>
            <button type="submit"
                    class="px-6 py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs sm:text-sm font-bold rounded-xl shadow-xs transition flex items-center gap-2">
                <i class="ri-check-line text-base"></i>
                <span>ইউনিয়ন আপডেট করুন</span>
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
    // Quill Rich Text Editor Initialization
    const quill = new Quill('#quill-editor', {
        theme: 'snow',
        placeholder: 'ইউনিয়নের ভৌগোলিক অবস্থান, ইতিহাস ও নাগরিক সেবাসমূহ এখানে বিস্তারিত লিখুন...',
        modules: {
            toolbar: [
                [{ 'header': [2, 3, 4, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'color': [] }, { 'background': [] }],
                ['blockquote', 'link'],
                ['clean']
            ]
        }
    });

    const descInput = document.getElementById('description-input');
    if (descInput && descInput.value) {
        quill.root.innerHTML = descInput.value;
    }

    document.getElementById('union-form').addEventListener('submit', function() {
        if (descInput) {
            descInput.value = quill.root.innerHTML;
        }
    });

    // Image preview handler
    const imageUpload = document.getElementById('imageUpload');
    const previewGrid = document.getElementById('image-preview-grid');
    if (imageUpload && previewGrid) {
        imageUpload.addEventListener('change', function() {
            previewGrid.innerHTML = '';
            Array.from(this.files).forEach((file) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const item = document.createElement('div');
                    item.className = 'image-preview-item';
                    item.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                    previewGrid.appendChild(item);
                };
                reader.readAsDataURL(file);
            });
        });
    }

    // Dynamic Member Repeater
    let memberIndex = 0;
    const existingMembers = @json($union->members);

    function addMemberRow(data = {}) {
        const container = document.getElementById('members-container');
        const idx = memberIndex++;
        const card = document.createElement('div');
        card.className = 'p-4 rounded-xl border border-gray-200 bg-gray-50/60 relative space-y-3';
        card.id = `member-card-${idx}`;

        const isChairman = data.member_type === 'chairman' || (!data.member_type && idx === 0);
        const hasPhoto = data.photo_url || false;

        card.innerHTML = `
            ${data.id ? `<input type="hidden" name="members[${idx}][id]" value="${data.id}">` : ''}
            <div class="flex items-center justify-between pb-2 border-b border-gray-200/80">
                <span class="text-xs font-bold text-gray-700 flex items-center gap-1.5">
                    <span class="w-5 h-5 rounded-full bg-[#0b4622] text-white flex items-center justify-center text-[10px] font-bold member-num">${idx + 1}</span>
                    <span>সদস্য তথ্য</span>
                    ${isChairman ? '<span class="text-[10px] font-bold bg-amber-100 text-amber-800 px-2 py-0.5 rounded-full">ইউপি চেয়ারম্যান</span>' : ''}
                </span>
                <button type="button" onclick="removeMemberRow(${idx}, ${data.id || 'null'})" class="w-6 h-6 rounded-md bg-red-50 hover:bg-red-100 text-red-600 flex items-center justify-center transition" title="মুছে ফেলুন">
                    <i class="ri-delete-bin-line text-xs"></i>
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 text-xs">
                <div>
                    <label class="block font-bold text-gray-700 mb-1">নাম <span class="text-red-500">*</span></label>
                    <input type="text" name="members[${idx}][name]" value="${data.name || ''}" required placeholder="পূর্ণ নাম" class="w-full px-3 py-2 rounded-lg border border-gray-300 text-xs bg-white focus:outline-none focus:border-[#0b4622]">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">পদবি <span class="text-red-500">*</span></label>
                    <input type="text" name="members[${idx}][designation]" value="${data.designation || (isChairman ? 'ইউপি চেয়ারম্যান' : 'ইউপি সদস্য')}" required placeholder="যেমন: ইউপি চেয়ারম্যান / সদস্য (১নং ওয়ার্ড)" class="w-full px-3 py-2 rounded-lg border border-gray-300 text-xs bg-white focus:outline-none focus:border-[#0b4622]">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">ভূমিকা / টাইপ</label>
                    <select name="members[${idx}][member_type]" class="w-full px-3 py-2 rounded-lg border border-gray-300 text-xs bg-white focus:outline-none focus:border-[#0b4622]">
                        <option value="chairman" ${data.member_type === 'chairman' ? 'selected' : ''}>চেয়ারম্যান</option>
                        <option value="member" ${data.member_type === 'member' || (!data.member_type && !isChairman) ? 'selected' : ''}>সাধারণ মেম্বার</option>
                        <option value="female_member" ${data.member_type === 'female_member' ? 'selected' : ''}>সংরক্ষিত মহিলা মেম্বার</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">শিক্ষাগত যোগ্যতা</label>
                    <input type="text" name="members[${idx}][qualification]" value="${data.qualification || ''}" placeholder="যেমন: বি.এ / এইচ.এস.সি" class="w-full px-3 py-2 rounded-lg border border-gray-300 text-xs bg-white focus:outline-none focus:border-[#0b4622]">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">মোবাইল নম্বর</label>
                    <input type="text" name="members[${idx}][phone]" value="${data.phone || ''}" placeholder="017XXXXXXXX" class="w-full px-3 py-2 rounded-lg border border-gray-300 text-xs bg-white focus:outline-none focus:border-[#0b4622]">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">ইমেইল</label>
                    <input type="email" name="members[${idx}][email]" value="${data.email || ''}" placeholder="member@gmail.com" class="w-full px-3 py-2 rounded-lg border border-gray-300 text-xs bg-white focus:outline-none focus:border-[#0b4622]">
                </div>

                <div class="sm:col-span-2">
                    <label class="block font-bold text-gray-700 mb-1">ছবি আপলোড</label>
                    <div class="flex items-center gap-2">
                        ${hasPhoto ? `<img src="${data.photo_url}" class="w-8 h-8 rounded-lg object-cover border border-gray-300 shrink-0">` : ''}
                        <input type="file" name="members[${idx}][photo]" accept="image/*" class="w-full text-xs file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-[#0b4622]/10 file:text-[#0b4622] hover:file:bg-[#0b4622]/20">
                    </div>
                </div>
            </div>
        `;
        container.appendChild(card);
        updateMemberNumbers();
    }

    function removeMemberRow(idx, memberId) {
        if (memberId) {
            const hiddenDelete = document.createElement('input');
            hiddenDelete.type = 'hidden';
            hiddenDelete.name = 'delete_members[]';
            hiddenDelete.value = memberId;
            document.getElementById('union-form').appendChild(hiddenDelete);
        }
        const card = document.getElementById(`member-card-${idx}`);
        if (card) {
            card.remove();
            updateMemberNumbers();
        }
    }

    function updateMemberNumbers() {
        document.querySelectorAll('.member-num').forEach((el, index) => {
            el.textContent = index + 1;
        });
    }

    // Populate existing members on load
    document.addEventListener('DOMContentLoaded', function() {
        if (existingMembers && existingMembers.length > 0) {
            existingMembers.forEach(m => addMemberRow(m));
        } else {
            addMemberRow({ designation: 'ইউপি চেয়ারম্যান', member_type: 'chairman' });
        }
    });
</script>
@endpush

