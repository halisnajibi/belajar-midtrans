@extends('layouts.app')
@section('content')
    <h1>Detail Pesanan</h1>
    <table class="table table-hover">
        <thead>
            <th>No</th>
            <th>Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Total Harga</th>
        </thead>
        <tbody>
            @php $total = 0;@endphp
            @foreach ($produk as $cart)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $cart->produk->judul }}</td>
                    <td>{{ $cart->produk->harga }}</td>
                    <td>{{ $cart->jumlah }}</td>
                    <td>{{ $cart->produk->harga * $cart->jumlah }}</td>
                </tr>
                @php $total += $cart->produk->harga * $cart->jumlah; @endphp
            @endforeach
            <tr>
                <td colspan="4" class="text-end"><strong>Total Bayar:</strong></td>
                <td><strong>{{ $total }}</strong></td>
            </tr>
        </tbody>
    </table>
    <button id="pay-button" class="btn btn-success">Bayar</button>
@endsection
@push('myscript')
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key={{ config('midtrans.server_key') }}></script>
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            window.snap.pay('{{ $token }}', {
                onSuccess: function(result) {
                    /* You may add your own implementation here */
                    console.log(result)
                    const url = window.location.href;
                    const urlArray = url.split('/');
                    const idCart = urlArray[urlArray.length - 1];
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        'url': 'notification',
                        'type': 'post',
                        'data': {
                            data: result,
                            idCart: idCart,
                        },
                        success: function(response) {
                            console.log(response)
                            window.location.href = '/riwayat/' + response['kode_pemesanan']
                        }
                    });
                },
                onPending: function(result) {
                    /* You may add your own implementation here */
                    const url = window.location.href;
                    const urlArray = url.split('/');
                    const idCart = urlArray[urlArray.length - 1];
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        'url': 'notification',
                        'type': 'post',
                        'data': {
                            data: result,
                            idCart: idCart,
                        },
                        success: function(response) {
                           console.log(response)
                            window.location.href = '/riwayat/' + response['kode_pemesanan']
                        }
                    });
                },
                onError: function(result) {
                    /* You may add your own implementation here */
                    alert("payment failed!! silhakan coba lagi");
                },
                onClose: function() {
                    /* You may add your own implementation here */
                    alert('you closed the popup without finishing the payment');
                }
            })
        });
    </script>
@endpush
