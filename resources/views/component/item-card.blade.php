@props(['link', 'image', 'name', 'price', 'quantity', 'category'])

<div class="w-full h-fit flex bg-white rounded-lg">
    <div class="flex justify-center items-center rounded-l-lg aspect-square object-contain max-w-[10rem]">
        <img class="w-full" src="{{ asset($image) }}" alt="{{ $name }}" />
    </div>
    <div class="p-5 flex flex-col justify-between w-full">
        <div class="flex flex-col">
            <div class="flex justify-between flex-1 gap-2">
                <a href="{{ $link }}" class="font-bold text-xl">
                    {{ Str::limit($name) }}
                </a>
                <h2 class="font-bold text-xl w-1/3 text-end">Rp {{ $price }}</h2>
            </div>
            <div class="text-sm text-font_secondary">
                <p>Category: {{ $category }}</p>
                <p>Quantity: {{ $quantity }}</p>
            </div>
        </div>
        <div class="flex justify-end">
            <a href="">
                <svg class="w-7 h-7 text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                </svg>
            </a>
        </div>
    </div>
</div>