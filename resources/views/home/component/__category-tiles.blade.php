@props(['route', 'image', 'name'])

<figure class="relative w-full max-w-sm md:max-w-md max-h-full">
    <a href="{{ $route }}">
        <img class="rounded-lg w-full h-auto object-cover" src="{{ $image }}" alt="image description">
        <figcaption class="absolute text-base md:text-lg lg:text-xl font-secondary left-1/2 bottom-2 transform -translate-x-1/2">
            <p class="bg-white rounded-full px-4 py-2 text-center">{{ $name }}</p>
        </figcaption>
    </a>
</figure>
