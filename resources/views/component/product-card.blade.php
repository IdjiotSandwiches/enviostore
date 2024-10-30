@props(['link', 'image', 'name', 'price'])

<div class="max-w-xs bg-white rounded-lg dark:bg-gray-800 dark:border-gray-700">
    <a href="{{ $link }}">
        <div>
            <img class="rounded-t-lg aspect-square object-contain" src="{{ $image }}" alt="{{ $name }}" />
        </div>
        <div class="p-5 flex flex-col gap-2">
            <div>
                <h5 class="text-xl font-bold text-font_primary dark:text-white">{{ $name }}</h5>
                <p class="text-base text-font_secondary dark:text-gray-400">Nama Penjual</p>
                <p class="text-base text-font_secondary dark:text-gray-400">4.5 | 25 Review</p>
            </div>
            <p class="text-xl font-bold text-font_primary dark:text-gray-400">Rp {{ $price }}</p>
        </div>
    </a>
</div>
