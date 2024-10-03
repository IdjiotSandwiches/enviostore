@extends('layout.layout')
@section('title', 'Welcome')

@section('content')
    <div>
        Test
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('div').textContent = 'Hello';
        });
    </script>
@endsection
