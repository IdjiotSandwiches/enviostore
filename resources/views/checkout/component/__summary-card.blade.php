@props(['subtotal', 'quantity', 'transaction', 'shipping', 'total'])

<div class="divide-y bg-white h-fit rounded-lg shadow-sm">
    <div class="p-4">
        <h2 class="text-xl font-bold">{{ __('page.cart.summary') }}</h2>
    </div>
    <div class="p-4">
        <div class="flex justify-between pb-2">
            <p class="font-medium text-font_secondary">{{ __('page.cart.total_items') }}</p>
            <p>{{ $quantity }}</p>
        </div>
        <div class="flex justify-between pb-2">
            <p class="font-medium text-font_secondary">Subtotal</p>
            <p>Rp {{ $subtotal }}</p>
        </div>
        <div class="flex justify-between pb-2">
            <p class="font-medium text-font_secondary">{{ __('page.checkout.transaction_fee') }}</p>
            <p>Rp {{ $transaction }}</p>
        </div>
        <div class="flex justify-between">
            <p class="font-medium text-font_secondary">{{ __('page.checkout.shipping_fee') }}</p>
            <p>Rp <span id="shipping-fee">{{ $shipping }}</span></p>
        </div>
    </div>
    <div class="p-4">
        <div class="flex justify-between font-semibold text-font_primary">
            <p>Total</p>
            <p>Rp <span id="total">{{ $total }}</span></p>
        </div>
        <button type="submit" id="pay-btn"
            class="mt-4 flex w-full justify-center items-center gap-4 text-white bg-button disabled:cursor-not-allowed disabled:bg-button/70 hover:bg-button/80 focus:ring-4 focus:outline-none focus:ring-button/15 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            @include('component.__spinner')
            <div class="flex items-center gap-2">
                <svg width="15" height="15" viewBox="0 0 22 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M9.26316 0L17.7135 2.622C17.9492 2.69507 18.1551 2.84105 18.3014 3.03863C18.4476 3.23621 18.5264 3.47504 18.5263 3.72025V5.75H20.8421C21.1492 5.75 21.4437 5.87116 21.6609 6.08683C21.878 6.30249 22 6.595 22 6.9V16.1C22 16.405 21.878 16.6975 21.6609 16.9132C21.4437 17.1288 21.1492 17.25 20.8421 17.25L17.1137 17.2511C16.6656 17.8376 16.1214 18.3551 15.4926 18.7806L9.26316 23L3.03368 18.7818C2.09871 18.1487 1.33361 17.2983 0.804899 16.3046C0.27619 15.3109 -0.000117205 14.204 3.72956e-08 13.0801V3.72025C0.000139649 3.47523 0.0790687 3.23666 0.225283 3.03932C0.371496 2.84197 0.577351 2.69617 0.812842 2.62315L9.26316 0ZM9.26316 2.4081L2.31579 4.5655V13.0801C2.31562 13.7842 2.47818 14.4789 2.79095 15.1107C3.10371 15.7425 3.55833 16.2946 4.11979 16.7244L4.33863 16.8808L9.26316 20.2159L13.6423 17.25H8.10526C7.79817 17.25 7.50366 17.1288 7.28651 16.9132C7.06936 16.6975 6.94737 16.405 6.94737 16.1V6.9C6.94737 6.595 7.06936 6.30249 7.28651 6.08683C7.50366 5.87116 7.79817 5.75 8.10526 5.75H16.2105V4.5655L9.26316 2.4081ZM9.26316 11.5V14.95H19.6842V11.5H9.26316ZM9.26316 9.2H19.6842V8.05H9.26316V9.2Z"
                        fill="white" />
                </svg>
                {{ __('page.checkout.pay') }}
            </div>
        </button>
    </div>
</div>