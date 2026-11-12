@extends('layouts.admin.admin-layout')

@section('title', 'ব্লগ পোস্টসমূহ ব্যবস্থাপনা | আগামীর শৈলকুপা')

@section('content')
<div class="space-y-6">

  <!-- Breadcrumb & Top Bar -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line"></i>
        <span class="text-gray-400">ব্লগ ও আপডেট</span>
        <i class="ri-arrow-right-s-line"></i>
        <span class="text-[#0b4622] font-semibold">সকল পোস্ট</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
        <i class="ri-article-line text-[#0b4622]"></i>
        <span>ব্লগ ও আপডেট তালিকা (Posts)</span>
      </h1>
      <p class="text-xs text-gray-500 mt-0.5">
        শৈলকুপার যাবতীয় সংবাদ, নিবন্ধ ও ব্লগ পোস্ট তৈরি, সম্পাদনা ও স্ট্যাটাস নিয়ন্ত্রণ করুন।
      </p>
    </div>

    <div class="flex items-center gap-2.5">
      <a
        href="{{ route('admin.categories.index') }}"
        class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition cursor-pointer"
      >
        <i class="ri-price-tag-3-line"></i>
        <span>ক্যাটাগরি ম্যানেজ</span>
      </a>

      <a
        href="{{ route('admin.posts.create') }}"
        class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-xs hover:shadow transition cursor-pointer"
      >
        <i class="ri-add-line text-base"></i>
        <span>নতুন পোস্ট লিখুন</span>
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
    <!-- Category & Status Filters -->
    <div class="flex flex-wrap items-center gap-2">
      <!-- Status Filter -->
      <div class="flex items-center gap-1">
        <a
          href="{{ route('admin.posts.index', array_merge(request()->except('status', 'page'))) }}"
          class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ !request()->filled('status') ? 'bg-[#0b4622] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
        >
          সকল
        </a>
        <a
          href="{{ route('admin.posts.index', array_merge(request()->except('page'), ['status' => '1'])) }}"
          class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === '1' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
        >
          সক্রিয়
        </a>
        <a
          href="{{ route('admin.posts.index', array_merge(request()->except('page'), ['status' => '0'])) }}"
          class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === '0' ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
        >
          ড্রাফট / নিষ্ক্রিয়
        </a>
      </div>

      <!-- Category Filter Dropdown -->
      @if($categories->count() > 0)
        <form method="GET" action="{{ route('admin.posts.index') }}" class="inline-flex">
          @if(request()->filled('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
          @if(request()->filled('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
          <select
            name="category_id"
            onchange="this.form.submit()"
            class="px-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] text-gray-700 font-semibold cursor-pointer"
          >
            <option value="">সকল ক্যাটাগরি</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
              </option>
            @endforeach
          </select>
        </form>
      @endif
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('admin.posts.index') }}" class="flex items-center gap-2">
      @if(request()->filled('category_id')) <input type="hidden" name="category_id" value="{{ request('category_id') }}"> @endif
      @if(request()->filled('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
      <div class="relative">
        <input
          type="text"
          name="search"
          value="{{ request('search') }}"
          placeholder="পোস্ট খুঁজুন..."
          class="pl-9 pr-3.5 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition w-56"
        >
        <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
      </div>
      <button type="submit" class="px-3 py-1.5 bg-[#0b4622] text-white rounded-xl text-xs font-bold">
        খুঁজুন
      </button>
      @if(request()->filled('search') || request()->filled('category_id'))
        <a href="{{ route('admin.posts.index') }}" class="text-xs text-gray-400 hover:text-gray-600">রিসেট</a>
      @endif
    </form>
  </div>

  <!-- Posts Table -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-2xs overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-gray-50/80 border-b border-gray-100 text-[11px] font-black text-gray-500 uppercase tracking-wider">
            <th class="py-3 px-4 text-center w-12">ID</th>
            <th class="py-3 px-4">থাম্বনেইল</th>
            <th class="py-3 px-4">শিরোনাম ও স্লাগ</th>
            <th class="py-3 px-4">ক্যাটাগরি</th>
            <th class="py-3 px-4 text-center">প্রকাশের তারিখ</th>
            <th class="py-3 px-4 text-center">স্ট্যাটাস</th>
            <th class="py-3 px-4 text-center w-28">অ্যাকশন</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-xs text-gray-700">
          @forelse($posts as $post)
            <tr class="hover:bg-gray-50/70 transition">
              <td class="py-3 px-4 text-center font-bold text-gray-400">
                #{{ $post->id }}
              </td>

              <!-- Thumbnail -->
              <td class="py-3 px-4">
                <div class="w-16 h-11 rounded-xl overflow-hidden bg-gray-100 border border-gray-200 shadow-2xs">
                  <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                </div>
              </td>

              <!-- Title & Slug -->
              <td class="py-3 px-4 max-w-sm">
                <span class="font-extrabold text-gray-900 line-clamp-1">
                  {{ $post->title }}
                </span>
                <p class="font-mono text-[11px] text-gray-400 truncate mt-0.5">
                  /{{ $post->slug }}
                </p>
              </td>

              <!-- Category -->
              <td class="py-3 px-4">
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-[11px] font-bold bg-emerald-50 text-[#0b4622] border border-emerald-100">
                  <i class="ri-price-tag-3-line text-xs"></i>
                  <span>{{ $post->category->name ?? 'অশ্রেণীভুক্ত' }}</span>
                </span>
              </td>

              <!-- Published Date -->
              <td class="py-3 px-4 text-center text-gray-500 font-medium">
                {{ $post->published ? $post->published->format('d M, Y') : '—' }}
              </td>

              <!-- AJAX Toggle Switch -->
              <td class="py-3 px-4 text-center">
                <label class="relative inline-flex items-center cursor-pointer">
                  <input
                    type="checkbox"
                    value="1"
                    {{ $post->status ? 'checked' : '' }}
                    onchange="togglePostStatus({{ $post->id }}, this)"
                    class="sr-only peer"
                  >
                  <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#0b4622]"></div>
                </label>
              </td>

              <!-- Actions -->
              <td class="py-3 px-4 text-center">
                <div class="flex items-center justify-center gap-1.5">
                  <a
                    href="{{ route('admin.posts.edit', $post->id) }}"
                    class="w-8 h-8 rounded-lg bg-emerald-50 hover:bg-[#0b4622] text-[#0b4622] hover:text-white flex items-center justify-center transition cursor-pointer"
                    title="সম্পাদনা করুন"
                  >
                    <i class="ri-edit-line text-sm"></i>
                  </a>

                  <form
                    action="{{ route('admin.posts.destroy', $post->id) }}"
                    method="POST"
                    onsubmit="return confirm('আপনি কি নিশ্চিত যে এই পোস্টটি মুছে ফেলতে চান?');"
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
                <i class="ri-article-line text-3xl block mb-2 text-gray-300"></i>
                কোনো ব্লগ পোস্ট পাওয়া যায়নি।
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($posts->hasPages())
      <div class="p-4 border-t border-gray-100 flex justify-center">
        {{ $posts->links() }}
      </div>
    @endif
  </div>

</div>

<script>
function togglePostStatus(id, checkbox) {
  fetch(`/admin/posts/${id}/status`, {
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

