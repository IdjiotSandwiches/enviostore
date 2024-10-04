@props(['itemRoute', 'itemImage', 'itemName', 'itemPrice', 'itemSeller', 'itemRating', 'itemReview'])

<a href="{{ route($itemRoute) }}" class="grid group max-w-xs w-80 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <div>
        <img class="rounded-t-lg w-full h-60 object-contain select-none" src="{{ asset($itemImage) }}" alt="{{ $itemName }}" />
    </div>
    <div
        class="w-full group-hover:bg-gray-100 transition-colors"
        data-twe-ripple-init
        data-twe-ripple-color="rgb(156 163 175)"
    >
        <div class="p-4 border-t">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $itemName }}</h5>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $itemPrice }}</p>
            <p class="font-normal text-gray-700 dark:text-gray-400">{{ $itemSeller }}</p>
            <div class="flex gap-2 items-center">
                <svg class="w-6 h-6 text-yellow-300 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"/>
                </svg>
                <p class="font-normal text-gray-700 dark:text-gray-400 mt-1">{{ "$itemRating | $itemReview Reviews" }}</p>
            </div>
        </div>
    </div>
</a>
