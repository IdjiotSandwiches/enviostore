@extends('layout.layout')
@section('title', 'Checkout')

@section('content')
<section class="max-w-screen-xl px-4 py-8 md:mx-auto" id="container">
    <form id="payment-form" method="POST" action="{{ route('checkout.createOrder') }}" class="grid gap-4">
        @csrf
        @method('POST')
        <h1 class="font-bold text-3xl">Checkout</h1>
        <div class="flex flex-col lg:flex-row justify-between gap-4">
            <section class="grid gap-4 flex-1">
                <div id="cartContainer" class="grid gap-4 flex-1"></div>
                <div id="addressContainer" class="grid gap-4"></div>
                <div id="shippingContainer" class="grid gap-4"></div>
            </section>
            <section id="summaryContainer" class="lg:w-1/3 xl:w-1/4"></section>
        </div>
    </form>
</section>
@endsection

@section('extra-js')
@include('component.js.__card-replace-summary')
<script>
    const cartContainer = document.querySelector('#cartContainer');
    const summaryContainer = document.querySelector('#summaryContainer');
    const shippingContainer = document.querySelector('#shippingContainer');
    const addressContainer = document.querySelector('#addressContainer');
    const shippings = {!! $shippings !!};
    let totalPrice;

    function radioInputListener() {
        const shippingButtons = document.querySelectorAll('input[type="radio"][name="shippings"]');
        shippingButtons.forEach(button => {
            button.addEventListener('click', function () {
                let shipping = document.querySelector('#shipping-fee');
                shippingFee = shippings.find(s => s.shipping_serial_code === this.value)['fee'];
                shipping.textContent = shippingFee;

                let total = document.querySelector('#total');
                let totalNum = totalPrice + parseFloat(shippingFee.replaceAll('.', ''));
                total.textContent = totalNum.toLocaleString('id-ID');
            });
        });
    }

    function replaceContent(response) {
        emptyContent();
        
        let items = response.data.items;
        let summary = response.data.summary;
        if(items.length === 0) {
            renderEmptyCart();
            return;
        }
        
        insertCard(items);
        insertSummary(summary);
        insertAddress();
        insertShippingRadio();
        radioInputListener();
    }

    function insertAddress() {
        let card = `{!! view('checkout.component.__address', ['address' => $address])->render() !!}`;
        addressContainer.insertAdjacentHTML('beforeend', card);
    }

    function insertSummary(summary) {
        let card = `{!! view('checkout.component.__summary-card', [
            'subtotal' => '::SUBTOTAL::',
            'quantity' => '::QUANTITY::',
            'transaction' => '::TRANSACTION::',
            'shipping' => '::SHIPPING::',
            'total' => '::TOTAL::'
        ])->render() !!}`;

        card = card.replace('::SUBTOTAL::', summary.subtotal ?? '-')
            .replace('::QUANTITY::', summary.quantity ?? '-')
            .replace('::TRANSACTION::', summary.adminFee ?? '-')
            .replace('::SHIPPING::', summary.shippingFee ?? '-')
            .replace('::TOTAL::', summary.total ?? '-');

        card = card.replace('::SUBTOTAL::', summary.subtotal ?? '-')
            .replace('::QUANTITY::', summary.quantity ?? '-');
        
        summaryContainer.insertAdjacentHTML('beforeend', card);
        totalPrice = parseFloat(summary.total.replaceAll('.', ''));
    }

    function insertShippingRadio() {
        let card = `{!! view('checkout.component.__shipping', ['shippings' => $shippings])->render() !!}`;
        shippingContainer.insertAdjacentHTML('beforeend', card);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const URL = '{{ route('cart.getCartItems') }}';
        fetchRequest(URL);
    });
</script>
@endsection