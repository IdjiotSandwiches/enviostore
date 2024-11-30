@extends('layout.layout')
@section('title', 'Cart')

@section('content')
<section class="max-w-screen-xl px-4 py-8 md:mx-auto grid gap-4">
    <h1 class="font-bold text-3xl">Your Cart</h1>
    <div>
        @include('component.skeleton-item')
    </div>
</section>
@endsection