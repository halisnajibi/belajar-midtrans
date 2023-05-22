@extends('layouts.app')
@section('content')
    <h1>Halaman Cart</h1>
    <table class="table table-hover">
        <thead>
            <th>No</th>
            <th>Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
        </thead>
        <tbody>
           @foreach ($carts as $cart)
               <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $cart->produk->judul }}</td>
                <td>{{ $cart->produk->harga }}</td>
                <td>{{ $cart->jumlah }}</td>
               </tr>
           @endforeach
        </tbody>
    </table>
    <a href="checkout/1" class="btn btn-primary">Checkout</a>
@endsection