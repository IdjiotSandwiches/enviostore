@extends('layout.layout')
@section('title', __('login.login'))

@section('content')
<section class="flex items-center justify-center px-4 py-8">
    <img src="{{ asset('img/login-icon.png') }}" alt="login-icon" class="hidden w-1/2 lg:block">
    <div class="w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8">
        <form action="{{ route('attemptLogin') }}" method="POST" class="space-y-4">
            @csrf
            <h5 class="text-3xl text-center font-bold text-gray-900">{{ __('login.login') }}</h5>
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                <input type="email" name="email" id="email" @class([
                    "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5",
                    "border-red-500" => $errors->has('email')
                ]) placeholder="user@email.com" value="{{ old('email') }}" required />
                @error('email')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">{{ __('login.password') }}</label>
                <input type="password" name="password" id="password" @class([
                    "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5",
                    "border-red-500" => $errors->has('password')
                ]) required />
                @error('password')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-start">
                <a href="#" class="text-sm text-font_secondary hover:text-font_primary hover:underline">{{ __('login.lost') }}?</a>
            </div>
            <button type="submit" class="flex w-full justify-center items-center gap-4 text-white bg-button disabled:cursor-not-allowed disabled:bg-button/70 hover:bg-button/80 focus:ring-4 focus:outline-none focus:ring-button/15 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                @include('component.__spinner')
                {{ __('login.login') }}
            </button>
            <div class="text-sm font-medium text-font_primary">
                {{ __('login.not') }}? <a href="{{ route('register') }}" class="text-font_secondary hover:text-font_primary hover:underline">{{ __('login.create') }}</a>
            </div>
        </form>
    </div>
</section>
@endsection
