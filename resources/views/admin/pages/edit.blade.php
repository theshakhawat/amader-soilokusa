@extends('layouts.admin.admin-layout')

@section('title', 'পেজ সম্পাদনা - ' . $page->title)

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    <style>
        .ql-toolbar.ql-snow {
            border-color: #e5e7eb;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
            background: #f9fafb;
            font-family: inherit;
        }
        .ql-container.ql-snow {
            border-color: #e5e7eb;
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
            font-size: 0.95rem;
            min-height: 280px;
            background: #ffffff;
            font-family: inherit;
        }
        .ql-editor {
            min-height: 280px;
        }
        .ql-editor.ql-blank::before {
            color: #9ca3af;
            font-style: normal;
        }
    </style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb & Back -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">পেজ সম্পাদনা করুন</h1>
            <p class="text-sm text-gray-500 mt-1">"{{ $page->title }}" পেজের তথ্য ও কন্টেন্ট পরিবর্তন করুন</p>
        </div>
        <div class="flex items-center gap-2">
            @if($page->status)
                <a href="{{ route('custom-page.show', $page->slug) }}" target="_blank"
                   class="inline-flex items-center px-3.5 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm">
                    <i class="ri-external-link-line mr-1 text-[#0b4622]"></i> পেজটি দেখুন
                </a>
            @endif
            <a href="{{ route('admin.pages.index') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm">
                <i class="ri-arrow-left-line mr-1.5"></i> তালিকায় ফিরে যান
            </a>
        </div>
    </div>

    <!-- Error Alert -->
    @if ($errors->any())
        <div class="p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
            <div class="flex items-start">
                <i class="ri-error-warning-line text-red-500 text-lg mr-2 mt-0.5"></i>
                <div>
                    <h3 class="text-sm font-medium text-red-800">দয়া করে নিচের সমস্যাগুলো সংশোধন করুন:</h3>
                    <ul class="mt-1 list-disc list-inside text-xs text-red-700 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Form Card -->
    <form action="{{ route('admin.pages.update', $page) }}" method="POST" id="page-form" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-6">
            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                    পেজের শিরোনাম / নাম <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" id="title" required
                       value="{{ old('title', $page->title) }}"
                       placeholder="যেমন: আমাদের লক্ষ্য ও উদ্দেশ্য, ব্যবহারের শর্তাবলী..."
                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition-colors text-sm">
                <div class="flex items-center gap-2 mt-1.5 text-xs text-gray-500">
                    <span>বর্তমান স্লাগ: <code class="px-1.5 py-0.5 bg-gray-100 rounded text-gray-700 font-mono">{{ $page->slug }}</code></span>
                    <span>(শিরোনাম পরিবর্তন করলে স্লাগ স্বয়ংক্রিয়ভাবে আপডেট হবে)</span>
                </div>
            </div>

            <!-- Content (Quill Editor) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    পেজের বিস্তারিত কন্টেন্ট <span class="text-red-500">*</span>
                </label>
                <div id="quill-editor" class="min-h-[280px]"></div>
                <input type="hidden" name="content" id="content" value="{{ old('content', $page->content) }}">
            </div>

            <!-- Status Toggle -->
            <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                <div>
                    <label class="block text-sm font-medium text-gray-700">পেজের স্ট্যাটাস</label>
                    <p class="text-xs text-gray-500">স্ট্যাটাস সক্রিয় থাকলে ওয়েবসাইটে এই পেজটি সাধারণ পাঠকদের জন্য দৃশ্যমান থাকবে।</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="status" value="1" class="sr-only peer" {{ old('status', $page->status ? '1' : '0') == '1' ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0b4622]"></div>
                </label>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.pages.index') }}" 
               class="px-5 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                বাতিল করুন
            </a>
            <button type="submit" 
                    class="px-6 py-2.5 rounded-lg text-sm font-medium text-white bg-[#0b4622] hover:bg-[#08351a] shadow-sm transition-colors flex items-center gap-1.5">
                <i class="ri-check-line"></i> পরিবর্তন সংরক্ষণ করুন
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const quill = new Quill('#quill-editor', {
                theme: 'snow',
                placeholder: 'এখানে পেজের বিষয়বস্তু বিস্তারিত লিখুন...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, 4, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'align': [] }],
                        ['blockquote', 'code-block'],
                        ['link', 'clean']
                    ]
                }
            });

            // Restore content
            const initialContent = @json(old('content', $page->content ?? ''));
            if (initialContent) {
                quill.root.innerHTML = initialContent;
            }

            // Sync with hidden input on submit
            const form = document.getElementById('page-form');
            form.addEventListener('submit', function () {
                const hiddenInput = document.getElementById('content');
                if (quill.getText().trim().length === 0 && !quill.root.innerHTML.includes('<img')) {
                    hiddenInput.value = '';
                } else {
                    hiddenInput.value = quill.root.innerHTML;
                }
            });
        });
    </script>
@endpush

