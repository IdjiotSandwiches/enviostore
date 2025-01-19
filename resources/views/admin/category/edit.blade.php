@extends('layout.layout')
@section('title', 'Edit Products')

@section('content')
<section class="max-w-screen-xl px-4 py-8 md:mx-auto grid gap-4">
    <h1 class="font-bold text-3xl">{{ __('header.editCategory') }}</h1>
    <form action="{{ route('admin.editCategory', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="bg-primary rounded-lg shadow border border-gray-200 p-4 sm:p-6 md:p-8">
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name_en"
                            class="block mb-2 text-sm font-medium text-font_primary">{{ __('page.admin.category.name_en') }}</label>
                        <input type="text" name="name_en" id="name_en" @class([
                            'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5',
                            'border-red-500' => $errors->has('name_en'),
                        ])
                            placeholder="Enter category name (English)"
                            value="{{ old('name_en', $category->name_en) }}" />
                        @error('name_en')
                            <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="name_id"
                            class="block mb-2 text-sm font-medium text-font_primary">{{ __('page.admin.category.name_id') }}</label>
                        <input type="text" name="name_id" id="name_id" @class([
                            'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5',
                            'border-red-500' => $errors->has('name_id'),
                        ])
                            placeholder="Enter category name (Indonesian)"
                            value="{{ old('name_id', $category->name_id) }}" />
                        @error('name_id')
                            <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="md:col-span-2">
                    <div class="mt-2">
                        <img src="{{ $categoryImage }}" alt="Current Category Image" class="h-32 w-32 object-cover rounded">
                    </div>
                    <label for="category_image"
                        class="block mb-2 text-sm font-medium text-font_primary">{{ __('page.admin.category.image') }}</label>
                    <input type="file" name="category_image" id="category_image" accept="image/*" @class([
                        'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5',
                        'border-red-500' => $errors->has('category_image'),
                    ]) />
                    @error('category_image')
                        <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                    @enderror
                </div>
                <div class="text-center mt-4">
                    <button type="submit"
                        class="text-sm text-white text-center bg-button hover:bg-button/80 focus:ring-4 focus:outline-none focus:ring-button/15 font-medium rounded-lg px-4 md:px-5 py-1.5 md:py-2 text-nowrap">
                        {{ __('page.admin.category.update') }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection