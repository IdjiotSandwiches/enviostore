@extends('layout.layout')
@section('title', 'Welcome')

@section('content')
<a href="{{ route('categoryPage', ['category' => 'clothes']) }}">
    Cloth
</a>
@endsection
