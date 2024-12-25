@extends('layout.layout')
@section('title', 'Checkout')

@section('content')
<section class="max-w-screen-xl px-4 py-8 md:mx-auto grid gap-4">
    <h1 class="font-bold text-3xl">Checkout</h1>
    <div class="flex flex-col md:flex-row justify-between gap-4">
        <section class="grid gap-4 flex-1">
            <div id="cartContainer" class="grid gap-4 flex-1"></div>
            <div id="shippingContainer" class="grid gap-4"></div>
        </section>
        <section id="summaryContainer" class="md:w-1/3 lg:w-1/4"></section>
    </div>
</section>
@endsection

@section('extra-js')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    const cartContainer = document.querySelector('#cartContainer');
    const summaryContainer = document.querySelector('#summaryContainer');
    const shippingContainer = document.querySelector('#shippingContainer');
    const shippings = {!! $shippings !!};

    function radioInputListener() {
        const shippingButtons = document.querySelectorAll('input[type="radio"][name="shippings"]');
        shippingButtons.forEach(button => {
            button.addEventListener('click', function () {
                let shippingUrl = '{{ route('checkout.updateShipping', [$order->id, '::SHIPPING_SERIAL::']) }}';
                shippingUrl = shippingUrl.replace('::SHIPPING_SERIAL::', this.value);

                updateShipping(shippingUrl);

                let shipping = document.querySelector('#shipping-fee');
                shippingFee = shippings.find(s => s.shipping_serial_code === this.value)['fee'];
                shipping.textContent = shippingFee;

                let total = document.querySelector('#total');
                let totalNum = totalPrice + parseFloat(shippingFee.replaceAll('.', ''));
                total.textContent = totalNum.toLocaleString('id-ID');
            });
        });
    }

    function updateShipping(url) {
        customFetch(url, {
            method: 'POST',
        }).then(response => {
            if (!response.ok) {
                throw new Error();
            }
        }).catch(error => {
            let section = document.querySelector('section');
            let item = `{!! view('component.__fetch-failed')->render() !!}`;

            section.replaceChildren();
            section.insertAdjacentHTML('beforeend', item);
        });
    }

    function midtransSnap(response) {
        let order = response.data
        snap.pay(order.snap_token, {
            onSuccess: function (result) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '';
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                form.appendChild(csrfToken);
                document.body.appendChild(form);
                form.submit();
                document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            },
            onPending: function (result) {
                document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            },
            onError: function (result) {
                document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            }
        });
    }

    function getOrder() {
        let url = '{{ route('checkout.getOrder', [$order->id]) }}';
        customFetch(url, {
            method: 'GET',
        }).then(response => {
            if (!response.ok) {
                throw new Error();
            }

            return response.json();
        }).then(response => {
            midtransSnap(response);
        }).catch(error => {
            let section = document.querySelector('section');
            let item = `{!! view('component.__fetch-failed')->render() !!}`;

            section.replaceChildren();
            section.insertAdjacentHTML('beforeend', item);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.body.addEventListener('click', (e) => {
            if (e.target.matches('#pay-btn')) {
                getOrder();
            }
        });
    });
</script>

@yield('js')
@endsection