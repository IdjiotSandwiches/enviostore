@props(['link', 'rating', 'image', 'name', 'price'])

<div class="w-full max-w-xs md:max-w-md lg:max-w-xl bg-white border border-gray-200 rounded-lg shadow">
    <a href="{{ $link }}">
        <img class="w-full h-auto rounded-t-lg object-contain aspect-square" src="{{ $image }}" alt="product image" />
    </a>
    <div class="pt-2 px-3 md:px-4 lg:px-5 pb-5">
        <a href="{{ $link }}">
            <h5 class="text-lg md:text-md lg:text-2xl font-semibold tracking-tight text-font_primary dark:text-white">{{ $name }}</h5>
        </a>
        <a href="{{ $link }}">
            <h5 class="text-sm md:text-sm lg:text-lg font-regular tracking-tight text-font_secondary dark:text-white">EnvioStore</h5>
        </a>
        <div class="flex items-center mt-2.5 mb-2.5">
            <div class="flex items-center space-x-1 rtl:space-x-reverse">
                <svg class="w-5 h-5 md:w-4 md:h-4 text-white stroke-accent" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                </svg>
            </div>
            <span class= "text-lg md:text-lg font-regular pl-2 py-0.75 text-font_secondary">{{ $rating }}</span>
        </div>
        <div class="flex items-center justify-between">
            <span class="text-lg md:text-2xl lg:text-3xl font-bold text-font_primary dark:text-white">Rp. {{ $price }}</span>
        </div>
    </div>
</div>
