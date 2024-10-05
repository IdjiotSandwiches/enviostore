@extends('layout.layout')
@section('title', 'Login')

@section('content')
<section class="flex justify-center items-center">
    <form action="{{ route('attemptLogin') }}" method="POST" class="max-w-screen-md w-full">
        @csrf
        <div class="flex flex-col">
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
            @error('email')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex flex-col">
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
            @error('password')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <button class="bg-gray-100 py-2 w-full">Login</button>
    </form>
</section>
@endsection
