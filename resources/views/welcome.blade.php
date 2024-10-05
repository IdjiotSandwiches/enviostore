@extends('layout.layout')
@section('title', 'Welcome')

@section('content')
@include('component.carousel', with([
    'imgPaths' => [
        'img/0.png',
        'img/1.png',
        'img/2.png',
        'img/3.png',
    ]
]))
@endsection
