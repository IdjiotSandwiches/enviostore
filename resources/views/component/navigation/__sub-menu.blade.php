<nav class="bg-gray-50 shadow-sm overflow-auto">
    <div class="max-w-screen-xl px-4 py-3 mx-auto">
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
    </div>
    <form action="{{ route('toggleLanguage', app()->getLocale() === 'en' ? 'id' : 'en') }}" method="GET">
        @csrf
        @method('GET')
        <label class="inline-flex gap-2 items-center mb-5 cursor-pointer">
            <input type="checkbox" onchange="this.form.submit()" value="" class="sr-only peer" {{ app()->getLocale() === 'id' ? 'checked' : '' }}>
            <p class="flex items-center gap-2">
                <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 30" width="5" height="5">
                    <clipPath id="s">
                        <path d="M0,0 v30 h60 v-30 z" />
                    </clipPath>
                    <clipPath id="t">
                        <path d="M30,15 h30 v15 z v15 h-30 z h-30 v-15 z v-15 h30 z" />
                    </clipPath>
                    <g clip-path="url(#s)">
                        <path d="M0,0 v30 h60 v-30 z" fill="#012169" />
                        <path d="M0,0 L60,30 M60,0 L0,30" stroke="#fff" stroke-width="6" />
                        <path d="M0,0 L60,30 M60,0 L0,30" clip-path="url(#t)" stroke="#C8102E" stroke-width="4" />
                        <path d="M30,0 v30 M0,15 h60" stroke="#fff" stroke-width="10" />
                        <path d="M30,0 v30 M0,15 h60" stroke="#C8102E" stroke-width="6" />
                    </g>
                </svg>
                EN
            </p>
            <div
                class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-black/10 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all peer-checked:bg-black">
            </div>
            <p class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                    <path d="M31,8c0-2.209-1.791-4-4-4H5c-2.209,0-4,1.791-4,4v9H31V8Z" fill="#ea3323"></path>
                    <path d="M5,28H27c2.209,0,4-1.791,4-4v-8H1v8c0,2.209,1.791,4,4,4Z" fill="#fff"></path>
                    <path
                        d="M5,28H27c2.209,0,4-1.791,4-4V8c0-2.209-1.791-4-4-4H5c-2.209,0-4,1.791-4,4V24c0,2.209,1.791,4,4,4ZM2,8c0-1.654,1.346-3,3-3H27c1.654,0,3,1.346,3,3V24c0,1.654-1.346,3-3,3H5c-1.654,0-3-1.346-3-3V8Z"
                        opacity=".15"></path>
                    <path
                        d="M27,5H5c-1.657,0-3,1.343-3,3v1c0-1.657,1.343-3,3-3H27c1.657,0,3,1.343,3,3v-1c0-1.657-1.343-3-3-3Z"
                        fill="#fff" opacity=".2"></path>
                </svg>
                ID
            </p>
        </label>
    </form>
</nav>