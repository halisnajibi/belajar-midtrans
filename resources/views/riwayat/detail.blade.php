@extends('layouts.app')
@section('content')
    <h4>Detail Riwayat Produk Pesanan {{ $detail[0]->kode_order }}</h4>
    <table class="table table-hover">
        <thead>
            <th>No</th>
            <th>nama produk</th>
            <th>jumlah</th>
            <th>harga</th>
        </thead>
            @foreach ($detail as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->produk->judul }}</td>
                    <td>{{ $row->jumlah }}</td>
                    <td>{{ $row->produk->harga }}</td>
                </tr>
            @endforeach
        </>
    </table>
@endsection