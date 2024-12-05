@extends('layout.layout')
@section('title', 'Cart')

@section('content')
<section class="max-w-screen-xl px-4 py-8 md:mx-auto grid gap-4">
    <h1 class="font-bold text-3xl">Your Cart</h1>
    <div id="container" class="flex flex-col md:flex-row justify-between gap-4">
        <div id="cartContainer" class="grid gap-4 flex-1"></div>
        <div id="summaryContainer" class="md:w-1/3 lg:w-1/4"></div>
    </div>
</section>
@endsection

@section('extra-js')
<script>
    let cartContainer = document.querySelector('#cartContainer');
    let summaryContainer = document.querySelector('#summaryContainer');
    
    function fetchRequest(url) {
        emptyContent();

        setTimeout(function() {
            if(cartContainer.textContent !== '' && summaryContainer.textContent !== '') return;

            for (let i = 0; i < 8; i++) {
                let item = `{!! view('cart.component.__skeleton-item')->render() !!}`;
                cartContainer.insertAdjacentHTML('beforeend', item);
            }

            let item = `{!! view('cart.component.__skeleton-summary')->render() !!}`;
            summaryContainer.insertAdjacentHTML('beforeend', item);
        },200);

        customFetch(url, {
            method: 'GET',
        }).then(response => {
            if(!response.ok) {
                throw new Error(response.status);
            }

            emptyContent();
            return response.json();
        }).then(response => {
            replaceContent(response);
        }).catch(error => {
            console.log(error)
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
                .replaceAll('::NAME::', item.product_name)
                .replace('::PRICE::', item.price)
                .replace('::QUANTITY::', item.quantity)
                .replace('::CATEGORY::', item.category_name)
                .replace('::DELETE::', item.delete);
            
            cartContainer.insertAdjacentHTML('beforeend', card);
        });

        let summary = response.data.summary;
        let card = `{!! view('cart.component.__summary-card', [
            'price' => '::PRICE::',
            'quantity' => '::QUANTITY::',
        ])->render() !!}`;

        card = card.replace('::PRICE::', summary.price ?? '-')
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