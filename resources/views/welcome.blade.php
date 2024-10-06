@extends('layout.layout')
@section('title', 'Welcome')

@section('content')
@auth
    <p>Logged In</p>
@else
    <p>Not Auth</p>
@endauth
@endsection
