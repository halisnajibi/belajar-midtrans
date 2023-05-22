<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Order;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
   public function index($kode_pemesanan = null)
   {
    if($kode_pemesanan != null){
        return \view('riwayat.index',[
            'kodePemesanan' => $kode_pemesanan,
            'order' => Transaksi::all()
        ]);
    }else{
        return \view('riwayat.index',[
            'kodePemesanan' => null,
            'order' => Transaksi::all()
        ]);
    }
   }

   public function detailPemesanan($kodeOrder)
   {
        return \view('riwayat.detail',[
            'detail' => Order::where('kode_order',$kodeOrder)->get()
        ]);
   }
}
