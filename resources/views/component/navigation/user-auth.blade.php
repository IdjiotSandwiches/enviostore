@if (auth('admin')->check() || auth()->check())
    <div class="flex items-center gap-2" data-dropdown-toggle="userDropdown" data-dropdown-placement="bottom-end">
        <img id="avatarButton" type="button"
            class="block w-10 h-10 rounded-full cursor-pointer border border-gray-400" aria-hidden="true" src="" alt="User dropdown">
        <p class="hidden md:block">{{ auth()->user()->username ?? auth('admin')->user()->username }}</p>
    </div>
    <div id="userDropdown"
        class="hidden z-10 bg-white divide-y divide-gray-200 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600">
        <div class="py-1">
            <a href="#"
                class="flex gap-2 items-center justify-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-width="2"
                        d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                Profile
            </a>
        </div>
        <div class="py-1">
            <a href="{{ route('logout') }}"
                class="flex gap-2 items-center justify-center px-4 py-2 text-sm text-red-500 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-red-500 dark:hover:text-white">
                <svg class="w-6 h-6 text-red-500 dark:text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2" />
                </svg>
                Logout
            </a>
        </div>
    </div>
@else
    <div class="flex justify-center items-center gap-2">
        <a href="{{ route('login') }}"
            class="text-white bg-button hover:bg-button/80 focus:ring-4 focus:outline-none focus:ring-button/15 font-medium rounded-lg text-md px-4 md:px-5 py-1.5 md:py-2 dark:bg-button dark:hover:bg-button/80 dark:focus:ring-button/15 text-nowrap">Login</a>
        <a href="{{ route('register') }}"
            class="hidden md:block py-2 px-5 text-md font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-button hover:bg-background hover:text-button focus:z-10 focus:ring-4 focus:ring-button/15 dark:focus:ring-button/15 dark:bg-background dark:text-button dark:border-button dark:hover:text-white dark:hover:bg-background text-nowrap">Sign
            Up</a>
    </div>
@endif
