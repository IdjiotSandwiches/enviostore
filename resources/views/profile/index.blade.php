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
                <a href="{{ route('profile.changePassword') }}"
                    class="text-sm text-white text-center bg-button hover:bg-button/80 focus:ring-4 focus:outline-none focus:ring-button/15 font-medium rounded-lg px-4 md:px-5 py-1.5 md:py-2 text-nowrap">
                    {{ __('page.profile.change_password') }}
                </a>
            </div>
        </div>

        <div class="bg-primary border border-gray-200 rounded-lg shadow p-4">
            <h1 class="text-3xl font-semibold text-center h-fit pb-4">Orders</h1>
            <div class="mb-4 border-b border-gray-200" data-tabs-toggle="#default-styled-tab-content"
                data-tabs-active-classes="text-font_primary hover:text-font_primary border-font_primary"
                data-tabs-inactive-classes="text-accent/80 hover:text-accent border-gray-100 hover:border-gray-300">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                    data-tabs-toggle="#default-tab-content" role="tablist">
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="pending-tab"
                            data-tabs-target="#pending" type="button" role="tab" aria-controls="pending"
                            aria-selected="false">Pending</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button
                            class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                            id="completed-tab" data-tabs-target="#completed" type="button" role="tab"
                            aria-controls="completed" aria-selected="false">Completed</button>
                    </li>
                    <li role="presentation">
                        <button
                            class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                            id="cancelled-tab" data-tabs-target="#cancelled" type="button" role="tab"
                            aria-controls="cancelled" aria-selected="false">Cancelled</button>
                    </li>
                </ul>
            </div>
            <div id="default-tab-content" class="overflow-y-auto max-h-60">
                <div class="hidden px-4" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                    <div class="grid gap-4">
                        @foreach ($orders->pending as $order)
                            @include('profile.component.__order-item', ['order' => $order])
                        @endforeach
                    </div>
                </div>
                <div class="hidden px-4" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                    <div class="grid gap-4">
                        @foreach ($orders->complete as $order)
                            @include('profile.component.__order-item', ['order' => $order])
                        @endforeach
                    </div>
                </div>
                <div class="hidden px-4" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
                    <div class="grid gap-4">
                        @foreach ($orders->cancel as $order)
                            @include('profile.component.__order-item', ['order' => $order])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('extra-js')
@include('profile.component.__change-profile')
@endsection