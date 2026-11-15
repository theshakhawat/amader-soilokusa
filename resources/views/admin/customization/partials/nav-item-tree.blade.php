<li class="dd-item" data-id="{{ $item->id }}">
    <div class="dd-content flex items-center justify-between p-3 my-1.5 bg-white border border-gray-200 rounded-xl hover:border-gray-300 transition shadow-2xs">
        <!-- Drag Handle Area (Left) -->
        <div class="dd-handle flex items-center gap-2 cursor-grab active:cursor-grabbing flex-1 select-none py-1">
            <i class="ri-drag-move-2-line text-gray-400 text-sm"></i>
            @if($item->icon)
                <i class="{{ $item->icon }} text-[#0b4622]"></i>
            @endif
            <span class="text-sm font-bold text-gray-900">{{ $item->title }}</span>
            <span class="text-[11px] font-mono text-gray-500 bg-gray-100 px-2 py-0.5 rounded">{{ $item->url }}</span>
        </div>

        <!-- Action Controls Area (Right - Not draggable) -->
        <div class="dd-nodrag flex items-center gap-2.5 shrink-0 pl-3">
            <!-- Status Toggle Switch -->
            <label class="relative inline-flex items-center cursor-pointer select-none m-0">
                <input type="checkbox" value="1" {{ $item->status ? 'checked' : '' }}
                       id="toggle-input-{{ $item->id }}"
                       onchange="toggleItemStatus({{ $item->id }}, this)"
                       class="sr-only peer">
                <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#0b4622]"></div>
            </label>

            <!-- Edit Button -->
            <button type="button" 
                    onclick="openEditModal({{ $item->id }}, '{{ addslashes($item->title) }}', '{{ addslashes($item->url) }}', '{{ $item->parent_id }}', '{{ $item->icon }}', '{{ $item->target }}', {{ $item->status ? 1 : 0 }})"
                    class="w-7 h-7 rounded-lg bg-emerald-50 hover:bg-[#0b4622] text-[#0b4622] hover:text-white flex items-center justify-center transition cursor-pointer"
                    title="সম্পাদনা করুন">
                <i class="ri-edit-line text-xs"></i>
            </button>

            <!-- Delete Form -->
            <form action="{{ route('admin.customization.navbar.destroy', $item) }}" method="POST"
                  onsubmit="return confirm('এই মেন্যু আইটেমটি এবং এর অধীনস্থ সকল সাবমেন্যু মুছে ফেলতে চান?');" class="inline m-0">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="w-7 h-7 rounded-lg bg-red-50 hover:bg-[#c8102e] text-[#c8102e] hover:text-white flex items-center justify-center transition cursor-pointer"
                        title="মুছে ফেলুন">
                    <i class="ri-delete-bin-line text-xs"></i>
                </button>
            </form>
        </div>
    </div>

    @if($item->children->count() > 0)
        <ol class="dd-list">
            @foreach($item->children as $child)
                @include('admin.customization.partials.nav-item-tree', ['item' => $child])
            @endforeach
        </ol>
    @endif
</li>
