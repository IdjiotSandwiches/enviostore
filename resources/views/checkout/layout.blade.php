@extends('layout.layout')
@section('title', 'Checkout')

@section('content')
<section class="max-w-screen-xl px-4 py-8 md:mx-auto grid gap-4">
    <h1 class="font-bold text-3xl">Checkout</h1>
    <div class="flex flex-col lg:flex-row justify-between gap-4">
        <section class="grid gap-4 flex-1">
            <div id="cartContainer" class="grid gap-4 flex-1"></div>
            <div id="addressContainer" class="grid gap-4"></div>
            <div id="shippingContainer" class="grid gap-4"></div>
        </section>
        <section id="summaryContainer" class="lg:w-1/3 xl:w-1/4"></section>
    </div>

    <form id="payment-form" method="POST" action="{{ route('checkout.pay', [$order->id]) }}">
        @csrf
        @method('POST')
        <input type="hidden" name="result_type" id="result-type" value=""></div>
        <input type="hidden" name="result_data" id="result-data" value=""></div>
    </form>
</section>
@endsection

@section('extra-js')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    const cartContainer = document.querySelector('#cartContainer');
    const summaryContainer = document.querySelector('#summaryContainer');
    const shippingContainer = document.querySelector('#shippingContainer');
    const addressContainer = document.querySelector('#addressContainer');
    const shippings = {!! $shippings !!};
    let totalPrice;

    function getOrder() {
        const submitButton = document.querySelector('button[type="submit"]')
        const spinner = document.querySelector('div[role="status"]');
        
        submitButton.disabled = true;
        if(spinner) {
            spinner.classList.toggle('hidden');
        }

        let url = '{{ route('checkout.getOrder', [$order->id]) }}';
        customFetch(url, {
            method: 'GET',
        }).then(response => {
            let order = response.data;
            if(order.length === 0) {
                warningToast.fire({
                    icon: response.status,
                    titleText: response.message,
                });
            }
            else {
                midtransSnap(order);
            }
        }).finally(() => {
            submitButton.disabled = false;
            if(spinner) {
                spinner.classList.toggle('hidden');
            }
        });
    }

    function radioInputListener() {
        const shippingButtons = document.querySelectorAll('input[type="radio"][name="shippings"]');
        shippingButtons.forEach(button => {
            button.addEventListener('click', function () {
                let shippingUrl = '{{ route('checkout.updateShipping', [$order->id, '::SHIPPING_SERIAL::']) }}';
                shippingUrl = shippingUrl.replace('::SHIPPING_SERIAL::', this.value);
                customFetch(url, {
                    method: 'POST',
                });

                let shipping = document.querySelector('#shipping-fee');
                shippingFee = shippings.find(s => s.shipping_serial_code === this.value)['fee'];
                shipping.textContent = shippingFee;

                let total = document.querySelector('#total');
                let totalNum = totalPrice + parseFloat(shippingFee.replaceAll('.', ''));
                total.textContent = totalNum.toLocaleString('id-ID');
            });
        });
    }

    function replaceContent(response) {
        emptyContent();
        
        let items = response.data.items;
        let summary = response.data.summary;
        if(items.length === 0) {
            renderEmptyCart();
            return;
        }
        
        insertCard(items);
        insertSummary(summary);
        insertAddress();
        insertShippingRadio();
        radioInputListener();
    }

    function insertAddress()
    {
        let card = `{!! view('checkout.component.__address', ['address' => $address])->render() !!}`;
        addressContainer.insertAdjacentHTML('beforeend', card);
    }

    function insertSummary(summary) {
        let card = `{!! view('checkout.component.__summary-card', [
            'subtotal' => '::SUBTOTAL::',
            'quantity' => '::QUANTITY::',
            'transaction' => '::TRANSACTION::',
            'shipping' => '::SHIPPING::',
            'total' => '::TOTAL::'
        ])->render() !!}`;

        card = card.replace('::SUBTOTAL::', summary.subtotal ?? '-')
            .replace('::QUANTITY::', summary.quantity ?? '-')
            .replace('::TRANSACTION::', summary.adminFee ?? '-')
            .replace('::SHIPPING::', summary.shippingFee ?? '-')
            .replace('::TOTAL::', summary.total ?? '-');

        card = card.replace('::SUBTOTAL::', summary.subtotal ?? '-')
            .replace('::QUANTITY::', summary.quantity ?? '-');
        
        summaryContainer.insertAdjacentHTML('beforeend', card);
        document.querySelector('#pay-btn').addEventListener('click', function() {
            getOrder();
        });

        totalPrice = parseFloat(summary.total.replaceAll('.', ''));
    }

    function insertShippingRadio() {
        let card = `{!! view('checkout.component.__shipping', ['shippings' => $shippings])->render() !!}`;
        shippingContainer.insertAdjacentHTML('beforeend', card);
    }

    function changeResult(type, data) {
        document.querySelector('#result-type').value = type;
        document.querySelector('#result-data').value = JSON.stringify(data);
    }

    function midtransSnap(order) {
        const form = document.querySelector('#payment-form');

        snap.pay(order.snap_token, {
            onSuccess: function (result) {
                changeResult('success', result);
                form.submit();
            },
            onPending: function (result) {
                changeResult('pending', result);
                form.submit();
            },
            onError: function (result) {
                changeResult('error', result);
                form.submit();
            }
        });
    }
</script>

@yield('js')
@endsection