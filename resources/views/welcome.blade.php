@extends('layout.layout')
@section('title', 'Welcome')

@section('content')
<a href="{{ route('getProduct', ['id' => base64_encode("jacket_1")]) }}">Product 1</a>
@endsection
