@props(['order'])

<div class="w-full h-fit flex justify-between items-center bg-accent/10 shadow rounded-lg p-4">
    <div class="text-accent">
        <h3>{{ $order->unique_id }}</h3>
        <p>Created at: {{ $order->created_at }}</p>
    </div>
    <a href="{{ route('checkout.payment', $order->unique_id) }}" class="text-white bg-button disabled:cursor-not-allowed disabled:bg-button/70 hover:bg-button/80 focus:ring-4 focus:outline-none focus:ring-button/15 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Pay</a>
</div>