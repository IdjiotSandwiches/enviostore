@extends('layout.layout')
@section('title', 'Product')

@php
$imgPaths = [
    'img/0.png',
    'img/1.png',
    'img/2.png',
];
@endphp

@section('content')
<section class="max-w-screen-xl md:p-4 md:mx-auto min-h-screen">
    <section class="md:grid md:grid-cols-2 gap-4">
        <div class="glide group w-full md:w-80 lg:w-[30rem] h-80 md:h-[26rem] lg:h-[30rem]">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
                    @foreach ($imgPaths as $path)
                        <li class="glide__slide">
                            <img src="{{ asset($path) }}" class="h-80 lg:h-[24rem] object-cover select-none pointer-events-none md:rounded-md" alt="...">
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="glide__arrows opacity-0 group-hover:opacity-100 transition-opacity" data-glide-el="controls">
                <button class="glide__arrow glide__arrow--left md:top-40 lg:top-48 h-80 lg:h-[24rem] bg-black/30 border-none shadow-none left-0" data-glide-dir="<">
                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7"/>
                    </svg>
                </button>
                <button class="glide__arrow glide__arrow--right md:top-40 lg:top-48 h-80 lg:h-[24rem] bg-black/30 border-none shadow-none right-0" data-glide-dir=">">
                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
                    </svg>
                </button>
            </div>
            <div class="glide__bullets w-full bottom-0 gap-4 overflow-auto hidden md:flex" data-glide-el="controls[nav]">
                @foreach ($imgPaths as $key => $value)
                    <img class="glide__bullet h-20 w-20 p-0 m-0 object-cover border-none rounded-md" src="{{ $value }}" data-glide-dir="{{ "={$key}" }}" />
                @endforeach
            </div>
        </div>
        <div class="p-4 md:p-0 flex flex-col justify-between">
            <div class="grid gap-4">
                <h2 class="font-bold text-2xl md:text-4xl">Product Eco Friendly</h2>
                <h3 class="font-bold text-xl md:text-3xl">Rp 5.000</h3>
            </div>
            <div class="grid gap-4">
                <div class="flex items-center justify-between">
                    <label for="quantity-input" class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">Amount:</label>
                    <div class="relative flex items-center max-w-[8rem]">
                        <button type="button" id="decrement-button" data-input-counter-decrement="quantity-input" class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                            <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                            </svg>
                        </button>
                        <input type="text" id="quantity-input" data-input-counter data-input-counter-min="1" data-input-counter-max="50" aria-describedby="helper-text-explanation" class="bg-gray-50 border-x-0 border-gray-300 h-11 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="999" value="1" required />
                        <button type="button" id="increment-button" data-input-counter-increment="quantity-input" class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                            <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="grid gap-4">
                    <a href="#" class="text-center py-2 px-5 text-lg font-medium text-gray-900 focus:outline-none rounded-lg border border-button hover:bg-accent/10 hover:text-button focus:z-10 focus:ring-4 focus:ring-button/15 dark:focus:ring-button/15 dark:text-button dark:border-button dark:hover:text-white dark:hover:bg-accent/10 text-nowrap">+ Add to Cart</a>
                    <a href="#" class="text-white text-center bg-button hover:bg-button/80 focus:ring-4 focus:outline-none focus:ring-button/15 font-medium rounded-lg text-lg px-4 md:px-5 py-1.5 md:py-2 dark:bg-button dark:hover:bg-button/80 dark:focus:ring-button/15 text-nowrap">Buy</a>
                </div>
            </div>
        </div>
    </section>
    <section>

    </section>
</section>
@endsection

@section('extra-js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const options = {
            type: 'carousel',
            startAt: 0,
            animationDuration: 500,
        };

        new Glide('.glide', options).mount({ Controls, Breakpoints, Swipe });
    });
</script>
@endsection
