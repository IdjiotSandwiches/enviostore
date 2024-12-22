@props(['shipping'])

<div class="flex items-center ps-4 bg-primary rounded px-4">
    <input type="radio" value="{{ $shipping->shipping_serial_code }}" id="{{ $shipping->shipping_serial_code }}" name="shippings"
        class="w-4 h-4 text-black bg-gray-100 border-black focus:ring-black">
    <label for="{{ $shipping->shipping_serial_code }}"
        class="flex items-center justify-between w-full py-6 ms-2 text-sm font-medium text-gray-900">
        <div class="flex items-center gap-4">
            @include("checkout.component.icon.$shipping->icon")
            <div>
                <h2 class="text-xl">{{ $shipping->name }}</h2>
                <p class="text-sm text-font_secondary">({{ $shipping->description }})</p>
            </div>
        </div>
        <div class="text-xl">Rp {{ $shipping->fee }}</div>
    </label>
</div>