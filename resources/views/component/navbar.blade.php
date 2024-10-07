<div id="search-bar" class="hidden fixed bg-white z-50 h-screen w-screen p-4">
    <div class="flex gap-1 items-center justify-between">
        <div id="back-btn">
            <svg class="w-10 h-10 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 20 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M5 12h10M5 12l4-4m-4 4 4 4"/>
            </svg>
        </div>
        <div class="relative w-full">
            @include('component.search-bar')
        </div>
    </div>
</div>

<nav class="bg-white border-gray-200 dark:bg-gray-900 z-20">
    <div class="max-w-screen-xl flex items-center justify-between mx-auto p-4 gap-4">
        <!-- Logo -->
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <span class="self-center text-xl md:text-2xl font-semibold whitespace-nowrap dark:text-white italic">EnviroStore</span>
        </a>
        <!-- Search -->
        <div class="flex md:order-1 w-full md:w-8/12 lg:w-7/12 items-center justify-end md:justify-center gap-4">
            <!-- Search Icon -->
            <div id="search-icon" class=" md:hidden cursor-pointer select-none">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-gray-900 dark:text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
                <span class="sr-only">Search icon</span>
            </div>

            <!-- Search Bar -->
            <div class="hidden md:block relative md:w-full">
                @include('component.search-bar')
            </div>
            <!-- Shopping Category -->
            <a href="/" class="hidden lg:block">
                <svg class="w-8 h-8 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  copath stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"/>
                </svg>
            </a>
        </div>
        <div class="items-center justify-between md:flex w-auto md:order-2">
            @auth
                <!-- User Icon -->
                <img id="avatarButton" type="button" data-dropdown-toggle="userDropdown" data-dropdown-placement="bottom-start" class="w-10 h-10 rounded-full cursor-pointer" src="/docs/images/people/profile-picture-5.jpg" alt="User dropdown">
                <div id="userDropdown" class="z-10 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600">
                    <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                        <div>Bonnie Green</div>
                        <div class="font-medium truncate">name@flowbite.com</div>
                    </div>
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="avatarButton">
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a>
                        </li>
                    </ul>
                    <div class="py-1">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</a>
                    </div>
                </div>
            @else
                <!-- Login - Register -->
                <div class="flex justify-center items-center gap-2">
                    <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-md px-4 md:px-5 py-1.5 md:py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 text-nowrap">Login</button>
                    <button type="button" class="hidden md:block py-2 px-5 text-md font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 text-nowrap">Sign Up</button>
                </div>
            @endauth
        </div>
    </div>
</nav>
<!-- <nav class="bg-gray-50 dark:bg-gray-700">
    <div class="max-w-screen-xl px-4 py-3 mx-auto">
        <div class="flex items-center">
            <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-md">
                <li>
                    <a href="#" class="text-gray-900 dark:text-white hover:underline">Category</a>
                </li>
                <li>
                    <a href="#" class="text-gray-900 dark:text-white hover:underline">Products</a>
                </li>
                <li>
                    <a href="#" class="text-gray-900 dark:text-white hover:underline">Category 1</a>
                </li>
                <li>
                    <a href="#" class="text-gray-900 dark:text-white hover:underline">Category 2</a>
                </li>
            </ul>
        </div>
    </div>
</nav> -->

@section('extra-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchIcon = document.querySelector('#search-icon');
            const backBtn = document.querySelector('#back-btn');
            const searchBar = document.querySelector('#search-bar');

            searchIcon.addEventListener('click', function() {
                searchBar.classList.toggle('hidden')
            })

            backBtn.addEventListener('click', function() {
                searchBar.classList.toggle('hidden')
            })
        });
    </script>
@endsection

