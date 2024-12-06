@extends('layout.layout')
@section('title', 'Login')

@section('content')
    <section class="max-w-screen-xl md:px-4 md:py-8 md:mx-auto">
        {{-- PP and Name --}}
        <div class="flex">
            <div class="aspect-square object-cover max-w-48">
                <img src={{ asset('img/0.png') }} alt="..." class="rounded-full aspect-square object-cover">
            </div>
            <div class="pt-14 pl-7">
                <h1 class="text-5xl font-semibold">Dicky Dharma Susanto</h1>
                <p class="text-xl mt-2">Perum Taman Surya</p>
            </div>
        </div>
        {{-- User Information --}}
        <div class="flex mt-4">
            <div class="w-1/2 bg-primary justify-center rounded-lg shadow-gray-400 shadow-sm">
                <div class="m-7">
                    <h1 class="text-3xl font-semibold text-center">User Information</h1>
                </div>
                <hr class="bg-button stroke-black">
                <div class="flex md:gap-44">
                    <div class="m-5 mr-1">
                        <p class="text-xl font-normal text-accent">Name</p>
                    </div>
                    <div class="m-5 ml-1">
                        <p class="text-xl font-semibold">Dicky Dharma Susanto</p>
                    </div>
                </div>
                <hr class="bg-button stroke-black">
                <div class="flex md:gap-44">
                    <div class="m-5 mr-1">
                        <p class="text-xl font-normal text-accent">Adress</p>
                    </div>
                    <div class="m-5 ml-1">
                        <p class="text-xl font-semibold">Perum Taman Surya</p>
                    </div>
                </div>
                <hr class="bg-button stroke-black">
                <div class="flex md:gap-44">
                    <div class="m-5 mr-1">
                        <p class="text-xl font-normal text-accent">Email</p>
                    </div>
                    <div class="m-5 ml-3">
                        <p class="text-xl font-semibold">dickyganteng@gmail.com</p>
                    </div>
                </div>
                <hr class="bg-button stroke-black">
                <div class="flex md:gap-28 mb-32">
                    <div class="mr-1 m-5">
                        <p class="text-xl font-normal text-accent">Phone Number</p>
                    </div>
                    <div class="m-5 ml-1">
                        <p class="text-xl font-semibold">08954324911</p>
                    </div>
                </div>
                <div class="justify-center text-center m-8 mb-1 bg-button rounded-xl">
                    <a href="#" class="p-3">
                        <p class="text-xl font-normal text-primary">Change Password</p>
                    </a>
                </div>
                <div class="justify-center text-center m-8 border-solid border-2 border-button rounded-xl">
                    <a href="#" class="p-3">
                        <p class="text-xl font-normal text-button">Edit Information</p>
                    </a>
                </div>
            </div>
            <div>

            </div>
        </div>
    </section>
@endsection
