@extends('layouts.admin.admin-layout')

@section('title', 'সদস্য ব্যবস্থাপনা')

@section('content')
<div class="space-y-6">
  {{-- Header with Action Buttons --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight flex items-center gap-2.5">
        <span class="w-10 h-10 rounded-xl bg-emerald-50 text-[#0b4622] flex items-center justify-center text-xl shadow-2xs">
          <i class="ri-user-star-line"></i>
        </span>
        <span>সদস্য ব্যবস্থাপনা</span>
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-1 font-medium">নিবন্ধিত সকল সদস্য, নতুন আবেদন পর্যালোচনা, অনুমোদন ও ডিজিটাল কার্ড পরিচালনা</p>
    </div>

    <div class="flex flex-wrap items-center gap-2">
      {{-- Export Button --}}
      <a href="{{ route('admin.members.export', request()->query()) }}"
         class="inline-flex items-center gap-2 px-3.5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs sm:text-sm font-bold shadow-xs hover:shadow transition"
         title="সদস্যদের তালিকা এক্সেলে ডাউনলোড করুন">
        <i class="ri-file-excel-2-line text-base"></i>
        <span>এক্সপোর্ট (Excel/CSV)</span>
      </a>

      {{-- Print Button --}}
      <button type="button"
              onclick="window.print()"
              class="inline-flex items-center gap-2 px-3.5 py-2.5 bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 rounded-xl text-xs sm:text-sm font-bold shadow-2xs transition">
        <i class="ri-printer-line text-base text-gray-500"></i>
        <span>প্রিন্ট</span>
      </button>

      {{-- Add New Member Manually --}}
      <a href="{{ route('admin.members.create') }}"
         class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white rounded-xl text-xs sm:text-sm font-bold shadow-xs hover:shadow transition">
        <i class="ri-user-add-line text-base"></i>
        <span>নতুন সদস্য নিয়োগ</span>
      </a>
    </div>
  </div>

  {{-- Metrics Cards --}}
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    {{-- Total Members --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-4 sm:p-5 shadow-2xs flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold text-gray-500">মোট আবেদন ও সদস্য</p>
        <h3 class="text-xl sm:text-2xl font-black text-gray-900 mt-1">{{ number_format($totalMembers) }} জন</h3>
      </div>
      <div class="w-12 h-12 rounded-xl bg-gray-100 text-gray-700 flex items-center justify-center text-2xl shrink-0">
        <i class="ri-group-line"></i>
      </div>
    </div>

    {{-- Pending Applications (Needs Action) --}}
    <div class="bg-gradient-to-br from-amber-500/10 via-white to-white rounded-2xl border-2 {{ request('status') === 'pending' ? 'border-amber-500 ring-2 ring-amber-500/20' : 'border-amber-200' }} p-4 sm:p-5 shadow-2xs flex items-center justify-between">
      <div>
        <div class="flex items-center gap-1.5">
          <span class="inline-block w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
          <p class="text-xs font-bold uppercase tracking-wider text-amber-800">অপেক্ষমাণ নতুন আবেদন</p>
        </div>
        <h3 class="text-xl sm:text-2xl font-black text-amber-700 mt-1">{{ number_format($pendingMembers) }} জন</h3>
      </div>
      <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-2xl shrink-0">
        <i class="ri-time-line"></i>
      </div>
    </div>

    {{-- Approved Active Members --}}
    <div class="bg-white rounded-2xl border {{ request('status') === 'approved' ? 'border-emerald-600 ring-2 ring-emerald-500/20' : 'border-gray-200' }} p-4 sm:p-5 shadow-2xs flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold text-gray-500">অনুমোদিত ও সক্রিয় সদস্য</p>
        <h3 class="text-xl sm:text-2xl font-black text-emerald-600 mt-1">{{ number_format($approvedMembers) }} জন</h3>
      </div>
      <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl shrink-0">
        <i class="ri-checkbox-circle-line"></i>
      </div>
    </div>

    {{-- This Month's New Applications --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-4 sm:p-5 shadow-2xs flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold text-gray-500">চলতি মাসে আবেদন</p>
        <h3 class="text-xl sm:text-2xl font-black text-blue-600 mt-1">{{ number_format($thisMonthMembers) }} জন</h3>
      </div>
      <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl shrink-0">
        <i class="ri-calendar-event-line"></i>
      </div>
    </div>
  </div>

  {{-- Filters, Search & Status Tabs --}}
  <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-2xs space-y-3">
    {{-- Status Tabs --}}
    <div class="flex flex-wrap items-center gap-2 border-b border-gray-100 pb-3">
      @php
        $currentStatus = request('status', 'all');
      @endphp
      <a href="{{ route('admin.members.index', array_merge(request()->except(['status', 'page']), ['status' => 'all'])) }}"
         class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ $currentStatus === 'all' ? 'bg-[#0b4622] text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
        সকল আবেদন ({{ $totalMembers }})
      </a>

      <a href="{{ route('admin.members.index', array_merge(request()->except(['status', 'page']), ['status' => 'pending'])) }}"
         class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ $currentStatus === 'pending' ? 'bg-amber-600 text-white shadow-xs' : 'bg-amber-50 text-amber-800 hover:bg-amber-100' }}">
        <i class="ri-time-line"></i>
        <span>অপেক্ষমাণ / নতুন আবেদন</span>
        @if($pendingMembers > 0)
          <span class="px-1.5 py-0.2 rounded-full text-[10px] font-black {{ $currentStatus === 'pending' ? 'bg-white text-amber-700' : 'bg-amber-600 text-white' }}">{{ $pendingMembers }}</span>
        @endif
      </a>

      <a href="{{ route('admin.members.index', array_merge(request()->except(['status', 'page']), ['status' => 'approved'])) }}"
         class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ $currentStatus === 'approved' ? 'bg-emerald-700 text-white shadow-xs' : 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100' }}">
        <i class="ri-checkbox-circle-line"></i>
        <span>অনুমোদিত সদস্য ({{ $approvedMembers }})</span>
      </a>
    </div>

    {{-- Filter & Search Form --}}
    <form action="{{ route('admin.members.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
      <input type="hidden" name="status" value="{{ request('status', 'all') }}">

      {{-- Search --}}
      <div class="relative md:col-span-2">
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="সদস্যের নাম, মোবাইল নম্বর, ইমেইল, ঠিকানা..."
               class="w-full pl-9 pr-3 py-2 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622] transition">
        <i class="ri-search-line absolute left-3 top-2.5 text-gray-400"></i>
      </div>

      {{-- Blood Group Filter --}}
      <div>
        <select name="blood_group" class="w-full px-3 py-2 text-xs sm:text-sm border border-gray-300 rounded-xl focus:outline-none focus:border-[#0b4622] transition bg-white">
          <option value="all" {{ request('blood_group') === 'all' || !request('blood_group') ? 'selected' : '' }}>সকল রক্তের গ্রুপ</option>
          <option value="A+" {{ request('blood_group') === 'A+' ? 'selected' : '' }}>A+ (পজিটিভ)</option>
          <option value="A-" {{ request('blood_group') === 'A-' ? 'selected' : '' }}>A- (নেগেটিভ)</option>
          <option value="B+" {{ request('blood_group') === 'B+' ? 'selected' : '' }}>B+ (পজিটিভ)</option>
          <option value="B-" {{ request('blood_group') === 'B-' ? 'selected' : '' }}>B- (নেগেটিভ)</option>
          <option value="AB+" {{ request('blood_group') === 'AB+' ? 'selected' : '' }}>AB+ (পজিটিভ)</option>
          <option value="AB-" {{ request('blood_group') === 'AB-' ? 'selected' : '' }}>AB- (নেগেটিভ)</option>
          <option value="O+" {{ request('blood_group') === 'O+' ? 'selected' : '' }}>O+ (পজিটিভ)</option>
          <option value="O-" {{ request('blood_group') === 'O-' ? 'selected' : '' }}>O- (নেগেটিভ)</option>
        </select>
      </div>

      {{-- Actions --}}
      <div class="flex items-center gap-2">
        <button type="submit" class="w-full px-4 py-2 bg-gray-900 hover:bg-black text-white text-xs sm:text-sm font-bold rounded-xl transition flex items-center justify-center gap-1.5 shadow-2xs">
          <i class="ri-filter-3-line"></i> ফিল্টার
        </button>
        @if(request()->hasAny(['search', 'blood_group']) && (request('search') || (request('blood_group') && request('blood_group') !== 'all')))
          <a href="{{ route('admin.members.index', ['status' => request('status', 'all')]) }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-semibold rounded-xl transition" title="রিসেট">
            <i class="ri-refresh-line"></i>
          </a>
        @endif
      </div>
    </form>
  </div>

  {{-- Members Table --}}
  <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-2xs">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse text-xs sm:text-sm">
        <thead class="bg-gray-50/80 border-b border-gray-200 text-gray-600 font-bold uppercase tracking-wider text-[11px]">
          <tr>
            <th class="px-4 py-3.5 text-center w-12 border-r border-gray-200">ক্র.</th>
            <th class="px-4 py-3.5 border-r border-gray-200">সদস্যের তথ্য</th>
            <th class="px-4 py-3.5 border-r border-gray-200">যোগাযোগ (ফোন ও ইমেইল)</th>
            <th class="px-4 py-3.5 border-r border-gray-200 text-center">রক্তের গ্রুপ ও পেশা</th>
            <th class="px-4 py-3.5 border-r border-gray-200">ঠিকানা</th>
            <th class="px-4 py-3.5 border-r border-gray-200 text-center">স্ট্যাটাস ও অনুমোদন</th>
            <th class="px-4 py-3.5 border-r border-gray-200">আবেদনের তারিখ</th>
            <th class="px-4 py-3.5 text-center w-28">অ্যাকশন</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          @forelse($members as $idx => $member)
            <tr class="hover:bg-gray-50/60 transition align-middle">
              {{-- SL --}}
              <td class="px-4 py-3.5 text-center font-bold text-gray-500 border-r border-gray-200">
                {{ $members->firstItem() + $idx }}
              </td>

              {{-- Photo & Name --}}
              <td class="px-4 py-3.5 border-r border-gray-200">
                <div class="flex items-center gap-3">
                  <img src="{{ $member->photo_url }}"
                       alt="{{ $member->name }}"
                       class="w-10 h-10 rounded-full object-cover border border-gray-200 shrink-0">
                  <div>
                    <span class="font-bold text-gray-900 block">{{ $member->name }}</span>
                    <span class="text-[10px] font-mono text-[#0b4622] font-bold block">{{ $member->card_id_number }}</span>
                    <span class="text-[10px] text-gray-400 font-mono">slug: {{ $member->slug }}</span>
                  </div>
                </div>
              </td>

              {{-- Contact --}}
              <td class="px-4 py-3.5 border-r border-gray-200">
                <a href="tel:{{ $member->phone }}" class="text-xs text-[#0b4622] font-semibold hover:underline flex items-center gap-1 font-mono">
                  <i class="ri-phone-line"></i> {{ $member->phone }}
                </a>
                <a href="mailto:{{ $member->email }}" class="text-[11px] text-gray-500 hover:underline flex items-center gap-1 mt-0.5">
                  <i class="ri-mail-line"></i> {{ $member->email }}
                </a>
              </td>

              {{-- Blood Group & Occupation --}}
              <td class="px-4 py-3.5 border-r border-gray-200 text-center">
                @if($member->blood_group)
                  <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200">
                    <i class="ri-drop-fill text-red-500 text-[11px]"></i> {{ $member->blood_group }}
                  </span>
                @else
                  <span class="text-gray-400 text-xs">—</span>
                @endif
                @if($member->occupation)
                  <span class="block text-[11px] text-gray-600 mt-1 font-medium truncate max-w-[120px] mx-auto" title="{{ $member->occupation }}">
                    {{ $member->occupation }}
                  </span>
                @endif
              </td>

              {{-- Address --}}
              <td class="px-4 py-3.5 border-r border-gray-200 max-w-xs">
                <span class="text-xs text-gray-700 line-clamp-2" title="{{ $member->address }}">
                  {{ $member->address ?: '—' }}
                </span>
              </td>

              {{-- Status & Approve Toggle --}}
              <td class="px-4 py-3.5 border-r border-gray-200 text-center">
                @if($member->status)
                  <div class="flex flex-col items-center gap-1">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                      <i class="ri-checkbox-circle-fill text-emerald-500"></i> Active
                    </span>
                    <form action="{{ route('admin.members.status', $member->id) }}" method="POST">
                      @csrf
                      @method('PATCH')
                      <button type="submit"
                              class="text-[10px] text-gray-400 hover:text-red-600 underline transition cursor-pointer"
                              title="নিষ্ক্রিয় করতে ক্লিক করুন">
                        নিষ্ক্রিয় করুন
                      </button>
                    </form>
                  </div>
                @else
                  <div class="flex flex-col items-center gap-1">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                      <i class="ri-time-line text-amber-500"></i> Inactive
                    </span>
                    <form action="{{ route('admin.members.approve', $member->id) }}" method="POST">
                      @csrf
                      @method('PATCH')
                      <button type="submit"
                              class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-700 hover:bg-emerald-800 text-white text-[10px] font-bold shadow-2xs transition mt-0.5 cursor-pointer"
                              title="সদস্যপদ অনুমোদন করুন ও কনফার্মেশন ইমেইল পাঠান">
                        <i class="ri-check-line"></i> অনুমোদন করুন
                      </button>
                    </form>
                  </div>
                @endif
              </td>

              {{-- Date --}}
              <td class="px-4 py-3.5 border-r border-gray-200 text-xs text-gray-600 whitespace-nowrap">
                <span class="font-semibold block text-gray-900">{{ $member->created_at->format('d M, Y') }}</span>
                <span class="text-[11px] text-gray-400">{{ $member->created_at->format('h:i A') }}</span>
                @if($member->approved_at)
                  <span class="text-[10px] text-emerald-600 block mt-0.5" title="অনুমোদনের তারিখ">
                    ✓ {{ $member->approved_at->format('d/m/Y') }}
                  </span>
                @endif
              </td>

              {{-- Actions --}}
              <td class="px-4 py-3.5 text-center">
                <div class="flex items-center justify-center gap-1">
                  {{-- Digital ID Card (If Approved) --}}
                  @if($member->status)
                    <a href="{{ $member->public_card_url }}"
                       target="_blank"
                       class="w-8 h-8 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 flex items-center justify-center transition"
                       title="ডিজিটাল সদস্য আইডি কার্ড দেখুন ও ডাউনলোড করুন">
                      <i class="ri-id-card-line text-sm"></i>
                    </a>
                  @endif

                  {{-- View Details --}}
                  <a href="{{ route('admin.members.show', $member->id) }}"
                     class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 flex items-center justify-center transition"
                     title="বিস্তারিত দেখুন">
                    <i class="ri-eye-line text-sm"></i>
                  </a>

                  {{-- Edit --}}
                  <a href="{{ route('admin.members.edit', $member->id) }}"
                     class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 flex items-center justify-center transition"
                     title="তথ্য সম্পাদনা">
                    <i class="ri-edit-line text-sm"></i>
                  </a>

                  {{-- Delete --}}
                  <form action="{{ route('admin.members.destroy', $member->id) }}"
                        method="POST"
                        onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই সদস্যের রেকর্ড মুছে ফেলতে চান?');"
                        class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 flex items-center justify-center transition cursor-pointer"
                            title="মুছে ফেলুন">
                      <i class="ri-delete-bin-line text-sm"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="p-12 text-center text-gray-400">
                <i class="ri-user-search-line text-5xl text-gray-300 block mb-3"></i>
                <p class="text-sm font-semibold text-gray-600">কোনো সদস্যের তথ্য পাওয়া যায়নি।</p>
                <p class="text-xs text-gray-400 mt-1">ফিল্টারিং পরিবর্তন করুন অথবা নতুন সদস্য নিয়োগ দিন।</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($members->hasPages())
      <div class="px-4 py-3 border-t border-gray-200 bg-gray-50/50">
        {{ $members->links() }}
      </div>
    @endif
  </div>
</div>
@endsection
