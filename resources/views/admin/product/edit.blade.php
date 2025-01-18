@extends('layout.layout')
@section('title', 'Edit Products')

@section('content')
    <section class="max-w-screen-xl px-4 py-8 md:mx-auto grid gap-4">
        <h1 class="font-bold text-3xl">{{ __('header.editProduct') }}</h1>
        <form action="{{ route('admin.updateProduct', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="bg-primary rounded-lg shadow border border-gray-200 p-4 sm:p-6 md:p-8">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Name (English) -->
                        <div>
                            <label for="name_en" class="block mb-2 text-sm font-medium text-font_primary">Name
                                (English)</label>
                            <input type="text" name="name_en" id="name_en" @class([
                                'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5',
                                'border-red-500' => $errors->has('name_en'),
                            ])
                                value="{{ old('name_en', $product->name_en) }}"
                                placeholder="Enter product name (English)" />
                            @error('name_en')
                                <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Name (Indonesian) -->
                        <div>
                            <label for="name_id" class="block mb-2 text-sm font-medium text-font_primary">Name
                                (Indonesian)</label>
                            <input type="text" name="name_id" id="name_id" @class([
                                'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5',
                                'border-red-500' => $errors->has('name_id'),
                            ])
                                value="{{ old('name_id', $product->name_id) }}"
                                placeholder="Enter product name (Indonesian)" />
                            @error('name_id')
                                <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description (English) -->
                        <div class="md:col-span-2">
                            <label for="description_en" class="block mb-2 text-sm font-medium text-font_primary">Description
                                (English)</label>
                            <textarea name="description_en" id="description_en" rows="4" @class([
                                'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5',
                                'border-red-500' => $errors->has('description_en'),
                            ])
                                placeholder="Enter product description (English)">{{ old('description_en', $product->description_en) }}</textarea>
                            @error('description_en')
                                <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description (Indonesian) -->
                        <div class="md:col-span-2">
                            <label for="description_id" class="block mb-2 text-sm font-medium text-font_primary">Description
                                (Indonesian)</label>
                            <textarea name="description_id" id="description_id" rows="4" @class([
                                'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5',
                                'border-red-500' => $errors->has('description_id'),
                            ])
                                placeholder="Enter product description (Indonesian)">{{ old('description_id', $product->description_id) }}</textarea>
                            @error('description_id')
                                <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="price" class="block mb-2 text-sm font-medium text-font_primary">Price</label>
                            <input type="number" name="price" id="price" step="0.01" @class([
                                'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5',
                                'border-red-500' => $errors->has('price'),
                            ])
                                value="{{ old('price', $product->price) }}" placeholder="Enter product price" />
                            @error('price')
                                <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stocks -->
                        <div>
                            <label for="stocks" class="block mb-2 text-sm font-medium text-font_primary">Stocks</label>
                            <input type="number" name="stocks" id="stocks" @class([
                                'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5',
                                'border-red-500' => $errors->has('stocks'),
                            ])
                                value="{{ old('stocks', $product->stocks) }}" placeholder="Enter stock quantity" />
                            @error('stocks')
                                <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id"
                                class="block mb-2 text-sm font-medium text-font_primary">Category</label>
                            <select name="category_id" id="category_id" @class([
                                'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5',
                                'border-red-500' => $errors->has('category_id'),
                            ])>
                                <option value="">Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sustainability Score -->
                        <div>
                            <label for="sustainability_score"
                                class="block mb-2 text-sm font-medium text-font_primary">Sustainability Score</label>
                            <input type="number" name="sustainability_score" id="sustainability_score" step="0.01"
                                @class([
                                    'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5',
                                    'border-red-500' => $errors->has('sustainability_score'),
                                ])
                                value="{{ old('sustainability_score', $product->sustainability_score) }}"
                                placeholder="Enter sustainability score" />
                            @error('sustainability_score')
                                <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit"
                                class="text-sm text-white text-center bg-button hover:bg-button/80 focus:ring-4 focus:outline-none focus:ring-button/15 font-medium rounded-lg px-4 md:px-5 py-1.5 md:py-2 text-nowrap">
                                Update Product
                            </button>
                        </div>
                    </div>
                </div>
        </form>
        <div class="md:col-span-2">
            <label class="block mb-2 text-sm font-medium text-font_primary">Current Images</label>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach ($productImages as $image)
                    <div class="group relative border p-2 rounded shadow-lg">
                        <img src="{{ $image->converted_url }}" alt="Product Image" class="w-full h-32 object-cover rounded">
                        <div
                            class="absolute inset-0 bg-black bg-opacity-50 items-center justify-center rounded hidden group-hover:flex">
                            <!-- Separate Delete Form -->
                            <form action="{{ route('admin.deleteProductImage', $image->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 text-white text-sm font-medium py-1 px-3 rounded hover:bg-red-600">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    
        <div class="space-y-8">
            <form action="{{ route('admin.addProductImage', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('POST')
                <div class="md:col-span-2">
                    <label for="product_images" class="block mb-2 text-sm font-medium text-font_primary">Add New Images</label>
                    <input type="file" name="product_images[]" id="product_images" accept="image/*" multiple
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5" />
                </div>
                <div class="text-center mt-4">
                    <button type="submit"
                        class="text-sm text-white bg-button hover:bg-button/80 focus:ring-4 focus:outline-none focus:ring-button/15 font-medium rounded-lg px-4 md:px-5 py-1.5 md:py-2">
                        Upload New Images
                    </button>
                </div>
            </form>
    </section>
@endsection
