@extends('layouts.admin.admin-layout')

@section('title', 'যোগাযোগের বার্তাসমূহ')

@section('content')
<div class="space-y-6">

  <!-- Header / Breadcrumb -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-gray-100 shadow-xs">
    <div>
      <div class="flex items-center gap-2 text-xs font-semibold text-gray-500 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0b4622]">ড্যাশবোর্ড</a>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <span>কন্টেন্ট ও ব্যবস্থাপনা</span>
        <i class="ri-arrow-right-s-line text-gray-400"></i>
        <span class="text-[#0b4622]">যোগাযোগ বার্তা</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-black text-gray-900 flex items-center gap-2.5">
        <span class="w-10 h-10 rounded-xl bg-red-50 text-[#c8102e] flex items-center justify-center text-xl shrink-0">
          <i class="ri-mail-unread-line"></i>
        </span>
        যোগাযোগের বার্তাসমূহ (Contact Messages)
      </h1>
      <p class="text-xs sm:text-sm text-gray-500 mt-1">
        ওয়েবসাইটের কন্টাক্ট ফর্ম থেকে পাঠানো সাধারণ মানুষের প্রশ্ন, পরামর্শ ও বার্তাসমূহ পরিচালনা করুন।
      </p>
    </div>

    <!-- Quick stats -->
    <div class="flex items-center gap-3">
      <div class="px-4 py-2 rounded-xl bg-gray-50 border border-gray-200/80 text-center">
        <span class="text-xs text-gray-500 font-bold block">মোট বার্তা</span>
        <span class="text-base font-black text-gray-900">{{ $totalCount }}</span>
      </div>
      <div class="px-4 py-2 rounded-xl bg-red-50 border border-red-200/80 text-center">
        <span class="text-xs text-[#c8102e] font-bold block">অপঠিত</span>
        <span class="text-base font-black text-[#c8102e]">{{ $unreadCount }}</span>
      </div>
    </div>
  </div>

  @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-2">
      <i class="ri-checkbox-circle-fill text-emerald-600 text-lg"></i>
      {{ session('success') }}
    </div>
  @endif

  <!-- Filters & Search -->
  <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-xs">
    <form action="{{ route('admin.contact-messages.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
      <!-- Search Input -->
      <div class="sm:col-span-2 relative">
        <input
          type="text"
          name="search"
          value="{{ request('search') }}"
          placeholder="প্রেরকের নাম, ইমেইল, মোবাইল বা বিষয় দিয়ে খুঁজুন..."
          class="w-full pl-9 pr-4 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0b4622] text-xs sm:text-sm text-gray-800"
        />
        <i class="ri-search-line absolute left-3 top-2.5 text-gray-400 text-sm"></i>
      </div>

      <!-- Status Filter -->
      <div>
        <select
          name="status"
          onchange="this.form.submit()"
          class="w-full px-3 py-2 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0b4622] text-xs sm:text-sm text-gray-700"
        >
          <option value="">সকল বার্তা</option>
          <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>অপঠিত (Unread)</option>
          <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>পঠিত (Read)</option>
        </select>
      </div>
    </form>
  </div>

  <!-- Messages Table -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse text-xs sm:text-sm">
        <thead>
          <tr class="bg-gray-50/75 border-b border-gray-100 text-gray-600 uppercase text-[11px] font-extrabold tracking-wider">
            <th class="py-3.5 px-4 text-center">স্ট্যাটাস</th>
            <th class="py-3.5 px-4">প্রেরকের নাম ও ইমেইল</th>
            <th class="py-3.5 px-4">মোবাইল</th>
            <th class="py-3.5 px-4">বিষয় ও বার্তা প্রিভিউ</th>
            <th class="py-3.5 px-4">তারিখ ও সময়</th>
            <th class="py-3.5 px-4 text-right">অ্যাকশন</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-gray-700">
          @forelse($messages as $msg)
            <tr class="hover:bg-gray-50/60 transition {{ !$msg->is_read ? 'bg-amber-50/25 font-semibold' : '' }}">
              <!-- Status -->
              <td class="py-3.5 px-4 text-center">
                <button
                  type="button"
                  onclick="toggleMsgRead({{ $msg->id }}, this)"
                  class="cursor-pointer inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-extrabold transition {{ $msg->is_read ? 'bg-gray-100 text-gray-600' : 'bg-red-100 text-[#c8102e]' }}"
                >
                  <span class="w-1.5 h-1.5 rounded-full {{ $msg->is_read ? 'bg-gray-400' : 'bg-red-600 animate-pulse' }}"></span>
                  <span>{{ $msg->is_read ? 'পঠিত' : 'অপঠিত' }}</span>
                </button>
              </td>

              <!-- Name & Email -->
              <td class="py-3.5 px-4 font-bold text-gray-900">
                <div class="flex flex-col">
                  <span class="text-sm font-extrabold text-gray-900">{{ $msg->name }}</span>
                  <a href="mailto:{{ $msg->email }}" class="text-xs text-[#0b4622] hover:underline font-medium mt-0.5">{{ $msg->email }}</a>
                </div>
              </td>

              <!-- Phone -->
              <td class="py-3.5 px-4 text-gray-600 font-medium">
                {{ $msg->phone ?: 'প্রদান করেনি' }}
              </td>

              <!-- Subject & Message -->
              <td class="py-3.5 px-4 max-w-xs sm:max-w-md">
                <div class="flex flex-col">
                  <span class="font-extrabold text-gray-900 line-clamp-1">{{ $msg->subject ?: 'কোনো বিষয় উল্লেখ নেই' }}</span>
                  <span class="text-xs text-gray-500 font-normal line-clamp-2 mt-0.5">{{ $msg->message }}</span>
                </div>
              </td>

              <!-- Date -->
              <td class="py-3.5 px-4 text-gray-500 text-xs whitespace-nowrap">
                <div class="flex flex-col">
                  <span>{{ $msg->created_at->format('d M, Y') }}</span>
                  <span class="text-[10px] text-gray-400">{{ $msg->created_at->format('h:i A') }}</span>
                </div>
              </td>

              <!-- Actions -->
              <td class="py-3.5 px-4 text-right">
                <div class="inline-flex items-center gap-1.5">
                  <a
                    href="{{ route('admin.contact-messages.show', $msg) }}"
                    class="p-2 rounded-lg bg-emerald-50 hover:bg-[#0b4622] hover:text-white text-[#0b4622] transition"
                    title="সম্পূর্ণ বার্তা পড়ুন"
                  >
                    <i class="ri-eye-line text-base"></i>
                  </a>

                  <form action="{{ route('admin.contact-messages.destroy', $msg) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিতভাবে এই বার্তাটি মুছে ফেলতে চান?');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button
                      type="submit"
                      class="p-2 rounded-lg bg-gray-100 hover:bg-red-600 hover:text-white text-red-500 transition cursor-pointer"
                      title="মুছে ফেলুন"
                    >
                      <i class="ri-delete-bin-line text-base"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="py-12 text-center text-gray-400">
                <i class="ri-inbox-line text-4xl block mb-2 text-gray-300"></i>
                বর্তমানে কোনো যোগাযোগ বার্তা পাওয়া যায়নি।
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($messages->hasPages())
      <div class="p-4 border-t border-gray-100">
        {{ $messages->links() }}
      </div>
    @endif
  </div>

</div>

<script>
function toggleMsgRead(msgId, btn) {
  fetch(`/admin/contact-messages/${msgId}/toggle-read`, {
    method: 'PATCH',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    }
  })
  .then(res => res.json())
  .then(data => {
    if(data.success) {
      if(data.is_read) {
        btn.className = "cursor-pointer inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-extrabold transition bg-gray-100 text-gray-600";
        btn.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span><span>পঠিত</span>';
      } else {
        btn.className = "cursor-pointer inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-extrabold transition bg-red-100 text-[#c8102e]";
        btn.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-red-600 animate-pulse"></span><span>অপঠিত</span>';
      }
    }
  })
  .catch(err => {
    console.error(err);
  });
}
</script>
@endsection

