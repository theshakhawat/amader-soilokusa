@extends('layouts.admin.admin-layout')

@section('title', 'Administrative Console — আগামীর শৈলকুপা')

@section('content')
<div class="space-y-5 max-w-7xl mx-auto pb-8">

  {{-- ========================================================================= --}}
  {{-- 1. MINIMAL HEADER & QUICK ACTIONS                                         --}}
  {{-- ========================================================================= --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
      <h1 class="text-xl sm:text-2xl font-bold text-gray-900 tracking-tight">
        Administrative Console
      </h1>
      <p class="text-xs text-gray-500 mt-0.5 flex items-center gap-1.5">
        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
        <span>লাইভ সিস্টেম • {{ now()->translatedFormat('d F, Y') }}</span>
      </p>
    </div>

    {{-- Quick Action Buttons --}}
    <div class="flex items-center flex-wrap gap-2">
      <a
        href="{{ route('admin.members.create') }}"
        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 rounded-lg text-xs font-semibold shadow-2xs transition"
      >
        <i class="ri-user-add-line text-sm text-gray-500"></i>
        <span>+ সদস্য</span>
      </a>

      <a
        href="{{ route('admin.volunteers.create') }}"
        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 rounded-lg text-xs font-semibold shadow-2xs transition"
      >
        <i class="ri-hand-heart-line text-sm text-gray-500"></i>
        <span>+ স্বেচ্ছাসেবী</span>
      </a>

      <a
        href="{{ route('admin.donations.create') }}"
        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#0b4622] hover:bg-[#08351a] text-white rounded-lg text-xs font-semibold shadow-2xs transition"
      >
        <i class="ri-add-line text-sm"></i>
        <span>+ অনুদান এন্ট্রি</span>
      </a>

      <a
        href="{{ route('home') }}"
        target="_blank"
        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 rounded-lg text-xs font-semibold shadow-2xs transition"
        title="মূল ওয়েবসাইট"
      >
        <i class="ri-external-link-line text-sm text-gray-500"></i>
        <span>লাইভ সাইট</span>
      </a>
    </div>
  </div>


  {{-- ========================================================================= --}}
  {{-- 2. CORE STATS (Clean, Minimal, Subtle 1px borders, Clickable)             --}}
  {{-- ========================================================================= --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
    
    {{-- Members --}}
    <a
      href="{{ route('admin.members.index') }}"
      class="bg-white rounded-xl border border-gray-200/90 p-4 shadow-2xs hover:border-[#0b4622]/40 hover:shadow-sm transition group"
    >
      <span class="text-xs text-gray-500 font-medium block">মোট সদস্য</span>
      <span class="text-2xl font-bold text-gray-900 block mt-1">
        {{ $stats['total_members'] }} <span class="text-xs font-normal text-gray-400">জন</span>
      </span>
      <div class="flex items-center gap-2 mt-2 text-[11px] text-gray-500">
        <span class="text-emerald-700 font-medium">{{ $stats['active_members'] }} সক্রিয়</span>
        @if($stats['pending_members'] > 0)
          <span>•</span>
          <span class="text-amber-700 font-medium">{{ $stats['pending_members'] }} অপেক্ষমাণ</span>
        @endif
      </div>
    </a>

    {{-- Volunteers --}}
    <a
      href="{{ route('admin.volunteers.index') }}"
      class="bg-white rounded-xl border border-gray-200/90 p-4 shadow-2xs hover:border-[#0b4622]/40 hover:shadow-sm transition group"
    >
      <span class="text-xs text-gray-500 font-medium block">স্বেচ্ছাসেবী কর্মী</span>
      <span class="text-2xl font-bold text-gray-900 block mt-1">
        {{ $stats['total_volunteers'] }} <span class="text-xs font-normal text-gray-400">জন</span>
      </span>
      <div class="flex items-center gap-2 mt-2 text-[11px] text-gray-500">
        <span class="text-emerald-700 font-medium">{{ $stats['active_volunteers'] }} অনুমোদিত</span>
        @if($stats['pending_volunteers'] > 0)
          <span>•</span>
          <span class="text-amber-700 font-medium">{{ $stats['pending_volunteers'] }} আবেদন</span>
        @endif
      </div>
    </a>

    {{-- Donations Fund --}}
    <a
      href="{{ route('admin.donations.index') }}"
      class="bg-white rounded-xl border border-gray-200/90 p-4 shadow-2xs hover:border-[#0b4622]/40 hover:shadow-sm transition group"
    >
      <span class="text-xs text-gray-500 font-medium block">মোট অনুদান তহবিল</span>
      <span class="text-2xl font-bold text-gray-900 block mt-1">
        ৳{{ number_format($stats['total_donations'], 0) }}
      </span>
      <div class="mt-2 text-[11px] text-gray-500">
        <span>চলতি মাস: ৳{{ number_format($stats['this_month_donations'], 0) }}</span>
      </div>
    </a>

    {{-- Projects --}}
    <a
      href="{{ route('admin.projects.index') }}"
      class="bg-white rounded-xl border border-gray-200/90 p-4 shadow-2xs hover:border-[#0b4622]/40 hover:shadow-sm transition group"
    >
      <span class="text-xs text-gray-500 font-medium block">উন্নয়ন প্রকল্প</span>
      <span class="text-2xl font-bold text-gray-900 block mt-1">
        {{ $stats['total_projects'] }} <span class="text-xs font-normal text-gray-400">টি</span>
      </span>
      <div class="flex items-center gap-2 mt-2 text-[11px] text-gray-500">
        <span>{{ $stats['running_projects'] }} চলমান</span>
        <span>•</span>
        <span>{{ $stats['completed_projects'] }} সম্পন্ন</span>
      </div>
    </a>

  </div>


  {{-- ========================================================================= --}}
  {{-- 3. MINIMAL CHARTS (Clean 2-Column Grid)                                   --}}
  {{-- ========================================================================= --}}
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    
    {{-- Chart 1: Monthly Trends (2 Cols) --}}
    <div class="bg-white rounded-xl p-5 border border-gray-200/90 shadow-2xs lg:col-span-2">
      <div class="flex items-center justify-between pb-3 border-b border-gray-100">
        <div>
          <h2 class="text-sm font-bold text-gray-900">
            মাসিক অনুদান ও নিবন্ধন ট্রেন্ড
          </h2>
          <p class="text-[11px] text-gray-400 mt-0.5">গত ৬ মাসের তহবিল সংগ্রহ ও যোগদানের পরিসংখ্যান</p>
        </div>
        <div class="flex items-center gap-3 text-[11px] font-medium text-gray-500">
          <span class="flex items-center gap-1.5">
            <span class="w-2.5 h-2.5 rounded-full bg-[#0b4622]"></span>
            অনুদান (৳)
          </span>
          <span class="flex items-center gap-1.5">
            <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
            সদস্য
          </span>
          <span class="flex items-center gap-1.5">
            <span class="w-2.5 h-2.5 rounded-full bg-teal-500"></span>
            স্বেচ্ছাসেবী
          </span>
        </div>
      </div>

      <div class="mt-3 h-64 sm:h-72 w-full relative">
        <canvas id="monthlyTrendChart"></canvas>
      </div>
    </div>

    {{-- Chart 2: Blood Donor Pool (1 Col) --}}
    <div class="bg-white rounded-xl p-5 border border-gray-200/90 shadow-2xs">
      <div class="pb-3 border-b border-gray-100">
        <h2 class="text-sm font-bold text-gray-900">
          রক্তের গ্রুপ বণ্টন
        </h2>
        <p class="text-[11px] text-gray-400 mt-0.5">নিবন্ধিত ডোনার ব্যাংক বিবরণী</p>
      </div>

      <div class="mt-3 h-64 sm:h-72 w-full relative">
        <canvas id="bloodGroupChart"></canvas>
      </div>
    </div>

  </div>


  {{-- ========================================================================= --}}
  {{-- 4. RECENT ACTIVITY (Recent Donations & Submissions)                       --}}
  {{-- ========================================================================= --}}
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    
    {{-- Left: Recent Donations (2 Cols) --}}
    <div class="bg-white rounded-xl p-5 border border-gray-200/90 shadow-2xs lg:col-span-2">
      <div class="flex items-center justify-between pb-3 border-b border-gray-100">
        <div>
          <h2 class="text-sm font-bold text-gray-900">
            সর্বশেষ অনুদান সংগ্রহ
          </h2>
          <p class="text-[11px] text-gray-400 mt-0.5">রিয়েল-টাইম অনুদান লেনদেন</p>
        </div>
        <a
          href="{{ route('admin.donations.index') }}"
          class="text-xs font-semibold text-[#0b4622] hover:underline flex items-center gap-1"
        >
          <span>সকল অনুদান</span>
          <i class="ri-arrow-right-line text-xs"></i>
        </a>
      </div>

      <div class="overflow-x-auto mt-3">
        @if($recentDonations->isEmpty())
          <div class="text-center py-8 text-gray-400 text-xs">
            কোনো অনুদানের ডাটা পাওয়া যায়নি।
          </div>
        @else
          <table class="w-full text-left text-xs border-collapse">
            <thead>
              <tr class="border-b border-gray-100 text-gray-400 font-medium text-[11px]">
                <th class="py-2 px-2.5">দাতা</th>
                <th class="py-2 px-2.5">মাধ্যম</th>
                <th class="py-2 px-2.5 text-right">পরিমাণ</th>
                <th class="py-2 px-2.5">তারিখ</th>
                <th class="py-2 px-2.5 text-center">স্ট্যাটাস</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 font-normal">
              @foreach($recentDonations as $donation)
                <tr class="hover:bg-gray-50/60 transition">
                  <td class="py-2.5 px-2.5">
                    <p class="font-medium text-gray-900">{{ $donation->donor_name }}</p>
                    <p class="text-[10px] text-gray-400 font-mono">{{ $donation->trx_id ?? '' }}</p>
                  </td>
                  <td class="py-2.5 px-2.5 text-gray-600">
                    <span class="inline-block px-1.5 py-0.5 rounded text-[10px] font-medium bg-gray-50 border border-gray-200 text-gray-600">
                      {{ $donation->payment_method ?? ($donation->is_manual ? 'অফলাইন' : 'অনলাইন') }}
                    </span>
                  </td>
                  <td class="py-2.5 px-2.5 font-bold text-gray-900 text-right">
                    ৳{{ number_format($donation->amount, 0) }}
                  </td>
                  <td class="py-2.5 px-2.5 text-gray-500 text-[11px] whitespace-nowrap">
                    {{ $donation->created_at->format('d M, Y') }}
                  </td>
                  <td class="py-2.5 px-2.5 text-center">
                    @if($donation->status === 'success')
                      <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200/60">
                        সফল
                      </span>
                    @elseif($donation->status === 'pending')
                      <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-50 text-amber-800 border border-amber-200/60">
                        পেন্ডিং
                      </span>
                    @else
                      <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-gray-100 text-gray-600 border border-gray-200">
                        বাতিল
                      </span>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>

    {{-- Right: Recent Submissions (1 Col) --}}
    <div class="bg-white rounded-xl p-5 border border-gray-200/90 shadow-2xs">
      <div class="flex items-center justify-between pb-3 border-b border-gray-100">
        <div>
          <h2 class="text-sm font-bold text-gray-900">
            সাম্প্রতিক আবেদন ও নিবন্ধন
          </h2>
          <p class="text-[11px] text-gray-400 mt-0.5">নতুন সদস্য ও স্বেচ্ছাসেবী</p>
        </div>
      </div>

      <div class="mt-3 divide-y divide-gray-100 text-xs">
        {{-- Recent Members --}}
        @foreach($recentMembers as $m)
          <div class="py-2.5 flex items-center justify-between hover:bg-gray-50/50 rounded-lg px-1.5 -mx-1.5 transition">
            <div class="flex items-center gap-2.5 min-w-0">
              <div class="w-8 h-8 rounded-lg bg-gray-100 text-[#0b4622] font-bold flex items-center justify-center shrink-0 text-xs border border-gray-200">
                {{ mb_substr($m->name, 0, 1) }}
              </div>
              <div class="truncate">
                <a href="{{ route('admin.members.show', $m) }}" class="font-medium text-gray-900 hover:text-[#0b4622] truncate block">
                  {{ $m->name }}
                </a>
                <span class="text-[10px] text-gray-400">সদস্য • {{ $m->blood_group ?? 'গ্রুপ নেই' }}</span>
              </div>
            </div>
            <div class="text-right shrink-0">
              @if($m->status)
                <span class="inline-block text-[10px] font-medium text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded">
                  অনুমোদিত
                </span>
              @else
                <span class="inline-block text-[10px] font-medium text-amber-700 bg-amber-50 px-1.5 py-0.5 rounded">
                  অপেক্ষমাণ
                </span>
              @endif
            </div>
          </div>
        @endforeach

        {{-- Recent Volunteers --}}
        @foreach($recentVolunteers as $v)
          <div class="py-2.5 flex items-center justify-between hover:bg-gray-50/50 rounded-lg px-1.5 -mx-1.5 transition">
            <div class="flex items-center gap-2.5 min-w-0">
              <div class="w-8 h-8 rounded-lg bg-gray-100 text-teal-700 font-bold flex items-center justify-center shrink-0 text-xs border border-gray-200">
                {{ mb_substr($v->name, 0, 1) }}
              </div>
              <div class="truncate">
                <a href="{{ route('admin.volunteers.show', $v) }}" class="font-medium text-gray-900 hover:text-teal-700 truncate block">
                  {{ $v->name }}
                </a>
                <span class="text-[10px] text-gray-400">স্বেচ্ছাসেবী • {{ $v->blood_group ?? 'গ্রুপ নেই' }}</span>
              </div>
            </div>
            <div class="text-right shrink-0">
              @if($v->status)
                <span class="inline-block text-[10px] font-medium text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded">
                  অনুমোদিত
                </span>
              @else
                <span class="inline-block text-[10px] font-medium text-amber-700 bg-amber-50 px-1.5 py-0.5 rounded">
                  অপেক্ষমাণ
                </span>
              @endif
            </div>
          </div>
        @endforeach

        @if($recentMembers->isEmpty() && $recentVolunteers->isEmpty())
          <div class="text-center py-6 text-gray-400 text-xs">
            কোনো নিবন্ধন পাওয়া যায়নি
          </div>
        @endif
      </div>
    </div>

  </div>

</div>
@endsection

@push('scripts')
{{-- Chart.js CDN for Dynamic Interactive Charts --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // 1. Monthly Donation & Registration Trends Chart
  const trendCtx = document.getElementById('monthlyTrendChart');
  if (trendCtx) {
    const trendData = @json($chartData);

    new Chart(trendCtx, {
      type: 'line',
      data: {
        labels: trendData.labels,
        datasets: [
          {
            label: 'অনুদান (৳)',
            data: trendData.donations,
            borderColor: '#0b4622',
            backgroundColor: 'rgba(11, 70, 34, 0.05)',
            borderWidth: 2,
            tension: 0.35,
            fill: true,
            yAxisID: 'y',
            pointRadius: 3,
            pointBackgroundColor: '#0b4622'
          },
          {
            label: 'সদস্য',
            data: trendData.members,
            borderColor: '#3b82f6',
            backgroundColor: 'transparent',
            borderWidth: 2,
            tension: 0.35,
            yAxisID: 'y1',
            pointRadius: 3,
            pointBackgroundColor: '#3b82f6'
          },
          {
            label: 'স্বেচ্ছাসেবী',
            data: trendData.volunteers,
            borderColor: '#14b8a6',
            backgroundColor: 'transparent',
            borderWidth: 2,
            tension: 0.35,
            yAxisID: 'y1',
            pointRadius: 3,
            pointBackgroundColor: '#14b8a6'
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            backgroundColor: '#1f2937',
            titleFont: { size: 11 },
            bodyFont: { size: 11 },
            padding: 8,
            cornerRadius: 8
          }
        },
        scales: {
          x: {
            grid: { display: false },
            ticks: { font: { size: 10 }, color: '#6b7280' }
          },
          y: {
            type: 'linear',
            display: true,
            position: 'left',
            grid: { color: 'rgba(0, 0, 0, 0.04)' },
            ticks: {
              font: { size: 10 },
              color: '#6b7280',
              callback: value => '৳' + (value >= 1000 ? (value/1000) + 'k' : value)
            }
          },
          y1: {
            type: 'linear',
            display: false,
            position: 'right',
            grid: { drawOnChartArea: false }
          }
        }
      }
    });
  }

  // 2. Blood Groups Donor Pool Chart
  const bloodCtx = document.getElementById('bloodGroupChart');
  if (bloodCtx) {
    const bloodGroups = @json($chartData['blood_groups']);
    const labels = Object.keys(bloodGroups);
    const counts = Object.values(bloodGroups);

    new Chart(bloodCtx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          data: counts,
          backgroundColor: '#0b4622',
          borderRadius: 6,
          borderSkipped: false,
          maxBarThickness: 22
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: '#1f2937',
            padding: 8,
            cornerRadius: 8,
            callbacks: {
              label: context => context.parsed.y + ' জন ডোনার'
            }
          }
        },
        scales: {
          x: {
            grid: { display: false },
            ticks: { font: { size: 10, weight: 'bold' }, color: '#374151' }
          },
          y: {
            beginAtZero: true,
            grid: { color: 'rgba(0, 0, 0, 0.04)' },
            ticks: { stepSize: 1, font: { size: 10 }, color: '#6b7280' }
          }
        }
      }
    });
  }
});
</script>
@endpush
