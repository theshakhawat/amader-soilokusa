@extends('layouts.admin.admin-layout')

@section('title', 'ব্লগ ক্যাটাগরি ব্যবস্থাপনা | আগামীর শৈলকুপা')

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
        <span class="text-[#0b4622] font-semibold">ক্যাটাগরি</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-2">
        <i class="ri-price-tag-3-line text-[#0b4622]"></i>
        <span>ব্লগ ক্যাটাগরি তালিকা (Categories)</span>
      </h1>
      <p class="text-xs text-gray-500 mt-0.5">
        ব্লগ পোস্টের জন্য ক্যাটাগরি যোগ, সম্পাদনা ও পর্যবেক্ষণ করুন।
      </p>
    </div>

    <div class="flex items-center gap-2.5">
      <a
        href="{{ route('admin.posts.index') }}"
        class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition cursor-pointer"
      >
        <i class="ri-article-line"></i>
        <span>সকল পোস্ট দেখুন</span>
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

  @if($errors->any())
    <div class="p-4 bg-red-50 border border-red-200 text-red-700 text-xs font-bold rounded-2xl">
      <ul class="list-disc list-inside space-y-1">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

    <!-- Left 4 Cols: Add New Category Form -->
    <div class="lg:col-span-4">
      <div class="bg-white rounded-2xl border border-gray-100 shadow-2xs p-5 space-y-4 sticky top-6">
        <div class="flex items-center gap-2 pb-3 border-b border-gray-100">
          <i class="ri-add-circle-line text-[#0b4622] text-lg"></i>
          <h2 class="text-sm font-black text-gray-900">নতুন ক্যাটাগরি যোগ করুন</h2>
        </div>

        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
          @csrf

          <div>
            <label for="name" class="block text-xs font-bold text-gray-700 mb-1">
              ক্যাটাগরির নাম (Name) <span class="text-[#c8102e]">*</span>
            </label>
            <input
              type="text"
              id="name"
              name="name"
              value="{{ old('name') }}"
              placeholder="উদাঃ কৃষি ও উন্নয়ন"
              class="w-full px-3.5 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
              required
            >
          </div>

          <div>
            <label for="slug" class="block text-xs font-bold text-gray-700 mb-1">
              স্লাগ (Slug - ঐচ্ছিক)
            </label>
            <input
              type="text"
              id="slug"
              name="slug"
              value="{{ old('slug') }}"
              placeholder="উদাঃ agriculture-development"
              class="w-full px-3.5 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
            >
            <p class="text-[10px] text-gray-400 mt-1">ফাঁকা রাখলে স্বয়ংক্রিয়ভাবে নাম থেকে তৈরি হবে।</p>
          </div>

          <!-- Status toggle -->
          <div class="flex items-center justify-between p-3 bg-gray-50 border border-gray-200 rounded-xl">
            <span class="text-xs font-bold text-gray-700">সক্রিয় স্ট্যাটাস</span>
            <label class="relative inline-flex items-center cursor-pointer">
              <input type="checkbox" name="status" value="1" class="sr-only peer" checked>
              <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#0b4622]"></div>
            </label>
          </div>

          <button
            type="submit"
            class="w-full inline-flex items-center justify-center gap-1.5 py-2.5 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-xs transition cursor-pointer"
          >
            <i class="ri-check-line"></i>
            <span>ক্যাটাগরি তৈরি করুন</span>
          </button>
        </form>
      </div>
    </div>

    <!-- Right 8 Cols: Categories Table -->
    <div class="lg:col-span-8 space-y-4">

      <!-- Search & Filters -->
      <div class="bg-white p-3.5 rounded-2xl border border-gray-100 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-1.5">
          <a
            href="{{ route('admin.categories.index') }}"
            class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ !request()->filled('status') ? 'bg-[#0b4622] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
          >
            সকল
          </a>
          <a
            href="{{ route('admin.categories.index', ['status' => '1']) }}"
            class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === '1' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
          >
            সক্রিয়
          </a>
          <a
            href="{{ route('admin.categories.index', ['status' => '0']) }}"
            class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ request('status') === '0' ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
          >
            নিষ্ক্রিয়
          </a>
        </div>

        <form method="GET" action="{{ route('admin.categories.index') }}" class="flex items-center gap-2">
          <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="ক্যাটাগরি খুঁজুন..."
            class="px-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition w-44 sm:w-52"
          >
          <button type="submit" class="px-3 py-1.5 bg-[#0b4622] text-white rounded-xl text-xs font-bold">
            খুঁজুন
          </button>
        </form>
      </div>

      <!-- Table Card -->
      <div class="bg-white rounded-2xl border border-gray-100 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-gray-50/80 border-b border-gray-100 text-[11px] font-black text-gray-500 uppercase tracking-wider">
                <th class="py-3 px-4 text-center w-12">ID</th>
                <th class="py-3 px-4">ক্যাটাগরির নাম</th>
                <th class="py-3 px-4">স্লাগ (Slug)</th>
                <th class="py-3 px-4 text-center">পোস্ট সংখ্যা</th>
                <th class="py-3 px-4 text-center">স্ট্যাটাস</th>
                <th class="py-3 px-4 text-center w-24">অ্যাকশন</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-xs text-gray-700">
              @forelse($categories as $category)
                <tr class="hover:bg-gray-50/70 transition">
                  <td class="py-3 px-4 text-center font-bold text-gray-400">
                    #{{ $category->id }}
                  </td>

                  <!-- Name -->
                  <td class="py-3 px-4 font-bold text-gray-900">
                    {{ $category->name }}
                  </td>

                  <!-- Slug -->
                  <td class="py-3 px-4 font-mono text-[11px] text-gray-500">
                    {{ $category->slug }}
                  </td>

                  <!-- Posts count -->
                  <td class="py-3 px-4 text-center">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-50 text-[#0b4622] font-bold text-[11px]">
                      <i class="ri-article-line"></i>
                      <span>{{ $category->posts_count }} টি</span>
                    </span>
                  </td>

                  <!-- AJAX toggle switch -->
                  <td class="py-3 px-4 text-center">
                    <label class="relative inline-flex items-center cursor-pointer">
                      <input
                        type="checkbox"
                        value="1"
                        {{ $category->status ? 'checked' : '' }}
                        onchange="toggleCategoryStatus({{ $category->id }}, this)"
                        class="sr-only peer"
                      >
                      <div class="w-8 h-4 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[1px] after:left-[1px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-3.5 after:w-3.5 after:transition-all peer-checked:bg-[#0b4622]"></div>
                    </label>
                  </td>

                  <!-- Actions -->
                  <td class="py-3 px-4 text-center">
                    <div class="flex items-center justify-center gap-1.5">
                      <!-- Edit trigger modal/inline button -->
                      <button
                        type="button"
                        onclick="openEditCategoryModal({{ $category->id }}, '{{ addslashes($category->name) }}', '{{ $category->slug }}', {{ $category->status ? 'true' : 'false' }})"
                        class="w-7 h-7 rounded-lg bg-emerald-50 hover:bg-[#0b4622] text-[#0b4622] hover:text-white flex items-center justify-center transition cursor-pointer"
                        title="সম্পাদনা"
                      >
                        <i class="ri-edit-line text-xs"></i>
                      </button>

                      <form
                        action="{{ route('admin.categories.destroy', $category->id) }}"
                        method="POST"
                        onsubmit="return confirm('আপনি কি নিশ্চিত যে এই ক্যাটাগরিটি মুছে ফেলতে চান?');"
                        class="inline"
                      >
                        @csrf
                        @method('DELETE')
                        <button
                          type="submit"
                          class="w-7 h-7 rounded-lg bg-red-50 hover:bg-[#c8102e] text-[#c8102e] hover:text-white flex items-center justify-center transition cursor-pointer"
                          title="মুছে ফেলুন"
                        >
                          <i class="ri-delete-bin-line text-xs"></i>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="py-10 text-center text-gray-400">
                    <i class="ri-price-tag-3-line text-3xl block mb-2 text-gray-300"></i>
                    কোনো ক্যাটাগরি পাওয়া যায়নি।
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        @if($categories->hasPages())
          <div class="p-4 border-t border-gray-100 flex justify-center">
            {{ $categories->links() }}
          </div>
        @endif
      </div>

    </div>

  </div>

</div>

<!-- Edit Category Modal -->
<div id="edit-category-modal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs hidden items-center justify-center p-4">
  <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl space-y-4">
    <div class="flex items-center justify-between pb-3 border-b border-gray-100">
      <h3 class="text-sm font-black text-gray-900 flex items-center gap-1.5">
        <i class="ri-edit-line text-[#0b4622]"></i>
        <span>ক্যাটাগরি সম্পাদনা করুন</span>
      </h3>
      <button type="button" onclick="closeEditCategoryModal()" class="text-gray-400 hover:text-gray-700">
        <i class="ri-close-line text-xl"></i>
      </button>
    </div>

    <form id="edit-category-form" method="POST" class="space-y-4">
      @csrf
      @method('PUT')

      <div>
        <label for="edit-name" class="block text-xs font-bold text-gray-700 mb-1">
          ক্যাটাগরির নাম <span class="text-[#c8102e]">*</span>
        </label>
        <input
          type="text"
          id="edit-name"
          name="name"
          class="w-full px-3.5 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
          required
        >
      </div>

      <div>
        <label for="edit-slug" class="block text-xs font-bold text-gray-700 mb-1">
          স্লাগ (Slug)
        </label>
        <input
          type="text"
          id="edit-slug"
          name="slug"
          class="w-full px-3.5 py-2 text-xs bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-[#0b4622] transition"
        >
      </div>

      <div class="flex items-center justify-between p-3 bg-gray-50 border border-gray-200 rounded-xl">
        <span class="text-xs font-bold text-gray-700">সক্রিয় স্ট্যাটাস</span>
        <label class="relative inline-flex items-center cursor-pointer">
          <input type="checkbox" id="edit-status" name="status" value="1" class="sr-only peer">
          <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#0b4622]"></div>
        </label>
      </div>

      <div class="flex items-center justify-end gap-2.5 pt-2">
        <button
          type="button"
          onclick="closeEditCategoryModal()"
          class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition"
        >
          বাতিল
        </button>
        <button
          type="submit"
          class="px-5 py-2 bg-[#0b4622] hover:bg-[#08351a] text-white text-xs font-bold rounded-xl shadow-xs transition"
        >
          আপডেট করুন
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function toggleCategoryStatus(id, checkbox) {
  fetch(`/admin/categories/${id}/status`, {
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

function openEditCategoryModal(id, name, slug, status) {
  const modal = document.getElementById('edit-category-modal');
  const form = document.getElementById('edit-category-form');
  form.action = `/admin/categories/${id}`;

  document.getElementById('edit-name').value = name;
  document.getElementById('edit-slug').value = slug;
  document.getElementById('edit-status').checked = status;

  modal.classList.remove('hidden');
  modal.classList.add('flex');
}

function closeEditCategoryModal() {
  const modal = document.getElementById('edit-category-modal');
  modal.classList.remove('flex');
  modal.classList.add('hidden');
}
</script>
@endsection

