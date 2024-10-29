@extends('layout.layout')
@section('title', 'Product')

@section('content')
<section class="max-w-screen-xl md:px-4 md:py-8 md:mx-auto grid gap-4">
    <h1 class="font-bold text-2xl">Category</h1>
    <button id="filterDropdown" data-dropdown-toggle="dropdown" class="flex gap-2 p-2 rounded-lg max-w-[18rem] justify-center items-center bg-primary text-font_primary border border-font_primary" type="button">
        Sort By:
        <span class="font-bold">
            Newest First
        </span>
        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M20 6H10m0 0a2 2 0 1 0-4 0m4 0a2 2 0 1 1-4 0m0 0H4m16 6h-2m0 0a2 2 0 1 0-4 0m4 0a2 2 0 1 1-4 0m0 0H4m16 6H10m0 0a2 2 0 1 0-4 0m4 0a2 2 0 1 1-4 0m0 0H4"/>
        </svg>
    </button>

    <!-- Dropdown menu -->
    <div id="dropdown" class="max-w-xs z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-72 dark:bg-gray-700">
        <ul class="py-2 text-gray-700 dark:text-gray-200" aria-labelledby="filterDropdown">
            <li value="1" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Newest First</li>
            <li value="2" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Highest Price</li>
            <li value="3" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Lowest Price</li>
        </ul>
    </div>

    <div class="grid grid-cols-4 gap-4">
        {{-- @foreach ($products as $product) --}}
            <div class="max-w-xs bg-white rounded-lg dark:bg-gray-800 dark:border-gray-700">
                <a href="{{-- $product->link --}}">
                    <div>
                        <img class="rounded-t-lg aspect-square object-contain" src="{{-- $product->img --}}" alt="" />
                    </div>
                    <div class="p-5 flex flex-col gap-2">
                        <div>
                            <h5 class="text-xl font-bold text-font_primary dark:text-white">{{-- $product->name --}}</h5>
                            <p class="text-base text-font_secondary dark:text-gray-400">Nama Penjual</p>
                            <p class="text-base text-font_secondary dark:text-gray-400">4.5 | 25 Review</p>
                        </div>
                        <p class="text-xl font-bold text-font_primary dark:text-gray-400">Rp {{-- $product->price --}}</p>
                    </div>
                </a>
            </div>
        {{-- @endforeach --}}
    </div>
</section>
@endsection
