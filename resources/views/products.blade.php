@extends('layout.layout')
@section('title', 'Products')

@section('content')
<section class="max-w-screen-xl md:px-4 md:py-8 md:mx-auto">
    <div class="grid grid-cols-4 gap-4">
        @foreach ($products as $product)
            <div class="max-w-xs bg-white rounded-lg dark:bg-gray-800 dark:border-gray-700">
                <a href="{{ $product->link }}">
                    <div>
                        <img class="rounded-t-lg aspect-square object-contain" src="{{ $product->img }}" alt="" />
                    </div>
                    <div class="p-5 flex flex-col gap-2">
                        <div>
                            <h5 class="text-xl font-bold text-font_primary dark:text-white">{{ $product->name }}</h5>
                            <p class="text-base text-font_secondary dark:text-gray-400">Nama Penjual</p>
                            <p class="text-base text-font_secondary dark:text-gray-400">4.5 | 25 Review</p>
                        </div>
                        <p class="text-xl font-bold text-font_primary dark:text-gray-400">Rp {{ $product->price }}</p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    {{ $products->links('pagination::tailwind') }}
</section>
@endsection
