@extends('layouts.app')
@section('content')
    <h4>Detail Pesanan</h4>
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">{{ $order->nama }} - {{ $order->telepon }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">Jumalah Order {{ $order->qty }}</h6>
            <p class="card-text">Total Bayar : Rp {{ $order->total_bayar }}</p>
        </div>
    </div>
@endsection
@push('myscript')
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key={{ config('midtrans.server_key') }}></script>
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    /* You may add your own implementation here */
                    alert("payment success!");
                    console.log(result);
                    window.location.href = '/invoice'
                },
                onPending: function(result) {
                    /* You may add your own implementation here */
                    alert("wating your payment!");
                    console.log(result);
                },
                onError: function(result) {
                    /* You may add your own implementation here */
                    alert("payment failed!");
                    console.log(result);
                },
                onClose: function() {
                    /* You may add your own implementation here */
                    alert('you closed the popup without finishing the payment');
                }
            })
        });
    </script>
 @endpush
