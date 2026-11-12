@extends('layouts.admin.admin-layout')

@section('title', 'উন্নয়ন প্রকল্পসমূহ ব্যবস্থাপনা | আগামীর শৈলকুপা')

@section('content')
<div class="space-y-6">

  <!-- Breadcrumb & Top Bar -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line"></i>
        <span class="text-[#0b4622] font-semibold">উন্নয়ন প্রকল্পসমূহ</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
        <i class="ri-stack-line text-[#0b4622]"></i>
        <span>উন্নয়ন প্রকল্প তালিকা (Projects)</span>
      </h1>
      <p class="text-xs text-gray-500 mt-0.5">
        শৈলকুপার চলমান, সম্পন্ন ও আসন্ন সকল উন্নয়ন প্রকল্প যোগ, সম্পাদনা ও পর্যবেক্ষণ করুন।
      </p>
    </div>

    <div class="flex items-center gap-2.5">
      <a
        href="{{ route('projects.index') }}"
        target="_blank"
        class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition cursor-pointer"
      >
        <i class="ri-external-link-line"></i>
        <span>পাবলিক পেজ দেখুন</span>
      </a>

      <a
        href="{{ route('admin.projects.create') }}"
        class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-xs hover:shadow transition cursor-pointer"
      >
        <i class="ri-add-line text-base"></i>
        <span>নতুন প্রকল্প যোগ করুন</span>
      </a>
    </div>
  </div>

  @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-2xl flex items-center justify-between">
      <div class="flex items-center gap-2">
        <i class="ri-checkbox-circle-fill text-emerald-600 text-base"></i>
        <span>{{ session('success') }}</span>
      </div>
    </div>
  @endif

  <!-- Filters & Search Bar -->
  <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-2xs flex flex-col md:flex-row md:items-center justify-between gap-3">
    <!-- Status Filter Buttons -->
    <div class="flex flex-wrap items-center gap-1.5">
      <a
        href="{{ route('admin.projects.index') }}"
        class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ !request()->filled('project_status') ? 'bg-[#0b4622] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
      >
        সকল
      </a>
      <a
        href="{{ route('admin.projects.index', ['project_status' => 'running']) }}"
        class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('project_status') === 'running' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
      >
        চলমান
      </a>
      <a
        href="{{ route('admin.projects.index', ['project_status' => 'completed']) }}"
        class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('project_status') === 'completed' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
      >
        সম্পন্ন
      </a>
      <a
        href="{{ route('admin.projects.index', ['project_status' => 'upcoming']) }}"
        class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('project_status') === 'upcoming' ? 'bg-amber-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
      >
        আসন্ন
      </a>
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('admin.projects.index') }}" class="flex items-center gap-2">
      <div class="relative">
        <input
          type="text"
          name="search"
          value="{{ request('search') }}"
          placeholder="প্রকল্প খুঁজুন..."
          class="pl-9 pr-3.5 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition w-56"
        >
        <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
      </div>
      <button type="submit" class="px-3 py-1.5 bg-[#0b4622] text-white rounded-xl text-xs font-bold">
        খুঁজুন
      </button>
      @if(request()->filled('search'))
        <a href="{{ route('admin.projects.index') }}" class="text-xs text-gray-400 hover:text-gray-600">রিসেট</a>
      @endif
    </form>
  </div>

  <!-- Projects Table / Grid -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-2xs overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-gray-50/80 border-b border-gray-100 text-[11px] font-black text-gray-500 uppercase tracking-wider">
            <th class="py-3 px-4 text-center w-14">ক্রম</th>
            <th class="py-3 px-4">থাম্বনেইল</th>
            <th class="py-3 px-4">শিরোনাম ও বিবরণ</th>
            <th class="py-3 px-4 text-center">প্রকল্প পর্যায়</th>
            <th class="py-3 px-4 text-center">স্লাইডার ছবি</th>
            <th class="py-3 px-4 text-center">স্ট্যাটাস</th>
            <th class="py-3 px-4 text-center w-28">অ্যাকশন</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-xs text-gray-700">
          @forelse($projects as $project)
            @php $badge = $project->status_badge; @endphp
            <tr class="hover:bg-gray-50/70 transition">
              <td class="py-3 px-4 text-center font-bold text-gray-400">
                {{ $project->order_index ?? 0 }}
              </td>

              <!-- Thumbnail Preview -->
              <td class="py-3 px-4">
                <div class="w-16 h-12 rounded-xl overflow-hidden bg-gray-100 border border-gray-200 shadow-2xs">
                  <img src="{{ $project->thumbnail_url }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                </div>
              </td>

              <!-- Title & Desc -->
              <td class="py-3 px-4 max-w-xs">
                <a href="{{ route('projects.details', $project->id) }}" target="_blank" class="font-extrabold text-gray-900 hover:text-[#0b4622] transition line-clamp-1">
                  {{ $project->title }}
                </a>
                <p class="text-[11px] text-gray-400 line-clamp-1 mt-0.5">
                  {{ strip_tags($project->description) }}
                </p>
              </td>

              <!-- Project Status Badge -->
              <td class="py-3 px-4 text-center">
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-[10px] font-extrabold {{ $badge['bg'] }} {{ $badge['text_color'] }}">
                  <i class="{{ $badge['icon'] }}"></i>
                  <span>{{ $badge['text'] }}</span>
                </span>
              </td>

              <!-- Photos Count -->
              <td class="py-3 px-4 text-center">
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-gray-100 text-gray-600 font-bold text-[11px]">
                  <i class="ri-image-line text-xs"></i>
                  <span>{{ $project->photos_count }} টি ছবি</span>
                </span>
              </td>

              <!-- AJAX Toggle Switch -->
              <td class="py-3 px-4 text-center">
                <label class="relative inline-flex items-center cursor-pointer">
                  <input
                    type="checkbox"
                    value="1"
                    {{ $project->status ? 'checked' : '' }}
                    onchange="toggleProjectStatus({{ $project->id }}, this)"
                    class="sr-only peer"
                  >
                  <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#0b4622]"></div>
                </label>
              </td>

              <!-- Actions (Edit / Delete) -->
              <td class="py-3 px-4 text-center">
                <div class="flex items-center justify-center gap-1.5">
                  <a
                    href="{{ route('admin.projects.edit', $project->id) }}"
                    class="w-8 h-8 rounded-lg bg-emerald-50 hover:bg-[#0b4622] text-[#0b4622] hover:text-white flex items-center justify-center transition cursor-pointer"
                    title="সম্পাদনা করুন"
                  >
                    <i class="ri-edit-line text-sm"></i>
                  </a>

                  <form
                    action="{{ route('admin.projects.destroy', $project->id) }}"
                    method="POST"
                    onsubmit="return confirm('আপনি কি নিশ্চিত যে এই প্রকল্পটি মুছে ফেলতে চান?');"
                    class="inline"
                  >
                    @csrf
                    @method('DELETE')
                    <button
                      type="submit"
                      class="w-8 h-8 rounded-lg bg-red-50 hover:bg-[#c8102e] text-[#c8102e] hover:text-white flex items-center justify-center transition cursor-pointer"
                      title="মুছে ফেলুন"
                    >
                      <i class="ri-delete-bin-line text-sm"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="py-12 text-center text-gray-400">
                <i class="ri-stack-line text-3xl block mb-2 text-gray-300"></i>
                কোনো উন্নয়ন প্রকল্প পাওয়া যায়নি।
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($projects->hasPages())
      <div class="p-4 border-t border-gray-100 flex justify-center">
        {{ $projects->links() }}
      </div>
    @endif
  </div>

</div>

<script>
function toggleProjectStatus(id, checkbox) {
  fetch(`/admin/projects/${id}/status`, {
    method: 'PATCH',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json'
    }
  })
  .then(res => res.json())
  .then(data => {
    if (!data.success) {
      checkbox.checked = !checkbox.checked;
      alert('স্ট্যাটাস আপডেট করতে সমস্যা হয়েছে।');
    }
  })
  .catch(err => {
    checkbox.checked = !checkbox.checked;
    alert('সার্ভার এরর');
  });
}
</script>
@endsection

