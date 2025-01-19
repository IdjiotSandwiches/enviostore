@extends('layout.layout')
@section('title', 'Add Products')

@section('content')
    <section class="max-w-screen-xl px-4 py-8 md:mx-auto grid gap-4">
        <h1 class="font-bold text-3xl">{{ __('header.addProduct') }}</h1>
        <form action="{{ route('admin.product.addProduct') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="bg-primary rounded-lg shadow border border-gray-200 p-4 sm:p-6 md:p-8">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name_en"
                                class="block mb-2 text-sm font-medium text-font_primary">{{ __('page.admin.product.name_en') }}</label>
                            <input type="text" name="name_en" id="name_en" @class([
                                'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5',
                                'border-red-500' => $errors->has('name_en'),
                            ])
                                placeholder="Enter product name (English)" value="{{ old('name_en') }}" />
                            @error('name_en')
                                <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                            @enderror
                        </div>
 
                        <div>
                            <label for="name_id"
                                class="block mb-2 text-sm font-medium text-font_primary">{{ __('page.admin.product.name_id') }}</label>
                            <input type="text" name="name_id" id="name_id" @class([
                                'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5',
                                'border-red-500' => $errors->has('name_id'),
                            ])
                                placeholder="Enter product name (Indonesian)" value="{{ old('name_id') }}" />
                            @error('name_id')
                                <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                            @enderror
                        </div>
    
                        <div class="md:col-span-2">
                            <label for="description_en"
                                class="block mb-2 text-sm font-medium text-font_primary">{{ __('page.admin.product.description_en') }}</label>
                            <textarea name="description_en" id="description_en" rows="4" @class([
                                'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5',
                                'border-red-500' => $errors->has('description_en'),
                            ]) placeholder="Enter product description (English)">{{ old('description_en') }}</textarea>
                            @error('description_en')
                                <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="md:col-span-2">
                            <label for="description_id"
                                class="block mb-2 text-sm font-medium text-font_primary">{{ __('page.admin.product.description_id') }}</label>
                            <textarea name="description_id" id="description_id" rows="4" @class([
                                'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5',
                                'border-red-500' => $errors->has('description_id'),
                            ]) placeholder="Enter product description (Indonesian)">{{ old('description_id') }}</textarea>
                            @error('description_id')
                                <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                            @enderror
                        </div>
    
                        <div>
                            <label for="price"
                                class="block mb-2 text-sm font-medium text-font_primary">{{ __('page.admin.product.price') }}</label>
                            <input type="number" name="price" id="price" step="0.01" @class([
                                'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5',
                                'border-red-500' => $errors->has('price'),
                            ])
                                placeholder="Enter product price" value="{{ old('price') }}" />
                            @error('price')
                                <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                            @enderror
                        </div>
    
                        <div>
                            <label for="stocks"
                                class="block mb-2 text-sm font-medium text-font_primary">{{ __('page.admin.product.stocks') }}</label>
                            <input type="number" name="stocks" id="stocks" @class([
                                'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5',
                                'border-red-500' => $errors->has('stocks'),
                            ])
                                placeholder="Enter stock quantity" value="{{ old('stocks') }}" />
                            @error('stocks')
                                <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category_id"
                                class="block mb-2 text-sm font-medium text-font_primary">{{ __('page.admin.product.category') }}</label>
                            <select name="category_id" id="category_id" @class([
                                'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5',
                                'border-red-500' => $errors->has('category_id'),
                            ])>
                                <option value="">Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                            @enderror
                        </div>
    
                        <div>
                            <label for="sustainability_score"
                                class="block mb-2 text-sm font-medium text-font_primary">{{ __('page.admin.product.sustainability_score') }}</label>
                            <input type="number" name="sustainability_score" id="sustainability_score" step="0.01" @class([
                                'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5',
                                'border-red-500' => $errors->has('sustainability_score'),
                            ])
                                placeholder="Enter sustainability score" value="{{ old('sustainability_score') }}" />
                            @error('sustainability_score')
                                <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="md:col-span-2">
                            <label for="product_images"
                                class="block mb-2 text-sm font-medium text-font_primary">{{ __('page.admin.product.image') }}</label>
                            <input type="file" name="product_images[]" id="product_images" accept="image/*" multiple
                                @class([
                                    'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-button focus:border-button block w-full p-2.5',
                                    'border-red-500' => $errors->has('product_images'),
                                ]) />
                            @error('product_images')
                                <p class="text-red-500 text-sm first-letter:uppercase">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit"
                            class="w-full text-sm text-white text-center bg-button hover:bg-button/80 focus:ring-4 focus:outline-none focus:ring-button/15 font-medium rounded-lg px-4 md:px-5 py-1.5 md:py-2 text-nowrap mt-4">
                            {{ __('page.admin.product.submit_changes') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
