@extends('layout.layout')
@section('title', 'Profile')

@section('content')
<section class="max-w-screen-xl px-4 py-8 mx-auto">
    {{-- Profile Picture and Name --}}
    <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
        <div class="w-36 h-36 md:w-48 md:h-48" id="profile-picture"></div>
        <div class="pt-7 text-center md:text-left md:pt-7">
            <h1 class="text-3xl md:text-5xl font-semibold">{{ $user->username ?? 'User Name' }}</h1>
            <p class="text-lg md:text-xl mt-2">{{ $user->address ?? 'Unknown Address' }}</p>
        </div>
    </div>

    {{-- User Information --}}
    <div class="grid mt-8 gap-6 md:grid-cols-2">
        {{-- User Info Card --}}
        <div class="bg-primary rounded-lg shadow-md p-6 divide-y-2">
            <div class="mb-6">
                <h1 class="text-2xl md:text-3xl font-semibold text-center">User Information</h1>
            </div>
            <div class="grid grid-cols-2 gap-4 py-4">
                <p class="text-lg md:text-xl font-normal text-accent">Name</p>
                <p class="text-lg md:text-xl font-semibold text-right">{{ $user->username ?? 'Not Provided' }}</p>
            </div>
            <div class="grid grid-cols-2 gap-4 py-4">
                <p class="text-lg md:text-xl font-normal text-accent">Address</p>
                <p class="text-lg md:text-xl font-semibold text-right">{{ $user->address ?? 'Unknown Address' }}</p>
            </div>
            <div class="grid grid-cols-2 gap-4 py-4">
                <p class="text-lg md:text-xl font-normal text-accent">Email</p>
                <p class="text-lg md:text-xl font-semibold text-right">{{ $user->email }}</p>
            </div>
            <div class="grid grid-cols-2 gap-4 py-4 mb-24">
                <p class="text-lg md:text-xl font-normal text-accent">Phone Number</p>
                <p class="text-lg md:text-xl font-semibold text-right">{{ $user->phone_number ?? 'Not Provided' }}</p>
            </div>
            <div class="text-center mt-6">
                <a href="#" class="block p-3 bg-button text-primary rounded-xl text-lg md:text-xl font-normal">
                    Change Password
                </a>
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('profile.edit') }}" class="block p-3 border-2 border-button rounded-xl text-button text-lg md:text-xl font-normal">
                    Edit Information
                </a>
            </div>
        </div>

        {{-- Placeholder for Additional Section --}}
        <div class="bg-gray-100 rounded-lg shadow-md p-6 flex items-center justify-center">

        </div>
    </div>
</section>
@endsection

@section('extra-js')
<script>
    const profilePicturePlaceholder = document.querySelector('#profile-picture');

    function fetchRequest() {
        let url = '{{ route('profile.getProfilePicture') }}';

        setTimeout(function() {
            if(profilePicturePlaceholder.textContent !== '') return;

            let card = `{!! view('component.__profile-skeleton')->render() !!}`;
            profilePicturePlaceholder.insertAdjacentHTML('beforeend', card);
        },200);

        customFetch(url, {
            method: 'GET',
        }).then(response => {
            if(!response.ok) {
                throw new Error();
            }

            profilePicturePlaceholder.replaceChildren();
            return response.json();
        }).then(response => {
            replaceProfilePicture(response);
        }).catch(error => {
            let section = document.querySelector('section');
            let item = `{!! view('component.__fetch-failed')->render() !!}`;
            
            section.replaceChildren();
            section.insertAdjacentHTML('beforeend', item);
        });
    }

    function replaceProfilePicture(response) {
        const profilePicture = response.data;
        let card = `{!! view('profile.component.__profile-picture', [
            'profilePicture' => '::PROFILE_PICTURE::'
        ])->render() !!}`;

        card = card.replace('::PROFILE_PICTURE::', profilePicture);
        profilePicturePlaceholder.insertAdjacentHTML('beforeend', card);
    }

    document.addEventListener('DOMContentLoaded', function() {
        fetchRequest();
    });
</script>
@endsection