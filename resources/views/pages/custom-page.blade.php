@extends('layouts.website.website-layout')

@section('title', $page->title . ' - আগামীর শৈলকূপা')

@push('meta')
    <meta name="description" content="{{ Str::limit(strip_tags($page->content), 160) }}">
@endpush

@push('styles')
    <style>
        .custom-page-content {
            color: #374151;
            font-size: 1.05rem;
            line-height: 1.85;
            word-break: break-word;
        }
        .custom-page-content h1,
        .custom-page-content h2,
        .custom-page-content h3,
        .custom-page-content h4 {
            color: #111827;
            font-weight: 700;
            margin-top: 1.75em;
            margin-bottom: 0.75em;
            line-height: 1.4;
        }
        .custom-page-content h1 { font-size: 1.85rem; }
        .custom-page-content h2 { font-size: 1.5rem; }
        .custom-page-content h3 { font-size: 1.25rem; }
        .custom-page-content p {
            margin-bottom: 1.25em;
        }
        .custom-page-content ul,
        .custom-page-content ol {
            margin-top: 0.75em;
            margin-bottom: 1.25em;
            padding-left: 1.75rem;
        }
        .custom-page-content ul {
            list-style-type: disc;
        }
        .custom-page-content ol {
            list-style-type: decimal;
        }
        .custom-page-content li {
            margin-bottom: 0.5em;
        }
        .custom-page-content blockquote {
            border-left: 4px solid #0b4622;
            padding-left: 1rem;
            margin: 1.5em 0;
            color: #4b5563;
            font-style: italic;
            background: #f9fafb;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            border-radius: 0 0.5rem 0.5rem 0;
        }
        .custom-page-content img {
            max-width: 100%;
            height: auto;
            border-radius: 0.75rem;
            margin: 1.5em 0;
        }
        .custom-page-content a {
            color: #0b4622;
            text-decoration: underline;
            font-weight: 500;
        }
        .custom-page-content a:hover {
            color: #08351a;
        }
        .custom-page-content pre,
        .custom-page-content code {
            background-color: #f3f4f6;
            border-radius: 0.375rem;
            padding: 0.2em 0.4em;
            font-size: 0.9em;
        }
    </style>
@endpush

@section('content')
<main class="min-h-screen bg-gray-50 py-10 lg:py-14">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-[#0b4622] transition-colors flex items-center gap-1">
                <i class="ri-home-4-line"></i> হোম
            </a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-800 font-medium truncate">{{ $page->title }}</span>
        </nav>

        <!-- Main Card -->
        <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Header Header -->
            <div class="p-6 sm:p-8 lg:p-10 border-b border-gray-100 bg-gradient-to-r from-emerald-50/50 via-white to-transparent">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold text-[#0b4622] bg-[#0b4622]/10 mb-4">
                    <i class="ri-pages-line"></i> সাধারণ তথ্য
                </div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight leading-snug">
                    {{ $page->title }}
                </h1>
                <div class="mt-4 flex items-center gap-4 text-xs text-gray-500">
                    <span class="flex items-center gap-1">
                        <i class="ri-time-line"></i> সর্বশেষ হালনাগাদ: {{ $page->updated_at->locale('bn')->isoFormat('D MMMM YYYY') }}
                    </span>
                </div>
            </div>

            <!-- Body Content -->
            <div class="p-6 sm:p-8 lg:p-10">
                <div class="custom-page-content">
                    {!! $page->content !!}
                </div>
            </div>
        </article>

        <!-- Back Button -->
        <div class="mt-8 flex justify-center">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full text-sm font-medium text-white bg-[#0b4622] hover:bg-[#08351a] shadow-sm transition-all">
                <i class="ri-arrow-left-line"></i> হোমপেজে ফিরে যান
            </a>
        </div>
    </div>
</main>
@endsection

