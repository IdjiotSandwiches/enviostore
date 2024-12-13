@props(['link', 'image', 'name', 'price', 'quantity', 'category', 'delete'])

<div class="w-full h-fit flex bg-white rounded-lg">
    <a href="{{ $link }}" class="flex justify-center items-center rounded-l-lg aspect-square object-contain max-w-[8rem] md:max-w-[10rem]">
        <img class="w-full aspect-square object-contain p-2" src="{{ $image }}" alt="{{ $name }}" />
    </a>
    <div class="p-2 md:p-5 flex flex-col justify-between w-full">
        <div class="flex flex-col gap-2 lg:gap-0">
            <div class="flex flex-col lg:flex-row lg:justify-between flex-1 gap-1 lg:gap-2">
                <a href="{{ $link }}" class="font-bold text-lg md:text-xl">
                    {{ Str::limit($name, 30) }}
                </a>
                <h2 class="font-bold text-lg md:text-xl lg:w-1/3 lg:text-end">Rp {{ $price }}</h2>
            </div>
            <div class="text-sm text-font_secondary">
                <p>{{ __('header.category') }}: {{ $category }}</p>
                <p>{{ __('page.cart.quantity') }}: {{ $quantity }}</p>
            </div>
        </div>
        <div class="flex justify-end">
            <form action="{{ $delete }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">
                    <svg class="w-7 h-7 text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>