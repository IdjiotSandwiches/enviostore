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
                @foreach ($shippings as $shipping)
                    @include('checkout.component.__radio-btn', ['radioItem' => $shipping, 'icon' => 'checkout.component.__jne-icon', 'name' => 'shippings'])
                @endforeach
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