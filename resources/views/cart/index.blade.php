@extends('layout.layout')
@section('title', __('title.cart'))

@section('content')
<section class="max-w-screen-xl px-4 py-8 md:mx-auto grid gap-4">
    <h1 class="font-bold text-3xl">{{ __('header.cart') }}</h1>
    <div id="container" class="flex flex-col md:flex-row justify-between gap-4">
        <div id="cartContainer" class="grid gap-4 flex-1"></div>
        <div id="summaryContainer" class="md:w-1/3 lg:w-1/4"></div>
    </div>
</section>
@endsection

@section('extra-js')
@include('component.js.__card-replace-summary')
<script>
    function replaceContent(response) {
        emptyContent();
        
        let items = response.data.items;
        if(items.length === 0) {
            renderEmptyCart();
            return;
        }
        
        let summary = response.data.summary;
        
        insertCard(items);
        insertSummary(summary);
    }

    function insertSummary(summary) {
        @if (request()->routeIs('cart.index'))
            let card = `{!! view('cart.component.__summary-card', [
                'subtotal' => '::SUBTOTAL::',
                'quantity' => '::QUANTITY::',
            ])->render() !!}`;

            card = card.replace('::SUBTOTAL::', summary.subtotal ?? '-')
                .replace('::QUANTITY::', summary.quantity ?? '-');
        @else
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

            totalPrice = parseFloat(summary.total.replaceAll('.', ''));
        @endif
        
        summaryContainer.insertAdjacentHTML('beforeend', card);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const URL = '{{ route('cart.getCartItems') }}';
        fetchRequest(URL);
    });
</script>
@endsection