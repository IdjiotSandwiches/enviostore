<h1 class="font-bold text-3xl">{{ __('header.shipping') }}</h1>
@foreach ($shippings as $shipping)
    <div class="flex items-center ps-4 bg-primary rounded px-4">
        <input type="radio" value="{{ $shipping->shipping_serial_code }}" id="{{ $shipping->shipping_serial_code }}"
            name="shippings" class="w-4 h-4 text-black bg-gray-100 border-black focus:ring-black">
        <label for="{{ $shipping->shipping_serial_code }}"
            class="flex items-center justify-between w-full px-4 py-6 ms-2 text-sm font-medium text-gray-900">
            <div class="flex items-center gap-4 w-full">
                @include("checkout.component.icon.$shipping->icon")
                <div class="md:flex w-full justify-between items-center">
                    <div>
                        <h2 class="text-lg font-bold">{{ $shipping->name }}</h2>
                        <p class="text-xs text-font_secondary">({{ $shipping->description }})</p>
                    </div>
                    <div class="text-lg font-bold">Rp {{ $shipping->fee }}</div>
                </div>
            </div>
        </label>
    </div>
@endforeach
