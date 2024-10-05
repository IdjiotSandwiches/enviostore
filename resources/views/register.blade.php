@extends('layout.layout')
@section('title', 'Register')

@section('content')
<section class="flex justify-center items-center">
    <form action="{{ route('attemptRegister') }}" method="POST" class="max-w-screen-md w-full">
        @csrf
        <div class="flex flex-col">
            <label for="name">Name</label>
            <input type="text" name="name" id="name">
            @error('name')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex flex-col">
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
            @error('email')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex flex-col">
            <label for="phone_number">Phone Number</label>
            <input type="tel" name="phone_number" id="phone-number" minlength="8" maxlength="12" pattern="[0-9]{8,12}">
            @error('phone_number')
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
        <div class="flex flex-col">
            <label for="password_confirmation">Password Confirmation</label>
            <input type="password" name="password_confirmation" id="password-confirmation">
            @error('password_confirmation')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <button class="bg-gray-100 py-2 w-full">Register</button>
    </form>
</section>
@endsection
