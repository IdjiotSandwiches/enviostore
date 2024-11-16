@extends('layout.layout')
@section('title', 'Welcome')

@section('content')
<section class="min-h-screen">
    <form action="{{ route('storeFile') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="img">Image Test</label>
        <input type="file" name="image" id="image" class="">
        <button type="submit">Submit</button>
    </form>
    <div>
        <p>{{ Session::get('status') }}</p>
    </div>
    <img src="{{ url(route('getFile')) }}" alt="" class="w-20 h-20">
</section>
@endsection