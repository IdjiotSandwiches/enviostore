@extends('layout.layout')
@section('title', 'Products')

@section('content')
<section class="max-w-screen-xl md:px-4 md:py-8 md:mx-auto">
    <div class="grid grid-cols-5">
        @foreach ($products as $product)
            <div class="max-w-xs p-6 bg-white border border-gray-200 rounded-lg">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Noteworthy technology acquisitions 2021</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400"></p>
            </div>
        @endforeach
    </div>
    {{ $products->links('pagination::tailwind') }}
</section>
@endsection
