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
<section class="max-w-screen-xl p-4 mx-auto min-h-screen">
    <section class="md:flex gap-4">
        <div class="glide group w-[30rem]">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
                    @foreach ($imgPaths as $path)
                        <li class="glide__slide">
                            <img src="{{ asset($path) }}" class="h-[30rem] object-cover select-none pointer-events-none rounded-md" alt="...">
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="glide__arrows opacity-0 group-hover:opacity-100 transition-opacity" data-glide-el="controls">
                <button class="glide__arrow glide__arrow--left h-full bg-black/30 border-none shadow-none left-0" data-glide-dir="<">
                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7"/>
                    </svg>
                </button>
                <button class="glide__arrow glide__arrow--right h-full bg-black/30 border-none shadow-none right-0" data-glide-dir=">">
                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
                    </svg>
                </button>
            </div>
            <div class="glide__bullets -bottom-24 w-full gap-4 overflow-y-scroll hidden md:flex" data-glide-el="controls[nav]">
                @foreach ($imgPaths as $key => $value)
                    <img class="glide__bullet h-20 w-20 p-0 m-0 object-cover border-none rounded-md" src="{{ $value }}" data-glide-dir="{{ "={$key}" }}" />
                @endforeach
            </div>
        </div>
        <div>
            <h2>Product</h2>
        </div>
    </section>
</section>
@endsection

@section('extra-js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const options = {
            type: 'carousel',
            startAt: 0,
            animationDuration: 600,
            hoverpause: true,
        };

        new Glide('.glide', options).mount({ Controls, Breakpoints, Swipe });
    });
</script>
@endsection
