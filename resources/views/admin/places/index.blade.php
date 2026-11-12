@extends('layouts.admin.admin-layout')

@section('title', 'দর্শনীয় স্থান ব্যবস্থাপনা | আগামীর শৈলকুপা')

@section('content')
<div class="space-y-6">

  <!-- Breadcrumb & Top Bar -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line"></i>
        <span class="text-[#0b4622] font-semibold">দর্শনীয় স্থানসমূহ</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
        <i class="ri-map-pin-2-line text-[#0b4622]"></i>
        <span>দর্শনীয় স্থান তালিকা (Places)</span>
      </h1>
      <p class="text-xs text-gray-500 mt-0.5">
        শৈলকুপার দর্শনীয় ও ঐতিহাসিক স্থানসমূহ যোগ, সম্পাদনা ও পর্যবেক্ষণ করুন।
      </p>
    </div>

    <div class="flex items-center gap-2.5">
      <a
        href="{{ route('places.index') }}"
        target="_blank"
        class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition cursor-pointer"
      >
        <i class="ri-external-link-line"></i>
        <span>পাবলিক পেজ দেখুন</span>
      </a>

      <a
        href="{{ route('admin.places.create') }}"
        class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-xs hover:shadow transition cursor-pointer"
      >
        <i class="ri-add-line text-base"></i>
        <span>নতুন স্থান যোগ করুন</span>
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
        href="{{ route('admin.places.index') }}"
        class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ !request()->filled('status') ? 'bg-[#0b4622] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
      >
        সকল
      </a>
      <a
        href="{{ route('admin.places.index', ['status' => '1']) }}"
        class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === '1' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
      >
        সক্রিয়
      </a>
      <a
        href="{{ route('admin.places.index', ['status' => '0']) }}"
        class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === '0' ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
      >
        নিষ্ক্রিয়
      </a>
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('admin.places.index') }}" class="flex items-center gap-2">
      <div class="relative">
        <input
          type="text"
          name="search"
          value="{{ request('search') }}"
          placeholder="স্থান খুঁজুন..."
          class="pl-9 pr-3.5 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition w-56"
        >
        <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
      </div>
      <button type="submit" class="px-3 py-1.5 bg-[#0b4622] text-white rounded-xl text-xs font-bold">
        খুঁজুন
      </button>
      @if(request()->filled('search'))
        <a href="{{ route('admin.places.index') }}" class="text-xs text-gray-400 hover:text-gray-600">রিসেট</a>
      @endif
    </form>
  </div>

  <!-- Places Table -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-2xs overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-gray-50/80 border-b border-gray-100 text-[11px] font-black text-gray-500 uppercase tracking-wider">
            <th class="py-3 px-4 text-center w-14">ক্রম</th>
            <th class="py-3 px-4">থাম্বনেইল</th>
            <th class="py-3 px-4">শিরোনাম ও উপশিরোনাম</th>
            <th class="py-3 px-4">অবস্থান</th>
            <th class="py-3 px-4 text-center">ছবি</th>
            <th class="py-3 px-4 text-center">স্ট্যাটাস</th>
            <th class="py-3 px-4 text-center w-28">অ্যাকশন</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-xs text-gray-700">
          @forelse($places as $place)
            <tr class="hover:bg-gray-50/70 transition">
              <td class="py-3 px-4 text-center font-bold text-gray-400">
                {{ $place->order_index ?? 0 }}
              </td>

              <!-- Thumbnail Preview -->
              <td class="py-3 px-4">
                <div class="w-16 h-12 rounded-xl overflow-hidden bg-gray-100 border border-gray-200 shadow-2xs">
                  <img src="{{ $place->thumbnail_url }}" alt="{{ $place->title }}" class="w-full h-full object-cover">
                </div>
              </td>

              <!-- Title & Subtitle -->
              <td class="py-3 px-4 max-w-xs">
                <a href="{{ route('places.details', $place->id) }}" target="_blank" class="font-extrabold text-gray-900 hover:text-[#0b4622] transition line-clamp-1">
                  {{ $place->title }}
                </a>
                <p class="text-[11px] text-gray-400 line-clamp-1 mt-0.5">
                  {{ $place->subtitle ?? strip_tags($place->descriptions) }}
                </p>
              </td>

              <!-- Location -->
              <td class="py-3 px-4">
                @if($place->location)
                  <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-50 text-[#0b4622] font-semibold text-[10px]">
                    <i class="ri-map-pin-line"></i>
                    {{ Str::limit($place->location, 20) }}
                  </span>
                @else
                  <span class="text-gray-300 text-[11px]">—</span>
                @endif
              </td>

              <!-- Photos Count -->
              <td class="py-3 px-4 text-center">
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-gray-100 text-gray-600 font-bold text-[11px]">
                  <i class="ri-image-line text-xs"></i>
                  <span>{{ $place->photos_count }} টি</span>
                </span>
              </td>

              <!-- AJAX Toggle Switch -->
              <td class="py-3 px-4 text-center">
                <label class="relative inline-flex items-center cursor-pointer">
                  <input
                    type="checkbox"
                    value="1"
                    {{ $place->status ? 'checked' : '' }}
                    onchange="togglePlaceStatus({{ $place->id }}, this)"
                    class="sr-only peer"
                  >
                  <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#0b4622]"></div>
                </label>
              </td>

              <!-- Actions (Edit / Delete) -->
              <td class="py-3 px-4 text-center">
                <div class="flex items-center justify-center gap-1.5">
                  <a
                    href="{{ route('admin.places.edit', $place->id) }}"
                    class="w-8 h-8 rounded-lg bg-emerald-50 hover:bg-[#0b4622] text-[#0b4622] hover:text-white flex items-center justify-center transition cursor-pointer"
                    title="সম্পাদনা করুন"
                  >
                    <i class="ri-edit-line text-sm"></i>
                  </a>

                  <form
                    action="{{ route('admin.places.destroy', $place->id) }}"
                    method="POST"
                    onsubmit="return confirm('আপনি কি নিশ্চিত যে এই দর্শনীয় স্থানটি মুছে ফেলতে চান?');"
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
                <i class="ri-map-pin-line text-3xl block mb-2 text-gray-300"></i>
                কোনো দর্শনীয় স্থান পাওয়া যায়নি।
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($places->hasPages())
      <div class="p-4 border-t border-gray-100 flex justify-center">
        {{ $places->links() }}
      </div>
    @endif
  </div>

</div>

<script>
function togglePlaceStatus(id, checkbox) {
  fetch(`/admin/places/${id}/status`, {
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
      alert('স্ট্যাটাস আপডেট করতে সমস্যা হয়েছে।');
    }
  })
  .catch(err => {
    checkbox.checked = !checkbox.checked;
    alert('সার্ভার এরর');
  });
}
</script>
@endsection

