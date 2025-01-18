@props(['subtotal', 'quantity'])

<form action="{{ route('cart.checkout') }}" method="POST">
    @csrf
    @method('POST')
    <div class="divide-y bg-white h-fit rounded-lg shadow-sm">
        <div class="p-4">
            <h2 class="text-xl font-bold">{{ __('page.cart.summary') }}</h2>
        </div>
        <div class="p-4">
            <div class="flex justify-between pb-2">
                <p class="font-medium text-font_secondary">{{ __('page.cart.total_items') }}</p>
                <p>{{ $quantity }}</p>
            </div>
            <div class="flex justify-between">
                <p class="font-medium text-font_secondary">Subtotal</p>
                <p>Rp {{ $subtotal }}</p>
            </div>
            <button type="submit" class="mt-4 flex w-full justify-center items-center gap-4 text-white bg-button disabled:cursor-not-allowed disabled:bg-button/70 hover:bg-button/80 focus:ring-4 focus:outline-none focus:ring-button/15 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                @include('component.__spinner')
                Checkout
            </button>
        </div>
    </div>
</form>