@extends('layout.layout')
@section('title', 'Welcome')
@php
$imagePaths=[
    '/img/0.png',
    '/img/1.png',
    '/img/2.png',
    '/img/3.png',
    '/img/4.png',
];
@endphp

@section('content')
@include('component.carousel', ['imgPaths' => $imagePaths])
<div class="flex justify-center p-9">
    <h1 class="text-5xl font-secondary">
        Category 
    </h1>
</div>
<div class="container mx-auto px-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
        @include('component.tiles')
        @include('component.tiles')
        @include('component.tiles')
        @include('component.tiles')
    </div>
</div>
<div class="flex justify-center p-9">
    <h1 class="text-5xl font-secondary">
        Recommended Products 
    </h1>
</div>
<div class="container mx-auto px-4 pb-9">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
        @include('component.card')
        @include('component.card')
        @include('component.card')
        @include('component.card')
        @include('component.card')
        @include('component.card')
        @include('component.card')
        @include('component.card')
    </div>
</div>
@endsection
