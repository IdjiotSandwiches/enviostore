@extends('layout.layout')
@section('title', __('title.productManagement'))

@section('content')
    <section class="max-w-screen-xl px-4 py-8 md:mx-auto grid gap-4">
        <div class="flex items-center justify-between">
            <h1 class="font-bold text-3xl">{{ __('header.productManagement') }}</h1>
            <a href="{{ route('admin.product.addProductIndex') }}" class="px-4 py-2 bg-button text-white rounded-lg hover:bg-accent">
                {{ __('page.admin.addProduct') }}
            </a>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-16 py-3">
                            <span class="sr-only">Image</span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('page.admin.product') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('page.admin.category') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('page.admin.stocks') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('page.admin.price') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ __('page.admin.action') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="p-4">
                                <img src="{{ $product->img }}" class="h-32 w-32 object-cover rounded" alt="{{ $product->name }}">
                            </td>
                            <td class="px-6 py-4 font-semibold text-font_primary">
                                {{ $product->name }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-font_primary">
                                {{ $product->category_name }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-font_primary">
                                <div class="flex items-center">
                                {{ $product->stocks }}
                                </div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-font_primary">
                                {{ $product->price }}
                            </td>
                            <td class="px-4 py-4">
                                <form action="{{ route('admin.deleteProduct', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-red-700 mr-4">{{ __('page.admin.delete') }}</button>
                                </form>
                            </td>
                            <td class="py-4">
                                <a href="{{ route('admin.editProduct', $product->id) }}" class="bg-blue-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-blue-700">{{ __('page.admin.edit') }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
