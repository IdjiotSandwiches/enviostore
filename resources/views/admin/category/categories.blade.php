@extends('layout.layout')
@section('title', 'Category Management')

@section('content')
<section class="max-w-screen-xl px-4 py-8 md:mx-auto grid gap-4">
    <div class="flex items-center justify-between">
        <h1 class="font-bold text-3xl">{{ __('header.productManagement') }}</h1>
        <a href="{{ route('admin.addCategoryIndex') }}" class="px-4 py-2 bg-button text-white rounded-lg hover:bg-accent">
            Add Category
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
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="p-4">
                            <img src="{{ $category->image }}" class="w-16 md:w-32 max-w-32 max-h-32" alt="{{ $category->name }}">
                        </td>
                        <td class="px-6 py-4 font-semibold text-font_primary">
                            {{ $category->name }}
                        </td>
                        <td class="py-4">
                            <form action="{{ route('admin.deleteCategory', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-red-700 mr-4">Remove</button>
                            </form>
                        </td>
                        <td class="py-4">
                            <a href="{{ route('admin.editCategory', $category->id) }}" class="bg-blue-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-blue-700">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection