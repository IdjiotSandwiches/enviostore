<a href="{{ auth('admin')->check() ? route('admin.dashboard') : route('home') }}"
    class="flex items-center space-x-3 rtl:space-x-reverse">
    <span
        class="self-center text-xl md:text-2xl font-semibold whitespace-nowrap dark:text-white italic">EnviroStore</span>
</a>
