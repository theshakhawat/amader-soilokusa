@extends('layouts.website.website-layout')

@section('title', $title . ' - আগামীর শৈলকুপা')

@push('meta')
    <meta name="description" content="{{ Str::limit(strip_tags($primaryMessage->message ?? $primaryMessage->quote ?? ''), 160) }}">
@endpush

@push('styles')
    <style>
        .person-message-content {
            color: #374151;
            font-size: 1.05rem;
            line-height: 1.85;
        }
        .person-message-content p {
            margin-bottom: 1.25em;
        }
        .person-message-content h1,
        .person-message-content h2,
        .person-message-content h3 {
            color: #111827;
            font-weight: 700;
            margin-top: 1.5em;
            margin-bottom: 0.5em;
        }
        .person-message-content blockquote {
            border-left: 4px solid #0b4622;
            padding-left: 1rem;
            margin: 1.5em 0;
            color: #4b5563;
            font-style: italic;
            background: #f9fafb;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            border-radius: 0 0.5rem 0.5rem 0;
        }
    </style>
@endpush

@section('content')
<main class="min-h-screen bg-gray-50 py-10 lg:py-14">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Breadcrumb -->
        <nav class="flex items-center text-sm text-gray-500" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-[#0b4622] transition-colors flex items-center gap-1">
                <i class="ri-home-4-line"></i> হোম
            </a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-400">আমাদের সম্পর্কে</span>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-800 font-medium">{{ $title }}</span>
        </nav>

        @forelse($messages as $msg)
            <!-- Message Card -->
            <article class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Header Banner with Person Details -->
                <div class="p-6 sm:p-8 lg:p-10 border-b border-gray-100 bg-gradient-to-r from-emerald-50/60 via-white to-transparent flex flex-col sm:flex-row items-center sm:items-start gap-6">
                    <!-- Photo -->
                    <div class="relative shrink-0">
                        <img src="{{ $msg->image_url }}" alt="{{ $msg->name }}" 
                             class="w-28 h-28 sm:w-36 sm:h-36 rounded-2xl object-cover shadow-md border-4 border-white ring-2 ring-emerald-100">
                        <span class="absolute -bottom-2 -right-2 w-8 h-8 rounded-full bg-[#0b4622] text-white flex items-center justify-center text-sm shadow">
                            <i class="ri-chat-quote-line"></i>
                        </span>
                    </div>

                    <!-- Meta info -->
                    <div class="text-center sm:text-left flex-1">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold text-[#0b4622] bg-emerald-100/60 mb-2.5">
                            <i class="ri-user-star-line"></i> {{ $msg->type_label }}
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                            {{ $msg->name }}
                        </h1>
                        <p class="text-sm font-semibold text-gray-600 mt-1">
                            {{ $msg->designation }}
                        </p>

                        @if($msg->quote)
                            <!-- Quote Box -->
                            <div class="mt-4 p-4 rounded-xl bg-white/80 border border-emerald-100 shadow-2xs text-xs sm:text-sm text-gray-700 italic flex items-start gap-2.5">
                                <i class="ri-double-quotes-l text-xl text-[#c8102e] shrink-0"></i>
                                <span class="leading-relaxed">{{ $msg->quote }}</span>
                                <i class="ri-double-quotes-r text-xl text-[#c8102e] shrink-0 self-end"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Full Message Body -->
                <div class="p-6 sm:p-8 lg:p-10">
                    <div class="person-message-content">
                        {!! $msg->message !!}
                    </div>

                    <!-- Signature / Footer note -->
                    <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-500 gap-3">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span>আগামীর শৈলকূপা — শৈলকূপার উন্নয়নে আমরা এক পরিবার</span>
                        </div>
                        <div>
                            সর্বশেষ হালনাগাদ: {{ $msg->updated_at->locale('bn')->isoFormat('D MMMM YYYY') }}
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <div class="bg-white rounded-3xl p-12 text-center border border-gray-100 shadow-sm">
                <i class="ri-chat-voice-line text-4xl text-gray-300 block mb-3"></i>
                <h3 class="text-base font-bold text-gray-700">বর্তমানে কোনো বক্তব্য পাওয়া যায়নি।</h3>
                <p class="text-xs text-gray-500 mt-1">শীঘ্রই সম্মানিত ব্যক্তির বাণী এই পেজে প্রকাশ করা হবে।</p>
            </div>
        @endforelse

        <!-- Back to Home -->
        <div class="flex justify-center pt-2">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full text-xs sm:text-sm font-bold text-white bg-[#0b4622] hover:bg-[#08351a] shadow-sm transition">
                <i class="ri-arrow-left-line"></i> হোমপেজে ফিরে যান
            </a>
        </div>
    </div>
</main>
@endsection

