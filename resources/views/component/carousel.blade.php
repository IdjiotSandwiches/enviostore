@props(['banners'])

<div class="glide group">
    <div class="glide__track" data-glide-el="track">
        <ul class="glide__slides">
            @foreach ($banners as $banner)
                <li class="glide__slide">
                    <img src="{{ $banner }}" class="w-full h-auto object-cover select-none pointer-events-none" alt="...">
                </li>
            @endforeach
        </ul>
    </div>
    <div class="bottom-0 w-full h-1/5 absolute bg-gradient-to-t from-black/80 to-black/0"></div>
    <div class="glide__arrows opacity-0 group-hover:opacity-100 transition-opacity" data-glide-el="controls">
        <button class="glide__arrow glide__arrow--left h-full bg-black/30 border-none shadow-none left-0" data-glide-dir="<">
            <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7"/>
            </svg>
        </button>
        <button class="glide__arrow glide__arrow--right h-full bg-black/30 border-none shadow-none right-0" data-glide-dir=">">
            <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
            </svg>
        </button>
    </div>
    <div class="glide__bullets bottom-3" data-glide-el="controls[nav]">
        @foreach ($imgPaths as $key => $value)
            <button class="glide__bullet h-0.5 border-none w-16 rounded-none" data-glide-dir="{{ "={$key}" }}"></button>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const options = {
            type: 'carousel',
            startAt: 0,
            autoplay: 3000,
            animationDuration: 1000,
            hoverpause: true,
        };

        new Glide('.glide', options).mount({ Controls, Breakpoints, Swipe, Autoplay });
    });
</script>
