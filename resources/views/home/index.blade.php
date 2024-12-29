@extends('layout.layout')
@section('title', 'Homepage')

@section('content')
<div id="carousel"></div>
<section class="max-w-screen-xl mx-auto">
    <div class="flex justify-center p-9 md:text-2xl sm:text-lg">
        <h1 class="text-5xl font-secondary">
            {{ __('header.category') }}
        </h1>
    </div>
    <div id="bannerContainer" class="flex justify-center pb-9">
        <img class="h-auto max-w-full" src="{{ asset('img/Example Banner.png') }}" alt="image description">
    </div>
    <div class="mx-auto px-4">
        
    </div>
    <div class="flex justify-center p-9">
        <h1 class="text-5xl font-secondary">
            {{ __('header.recommended') }}
        </h1>
    </div>
    <div class="mx-auto px-4 pb-9">
        <div id="productContainer" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3"></div>
    </div>
</section>
@endsection

@section('extra-js')
<script>
    const productContainer = document.querySelector('#productContainer');
    const carouselPlaceholder = document.querySelector('#carousel');

    function emptyContent() {
        productContainer.replaceChildren();
        carouselPlaceholder.replaceChildren();
    }

    function renderCarousel(banners) {
        let carouselGlide = `{!! view('home.component.__carousel')->render() !!}`;
        carouselPlaceholder.insertAdjacentHTML('beforeend', carouselGlide);

        let glideSlides = document.querySelector('.glide__slides');
        let glideBullets = document.querySelector('.glide__bullets');

        banners.forEach((value, index) => {
            let banner = `{!! view('home.component.__carousel-slide', [
                'banner' => '::BANNER::',
            ])->render() !!}`;

            banner = banner.replace('::BANNER::', value);
            glideSlides.insertAdjacentHTML('beforeend', banner);

            let bullet = `{!! view('home.component.__carousel-bullet', [
                'key' => '::KEY::',
            ])->render() !!}`;

            bullet = bullet.replace('::KEY::', index);
            glideBullets.insertAdjacentHTML('beforeend', bullet);
        });

        const carousel = new Glide('.glide_carousel', {
            type: 'carousel',
            startAt: 0,
            autoplay: 3000,
            animationDuration: 1000,
            hoverpause: true,
        });

        carousel.mount({
            Controls,
            Breakpoints,
            Swipe,
            Autoplay
        });
    }

    function renderSlider(categories) {
        const slider = new Glide('.glide_slider', {
            type: 'slider',
            startAt: 0,
            animationDuration: 350,
            perView: 4,
            bound: true,
            rewind: false,
        });

        slider.mount({
            Controls,
            Breakpoints,
            Swipe
        });
    }

    function renderProducts(products) {
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
    }

    function showSkeleton() {
        for (let i = 0; i < 8; i++) {
            let card = `{!! view('component.__skeleton-card')->render() !!}`;
            productContainer.insertAdjacentHTML('beforeend', card);
        }

        let carouselSkeleton = `{!! view('home.component.__carousel-skeleton')->render() !!}`;
        carousel.insertAdjacentHTML('beforeend', carouselSkeleton);
    }

    function fetchRequest() {
        let url = '{{ route('getHomeItems') }}';
        emptyContent();

        setTimeout(function () {
            if (checkPlaceholder(productContainer) && 
            checkPlaceholder(carouselImgPlaceholder) && 
            checkPlaceholder(carouselButtonPlaceholder)) return;

            showSkeleton();
        }, 200);

        customFetch(url, {
            method: 'GET',
        }).then(response => {
            let data = response.data;
            console.log(data);
            emptyContent();

            renderProducts(data.products);
            renderCarousel(data.banners);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        fetchRequest();

       
    });
</script>
@endsection
