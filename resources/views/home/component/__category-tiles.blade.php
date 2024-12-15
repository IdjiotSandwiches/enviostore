@props(['category'])

<figure class="relative w-full max-w-xs md:max-w-sm lg:max-w-md max-h-full">
    <a href="{{ $category->link }}">
        <img class="rounded-lg w-full h-auto object-cover" src="{{ $category->image }}" alt="image description">
        <figcaption class="absolute text-base md:text-lg lg:text-xl font-secondary left-1/2 bottom-2 transform -translate-x-1/2">
            <p class="bg-white rounded-full px-4 py-2 text-sm md:text-md lg:text-2xl text-center">{{ ucwords($category->name) }}</p>
        </figcaption>
    </a>
</figure>
