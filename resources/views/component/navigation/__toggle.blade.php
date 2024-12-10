<form action="{{ route('toggleLanguage', app()->getLocale() === 'en' ? 'id' : 'en') }}" method="GET" class="flex">
    @csrf
    @method('GET')
    <label class="inline-flex gap-2 items-center cursor-pointer">
        <input type="checkbox" onchange="this.form.submit()" class="sr-only peer" {{ app()->getLocale() === 'id' ? 'checked' : '' }}>
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
            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" width="5" height="5" viewBox="0 0 32 32">
                <path d="M35,8H1V18H28V8H5Z" fill="#ea3323"></path>
                <path d="M5,28H27V20H1v12H5Z" fill="#fff"></path>
            </svg>
            ID
        </p>
    </label>
</form>