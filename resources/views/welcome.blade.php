@extends('layout.layout')
@section('title', 'Welcome')

@section('content')
<a href="{{ route('getProduct', ['id' => base64_encode(1)]) }}">Product 1</a>
@endsection
