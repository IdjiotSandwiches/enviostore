@extends('layout.layout')
@section('title', __('title.edit_profile'))

@section('content')
<section class="max-w-screen-xl px-4 py-8 mx-auto">
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="flex flex-col items-center gap-4">
            <div class="w-36 h-36" id="profile-picture-placeholder"></div>
            <label for="profile-picture-input"
                class="cursor-pointer text-white text-center bg-button hover:bg-button/80 focus:ring-4 focus:outline-none focus:ring-button/15 font-medium rounded-lg px-4 md:px-5 py-1.5 md:py-2 text-nowrap">
                {{ __('page.profile.upload_image') }}
            </label>
            <input type="file" name="profile_picture" id="profile-picture-input" accept="image/jpeg, image/png, image/jpg" class="hidden">
            @error('profile_picture')
                <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
            @enderror
        </div>
        <div class="bg-primary rounded-lg shadow border border-gray-200 p-4 sm:p-6 md:p-8 mt-4">
            <div class="space-y-4 grid gap-4">
                <h1 class="text-3xl font-semibold text-center">{{ __('page.profile.edit_information') }}</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                    <div>
                        <label for="username" class="block mb-2 text-sm font-medium text-font_primary">{{ __('page.profile.name') }}</label>
                        <input type="text" name="username" id="username" @class([
                            "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5",
                            "border-red-500" => $errors->has('username'),
                        ]) placeholder="{{ $user->username }}" value="{{ old('username') }}" />
                        @error('username')
                            <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="address" class="block mb-2 text-sm font-medium text-font_primary">{{ __('page.profile.address') }}</label>
                        <input type="text" id="address" name="address" @class([
                            "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5",
                            "border-red-500" => $errors->has('address'),
                        ]) placeholder="{{ $user->address }}" value="{{ old('address') }}" />
                        @error('address')
                            <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                        <input type="email" name="email" id="email" @class([
                            "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5",
                            "border-red-500" => $errors->has('email')
                        ]) placeholder="{{ $user->email }}" value="{{ old('email') }}" />
                        @error('email')
                            <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="phone_number" class="block mb-2 text-sm font-medium text-gray-900">{{ __('page.profile.phone_number') }}</label>
                        <input type="tel" name="phone_number" id="phone-number" minlength="8" maxlength="12" pattern="[0-9]{8,12}" @class([
                            "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5",
                            "border-red-500" => $errors->has('phone_number')
                        ]) placeholder="{{ $user->phone_number }}" value="{{ old('phone_number') }}" />
                        @error('phone_number')
                            <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <button type="submit"
                    class="text-sm text-white text-center bg-button hover:bg-button/80 focus:ring-4 focus:outline-none focus:ring-button/15 font-medium rounded-lg px-4 md:px-5 py-1.5 md:py-2 text-nowrap">
                    Save Changes
                </button>
            </div>
        </div>
    </form>
</section>
@endsection

@section('extra-js')
@include('profile.component.__change-profile')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('#profile-picture-input').addEventListener('change', function(e) {
            let imgUrl = URL.createObjectURL(e.target.files[0]);
            document.querySelector('#profile-picture').src = imgUrl;
        });
    });
</script>
@endsection