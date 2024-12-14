<div class="w-full flex flex-col items-center">
    <svg class="w-40 h-40 text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
        fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
            d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
    </svg>
    <h4 class="font-semibold text-2xl">{{ __('message.fetch_error') }}</h4>
    <a href="{{ auth('admin')->check() ? route('admin.dashboard') : route('home') }}"
        class="mt-4 text-white bg-button hover:bg-button/80 focus:ring-4 focus:ring-button/15 font-medium rounded-lg text-sm md:text-base px-5 py-2.5 me-2 mb-2 focus:outline-none">{{ __('message.return_home') }}</a>
</div>