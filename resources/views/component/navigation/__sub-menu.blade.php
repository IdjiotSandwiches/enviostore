@if (session(App\Interfaces\SessionKeyInterface::SESSION_IS_ADMIN))
<div class="flex items-center">
    <ul class="flex text-nowrap flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm md:text-md">
        <li>
            <a href="#" class="text-gray-900 hover:underline">Products</a>
        </li>
        <li>
            <a href="#" class="text-gray-900 hover:underline">Category</a>
        </li>
    </ul>
</div>
@else
<div class="flex items-center">
    <ul class="flex text-nowrap flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm md:text-md">
        <li>
            <a href="#" class="text-gray-900 hover:underline">Category</a>
        </li>
        <li>
            <a href="#" class="text-gray-900 hover:underline">Products</a>
        </li>
        <li>
            <a href="#" class="text-gray-900 hover:underline">Category 1</a>
        </li>
        <li>
            <a href="#" class="text-gray-900 hover:underline">Category 2</a>
        </li>
    </ul>
</div>
@endif
