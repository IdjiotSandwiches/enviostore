@include('component.navigation.responsive-search')

<nav class="bg-white border-gray-200 dark:bg-gray-900 z-20 sticky top-0">
    <div class="max-w-screen-xl flex items-center justify-between mx-auto p-4 gap-2 md:gap-4">
        <!-- Logo -->
        <a href="{{ auth('admin')->check() ? route('admin.dashboard') : route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <span class="self-center text-xl md:text-2xl font-semibold whitespace-nowrap dark:text-white italic">EnviroStore</span>
        </a>
        <!-- Search -->
        <div class="flex md:order-1 w-full md:w-8/12 lg:w-7/12 items-center justify-end md:justify-center gap-2 md:gap-4">
            <!-- Search Icon -->
            <div id="search-icon" class=" md:hidden cursor-pointer select-none">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-gray-900 dark:text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
                <span class="sr-only">Search icon</span>
            </div>
            <!-- Search Bar -->
            <div class="hidden md:block relative md:w-full">
                @include('component.navigation.search-bar')
            </div>
            <!-- Shopping Category -->
            <a href="/" class="">
                <svg class="w-8 h-8 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"/>
                </svg>
            </a>
        </div>
        <div class="items-center justify-between md:flex w-auto md:order-2">
            @if (auth('admin')->check() || auth()->check())
                <img id="avatarButton" type="button" data-dropdown-toggle="userDropdown" data-dropdown-placement="bottom-end" class="block w-10 h-10 rounded-full cursor-pointer" aria-hidden="true" src="/docs/images/people/profile-picture-5.jpg" alt="User dropdown">
                <div id="userDropdown" class="hidden z-10 bg-white divide-y divide-gray-200 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600">
                    <div class="py-1">
                        <a href="#" class="flex gap-2 items-center justify-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                            Profile
                        </a>
                    </div>
                    <div class="py-1">
                        <a href="{{ route('logout') }}" class="flex gap-2 items-center justify-center px-4 py-2 text-sm text-red-500 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-red-500 dark:hover:text-white">
                            <svg class="w-6 h-6 text-red-500 dark:text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2"/>
                            </svg>
                            Logout
                        </a>
                    </div>
                </div>
            @else
                <!-- Login - Register -->
                <div class="flex justify-center items-center gap-2">
                    <a href="{{ route('login') }}" class="text-white bg-button hover:bg-button/80 focus:ring-4 focus:outline-none focus:ring-button/15 font-medium rounded-lg text-md px-4 md:px-5 py-1.5 md:py-2 dark:bg-button dark:hover:bg-button/80 dark:focus:ring-button/15 text-nowrap">Login</a>
                    <a href="{{ route('register') }}" class="hidden md:block py-2 px-5 text-md font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-button hover:bg-background hover:text-button focus:z-10 focus:ring-4 focus:ring-button/15 dark:focus:ring-button/15 dark:bg-background dark:text-button dark:border-button dark:hover:text-white dark:hover:bg-background text-nowrap">Sign Up</a>
                </div>
            @endif
        </div>
    </div>
    @include('component.navigation.sub-nav')
</nav>

