@extends('layout.layout')
@section('title', 'Profile')

@section('content')
<section class="max-w-screen-xl px-4 py-8 mx-auto">
    {{-- Profile Picture and Name --}}
    <div class="flex flex-col items-center gap-4">
        <div class="w-36 h-36" id="profile-picture"></div>
        <div class="text-center">
            <h1 class="text-3xl font-semibold">{{ $user->username ?? 'User Name' }}</h1>
            <p class="text-lg mt-2">{{ $user->address }}</p>
        </div>
    </div>

    {{-- User Information --}}
    <div class="grid mt-8 gap-6 md:grid-cols-2">
        {{-- User Info Card --}}
        <div class="bg-primary grid gap-4 rounded-lg shadow-sm p-4">
            <h1 class="text-2xl font-semibold text-center">{{ __('page.profile.user_information') }}</h1>
            <div class="divide-y-2">
                <div class="flex justify-between py-4">
                    <p class="font-normal text-accent w-1/2">{{ __('page.profile.name') }}</p>
                    <p class="font-semibold flex-1 truncate text-right">{{ $user->username ?? '-' }}</p>
                </div>
                <div class="flex justify-between py-4">
                    <p class="font-normal text-accent w-1/2">{{ __('page.profile.address') }}</p>
                    <p class="font-semibold flex-1 truncate text-right">{{ $user->address ?? '-' }}</p>
                </div>
                <div class="flex justify-between py-4">
                    <p class="font-normal text-accent w-1/2">Email</p>
                    <p class="font-semibold flex-1 truncate text-right">{{ $user->email ?? '-' }}</p>
                </div>
                <div class="flex justify-between py-4">
                    <p class="font-normal text-accent w-1/2">{{ __('page.profile.phone_number') }}</p>
                    <p class="font-semibold flex-1 truncate text-right">{{ $user->phone_number ?? '-' }}</p>
                </div>
            </div>
            <div class="grid text-center gap-4">
                <a href="{{ route('profile.edit') }}" class="text-white text-center bg-button hover:bg-button/80 focus:ring-4 focus:outline-none focus:ring-button/15 font-medium rounded-lg text-lg px-4 md:px-5 py-1.5 md:py-2 text-nowrap">
                    {{ __('page.profile.edit_information') }}
                </a>
                <a href="#" class="flex items-center justify-center gap-2 text-center py-2 px-5 text-lg font-medium text-gray-900 focus:outline-none rounded-lg border border-button hover:bg-accent/10 hover:text-button focus:z-10 focus:ring-4 focus:ring-button/15">
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
<script>
    const profilePicturePlaceholder = document.querySelector('#profile-picture');

    function fetchRequest() {
        let url = '{{ route('profile.getProfilePicture') }}';
        console.log(profilePicturePlaceholder.textContent);

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
            return response.json();
        }).then(response => {
            profilePicturePlaceholder.replaceChildren();
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