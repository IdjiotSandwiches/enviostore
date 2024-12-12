<div class="flex items-center">
    <button type="button" data-drawer-target="drawer" data-drawer-show="drawer" data-drawer-backdrop="false"
        aria-controls="drawer" aria-controls="drawer">
        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" />
        </svg>
    </button>
</div>

<div id="drawer"
    class="fixed top-0 left-0 z-40 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-primary w-full dark:bg-gray-800"
    tabindex="-1" aria-labelledby="drawer-label">
    <h3 class="uppercase font-semibold">{{ __('settings') }}</h3>
    <button type="button" data-drawer-hide="drawer" aria-controls="drawer"
        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
        </svg>
        <span class="sr-only">Close menu</span>
    </button>
    <div class="grid py-4 overflow-y-auto divide-y">
        @if (session(App\Interfaces\SessionKeyInterface::SESSION_IS_LOGGED_IN))
            <div class="flex items-center gap-4 px-4 py-2">
                <img type="button" class="block w-14 h-14 rounded-full cursor-pointer" aria-hidden="true" src="#"
                    alt="User dropdown">
                <p class="font-semibold">
                    {{ session(App\Interfaces\SessionKeyInterface::SESSION_IDENTITY)->username }}
                </p>
            </div>
            <div>
                @include('component.navigation.auth.__user-settings', ['link' => '#', 'text' => __('navbar.profile'), 'icon' => 'component.navigation.icon.__profile'])
                @include('component.navigation.auth.__user-settings', ['link' => route('logout'), 'text' => __('navbar.logout'), 'icon' => 'component.navigation.icon.__logout'])
            </div>
        @else
            <div class="py-4 px-4">
                @include('component.navigation.__not-auth')
            </div>
        @endif

        <div class="py-4 px-4">
            @include('component.navigation.drawer.__responsive')
        </div>
    </div>
</div>