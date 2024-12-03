@props(['link', 'image', 'name', 'price', 'amount', 'category', 'stock'])

<div class="w-full h-fit flex items-center bg-white rounded-lg">
    <div class="flex justify-center items-center rounded-l-lg aspect-square object-contain max-w-[10rem]">
        <img class="w-full" src="{{ asset('img/0.png') }}" alt="" />
    </div>
    <div class="p-5 flex flex-col gap-2 w-full">
        <div class="flex justify-between flex-1 gap-2">
            <a href="{{ $link }}" class="font-bold text-lg">
                {{ Str::limit($name) }}
            </a>
            <h2 class="font-bold text-lg w-1/3 text-end">Rp {{ $price }}</h2>
        </div>
        <div class="text-xs text-font_secondary">
            <p>Category: {{ $category }}</p>
            <p>Stock: {{ $stock }}</p>
        </div>
        <div class="flex justify-end">
            <a href="">
                <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                </svg>
            </a>
            <div class="relative flex items-center max-w-[8rem]">
                <button type="button" id="decrement-button" data-input-counter-decrement="quantity-input"
                    class="bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-2.5 h-8 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                    <svg class="w-2 h-2 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 18 2">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h16" />
                    </svg>
                </button>
                <input type="text" id="quantity-input" data-input-counter data-input-counter-min="1"
                    data-input-counter-max="{{ $stock }}" aria-describedby="helper-text-explanation"
                    class="bg-gray-50 border-x-0 border-gray-300 h-8 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5"
                    placeholder="" value="{{ $amount }}" required />
                <button type="button" id="increment-button" data-input-counter-increment="quantity-input"
                    class="bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-2.5 h-8 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                    <svg class="w-2 h-2 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 1v16M1 9h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>