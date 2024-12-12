<div class="grid grid-cols-2 text-center md:flex md:justify-center md:items-center gap-2">
    <a href="{{ route('login') }}"
        class="text-white bg-button hover:bg-button/80 border border-button focus:ring-4 focus:outline-none focus:ring-button/15 font-medium rounded-lg text-md py-2 px-5 text-nowrap">{{ __('login.login') }}</a>
    <a href="{{ route('register') }}"
        class="py-2 px-5 text-md font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-button hover:bg-background hover:text-button focus:z-10 focus:ring-4 focus:ring-button/15 text-nowrap">{{ __('register.register') }}</a>
</div>