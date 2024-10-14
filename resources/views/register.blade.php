@extends('layout.auth-layout')
@section('title', 'Register')

@section('form')
<img src="{{ asset('img/register-icon.png') }}" alt="login-icon" class="hidden w-1/2 lg:block">
<div class="w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
    <form action="{{ route('attemptRegister') }}" method="POST" class="space-y-4">
        @csrf
        <h5 class="text-3xl text-center font-bold text-gray-900 dark:text-white">Sign Up</h5>
        <div>
            <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
            <input type="text" name="username" id="username" @class([
                "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white",
                "border-red-500" => $errors->has('username'),
            ]) placeholder="username" value="{{ old('username') }}" required />
            @error('username')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="phone_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone Number</label>
            <input type="tel" name="phone_number" id="phone-number" minlength="8" maxlength="12" pattern="[0-9]{8,12}" @class([
                "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white",
                "border-red-500" => $errors->has('phone_number')
            ]) placeholder="0123456789" value="{{ old('phone_number') }}" required />
            @error('phone_number')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
            <input type="email" name="email" id="email" @class([
                "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white",
                "border-red-500" => $errors->has('email')
            ]) placeholder="user@email.com" value="{{ old('email') }}" required />
            @error('email')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
            <input type="password" name="password" id="password" @class([
                "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white",
                "border-red-500" => $errors->has('password')
            ]) required />
            @error('password')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password Confirmation</label>
            <input type="password" name="password_confirmation" id="password-confirmation" @class([
                "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white",
                "border-red-500" => $errors->has('password_confirmation')
            ]) required />
            @error('password_confirmation')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <div class="flex items-center">
                <input id="checkbox" type="checkbox" name="terms_and_condition" class="w-4 h-4 text-button bg-gray-100 border-gray-300 rounded focus:ring-button/15 dark:focus:ring-button dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" required />
                <label for="checkbox" class="ms-2 text-sm font-medium text-font_primary dark:text-font_primary">
                    Agree to the <a href="#" class="text-font_secondary dark:text-font_secondary hover:text-font_primary hover:underline">terms and condition</a>
                </label>
            </div>
            @error('terms_and_condition')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="w-full text-white bg-button hover:bg-button/80 focus:ring-4 focus:outline-none focus:ring-button/15 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-button dark:hover:bg-button/80 dark:focus:ring-button/15">Sign Up</button>
        <div class="text-sm font-medium text-font_primary dark:text-font_primary">
            Already have an account? <a href="{{ route('login') }}" class="text-font_secondary hover:text-font_primary hover:underline dark:text-font_secondary">Login</a>
        </div>
    </form>
</div>
@endsection
