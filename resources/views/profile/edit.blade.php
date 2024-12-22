@extends('layout.layout')

@section('content')
    <section class="max-w-screen-xl md:px-4 md:py-8 md:mx-auto">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="m-7">
            @csrf
            @method('PUT')
            <div class="flex items-center mb-6">
                <div class="aspect-square object-cover max-w-48">
                    <img src="{{ $identity->profile_picture ?? asset('img/0.png') }}" alt="Profile Picture"
                        class="rounded-full aspect-square object-cover w-full h-full hover:bg-gray-400">
                </div>
                <div class="pl-7">
                    <label for="profile_picture"
                        class="cursor-pointer px-4 py-2 bg-black text-white rounded-lg shadow-md hover:bg-gray-200">
                        Upload New Image
                    </label>
                    <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="hidden">
                </div>
            </div>
            <div class="w-full bg-primary justify-center rounded-lg shadow-gray-400 shadow-sm p-6">
                <h1 class="text-3xl font-semibold text-center mb-5">Edit Information</h1>
                <hr class="bg-button stroke-black mb-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="username" class="block text-xl font-normal text-accent mb-2">Name</label>
                        <input type="text" id="username" name="username" value=""
                            class="w-full px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring focus:ring-button"
                            placeholder="Enter your name">
                    </div>
                    <div>
                        <label for="address" class="block text-xl font-normal text-accent mb-2">Address</label>
                        <input type="text" id="address" name="address" value=""
                            class="w-full px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring focus:ring-button"
                            placeholder="Enter your address">
                    </div>
                    <div>
                        <label for="email" class="block text-xl font-normal text-accent mb-2">Email</label>
                        <input type="email" id="email" name="email" value=""
                            class="w-full px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring focus:ring-button"
                            placeholder="Enter your email">
                    </div>
                    <div>
                        <label for="phone_number" class="block text-xl font-normal text-accent mb-2">Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number"
                            value=""
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
            </div>
        </form>
    </section>
@endsection
