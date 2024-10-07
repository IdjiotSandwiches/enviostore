@extends('layout.layout')
@section('title', 'Verification')

@section('content')
    <div>
        <h1>Verify Your Email Address</h1>
        <p>Please check your email for a verification link.</p>
        <p>If you did not receive the email,</p>
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit">Request another verification email</button>
        </form>
        @if (session('message'))
            <div>
                {{ session('message') }}
            </div>
        @endif
    </div>
@endsection
