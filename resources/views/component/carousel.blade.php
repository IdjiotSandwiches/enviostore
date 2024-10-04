@props(['imgPaths'])

<div id="default-carousel" class="group relative w-full" data-carousel="slide">
    <!-- Carousel wrapper -->
    <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
        @foreach ($imgPaths as $path)
            <div class="hidden duration-1000 ease-in-out" data-carousel-item>
                <img src="{{ asset($path) }}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                <div class="bottom-0 w-full h-1/4 absolute bg-gradient-to-t from-black/80 to-black/0"></div>
            </div>
        @endforeach
    </div>
    <!-- Slider indicators -->
    <div class="absolute z-30 hidden md:flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
        @foreach ($imgPaths as $key => $path)
            <button type="button" class="w-16 h-0.5 aria-[current=true]:bg-white" aria-current="true" aria-label="Slide {{ $key }}" data-carousel-slide-to="{{ $key }}"></button>
        @endforeach
    </div>
    <!-- Slider controls -->
    <button type="button" class="hidden group-hover:flex absolute top-0 start-0 z-30 items-center justify-center h-full bg-gray-900/20 px-2 cursor-pointer group focus:outline-none" data-carousel-prev>
        <span class="inline-flex items-center justify-center w-10 h-10">
            <svg class="w-4 h-4 text-gray-200 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
            </svg>
            <span class="sr-only">Previous</span>
        </span>
    </button>
    <button type="button" class="hidden group-hover:flex absolute top-0 end-0 z-30 items-center justify-center h-full bg-gray-900/20 px-2 cursor-pointer group focus:outline-none" data-carousel-next>
        <span class="inline-flex items-center justify-center w-10 h-10">
            <svg class="w-4 h-4 text-gray-200 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
            </svg>
            <span class="sr-only">Next</span>
        </span>
    </button>
</div>
