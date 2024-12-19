@props(['radioItem', 'icon', 'name'])

<div class="flex items-center ps-4 bg-primary rounded px-4">
    <input checked type="radio" value="" name="{{ $name }}"
        class="w-4 h-4 text-black bg-gray-100 border-black focus:ring-black">
    <label
        class="flex items-center justify-between w-full py-6 ms-2 text-sm font-medium text-gray-900">
        <div class="flex items-center gap-4">
            @include($icon)
            <div>
                <h2 class="text-xl">{{ $radioItem->name }}</h2>
                <p class="text-sm text-font_secondary">(5-7 Business Days)</p>
            </div>
        </div>
        <div class="text-xl">Rp {{ $radioItem->fee }}</div>
    </label>
</div>