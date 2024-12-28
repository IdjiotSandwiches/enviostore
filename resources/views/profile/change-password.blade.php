@extends('layout.layout')
@section('title', __('title.change_password'))

@section('content')
<section class="max-w-screen-xl px-4 py-8 mx-auto">
    <form action="{{ route('profile.attemptChangePassword') }}" method="POST" class="bg-primary rounded-lg shadow border border-gray-200 p-4 sm:p-6 md:p-8 mt-4">
        @csrf
        @method('PUT')
        <div class="space-y-4 grid gap-4">
            <h1 class="text-3xl font-semibold text-center">{{ __('page.profile.change_password') }}</h1>
            <div class="grid gap-4">
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-font_primary">{{ __('page.profile.password') }}</label>
                    <input type="password" name="password" id="password" @class([
                        "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5",
                        "border-red-500" => $errors->has('password'),
                    ]) />
                    @error('password')
                        <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block mb-2 text-sm font-medium text-font_primary">{{ __('page.profile.password_confirmation') }}</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" @class([
                        "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5",
                        "border-red-500" => $errors->has('password_confirmation'),
                    ]) />
                    @error('password_confirmation')
                        <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="old_password" class="block mb-2 text-sm font-medium text-font_primary">{{ __('page.profile.old_password') }}</label>
                    <input type="password" id="old_password" name="old_password" @class([
                        "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5",
                        "border-red-500" => $errors->has('old_password'),
                    ]) />
                    @error('old_password')
                        <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <button type="submit"
                class="text-sm text-white text-center bg-button hover:bg-button/80 focus:ring-4 focus:outline-none focus:ring-button/15 font-medium rounded-lg px-4 md:px-5 py-1.5 md:py-2 text-nowrap">
                {{ __('page.profile.change_password') }}
            </button>
        </div>
    </form>
</section>
@endsection