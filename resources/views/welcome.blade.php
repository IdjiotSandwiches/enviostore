@extends('layout.layout')
@section('title', 'Welcome')

@section('content')
<div class="flex justify-center items-center h-screen">
    @include('component.product-card')
</div>
@endsection
