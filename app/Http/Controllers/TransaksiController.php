<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function callback(Request $request)
    {
      $serverKey = config('midtrans.server_key');
      $hashed = \hash('sha512', $request->order_id.$request->status_code.$request->gross_amount.$serverKey); 
      if($hashed == $request->signature_key){
        if($request->transaction_status == 'settlement'){
            $transaksi = Transaksi::where('order_id',$request->order_id)->first();
            $transaksi->update(['transaction_status'=> 'settlement'] );
        }else if($request->transaction_status == 'pending'){
            $transaksi = Transaksi::where('order_id',$request->order_id)->first();
            $transaksi->update(['transaction_status'=> 'pending'] );
        }
      }
    }
}
