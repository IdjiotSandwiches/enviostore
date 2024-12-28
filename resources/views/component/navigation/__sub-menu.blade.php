<div class="flex items-center">
    <ul class="flex text-nowrap flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm md:text-md">
        @foreach ($menus as $menu)
            <li>
                <a href="{{ $menu->route }}" class="text-gray-900 hover:underline">{{ $menu->name }}</a>
            </li>
        @endforeach
    </ul>
</div>