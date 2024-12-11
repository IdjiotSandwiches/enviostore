<button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
    class="text-black hover:bg-button/10 focus:ring-4 focus:outline-none focus:ring-button/20 font-medium rounded-lg text-sm px-2.5 py-1 text-center inline-flex items-center"
    type="button">
    @if (\Illuminate\Support\Facades\App::getLocale() === 'id')
        @include('component.navigation.__ID')
    @elseif (\Illuminate\Support\Facades\App::getLocale() === 'en')
        @include('component.navigation.__EN')
    @endif
    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
    </svg>
</button>

<div id="dropdown" class="z-10 hidden bg-background divide-y divide-gray-100 rounded-lg shadow">
    <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownDefaultButton">
        <li class="block px-5 py-2.5 hover:bg-gray-100">
            <a href="{{ route('toggleLanguage', 'id') }}">
                @include('component.navigation.__ID')
            </a>
        </li>
        <li class="block px-5 py-2.5 hover:bg-gray-100">
            <a href="{{ route('toggleLanguage', 'en') }}">
                @include('component.navigation.__EN')
            </a>
        </li>
    </ul>
</div>