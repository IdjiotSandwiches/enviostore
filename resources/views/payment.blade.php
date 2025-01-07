@extends('layout.layout')
@section('title', 'Payment')

@section('content')
<section class="min-h-[calc(100vh-50%)]">
    <form id="payment-form" method="POST" action="{{ route('checkout.update') }}">
        @csrf
        @method('POST')
        <input type="hidden" name="result_data" id="result-data" value=""></div>
        <input type="hidden" name="order_id" id="order-id" value=""></div>
    </form>
</section>
@endsection

@section('extra-js')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    const orderId = {{ $order->id }};
    const snapToken = '{{ $order->snap_token }}';

    function changeResult(data, id) {
        document.querySelector('#result-data').value = JSON.stringify(data);
        document.querySelector('#order-id').value = id;
    }

    document.addEventListener('DOMContentLoaded', function() {
        console.log(orderId, snapToken)
        const form = document.querySelector('#payment-form');
        snap.pay(snapToken, {
            onSuccess: function (result) {
                changeResult(result, orderId);
                form.submit();
            },
            onPending: function (result) {
                changeResult(result, orderId);
                form.submit();
            },
            onError: function (result) {
                changeResult(result, orderId);
                form.submit();
            },
            onClose: function () {
                window.location.href = '{{ route('profile.index') }}';
            }
        });
    });
</script>
@endsection