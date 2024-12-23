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
@include('component.js.__card-replace-summary')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const URL = '{{ route('cart.getCartItems') }}';
        fetchRequest(URL);

        const shippingButtons = document.querySelectorAll('input[type="radio"][name="shippings"]');
        shippingButtons.forEach(button => {
            button.addEventListener('click', function() {
                let url = '{{ route('cart.getCartItems', ['::SHIPPING_SERIAL::']) }}';
                url = url.replace('::SHIPPING_SERIAL::', this.value);

                fetchRequest(url);
            })
        });
    });
</script>
@endsection