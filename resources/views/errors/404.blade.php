@extends('layout.layout')
@section('title', 'Not Found')

@section('content')
<section class="flex flex-col justify-center items-center gap-4 p-4">
    <img src="{{ asset('/img/404-icon.png') }}" alt="404-icon">
    <h1 class="text-xl md:text-3xl font-bold text-center">{{ __('message.not_found') }}</h1>
    <a href="{{ auth('admin')->check() ? route('admin.dashboard') : route('home') }}" class="text-white bg-button hover:bg-button/80 focus:ring-4 focus:ring-button/15 font-medium rounded-lg text-sm md:text-base px-5 py-2.5 me-2 mb-2 focus:outline-none">{{ __('message.return_home') }}</a>
</section>
@endsection
