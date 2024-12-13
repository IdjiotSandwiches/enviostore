@extends('layout.layout')
@section('title', __('title.register'))

@section('content')
<section class="flex items-center justify-center px-4 py-8">
    <img src="{{ asset('img/register-icon.png') }}" alt="login-icon" class="hidden w-1/2 lg:block">
    <div class="w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8">
        <form action="{{ route('attemptRegister') }}" method="POST" class="space-y-4">
            @csrf
            <h5 class="text-3xl text-center font-bold text-gray-900">{{ __('title.register') }}</h5>
            <div>
                <label for="username" class="block mb-2 text-sm font-medium text-gray-900">{{ __('form.username') }}</label>
                <input type="text" name="username" id="username" @class([
                    "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5",
                    "border-red-500" => $errors->has('username'),
                ]) placeholder="username" value="{{ old('username') }}" required />
                @error('username')
                    <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="phone_number" class="block mb-2 text-sm font-medium text-gray-900">{{ __('form.phone') }}</label>
                <input type="tel" name="phone_number" id="phone-number" minlength="8" maxlength="12" pattern="[0-9]{8,12}" @class([
                    "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5",
                    "border-red-500" => $errors->has('phone_number')
                ]) placeholder="0123456789" value="{{ old('phone_number') }}" required />
                @error('phone_number')
                    <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                <input type="email" name="email" id="email" @class([
                    "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5",
                    "border-red-500" => $errors->has('email')
                ]) placeholder="user@email.com" value="{{ old('email') }}" required />
                @error('email')
                    <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">{{ __('form.password') }}</label>
                <input type="password" name="password" id="password" @class([
                    "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5",
                    "border-red-500" => $errors->has('password')
                ]) required />
                @error('password')
                    <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">{{ __('form.confirmation') }}</label>
                <input type="password" name="password_confirmation" id="password-confirmation" @class([
                    "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5",
                    "border-red-500" => $errors->has('password_confirmation')
                ]) required />
                @error('password_confirmation')
                    <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <div class="flex items-center">
                    <input id="checkbox" type="checkbox" name="terms_and_condition" class="w-4 h-4 text-button bg-gray-100 border-gray-300 rounded focus:ring-button/15" required />
                    <label for="checkbox" class="ms-2 text-sm font-medium text-font_primary">
                        {{ __('form.agree') }} <a href="#" class="text-font_secondary lowercase hover:text-font_primary hover:underline">{{ __('footer.legal.terms') }}</a>
                    </label>
                </div>
                @error('terms_and_condition')
                    <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="flex w-full justify-center items-center gap-4 text-white bg-button disabled:cursor-not-allowed disabled:bg-button/70 hover:bg-button/80 focus:ring-4 focus:outline-none focus:ring-button/15 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                @include('component.__spinner')
                {{ __('title.register') }}
            </button>
            <div class="text-sm font-medium text-font_primary">
                {{ __('form.have') }}? <a href="{{ route('login') }}" class="text-font_secondary hover:text-font_primary hover:underline">{{ __('title.login') }}</a>
            </div>
        </form>
    </div>
</section>
@endsection
