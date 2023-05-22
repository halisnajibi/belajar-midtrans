<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return \view('order.index');
    }

    public function belanja()
    {
        return \view('order.belanja',[
            'produks' => Produk::all()
        ]);
    }

    public function checkout(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required',
            'telepon' => 'required',
            'qty' => 'required',
        ]);
        $validateData['total_bayar'] = $validateData['qty'] * 50000;
        $validateData['status'] = 'unpaid';
        Order::create($validateData);
        $order = Order::latest()->first();
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $order->id,
                'gross_amount' => $order->total_bayar,
            ),
            'customer_details' => array(
                'first_name' => $request->nama,
                'phone' => $request->telepon
            ),
        );
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        return \view('order.checkout',\compact('snapToken','order'));
    }
}
