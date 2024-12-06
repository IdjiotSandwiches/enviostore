@extends('layout.layout')
@section('title', 'Product')

@section('content')
<section class="max-w-screen-xl px-4 py-8 md:mx-auto grid gap-4">
    <h1 class="font-bold text-3xl">{{ ucfirst($category->name) }}</h1>
    <button id="filterDropdown" data-dropdown-toggle="dropdown" class="flex gap-2 p-2 rounded-lg max-w-[18rem] justify-center items-center bg-primary text-font_primary border border-font_primary" type="button">
        Sort By:
        <span class="font-bold">
            Newest First
        </span>
        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M20 6H10m0 0a2 2 0 1 0-4 0m4 0a2 2 0 1 1-4 0m0 0H4m16 6h-2m0 0a2 2 0 1 0-4 0m4 0a2 2 0 1 1-4 0m0 0H4m16 6H10m0 0a2 2 0 1 0-4 0m4 0a2 2 0 1 1-4 0m0 0H4"/>
        </svg>
    </button>

    <div id="dropdown" class="max-w-xs z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-72 dark:bg-gray-700">
        <ul class="py-2 text-gray-700 dark:text-gray-200" aria-labelledby="filterDropdown">
            <li value="1" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Newest First</li>
            <li value="2" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Lowest Price</li>
            <li value="3" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Highest Price</li>
        </ul>
    </div>

    <div class="grid gap-4">
        <div id="productContainer" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4"></div>
        <div id="pagination" class="flex items-center md:justify-between"></div>
    </div>
</section>
@endsection

@section('extra-js')
<script>
    function replaceProducts(response) {
        let data = response.data;
        let productContainer = document.querySelector('#productContainer');
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
        let productContainer = document.querySelector('#productContainer');
        productContainer.replaceChildren();

        setTimeout(function() {
            if(productContainer.textContent !== '') return;

            for (let i = 0; i < 8; i++) {
                let item = `{!! view('component.__skeleton-card')->render() !!}`;
                productContainer.insertAdjacentHTML('beforeend', item);
            }
        },200);

        customFetch(url, {
            method: 'GET',
        }).then(response => {
            if(!response.ok) {
                throw new Error();
            }

            productContainer.replaceChildren();
            return response.json();
        }).then(response => {
            replaceProducts(response);
        }).catch(error => {
            let section = document.querySelector('section');
            let item = `{!! view('component.__fetch-failed')->render() !!}`;
            
            section.replaceChildren();
            section.insertAdjacentHTML('beforeend', item);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        let sortButtons = document.querySelectorAll('#dropdown ul li');
        let filterDropdown = document.querySelector('#filterDropdown span');

        const URL = '{{ route('sortProducts', ['::CATEGORY::', '::SORT::']) }}';
        let url = URL.replace('::CATEGORY::', '{{ $category->name }}').replace('::SORT::', 1);
        fetchRequest(url);

        sortButtons.forEach(button => {
            button.addEventListener('click', function() {
                filterDropdown.textContent = this.textContent;
                let url = URL.replace('::CATEGORY::', '{{ $category->name }}').replace('::SORT::', this.value);
                fetchRequest(url);
            });
        });
    });
</script>
@endsection
