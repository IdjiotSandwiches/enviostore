<footer class="bg-white">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="flex flex-col md:flex-row md:justify-between md:gap-10">
            <div class="mb-6 md:mb-0">
                <a href="#" class="flex items-center">  
                    {{-- Logo --}}
                    <span class="self-center text-2xl font-semibold whitespace-nowrap italic">EnviroStore</span>
                </a>
            </div>
            {{-- Content --}}
            <div class="grid grid-cols-1 gap-8 sm:gap-6 sm:grid-cols-2 md:grid-cols-3 text-sm md:pl-8">
                {{-- Resources --}}
                <div>
                    <h2 class="mb-4 text-md font-semibold text-gray-900 uppercase">{{ __('navigation.resources') }}</h2>
                    <ul class="text-gray-900 font-medium">
                        <li class="mb-4">
                            <a href="#" class="hover:underline">{{ __('navigation.resources.goals') }}</a>
                        </li>
                        <li>
                            <a href="#" class="hover:underline">{{ __('navigation.resources.supply') }}</a>
                        </li>
                    </ul>
                </div>
                {{-- Legal and Notices --}}
                <div>
                    <h2 class="mb-4 text-md font-semibold text-gray-900 uppercase">{{ __('navigation.legal') }}</h2>
                    <ul class="text-gray-900 font-medium">
                        <li class="mb-4">
                            <a href="#" class="hover:underline">{{ __('navigation.legal.privacy') }}</a>
                        </li>
                        <li>
                            <a href="#" class="hover:underline">{{ __('navigation.legal.terms') }}</a>
                        </li>
                    </ul>
                </div>
                {{-- Social Media --}}
                <div>
                    <h2 class="mb-4 text-md font-semibold text-gray-900 uppercase">{{ __('navigation.social') }}</h2>
                    <ul class="text-gray-900 font-medium">
                        <li class="mb-4">
                            <a href="#" class="hover:underline">Github</a>
                        </li>
                        <li>
                            <a href="#" class="hover:underline">X(Twitter)</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        {{-- Copy Right --}}
        <hr class="my-6 border-gray-900 sm:mx-auto lg:my-8" />
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <span class="text-sm text-gray-900 sm:text-center">© 2024 <a href="#" class="hover:underline">EnviroStore</a>. {{ __('navigation.rights') }}.</span>
        </div>
    </div>
</footer>
