@extends('layout.layout')
@section('title', ucwords($category->name))

@section('content')
<section class="max-w-screen-xl px-4 py-8 md:mx-auto grid gap-4">
    <h1 class="font-bold text-3xl">{{ ucfirst($category->name) }}</h1>
    <button id="filterDropdown" data-dropdown-toggle="filterDropdownItems" class="flex gap-2 p-2 rounded-lg max-w-[18rem] justify-center items-center bg-primary text-font_primary border border-font_primary" type="button">
        {{ __('page.category.sort') }}:
        <span class="font-bold">
            {{ __('page.category.newest') }}
        </span>
        <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M20 6H10m0 0a2 2 0 1 0-4 0m4 0a2 2 0 1 1-4 0m0 0H4m16 6h-2m0 0a2 2 0 1 0-4 0m4 0a2 2 0 1 1-4 0m0 0H4m16 6H10m0 0a2 2 0 1 0-4 0m4 0a2 2 0 1 1-4 0m0 0H4"/>
        </svg>
    </button>

    <div id="filterDropdownItems" class="max-w-xs z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-72  cursor-pointer">
        <ul class="py-2 text-gray-700 " aria-labelledby="filterDropdown">
            <li value="1" class="block px-4 py-2 hover:bg-gray-100">{{ __('page.category.newest') }}</li>
            <li value="2" class="block px-4 py-2 hover:bg-gray-100">{{ __('page.category.lowest') }}</li>
            <li value="3" class="block px-4 py-2 hover:bg-gray-100">{{ __('page.category.highest') }}</li>
        </ul>
    </div>

    <div class="grid gap-4">
        <div id="productContainer" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 md:gap-4"></div>
        <div id="pagination" class="flex items-center md:justify-between"></div>
    </div>
</section>
@endsection

@section('extra-js')
<script>
    const productContainer = document.querySelector('#productContainer');
    
    function replaceProducts(response) {
        let data = response.data;
        productContainer.replaceChildren();

        let products = data.products;
        products.forEach(product => {
            let item = `{!! view('component.__product-card', [
                'link' => '::LINK::',
                'rating' => '::RATING::',
                'image' => '::IMAGE::',
                'name' => '::NAME::',
                'price' => '::PRICE::',
            ])->render() !!}`;

            item = item.replace('::LINK::', product.link)
                .replace('::RATING::', product.rating)
                .replace('::IMAGE::', product.img)
                .replaceAll('::NAME::', product.name)
                .replace('::PRICE::', product.price);

            item = product.isAvailable ? 
                item.replaceAll('::OPACITY::', '')
                    .replace('::HIDDEN::', 'hidden') : 
                item.replaceAll('::OPACITY::', 'opacity-30')
                    .replace('::HIDDEN::', '');

            productContainer.insertAdjacentHTML('beforeend', item);
        });

        if(data.hasPage) {
            let pagination = document.querySelector('#pagination');
            pagination.replaceChildren();

            let item = `{!! view('category.component.__pagination', [
                'firstItem' => '::FIRST_ITEM::',
                'lastItem' => '::LAST_ITEM::',
                'count' => '::COUNT::',
                'total' => '::TOTAL::'
            ])->render() !!}`;

            item = item.replace('::FIRST_ITEM::', data.firstItem)
                .replace('::LAST_ITEM::', data.lastItem)
                .replace('::COUNT::', data.count)
                .replace('::TOTAL::', data.total);

            pagination.insertAdjacentHTML('beforeend', item);

            let prevNext = [data.previousPageUrl, data.nextPageUrl];
            let buttons = document.querySelectorAll('.button');
            buttons.forEach((value, key) => {
                value.addEventListener('click', function() {
                    fetchRequest(prevNext[key]);
                });

                if(!prevNext[key]) value.setAttribute('disabled', true);
                else value.removeAttribute('disabled');
            });
        }
    }

    function fetchRequest(url) {
        productContainer.replaceChildren();

        setTimeout(function() {
            if(checkPlaceholder(productContainer)) return;

            for (let i = 0; i < 8; i++) {
                let item = `{!! view('component.__skeleton-card')->render() !!}`;
                productContainer.insertAdjacentHTML('beforeend', item);
            }
        },200);

        customFetch(url, {
            method: 'GET',
        }).then(response => {
            productContainer.replaceChildren();
            replaceProducts(response);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        let sortButtons = document.querySelectorAll('#filterDropdownItems ul li');
        let filterDropdown = document.querySelector('#filterDropdown span');

        const URL = '{{ route('sortProducts', ['::CATEGORY::', '::SORT::']) }}';
        let url = URL.replace('::CATEGORY::', '{{ $category->category_serial_code }}').replace('::SORT::', 1);
        fetchRequest(url);

        sortButtons.forEach(button => {
            button.addEventListener('click', function() {
                filterDropdown.textContent = this.textContent;
                let url = URL.replace('::CATEGORY::', '{{ $category->category_serial_code }}').replace('::SORT::', this.value);
                fetchRequest(url);
            });
        });
    });
</script>
@endsection
