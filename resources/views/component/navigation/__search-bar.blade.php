<div id="search-icon" class="cursor-pointer select-none" data-dropdown-toggle="searchBar"
    data-dropdown-offset-skidding="88" data-dropdown-offset-distance="28" data-dropdown-placement="bottom-end">
    <svg class="w-5 h-5 md:w-6 md:h-6 text-gray-900" aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
    </svg>
    <span class="sr-only">Search icon</span>
</div>

<form action="" method="GET" id="searchBar" class="relative hidden z-10 w-56">
    @csrf
    @method('GET')
    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
        </svg>
        <span class="sr-only">Search icon</span>
    </div>
    <input type="text" id="search-navbar"
        class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-400 rounded-lg bg-gray-50 focus:ring-button/20 focus:border-button/20"
        placeholder="Search...">
</form>
