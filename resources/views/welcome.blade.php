@extends('layout.layout')
@section('title', 'Welcome')

@section('content')
    <div id="test" class="text-xl">
        Category
    </div>

    <script>
        const fontFamily = window.getComputedStyle(document.getElementById('test')).fontFamily;
        console.log('Current Font:', fontFamily);
</script>
@endsection
