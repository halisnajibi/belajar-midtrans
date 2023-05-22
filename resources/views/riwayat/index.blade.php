@extends('layouts.app')
@section('content')
<h1>Riwayat Pesanan</h1>
@if ($kodePemesanan != null)
<div class="alert alert-success" role="alert">
  Berhasil Melakukan Pemesanan!! {{ $kodePemesanan }}
  </div>
@endif
<table class="table table-hover">
    <thead>
        <th>No</th>
        <th>no pemesanan</th>
        <th>Tanggal Order</th>
        <th>Jumlah bayar</th>
        <th>metode pembayaran</th>
        <th>status</th>
        <th>cara bayar</th>
        <th>aksi</th>
    </thead>
    <tbody>
        @php $total = 0;
        $previousKodeOrder = null;
        @endphp  
        @foreach ($order as $row)
        @php
            if ($row->kode_order == $previousKodeOrder) {
                  continue;
            }
        @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->kode_order }}</td>
                <td>{{ $row->order->tanggal_order }}</td>
                <td>{{ $row->gross_amount}}</td>
                <td>{{ $row->payment_type }}</td>
                <td>{{ $row->transaction_status	 }}</td>
                <td><a href="{{ $row->pdf }}" target="_blank">Download</a></td>
                <td><a href="/detailPemesanan/{{ $row->kode_order }}">Detail</a></td>
            </tr>
           @php
                $previousKodeOrder = $row->kode_order;
           @endphp
        @endforeach
    </tbody>
</table>
@endsection