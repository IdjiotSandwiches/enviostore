<button id="dropdownDefaultButton" data-dropdown-toggle="localeDropdown"
    class="text-black hover:bg-button/10 focus:ring-4 focus:outline-none focus:ring-button/20 font-medium rounded-lg text-sm px-2.5 py-1 text-center inline-flex items-center border border-font_secondary/50"
    type="button">
    @include('component.navigation.locale.__default')
    <svg class="w-2.5 h-2.5 ms-1 md:ms-2 hidden md:block" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
    </svg>
</button>

<div id="localeDropdown" class="z-30 hidden bg-background divide-y divide-gray-100 rounded-lg shadow">
    <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownDefaultButton">
        @include('component.navigation.locale.__locales')
    </ul>
</div>