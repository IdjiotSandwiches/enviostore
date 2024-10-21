@extends('layout.layout')
@section('title', 'Welcome')

@section('content')
<div class="container mx-auto px-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
        @include('component.card')
        @include('component.card')
        @include('component.card')
        @include('component.card')
    </div>
</div>
@endsection
