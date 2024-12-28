@extends('layout.layout')
@section('title', __('title.profile'))

@section('content')
<section class="max-w-screen-xl px-4 py-8 mx-auto">
    <div class="flex flex-col items-center gap-4">
        <div class="w-36 h-36" id="profile-picture-placeholder"></div>
        <div class="text-center">
            <h1 class="text-3xl font-semibold">{{ $user->username ?? 'User Name' }}</h1>
            <p class="text-lg mt-2">{{ $user->address }}</p>
        </div>
    </div>
    <div class="grid mt-4 gap-4 md:grid-cols-2">
        <div class="bg-primary grid gap-4 border border-gray-200 rounded-lg shadow p-4">
            <h1 class="text-3xl font-semibold text-center">{{ __('page.profile.user_information') }}</h1>
            <div class="divide-y-[1px]">
                <div class="flex justify-between py-4">
                    <p class="text-sm text-accent w-1/2">{{ __('page.profile.name') }}</p>
                    <p class="font-semibold flex-1 truncate text-right">{{ $user->username ?? '-' }}</p>
                </div>
                <div class="flex justify-between py-4">
                    <p class="text-sm text-accent w-1/2">{{ __('page.profile.address') }}</p>
                    <p class="font-semibold flex-1 truncate text-right">{{ $user->address ?? '-' }}</p>
                </div>
                <div class="flex justify-between py-4">
                    <p class="text-sm text-accent w-1/2">Email</p>
                    <p class="font-semibold flex-1 truncate text-right">{{ $user->email ?? '-' }}</p>
                </div>
                <div class="flex justify-between py-4">
                    <p class="text-sm text-accent w-1/2">{{ __('page.profile.phone_number') }}</p>
                    <p class="font-semibold flex-1 truncate text-right">{{ $user->phone_number ?? '-' }}</p>
                </div>
            </div>
            <div class="grid text-center gap-2">
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center justify-center gap-2 text-center py-2 px-5 text-sm font-medium text-gray-900 focus:outline-none rounded-lg border border-button hover:bg-accent/10 hover:text-button focus:z-10 focus:ring-4 focus:ring-button/15">
                    {{ __('page.profile.edit_information') }}
                </a>
                <a href="#"
                class="text-sm text-white text-center bg-button hover:bg-button/80 focus:ring-4 focus:outline-none focus:ring-button/15 font-medium rounded-lg px-4 md:px-5 py-1.5 md:py-2 text-nowrap">
                    {{ __('page.profile.change_password') }}
                </a>
            </div>
        </div>
    
        {{-- Placeholder for Additional Section --}}
        <div class="bg-gray-100 rounded-lg shadow-sm p-6 flex items-center justify-center">
    
        </div>
    </div>
</section>
@endsection

@section('extra-js')
@include('profile.component.__change-profile')
@endsection