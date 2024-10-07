@extends('layout.layout')
@section('title', 'Seller')

@section('content')
@auth
    <p>Seller</p>
@else
    <p>Not Auth</p>
@endauth
@endsection
