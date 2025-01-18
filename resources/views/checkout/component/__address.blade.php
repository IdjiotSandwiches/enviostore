<div class="grid gap-2 ps-4 bg-primary rounded px-4 py-6 shadow-sm">
    <p class=" ms-2">
        <span class="text-font_secondary">{{ __('page.checkout.address') }}</span> <span class="font-semibold">{{ $address ?? '-' }}</span>
    </p>
    @if (!$address)
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 ms-2 text-sm text-font_secondary hover:text-font_primary hover:underline">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
            {{ __('page.checkout.add_address') }}
        </a>
    @endif
</div>