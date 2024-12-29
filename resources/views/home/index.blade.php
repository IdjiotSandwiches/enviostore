@extends('layout.layout')
@section('title', 'Homepage')

@section('content')
<div id="carousel"></div>
<section class="max-w-screen-xl px-4 py-8 md:mx-auto grid gap-8">
    <div class="grid gap-4">
        <h1 class="text-4xl md:text-5xl text-center font-secondary">{{ __('header.category') }}</h1>
        <div id="bannerContainer"></div>
        <div id="categoryContainer" class="flex flex-shrink-0 overflow-auto gap-8"></div>
    </div>
    <div class="grid gap-4">
        <h1 class="text-4xl md:text-5xl text-center font-secondary">{{ __('header.recommended') }}</h1>
        <div id="productContainer" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"></div>
    </div>
</section>
@endsection

@section('extra-js')
<script>
    const productContainer = document.querySelector('#productContainer');
    const carouselContainer = document.querySelector('#carousel');
    const categoryContainer = document.querySelector('#categoryContainer');
    const bannerContainer = document.querySelector('#bannerContainer');

    function emptyContent() {
        productContainer.replaceChildren();
        carouselContainer.replaceChildren();
        categoryContainer.replaceChildren();
        bannerContainer.replaceChildren();
    }

    function renderCarousel(carouselImg) {
        let carouselGlide = `{!! view('home.component.__carousel')->render() !!}`;
        carouselContainer.insertAdjacentHTML('beforeend', carouselGlide);

        let glideSlides = document.querySelector('.glide_carousel .glide__slides');
        let glideBullets = document.querySelector('.glide_carousel .glide__bullets');

        carouselImg.forEach((value, index) => {
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

        carousel.mount({ Controls, Breakpoints, Swipe, Autoplay });
    }

    function renderSlider(categories) {
        let glideSlider = `{!! view('home.component.__slider')->render() !!}`;
        categoryContainer.insertAdjacentHTML('beforeend', glideSlider);

        let glideSlides = document.querySelector('.glide_slider .glide__slides');

        categories.forEach(category => {
            let slide = `{!! view('home.component.__category-tiles', [
                'route' => '::ROUTE::',
                'image' => '::IMAGE::',
                'name' => '::NAME::',
            ])->render() !!}`;

            slide = slide.replace('::ROUTE::', category.link)
                .replace('::IMAGE::', category.image)
                .replace('::NAME::', category.name);

            glideSlides.insertAdjacentHTML('beforeend', slide);
        });

        const slider = new Glide('.glide_slider', {
            type: 'slider',
            startAt: 0,
            animationDuration: 350,
            perView: 4,
            bound: true,
            rewind: false,
            breakpoints: {
                768: { perView: 3 },
                640: { perView: 2 },
            }
        });

        slider.mount({ Controls, Breakpoints, Swipe });
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

    function renderBanner(banner) {
        let card = `{!! view('home.component.__banner', ['banner' => '::BANNER::'])->render() !!}`;
        card = card.replace('::BANNER::', banner);

        bannerContainer.insertAdjacentHTML('beforeend', card);
    }

    function showSkeleton() {
        for (let i = 0; i < 8; i++) {
            let card = `{!! view('component.__skeleton-card')->render() !!}`;
            productContainer.insertAdjacentHTML('beforeend', card);
        }

        let carouselSkeleton = `{!! view('home.component.__carousel-skeleton')->render() !!}`;
        carouselContainer.insertAdjacentHTML('beforeend', carouselSkeleton);
        bannerContainer.insertAdjacentHTML('beforeend', carouselSkeleton);

        for (let i = 0; i < 4; i++) {
            let card = `{!! view('home.component.__slider-skeleton')->render() !!}`;
            categoryContainer.insertAdjacentHTML('beforeend', card);
        }
    }

    function fetchRequest() {
        let url = '{{ route('getHomeItems') }}';
        emptyContent();

        setTimeout(function () {
            if (checkPlaceholder(productContainer)) return;

            showSkeleton();
        }, 200);

        customFetch(url, {
            method: 'GET',
        }).then(response => {
            emptyContent();
            let data = response.data;
            
            renderProducts(data.products);
            renderCarousel(data.carouselImg);
            renderSlider(data.categories);
            renderBanner(data.banner);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        fetchRequest();
    });
</script>
@endsection
