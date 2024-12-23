@extends('layout.layout')
@section('title', 'Checkout')

@section('content')
<section class="max-w-screen-xl px-4 py-8 md:mx-auto grid gap-4">
    <h1 class="font-bold text-3xl">Checkout</h1>
    <form action="" method="POST" class="flex flex-col md:flex-row justify-between gap-4">
        @csrf
        @method('POST')
        <section class="grid gap-4 flex-1">
            <div id="cartContainer" class="grid gap-4 flex-1"></div>
            <div class="grid gap-4">
                <h1 class="font-bold text-3xl">{{ __('header.shipping') }}</h1>
                @foreach ($shippings as $shipping)
                    @include('checkout.component.__shipping', ['shipping' => $shipping])
                @endforeach
            </div>
            <div class="grid gap-4">
                <h1 class="font-bold text-3xl">{{ __('header.payment') }}</h1>
                @foreach ($payments as $payment)
                    @include('checkout.component.__payment', ['payment' => $payment])
                @endforeach
            </div>
        </section>
        <section id="summaryContainer" class="md:w-1/3 lg:w-1/4"></section>
    </form>
</section>
@endsection

@section('extra-js')
<script>
    function fetchRequest(url) {
        emptyContent();

        setTimeout(function() {
            if(cartContainer.textContent !== '' && summaryContainer.textContent !== '') return;

            for (let i = 0; i < 3; i++) {
                let item = `{!! view('component.__skeleton-item')->render() !!}`;
                cartContainer.insertAdjacentHTML('beforeend', item);
            }

            let item = `{!! view('component.__skeleton-summary')->render() !!}`;
            summaryContainer.insertAdjacentHTML('beforeend', item);
        },200);

        customFetch(url, {
            method: 'GET',
        }).then(response => {
            if(!response.ok) {
                throw new Error();
            }

            emptyContent();
            return response.json();
        }).then(response => {
            replaceContent(response);
        }).catch(error => {
            let section = document.querySelector('section');
            let item = `{!! view('component.__fetch-failed')->render() !!}`;
            
            section.replaceChildren();
            section.insertAdjacentHTML('beforeend', item);
        });
    }

    function replaceContent(response) {
        emptyContent();
        
        let items = response.data.items;
        if(items.length === 0) {
            let container = document.querySelector('#container');
            container.replaceChildren();

            let item = `{!! view('component.__empty-card')->render() !!}`;
            container.insertAdjacentHTML('beforeend', item);
        }
        items.forEach(item => {
            let card = `{!! view('component.__item-card', [
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
        let card = `{!! view('checkout.component.__summary-card', [
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