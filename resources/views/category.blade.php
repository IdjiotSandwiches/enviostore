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

        let products = data.data;
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

        let lastPage = data.last_page;
        if(lastPage > 1) {
            let pagination = document.querySelector('#pagination');
            pagination.replaceChildren();

            let item = `{!! view('component.pagination', [
                'totalShown' => '::TOTAL_SHOWN::',
                'totalItem' => '::TOTAL_ITEM::',
            ])->render() !!}`;

            item = item.replace('::TOTAL_SHOWN::', data.to)
                .replace('::TOTAL_ITEM::', data.total);

            pagination.insertAdjacentHTML('beforeend', item);

            let links = data.links;
            let prevNext = [links.at(0), links.at(-1)];
            let buttons = document.querySelectorAll('.button');
            buttons.forEach((value, key) => {
                value.setAttribute('onclick',  `fetchRequest('${prevNext[key].url}')`);
                if(!prevNext[key].url) {
                    value.setAttribute('disabled', true);
                }
                else {
                    value.removeAttribute('disabled');
                }
            });
        }
    }

    function fetchRequest(url) {
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

        let fetchUrl = '{{ route('sortProducts', ['::CATEGORY::', 1]) }}';
        fetchUrl = fetchUrl.replace('::CATEGORY::', '{{ $category->name }}');
        fetchRequest(fetchUrl);

        let buttons = document.querySelectorAll('.button');

        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                fetchRequest(button.getAttribute('href'));
            });
        });

        sort.forEach(item => {
            item.addEventListener('click', function() {
                filterDropdown.textContent = this.textContent;
                let url = '{{ route('sortProducts', ['::CATEGORY::', '::SORT::']) }}';
                url = url.replace('::CATEGORY::', '{{ $category->name }}').replace('::SORT::', item.value);
                fetchRequest(url);
            });
        });
    });
</script>
@endsection
