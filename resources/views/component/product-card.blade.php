@props(['link', 'image', 'name', 'price'])

<div class="max-w-xs bg-white rounded-lg dark:bg-gray-800 dark:border-gray-700">
    <a href="{{ $link }}">
        <div>
            <img class="rounded-t-lg aspect-square object-contain" src="{{ $img }}" alt="{{ $name }}" />
        </div>
        <div class="p-5 flex flex-col gap-2">
            <div>
                <h5 class="text-xl font-bold text-font_primary dark:text-white">{{ $name }}</h5>
            </div>
            <p class="text-xl font-bold text-font_primary dark:text-gray-400">Rp {{ $price }}</p>
        </div>
    </a>
</div>
