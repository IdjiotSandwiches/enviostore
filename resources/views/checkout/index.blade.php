@extends('layout.layout')
@section('title', 'Checkout')

@section('content')
<section class="max-w-screen-xl px-4 py-8 md:mx-auto grid gap-4">
    <h1 class="font-bold text-3xl">Checkout</h1>
    <form action="" method="POST" class="flex flex-col md:flex-row justify-between gap-4">
        @csrf
        @method('POST')
        <section class="grid gap-4 flex-1">
            <div id="cartContainer" class="grid gap-4 flex-1">
                @include('component.__skeleton-item')
            </div>
            <div class="grid gap-4">
                <h1 class="font-bold text-3xl">Shipping</h1>
                <div class="flex items-center ps-4 bg-primary rounded px-4">
                    <input checked id="bordered-radio-1" type="radio" value="" name="bordered-radio"
                        class="w-4 h-4 text-black bg-gray-100 border-black focus:ring-black">
                    <label for="bordered-radio-1"
                        class="flex items-center justify-between w-full py-6 ms-2 text-sm font-medium text-gray-900">
                        <div class="flex items-center gap-4">
                            @include('checkout.component.__jne-icon')
                            <div>
                                <h2 class="text-xl">JNE</h2>
                                <p class="text-sm text-font_secondary">(5-7 Business Days)</p>
                            </div>
                        </div>
                        <div class="text-xl">Rp 3.000</div>
                    </label>
                </div>
            </div>
            <div>
                <h1 class="font-bold text-3xl">Payment</h1>

            </div>
        </section>
        <section class="md:w-1/3 lg:w-1/4">
            @include('component.__skeleton-summary')
        </section>
    </form>
</section>
@endsection