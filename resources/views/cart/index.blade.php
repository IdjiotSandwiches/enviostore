@extends('layout.layout')
@section('title', __('title.cart'))

@section('content')
<section class="max-w-screen-xl px-4 py-8 md:mx-auto grid gap-4">
    <h1 class="font-bold text-3xl">{{ __('header.cart') }}</h1>
    <div id="container" class="flex flex-col md:flex-row justify-between gap-4">
        <div id="cartContainer" class="grid gap-4 flex-1"></div>
        <div id="summaryContainer" class="md:w-1/3 lg:w-1/4"></div>
    </div>
</section>
@endsection

@section('extra-js')
<script>
    const cartContainer = document.querySelector('#cartContainer');
    const summaryContainer = document.querySelector('#summaryContainer');
    
    function fetchRequest(url) {
        emptyContent();

        setTimeout(function() {
            if(checkPlaceholder(cartContainer) && checkPlaceholder(summaryContainer)) return;

            for (let i = 0; i < 8; i++) {
                let item = `{!! view('component.__skeleton-item')->render() !!}`;
                cartContainer.insertAdjacentHTML('beforeend', item);
            }

            let item = `{!! view('component.__skeleton-summary')->render() !!}`;
            summaryContainer.insertAdjacentHTML('beforeend', item);
        },200);

        customFetch(url, {
            method: 'GET',
        }).then(response => {
            emptyContent();
            replaceContent(response);
        });
    }

    function replaceContent(response) {
        emptyContent();
        
        let items = response.data.items;
        if(items.length === 0) {
            let container = document.querySelector('#container');
            container.replaceChildren();

            let item = `{!! view('cart.component.__empty-card')->render() !!}`;
            container.insertAdjacentHTML('beforeend', item);
        }
        items.forEach(item => {
            let card = `{!! view('cart.component.__item-card', [
                'link' => '::LINK::',
                'image' => '::IMAGE::',
                'name' => '::NAME::',
                'price' => '::PRICE::',
                'quantity' => '::QUANTITY::',
                'category' => '::CATEGORY::',
                'delete' => '::DELETE::',
            ])->render() !!}`;

            card = card.replace('::LINK::', item.link)
                .replace('::IMAGE::', item.img)
                .replaceAll('::NAME::', item.productName)
                .replace('::PRICE::', item.price)
                .replace('::QUANTITY::', item.quantity)
                .replace('::CATEGORY::', item.categoryName)
                .replace('::DELETE::', item.delete);
            
            cartContainer.insertAdjacentHTML('beforeend', card);
        });

        let summary = response.data.summary;
        let card = `{!! view('cart.component.__summary-card', [
            'subtotal' => '::SUBTOTAL::',
            'quantity' => '::QUANTITY::',
        ])->render() !!}`;

        card = card.replace('::SUBTOTAL::', summary.subtotal ?? '-')
            .replace('::QUANTITY::', summary.quantity ?? '-');
        
        summaryContainer.insertAdjacentHTML('beforeend', card);
    }

    function emptyContent() {
        cartContainer.replaceChildren();
        summaryContainer.replaceChildren();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const URL = '{{ route('cart.getCartItems') }}';
        fetchRequest(URL);
    });
</script>
@endsection