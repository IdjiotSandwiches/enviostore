@extends('layout.layout')
@section('title', 'Cart')

@section('content')
<section class="max-w-screen-xl px-4 py-8 md:mx-auto grid gap-4">
    <h1 class="font-bold text-3xl">Your Cart</h1>
    <div class="flex flex-col md:flex-row justify-between gap-4">
        <div id="cartContainer" class="grid gap-4 md:w-2/3"></div>
        <div id="summaryContainer" class="md:w-1/3 divide-y bg-white h-fit"></div>
    </div>
</section>
@endsection

@section('extra-js')
<script>
    let cartContainer = document.querySelector('#cartContainer');
    let summaryContainer = document.querySelector('#summaryContainer');
    cartContainer.replaceChildren();
    summaryContainer.replaceChildren();

    document.addEventListener('DOMContentLoaded', function () {
        for (let i = 0; i < 3; i++) {
            let item = `{!! view('component.skeleton-item')->render() !!}`;
            cartContainer.insertAdjacentHTML('beforeend', item);
        }

        let item = `{!! view('component.skeleton-summary')->render() !!}`;
        summaryContainer.insertAdjacentHTML('beforeend', item);
    });
</script>
@endsection