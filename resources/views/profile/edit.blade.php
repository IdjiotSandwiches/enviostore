@extends('layout.layout')

@section('content')
    <section class="max-w-screen-xl md:px-4 md:py-8 md:mx-auto">
        <div class="flex">
            <div class="aspect-square object-cover max-w-48">
                <img src="{{ $identity->profile_picture ?? asset('img/0.png') }}" alt="..."
                    class="rounded-full aspect-square object-cover w-full h-full hover:bg-gray-400">
            </div>
            <div class="pt-14 pl-7">
                <form action="#" method="POST" enctype="multipart/form-data"
                    class="text-center">
                    @csrf
                    <!-- File Input -->
                    <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="hidden"
                        onchange="this.form.submit()">
                    <!-- Label Styled as a Button -->
                    <label for="profile_picture"
                        class="cursor-pointer px-4 py-2 bg-white text-black rounded-lg shadow-md hover:bg-gray-200">
                        Upload Image
                    </label>
                </form>
            </div>
        </div>
        {{-- User Information --}}
        <div class="flex mt-4">
            <div class="w-full bg-primary justify-center rounded-lg shadow-gray-400 shadow-sm">
                <form action="#" method="POST" class="m-7">
                    @csrf
                    @method('PUT')
                    <h1 class="text-3xl font-semibold text-center mb-5">Edit Information</h1>

                    <hr class="bg-button stroke-black mb-5">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-xl font-normal text-accent mb-2">Name</label>
                            <input type="text" id="name" name="name" value="{{ $identity->name ?? '' }}"
                                class="w-full px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring focus:ring-button"
                                placeholder="Enter your name">
                        </div>

                        <div>
                            <label for="address" class="block text-xl font-normal text-accent mb-2">Address</label>
                            <input type="text" id="address" name="address" value="{{ $identity->address ?? '' }}"
                                class="w-full px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring focus:ring-button"
                                placeholder="Enter your address">
                        </div>

                        <div>
                            <label for="email" class="block text-xl font-normal text-accent mb-2">Email</label>
                            <input type="email" id="email" name="email" value="{{ $identity->email ?? '' }}"
                                class="w-full px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring focus:ring-button"
                                placeholder="Enter your email">
                        </div>

                        <div>
                            <label for="phone_number" class="block text-xl font-normal text-accent mb-2">Phone
                                Number</label>
                            <input type="text" id="phone_number" name="phone_number"
                                value="{{ $identity->phone_number ?? '' }}"
                                class="w-full px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring focus:ring-button"
                                placeholder="Enter your phone number">
                        </div>
                    </div>

                    <hr class="bg-button stroke-black my-5">

                    <div class="text-center">
                        <button type="submit"
                            class="px-6 py-2 bg-button text-primary rounded shadow-md hover:bg-opacity-80 focus:outline-none focus:ring focus:ring-gray-200">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>


    </section>
@endsection
