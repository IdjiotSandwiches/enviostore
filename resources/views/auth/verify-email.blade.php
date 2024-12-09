@extends('layout.layout')
@section('title', 'Verification')

@section('content')
<section class="max-w-screen-xl p-4 md:px-4 md:py-8 md:mx-auto flex justify-center gap-4">
    <div class="max-w-lg p-4 bg-white shadow rounded-lg sm:p-8 text-center flex flex-col items-center justify-center gap-4">
        <svg class="w-36 h-36 text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
        </svg>
        <h2 class="text-2xl font-bold text-font_primary">{{ __('verification.header') }}</h2>
        <div class="text-font_secondary">
            <p>{{ __('verification.reminder') }}</p>
            <p>{{ __('verification.notify') }}</p>
        </div>
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full text-white bg-button hover:bg-button/80 focus:ring-4 focus:outline-none focus:ring-button/15 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-button dark:hover:bg-button/80 dark:focus:ring-button/15">{{ __('verification.resend') }}</button>
        </form>
        @if (session('message'))
            <div>
                {{ session('message') }}
            </div>
        @endif
    </div>
</section>
@endsection
