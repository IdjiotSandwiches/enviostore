@extends('layout.layout')
@section('title', 'Product')

@section('content')
<section class="max-w-screen-xl px-4 py-8 md:mx-auto grid gap-4">
    <h1 class="font-bold text-3xl">{{ $categoryName }}</h1>
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
        <div id="productContainer" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($products as $product)
                @include('component.product-card', [
                    'link' => $product->link,
                    'image' => $product->img,
                    'name' => $product->name,
                    'price' => $product->price,
                ])
            @endforeach
        </div>
        <div id="pagination" class="flex items-center md:justify-between">
            <p class="hidden md:block text-sm text-font_secondary">Showing
                <span id="totalShown">{{ $products->count() }}</span> of
                <span id="totalItem">{{ $products->total() }}</span> results</p>
            <div class="flex gap-2">
                <a href="{{ $products->previousPageUrl() }}" id="prev-btn" class="p-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-md border border-button hover:bg-background hover:text-button focus:z-10 focus:ring-4 focus:ring-button/15 dark:focus:ring-button/15 dark:bg-background dark:text-button dark:border-button dark:hover:text-white dark:hover:bg-background text-nowrap">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </a>
                <a href="{{ $products->nextPageUrl() }}" id="next-btn" class="p-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-md border border-button hover:bg-background hover:text-button focus:z-10 focus:ring-4 focus:ring-button/15 dark:focus:ring-button/15 dark:bg-background dark:text-button dark:border-button dark:hover:text-white dark:hover:bg-background text-nowrap">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@section('extra-js')
<script>
    function replaceProducts(response) {
        let productContainer = document.querySelector('#productContainer');
        productContainer.replaceChildren();

        let products = response.data.data;
        products.forEach(product => {
            let item = `{!! view('component.product-card', [
                'link' => '::LINK::',
                'image' => '::IMAGE::',
                'name' => '::NAME::',
                'price' => '::PRICE::',
            ])->render() !!}`

            item = item.replace('::LINK::', product.link)
                .replace('::IMAGE::', product.img)
                .replaceAll('::NAME::', product.name)
                .replace('::PRICE::', product.price);

            productContainer.insertAdjacentHTML('beforeend', item);
        });

        let links = response.data.links;
        let prevBtn = document.querySelector('#prev-btn')
        let nextBtn = document.querySelector('#next-btn')

        prevBtn.setAttribute('href', links.at(0).url);
        nextBtn.setAttribute('href', links.at(-1).url);

        let classReplace = ['pointer-events-none', 'cursor-not-allowed', 'border-font_secondary', 'text-font_secondary'];
        if(links.at(0).url === null) {
            prevBtn.classList.add('pointer-events-none', 'cursor-not-allowed', 'border-font_secondary', 'text-font_secondary');
        }
        else {
            prevBtn.classList.remove('pointer-events-none', 'cursor-not-allowed', 'border-font_secondary', 'text-font_secondary');
        }
        if(links.at(-1).url === null) {
            nextBtn.classList.add('pointer-events-none', 'cursor-not-allowed', 'border-font_secondary', 'text-font_secondary');
        }
        else {
            nextBtn.classList.remove('pointer-events-none', 'cursor-not-allowed', 'border-font_secondary', 'text-font_secondary');
        }
    }

    function fetchRequest(url) {
        console.log(url)
        fetch(url, {
            // Nanti dibikin ke common-js
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
        }).then(response => {
            if(!response.ok) {
                throw new Error('Fetch Error!');
            }

            return response.json();
        }).then(response => {
            console.log(response)
            replaceProducts(response);
        }).catch(error => {
            // Nanti di fix pake toast
            console.log(error);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        let sort = document.querySelectorAll('#dropdown ul li');
        let filterDropdown = document.querySelector('#filterDropdown span');

        document.querySelector('#prev-btn').addEventListener('click', function(e) {
            e.preventDefault();
            fetchRequest(this.getAttribute('href'));
        });

        document.querySelector('#next-btn').addEventListener('click', function(e) {
            e.preventDefault();
            fetchRequest(this.getAttribute('href'));
        });

        sort.forEach(item => {
            item.addEventListener('click', function() {
                filterDropdown.textContent = this.textContent;
                let url = '{{ route('sortProducts', ['::CATEGORY::', '::SORT::']) }}';
                url = url.replace('::CATEGORY::', '{{ strtolower($categoryName) }}').replace('::SORT::', item.value);
                fetchRequest(url);
            });
        });
    });
</script>
@endsection
