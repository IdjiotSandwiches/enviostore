<!DOCTYPE html>
<html lang="en">
@include('component.__head')
<body class="bg-background font-primary">
    @include('component.navigation.navbar')
    @yield('content')
    @include('component.__footer')
    @include('component.js.__common-js')
    @yield('extra-js')
</body>
</html>
