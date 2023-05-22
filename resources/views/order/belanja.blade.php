@extends('layouts.app')
@section('content')
    <h4>Silahkan Belanja</h4>
    <div class="row">
      @foreach ($produks as $produk)
      <div class="col-3 mx-2 my-2">
        <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">{{ $produk->judul }}</h5>
            <p class="card-text">Rp {{ $produk->harga }}</p>
        </div>
        <input type="number" class="form-control" value="1">
        <button class="btn btn-primary tombol-cart" data-idproduk="{{ $produk->id }}">Tambah Cart</button>
       </div> 
      </div>
      @endforeach
    </div>
@endsection
@push('myscript')
<script>
  $('.tombol-cart').on('click',function(){
    const idProduk = $(this).data('idproduk');
    const jumlah = $(this).siblings('.form-control').val();
     $.ajax({
        url:'cartProduk',
        type:'get',
        data:{
          idProduk:idProduk,
          jumlah:jumlah
        },
        success:function(response){
         $('#cart').text('Cart (' + response + ')')
        }
    })

  })
</script>
@endpush
