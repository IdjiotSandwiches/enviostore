@extends('checkout.layout')

@section('js')
@include('component.js.__card-replace-summary')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const URL = '{{ route('cart.getCartItems') }}';
        fetchRequest(URL);
    });
</script>
@endsection