@extends('layout.layout')
@section('title', 'Homepage')

@section('content')
@include('home.component.__carousel', ['imgPaths' => $banners])
<div class="max-w-screen-xl mx-auto">
    <div class="flex justify-center p-9 md:text-2xl sm:text-lg">
        <h1 class="text-5xl font-secondary">
            {{ __('header.category') }}
        </h1>
    </div>
    <div class="flex justify-center pb-9">
        <img class="h-auto max-w-full" src="{{ asset('img/Example Banner.png') }}" alt="image description">
    </div>
    <div class="mx-auto px-4">
        @include('home.component.__slider', ['categories' => $categories])
    </div>
    <div class="flex justify-center p-9">
        <h1 class="text-5xl font-secondary">
            {{ __('header.recommended') }}
        </h1>
    </div>
    <div class="mx-auto px-4 pb-9">
        <div id="productContainer" class="grid grid-cols-1 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-4 gap-3">
            @foreach ($products as $product)
                        @include('component.__product-card', [
                    'link' => $product->link,
                    'image' => $product->img,
                    'name' => $product->name,
                    'rating' => $product->rating,
                    'price' => $product->price,
                ])
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const carousel = new Glide('.glide_carousel', {
            type: 'carousel',
            startAt: 0,
            autoplay: 3000,
            animationDuration: 1000,
            hoverpause: true,
        });

        const slider = new Glide('.glide_slider', {
            type: 'slider',
            startAt: 0,
            animationDuration: 350,
            perView: 4,
            bound: true,
            rewind: false,
        });

        carousel.mount({
            Controls,
            Breakpoints,
            Swipe,
            Autoplay
        });
        slider.mount({
            Controls,
            Breakpoints,
            Swipe
        });
    });

    function fetchRequest(url) {
        let productContainer = document.querySelector('#productContainer');
        productContainer.replaceChildren();

        setTimeout(function () {
            if (productContainer.textContent !== '') return;

            for (let i = 0; i < 8; i++) {
                let item = `{!! view('component.__skeleton-card')->render() !!}`;
                productContainer.insertAdjacentHTML('beforeend', item);
            }
        }, 200);

        fetch(url, {
            method: 'GET',
        }).then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            productContainer.replaceChildren();
            return response.json();
        }).then(products => {
            products.forEach(product => {
                let productCard = `
                @include('component.__product-card', [
                    'link' => '${product.link}',
                    'image' => '${product.img}',
                    'name' => '${product.name}',
                    'rating' => ${product . rating},
                    'price' => '${product.price}',
                ])`;
                productContainer.insertAdjacentHTML('beforeend', productCard);
            });
        }).catch(error => {
            let section = document.querySelector('section');
            let item = `{!! view('component.__fetch-failed')->render() !!}`;

            section.replaceChildren();
            section.insertAdjacentHTML('beforeend', item);
        });

        function retryFetch() {
            loadProducts();
        }

        document.addEventListener('DOMContentLoaded', () => {
            loadProducts();
        });
    }
</script>
@endsection