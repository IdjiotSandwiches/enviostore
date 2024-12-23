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
    document.addEventListener('DOMContentLoaded', function () {
        const URL = '{{ route('cart.getCartItems') }}';
        fetchRequest(URL);
    });
</script>
@endsection