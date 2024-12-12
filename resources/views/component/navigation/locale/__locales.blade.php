<li class="block px-5 py-1 hover:bg-gray-100">
    <a href="{{ route('toggleLanguage', 'id') }}" class="inline-flex items-center gap-2">
        @include('component.navigation.locale.__ID')
    </a>
</li>
<li class="block px-5 py-1 hover:bg-gray-100">
    <a href="{{ route('toggleLanguage', 'en') }}" class="inline-flex items-center gap-2">
        @include('component.navigation.locale.__EN')
    </a>
</li>