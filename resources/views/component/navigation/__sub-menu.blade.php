@if (session(App\Interfaces\SessionKeyInterface::SESSION_IS_ADMIN))
<div class="flex items-center">
    <ul class="flex text-nowrap flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm md:text-md">
        <li>
            <a href="{{ route('admin.product.index') }}" class="text-gray-900 hover:underline">Products</a>
        </li>
        <li>
            <a href="{{ route('admin.categories.index') }}" class="text-gray-900 hover:underline">Categories</a>
        </li>
    </ul>
</div>
@else
<div class="flex items-center">
    <ul class="flex text-nowrap flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm md:text-md">
        @foreach ($menus as $menu)
            <li>
                <a href="{{ $menu->route }}" class="text-gray-900 hover:underline">{{ $menu->name }}</a>
            </li>
        @endforeach
    </ul>
</div>
@endif
