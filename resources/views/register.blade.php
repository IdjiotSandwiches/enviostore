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
            <input type="text" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="username" required />
        </div>
        <div>
            <label for="phone_number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone Number</label>
            <input type="tel" name="phone_number" id="phone-number" minlength="8" maxlength="12" pattern="[0-9]{8,12}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="0123456789" required />
        </div>
        <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="user@email.com" required />
        </div>
        <div>
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
            <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
        </div>
        <div>
            <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password Confirmation</label>
            <input type="password" name="password_confirmation" id="password-confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
        </div>
        <div class="flex items-center mb-4">
            <input id="checkbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label for="checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                Agree to the <a href="#" class="underline">terms and condition</a>
            </label>
        </div>
        <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Sign Up</button>
        <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
            Already have an account? <a href="{{ route('login') }}" class="text-blue-700 hover:underline dark:text-blue-500">Login</a>
        </div>
    </form>
</div>
@endsection
