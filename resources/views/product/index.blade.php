@extends('layout.layout')
@section('title', ucwords($product->name))

@section('content')
<section class="max-w-screen-xl md:px-4 md:py-8 md:mx-auto">
    <section class="md:grid md:grid-cols-2 gap-4">
        <div class="glide group w-full md:w-80 lg:w-[24rem] xl:w-[30rem] md:h-[26rem] lg:h-[30rem] xl:h-[36rem]">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
                    @foreach ($product->images as $img)
                        <li class="glide__slide">
                            <img src="{{ $img }}"
                                class="w-full h-full aspect-square object-contain select-none pointer-events-none md:rounded-md"
                                alt="...">
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="glide__arrows opacity-0 group-hover:opacity-100 transition-opacity" data-glide-el="controls">
                <button
                    class="glide__arrow glide__arrow--left rounded-none md:rounded-l-md md:top-40 lg:top-48 xl:top-60 h-full sm:h-80 lg:h-[24rem] xl:h-[30rem] bg-black/30 border-none shadow-none left-0"
                    data-glide-dir="<">
                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m15 19-7-7 7-7" />
                    </svg>
                </button>
                <button
                    class="glide__arrow glide__arrow--right rounded-none md:rounded-r-md md:top-40 lg:top-48 xl:top-60 h-full sm:h-80 lg:h-[24rem] xl:h-[30rem] bg-black/30 border-none shadow-none right-0"
                    data-glide-dir=">">
                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m9 5 7 7-7 7" />
                    </svg>
                </button>
            </div>
            <div class="glide__bullets w-full bottom-0 gap-4 overflow-auto hidden md:flex"
                data-glide-el="controls[nav]">
                @foreach ($productImgs as $key => $value)
                    <img class="glide__bullet h-20 w-20 p-0 m-0 object-contain border-none rounded-md" src="{{ $value }}"
                        data-glide-dir="{{ "={$key}" }}" />
                @endforeach
            </div>
        </div>
        <div class="p-4 md:p-0 flex flex-col justify-between">
            <div class="grid gap-4">
                <h2 class="font-bold text-2xl md:text-4xl">{{ $product->name }}</h2>
                <p>212 have brought this product</p>
                <p>25 Reviews</p>
                <h3 class="font-bold text-xl md:text-3xl">Rp {{ $product->price }}</h3>
            </div>
            <form action="{{ route('cart.addToCart') }}" method="POST" class="grid gap-4">
                @csrf
                @method('POST')
                <input type="hidden" id="product_serial" name="product_serial" value="{{ $product->product_serial }}"
                    class="hidden">
                <div class="flex items-end justify-between">
                    <label for="quantity-input"
                        class="block mb-2 text-lg font-medium text-accent">{{ __('page.product.amount') }}:</label>
                    <div class="relative flex items-center max-w-[8rem]">
                        <button type="button" id="decrement-button" data-input-counter-decrement="quantity"
                            class="bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 focus:ring-2 focus:outline-none">
                            <svg class="w-3 h-3 text-gray-900" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 1h16" />
                            </svg>
                        </button>
                        <input type="text" name="quantity" id="quantity" data-input-counter data-input-counter-min="1"
                            data-input-counter-max="{{ $product->stocks }}" aria-describedby="helper-text-explanation"
                            class="bg-gray-50 border-x-0 border-gray-300 h-11 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5"
                            placeholder="{{ $product->stocks }}" value="1" required />
                        <button type="button" id="increment-button" data-input-counter-increment="quantity"
                            class="bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 focus:ring-2 focus:outline-none">
                            <svg class="w-3 h-3 text-gray-900" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M9 1v16M1 9h16" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="text-right block font-medium text-accent">
                    {{ __('page.product.stocks') }}: {{ $product->stocks }}
                </div>
                @if (!$product->stocks)
                    <div class="p-4 mb-4 text-red-800 rounded-lg bg-red-100/80 text-center" role="alert">
                        <span class="font-bold">{{ __('page.product.unavailable') }}</span>
                    </div>
                @else
                    <button type="submit"
                        class="flex items-center justify-center gap-2 text-center py-2 px-5 text-lg font-medium text-white rounded-lg bg-button hover:bg-button/80 focus:ring-4 focus:outline-none focus:ring-button/15">
                        <svg class="w-8 h-8" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
                        </svg>
                        + {{ __('page.product.add') }}
                    </button>
                @endif
            </form>
        </div>
    </section>
    <section class="p-4 md:p-0 md:pt-10">
        <div id="accordion-open" data-accordion="open" data-active-classes="text-font_primary" data-inactive-classes="text-font_primary">
            <h2 id="accordion-open-heading-1" class="bg-primary shadow-sm rounded-t-lg">
                <button type="button"
                        class="flex items-center justify-between w-full p-5 font-bold rtl:text-right text-font_primary border-b border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 gap-3"
                        data-accordion-target="#accordion-open-body-1" aria-expanded="true"
                        aria-controls="accordion-open-body-1">
                    <span>{{ __('page.product.about') }}</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                </button>
            </h2>
            <div id="accordion-open-body-1" class="hidden" aria-labelledby="accordion-open-heading-1">
                <div class="p-5 border border-t-0 rounded-b-xl bg-primary">
                    <p>{{ $product->description }}</p>
                </div>
            </div>
        </div>
    </section>
</section>
@endsection

@section('extra-js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const options = {
            type: 'slider',
            startAt: 0,
            animationDuration: 350,
        };

        new Glide('.glide', options).mount({ Controls, Breakpoints, Swipe });
    });
</script>
@endsection