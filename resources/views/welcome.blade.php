@extends('layout.layout')
@section('title', 'Welcome')

@section('content')
<div class="flex gap-4 justify-center items-center h-screen overflow-auto whitespace-nowrap">
    @include('component.product-card', with([
        'itemName' => 'Item 1',
        'itemPrice' => 'Rp 5.000',
        'itemSeller' => 'Eco Seller',
        'itemRating' => '4.5',
        'itemReview' => '10'
    ]))
</div>
@endsection
