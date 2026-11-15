@extends('layouts.admin.admin-layout')

@section('title', 'নতুন অফিস যোগ করুন')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    <style>
        .ql-toolbar.ql-snow { border-color: #e5e7eb; border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem; background: #f9fafb; }
        .ql-container.ql-snow { border-color: #e5e7eb; border-bottom-left-radius: 0.5rem; border-bottom-right-radius: 0.5rem; font-size: 0.95rem; min-height: 220px; background: #fff; }
        .member-card { transition: all 0.2s; }
    </style>
@endpush

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
                <i class="ri-arrow-right-s-line"></i>
                <a href="{{ route('admin.offices.index') }}" class="hover:text-[#0b4622]">অফিস সমূহ</a>
                <i class="ri-arrow-right-s-line"></i>
                <span class="text-[#0b4622] font-semibold">নতুন অফিস</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
                <i class="ri-government-line text-[#0b4622]"></i>
                <span>নতুন অফিস যোগ করুন</span>
            </h1>
        </div>
        <a href="{{ route('admin.offices.index') }}"
           class="inline-flex items-center gap-1.5 px-4 py-2 border border-gray-300 text-gray-700 text-xs font-bold rounded-xl hover:bg-gray-50 transition">
            <i class="ri-arrow-left-line"></i> তালিকায় ফিরুন
        </a>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl">
            <ul class="list-disc list-inside text-xs text-red-700 space-y-0.5">
                @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.offices.store') }}" method="POST" enctype="multipart/form-data" id="office-form" class="space-y-6">
        @csrf

        {{-- ===== 1. BASIC INFORMATION ===== --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
            <h2 class="text-sm font-bold text-gray-800 pb-3 border-b border-gray-100 flex items-center gap-2">
                <i class="ri-information-line text-[#0b4622]"></i> মৌলিক তথ্য
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Office Name --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">অফিসের নাম <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           placeholder="যেমন: উপজেলা কৃষি অফিস, শৈলকূপা"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition text-sm">
                </div>

                {{-- Location --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">লোকেশন / ঠিকানা</label>
                    <input type="text" name="location" value="{{ old('location') }}"
                           placeholder="যেমন: উপজেলা পরিষদ কমপ্লেক্স, শৈলকূপা"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition text-sm">
                </div>

                {{-- Status --}}
                <div class="md:col-span-2 flex items-center gap-3 pt-1">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="status" value="0">
                        <input type="checkbox" name="status" value="1" {{ old('status', '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-[#0b4622] transition-all after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-5"></div>
                    </label>
                    <div>
                        <div class="text-sm font-semibold text-gray-700">প্রকাশিত (Active)</div>
                        <div class="text-xs text-gray-400">চালু থাকলে ওয়েবসাইটে সর্বসাধারণ দেখতে পারবে</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== 2. SINGLE OFFICE IMAGE ===== --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-bold text-gray-800 pb-3 border-b border-gray-100 flex items-center gap-2">
                <i class="ri-image-line text-[#0b4622]"></i>
                অফিস ইমেজ
                <span class="text-xs text-gray-400 font-normal">— একটি প্রধান ছবি আপলোড করুন</span>
            </h2>
            <div class="flex flex-col sm:flex-row items-center gap-5">
                <div class="w-36 h-28 bg-gray-50 border-2 border-dashed border-gray-200 rounded-xl overflow-hidden flex items-center justify-center shrink-0" id="office-image-preview">
                    <i class="ri-image-add-line text-4xl text-gray-300"></i>
                </div>
                <div class="flex-1 w-full space-y-2">
                    <label class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl cursor-pointer transition">
                        <i class="ri-upload-2-line"></i> ছবি নির্বাচন করুন
                        <input type="file" name="image" accept="image/*" class="hidden" onchange="previewOfficeImage(this)">
                    </label>
                    <p class="text-xs text-gray-400">JPG, PNG, WEBP — সর্বোচ্চ 4MB। এই ছবিটি ব্যানার বা থাম্বনেইল হিসেবে প্রদর্শিত হবে।</p>
                </div>
            </div>
        </div>

        {{-- ===== 3. DESCRIPTION (QUILL EDITOR) ===== --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-4">
            <h2 class="text-sm font-bold text-gray-800 pb-3 border-b border-gray-100 flex items-center gap-2">
                <i class="ri-article-line text-[#0b4622]"></i>
                অফিসের বিবরণ ও পরিচিতি (Description)
            </h2>
            <div id="description-editor" style="min-height: 220px;"></div>
            <input type="hidden" name="description" id="description-hidden">
        </div>

        {{-- ===== 4. MEMBERS REPEATER (কর্মকর্তাবৃন্দ) ===== --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                    <i class="ri-team-line text-[#0b4622]"></i>
                    অফিসের ব্যক্তিবর্গ / কর্মকর্তাবৃন্দ
                    <span class="text-xs text-gray-400 font-normal">— কর্মকর্তা ও কর্মচারীদের তথ্য যুক্ত করুন</span>
                </h2>
                <button type="button" onclick="addMemberCard()"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-[#0b4622]/10 text-[#0b4622] text-xs font-bold rounded-xl hover:bg-[#0b4622]/20 transition">
                    <i class="ri-user-add-line"></i> কর্মকর্তা যুক্ত করুন
                </button>
            </div>
            <div id="members-container" class="space-y-4">
                {{-- Dynamically injected by JavaScript --}}
            </div>
            <div id="no-member-msg" class="text-center py-8 text-gray-400">
                <i class="ri-user-add-line text-3xl block mb-2 text-gray-300"></i>
                <p class="text-sm">কোনো কর্মকর্তার তথ্য যুক্ত হয়নি।</p>
                <button type="button" onclick="addMemberCard()"
                        class="mt-2 text-xs text-[#0b4622] font-semibold underline">+ প্রথম কর্মকর্তা যুক্ত করুন</button>
            </div>
        </div>

        {{-- Submit Buttons --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.offices.index') }}"
               class="px-5 py-2.5 border border-gray-200 text-gray-600 text-sm font-bold rounded-xl hover:bg-gray-50 transition">বাতিল</a>
            <button type="submit" onclick="beforeSubmit()"
                    class="px-6 py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-sm font-bold rounded-xl shadow-sm transition flex items-center gap-2">
                <i class="ri-save-line"></i> অফিস সংরক্ষণ করুন
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.min.js"></script>
<script>
// ===== Quill Editor =====
const quill = new Quill('#description-editor', {
    theme: 'snow',
    placeholder: 'অফিসের সেবা, কার্যক্রম ও সিটিজেন চার্টার সম্পর্কিত বিস্তারিত বিবরণ লিখুন...',
    modules: {
        toolbar: [
            [{ header: [1, 2, 3, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ color: [] }, { background: [] }],
            [{ list: 'ordered' }, { list: 'bullet' }],
            ['blockquote', 'link'],
            ['clean']
        ]
    }
});

// Office Single Image Preview
function previewOfficeImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('office-image-preview').innerHTML =
                `<img src="${e.target.result}" class="w-full h-full object-cover rounded-xl" alt="Preview">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// ===== Members Repeater =====
let memberIndex = 0;
function addMemberCard(data = {}) {
    document.getElementById('no-member-msg').style.display = 'none';
    const idx = memberIndex++;
    const card = document.createElement('div');
    card.className = 'member-card bg-gray-50 border border-gray-200 rounded-2xl p-5';
    card.id = `member-card-${idx}`;
    card.innerHTML = `
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xs font-bold text-gray-700 flex items-center gap-2">
                <span class="w-6 h-6 bg-[#0b4622] text-white text-xs font-bold rounded-full flex items-center justify-center">${idx + 1}</span>
                কর্মকর্তার তথ্য
            </h3>
            <button type="button" onclick="removeMemberCard(${idx})"
                    class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition text-xs flex items-center gap-1 font-semibold">
                <i class="ri-delete-bin-line"></i> সরান
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Photo --}}
            <div class="flex flex-col items-center gap-3">
                <div class="w-20 h-20 rounded-full border-2 border-dashed border-gray-300 overflow-hidden bg-white flex items-center justify-center" id="member-photo-preview-${idx}">
                    <i class="ri-user-3-line text-3xl text-gray-300"></i>
                </div>
                <label class="cursor-pointer text-xs text-[#0b4622] font-semibold hover:underline">
                    ছবি নির্বাচন
                    <input type="file" name="members[${idx}][photo]" accept="image/*" class="hidden" onchange="previewMemberPhoto(this, ${idx})">
                </label>
            </div>
            {{-- Fields --}}
            <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">নাম <span class="text-red-500">*</span></label>
                    <input type="text" name="members[${idx}][name]" value="${data.name || ''}" required
                           placeholder="কর্মকর্তার পূর্ণ নাম"
                           class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition bg-white">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">পদবী <span class="text-red-500">*</span></label>
                    <input type="text" name="members[${idx}][designation]" value="${data.designation || ''}" required
                           placeholder="যেমন: উপজেলা কৃষি অফিসার"
                           class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition bg-white">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">ফোন নম্বর</label>
                    <input type="text" name="members[${idx}][phone]" value="${data.phone || ''}"
                           placeholder="01XXXXXXXXX"
                           class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition bg-white">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">ইমেইল এড্রেস</label>
                    <input type="email" name="members[${idx}][email]" value="${data.email || ''}"
                           placeholder="officer@domain.gov.bd"
                           class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition bg-white">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">শিক্ষাগত যোগ্যতা</label>
                    <input type="text" name="members[${idx}][qualification]" value="${data.qualification || ''}"
                           placeholder="যেমন: বি.এস-সি (কৃষি), এম.এস-সি"
                           class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition bg-white">
                </div>
            </div>
        </div>`;
    document.getElementById('members-container').appendChild(card);
}

function removeMemberCard(idx) {
    document.getElementById(`member-card-${idx}`)?.remove();
    if (document.querySelectorAll('.member-card').length === 0) {
        document.getElementById('no-member-msg').style.display = '';
    }
}

function previewMemberPhoto(input, idx) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(`member-photo-preview-${idx}`).innerHTML =
                `<img src="${e.target.result}" class="w-full h-full object-cover">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function beforeSubmit() {
    document.getElementById('description-hidden').value = quill.root.innerHTML;
}
</script>
@endpush

