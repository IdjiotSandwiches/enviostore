<!DOCTYPE html>
<html lang="en">
@include('component.head')
<body class="bg-background font-primary">
    @include('component.navigation.navbar')
    @yield('content')
    @include('component.footer')
    @include('component.common-js')
    @yield('extra-js')
</body>
</html>
