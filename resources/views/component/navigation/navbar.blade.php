<nav class="bg-white border-gray-200 dark:bg-gray-900 z-20 sticky top-0">
    <div class="max-w-screen-xl flex items-center justify-between mx-auto p-4 gap-2 md:gap-4">
        @include('component.navigation.logo')

        <div class="flex w-full items-center justify-end gap-2 md:gap-4">
            @if (!session(App\Interfaces\SessionKeyInterface::SESSION_IS_ADMIN))
                @include('component.navigation.search-bar')
                @include('component.navigation.user-cart')
            @endif
            @include('component.navigation.user-auth')
        </div>
    </div>

    @include('component.navigation.sub-menu')
</nav>

