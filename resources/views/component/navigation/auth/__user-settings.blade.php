@props(['link', 'text', 'icon'])

<div class="py-1">
    <a href="{{ $link }}" @class([
        'flex gap-2 md:items-center md:justify-center px-4 py-2 text-md md:text-sm hover:bg-gray-100 text-gray-700',
        'text-red-500' => $text === __('navigation.logout')
    ])>
        @include($icon)
        {{ $text }}
    </a>
</div>