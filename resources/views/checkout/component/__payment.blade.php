@props(['payment'])

<div class="flex items-center ps-4 bg-primary rounded px-4">
    <input type="radio" value="{{ $payment->payment_serial_code }}" id="{{ $payment->payment_serial_code }}" name="payments"
        class="w-4 h-4 text-black bg-gray-100 border-black focus:ring-black">
    <label for="{{ $payment->payment_serial_code }}"
        class="flex items-center justify-between w-full px-4 py-6 ms-2 text-sm font-medium text-gray-900">
        <div class="flex items-center gap-4">
            @include("checkout.component.icon.$payment->icon")
            <h2 class="text-xl">{{ $payment->name }}</h2>
        </div>
    </label>
</div>