@extends('layout.layout')
@section('title', __('title.cart'))

@section('content')
<section class="max-w-screen-xl px-4 py-8 md:mx-auto grid gap-4">
    <h1 class="font-bold text-3xl">{{ __('header.cart') }}</h1>
    <div id="container" class="flex flex-col lg:flex-row justify-between gap-4">
        <div id="cartContainer" class="grid gap-4 flex-1"></div>
        <div id="summaryContainer" class="lg:w-1/3 xl:w-1/4"></div>
    </div>
</section>
@endsection

@section('extra-js')
@include('component.js.__card-replace-summary')
<script>
    const cartContainer = document.querySelector('#cartContainer');
    const summaryContainer = document.querySelector('#summaryContainer');
    
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
        let card = `{!! view('cart.component.__summary-card', [
            'subtotal' => '::SUBTOTAL::',
            'quantity' => '::QUANTITY::',
        ])->render() !!}`;

        card = card.replace('::SUBTOTAL::', summary.subtotal ?? '-')
            .replace('::QUANTITY::', summary.quantity ?? '-');
        
        summaryContainer.insertAdjacentHTML('beforeend', card);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const URL = '{{ route('cart.getCartItems') }}';
        fetchRequest(URL);
    });
</script>
@endsection