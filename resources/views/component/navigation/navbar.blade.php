<nav class="bg-white border-gray-200 z-20 sticky top-0">
    <div class="max-w-screen-xl flex items-center justify-between mx-auto p-4 gap-2 md:gap-4">
        <a href="{{ session(App\Interfaces\SessionKeyInterface::SESSION_IS_ADMIN) ? route('admin.product.index') : route('home') }}"
            class="flex items-center space-x-3 rtl:space-x-reverse">
            <span class="self-center text-xl md:text-2xl font-semibold whitespace-nowrap italic">EnviroStore</span>
        </a>

        <div class="flex w-full items-center justify-end gap-2 md:gap-4">
            @if (!session(App\Interfaces\SessionKeyInterface::SESSION_IS_ADMIN))
                @include('component.navigation.__search-bar')
                @include('component.navigation.__user-cart')
            @endif

            <div class="hidden md:block">
                @include('component.navigation.auth.__user-auth')
            </div>

            <div class="hidden md:block">
                @include('component.navigation.locale.__toggle')
            </div>

            <div class="md:hidden">
                @include('component.navigation.drawer.__drawer')
            </div>
        </div>
    </div>

    <div class="bg-gray-50 shadow-sm overflow-auto flex justify-between">
        <div class="md:flex justify-between items-center w-full max-w-screen-xl px-4 py-3 mx-auto">
            @include('component.navigation.__sub-menu')
        </div>
    </div>
</nav>
