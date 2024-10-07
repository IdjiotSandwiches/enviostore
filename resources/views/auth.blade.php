@extends('layout.layout')
@section('title', 'Auth')

@section('content')
@auth
    <p>Auth</p>
@else
    <p>Not Auth</p>
@endauth
@endsection
