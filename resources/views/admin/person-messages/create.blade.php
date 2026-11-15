@extends('layouts.admin.admin-layout')

@section('title', 'নতুন ব্যক্তির বাণী যোগ করুন')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    <style>
        .ql-toolbar.ql-snow {
            border-color: #e5e7eb;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
            background: #f9fafb;
        }
        .ql-container.ql-snow {
            border-color: #e5e7eb;
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
            font-size: 0.95rem;
            min-height: 250px;
            background: #ffffff;
        }
    </style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb & Back -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">নতুন বাণী যোগ করুন</h1>
            <p class="text-sm text-gray-500 mt-1">উপদেষ্টা, পৃষ্ঠপোষক বা যেকোনো বিশিষ্ট ব্যক্তিত্বের বার্তা ও বাণী যুক্ত করুন</p>
        </div>
        <a href="{{ route('admin.person-messages.index') }}" 
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm">
            <i class="ri-arrow-left-line mr-1.5"></i> তালিকায় ফিরে যান
        </a>
    </div>

    <!-- Error Alert -->
    @if ($errors->any())
        <div class="p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
            <div class="flex items-start">
                <i class="ri-error-warning-line text-red-500 text-lg mr-2 mt-0.5"></i>
                <div>
                    <h3 class="text-sm font-medium text-red-800">দয়া করে নিচের সমস্যাগুলো সমাধান করুন:</h3>
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
    <form action="{{ route('admin.person-messages.store') }}" method="POST" enctype="multipart/form-data" id="message-form" class="space-y-6">
        @csrf
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- বাণীর ধরন (Dynamic Free-text with Datalist Suggestions) -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">
                        বাণীর ক্যাটাগরি / ধরন <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="type" id="type" list="type-suggestions" required
                           value="{{ old('type') }}"
                           placeholder="যেকোনো ক্যাটাগরি লিখুন বা লিস্ট থেকে বেছে নিন..."
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition-colors text-sm">
                    <datalist id="type-suggestions">
                        @foreach($suggestions as $item)
                            <option value="{{ $item }}"></option>
                        @endforeach
                    </datalist>
                    <p class="text-[11px] text-gray-500 mt-1 flex items-center gap-1">
                        <i class="ri-information-line"></i> কোনো সীমাবদ্ধতা নেই; আপনি ইচ্ছামতো যেকোনো নতুন ক্যাটাগরি টাইপ করে দিতে পারবেন।
                    </p>
                </div>

                <!-- ব্যক্তির নাম -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        ব্যক্তির পূর্ণ নাম <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" required
                           value="{{ old('name') }}"
                           placeholder="উদাঃ ড. মোঃ আতাউর রহমান"
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition-colors text-sm">
                </div>

                <!-- পদবি / পরিচয় -->
                <div>
                    <label for="designation" class="block text-sm font-medium text-gray-700 mb-1">
                        পদবি ও পরিচিতি <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="designation" id="designation" required
                           value="{{ old('designation') }}"
                           placeholder="উদাঃ প্রধান উপদেষ্টা, আগামীর শৈলকূপা"
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition-colors text-sm">
                </div>

                <!-- ছবি আপলোড -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
                        ব্যক্তির ছবি (Photo)
                    </label>
                    <input type="file" name="image" id="image" accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-[#0b4622] hover:file:bg-emerald-100">
                </div>
            </div>

            <!-- কোটেশন / বাণীর মূল সারাংশ -->
            <div>
                <label for="quote" class="block text-sm font-medium text-gray-700 mb-1">
                    বাণীর মূল বাণী / এক লাইনের উদ্ধৃতি (Quote)
                </label>
                <textarea name="quote" id="quote" rows="2"
                          placeholder="উদাঃ শৈলকূপার ঐক্য ও মানবিক পরিবর্তনের লক্ষ্যে আমাদের তরুণরাই মূল চালিকাশক্তি..."
                          class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#0b4622]/20 focus:border-[#0b4622] transition-colors text-sm">{{ old('quote') }}</textarea>
            </div>

            <!-- বিস্তারিত বক্তব্য (Quill Editor) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    সম্পূর্ণ বক্তব্য / বাণী (Full Message) <span class="text-red-500">*</span>
                </label>
                <div id="quill-editor" class="min-h-[250px]"></div>
                <input type="hidden" name="message" id="message" value="{{ old('message') }}">
            </div>

            <!-- ক্রম ও স্ট্যাটাস -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-100">
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-1">
                        প্রদর্শনের ক্রম (Order Index)
                    </label>
                    <input type="number" name="order" id="order" value="{{ old('order', 0) }}"
                           class="w-32 px-4 py-2 rounded-lg border border-gray-300 text-sm">
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">সক্রিয় স্ট্যাটাস</label>
                        <p class="text-xs text-gray-500">অন থাকলে এই বাণীটি ওয়েবসাইটে প্রদর্শিত হবে</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="status" value="1" class="sr-only peer" {{ old('status', '1') == '1' ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0b4622]"></div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.person-messages.index') }}" 
               class="px-5 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                বাতিল
            </a>
            <button type="submit" 
                    class="px-6 py-2.5 rounded-lg text-sm font-medium text-white bg-[#0b4622] hover:bg-[#08351a] shadow-sm transition-colors flex items-center gap-1.5 cursor-pointer">
                <i class="ri-save-line"></i> বাণী সংরক্ষণ করুন
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
                placeholder: 'এখানে সম্মানিত ব্যক্তির পূর্ণাঙ্গ বক্তব্য বিস্তারিত লিখুন...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['blockquote', 'link'],
                        ['clean']
                    ]
                }
            });

            const oldMsg = @json(old('message', ''));
            if (oldMsg) {
                quill.root.innerHTML = oldMsg;
            }

            const form = document.getElementById('message-form');
            form.addEventListener('submit', function () {
                const hiddenInput = document.getElementById('message');
                if (quill.getText().trim().length === 0) {
                    hiddenInput.value = '';
                } else {
                    hiddenInput.value = quill.root.innerHTML;
                }
            });
        });
    </script>
@endpush
