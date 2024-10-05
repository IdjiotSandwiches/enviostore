@extends('layout.layout')
@section('title', 'Register')

@section('content')
<section class="flex justify-center items-center">
    <form action="POST" class="max-w-screen-md w-full">
        @csrf
        <div class="flex flex-col">
            <label for="name">Name</label>
            <input type="text" name="name" id="name">
        </div>
        <div class="flex flex-col">
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
        </div>
        <div class="flex flex-col">
            <label for="phone_number">Phone Number</label>
            <input type="tel" name="phone_number" id="phone-number" minlength="8" maxlength="12" pattern="[0-9]{8,12}">
        </div>
        <div class="flex flex-col">
            <label for="password_confirmation">Password Confirmation</label>
            <input type="password" name="password_confirmation" id="password-confirmation">
        </div>
    </form>
</section>
@endsection
