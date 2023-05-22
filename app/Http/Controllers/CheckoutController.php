<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\CartProduk;
use App\Models\Order;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class CheckoutController extends Controller
{
    public function checkout(Request $request, $id)
    {
        $cartProduk = CartProduk::where('cart_id', $id)->where('status','cart')->get();
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $items = [];
        $no = 1;
        foreach ($cartProduk as $row) {
            $items[] = array(
                'id' => $row->id,
                'price' => $row->produk->harga,
                'quantity' => $row->jumlah,
                'name' => $row->produk->judul
            );
        }
        $total = 0;
        foreach ($items as $item) {
            // $total += $item['price'];
            $total = $item['price'] * $item['quantity'];
        }

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $total,
            ),
            'item_details' => $items,
            'customer_details' => array(
                'first_name' => 'budi',
                'last_name' => 'pratama',
                'email' => 'budi.pra@example.com',
                'phone' => '08111222333',
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        // return \view('order.checkout',\compact('snapToken','order'));
        return \view('checkout.index', [
            'produk' => $cartProduk,
            'token' => $snapToken
        ]);
    }

    public function notification(Request $request)
    {
        $data = $request->input('data');
        $idCart = $request->input('idCart');
        $kodeOrder = \date('Ymd').Str::random(5);
        if($data['transaction_status'] == 'pending'){
               $this->_pending($data,$idCart,$kodeOrder);
               return $result =[
                'alert' => 'berhasil memilih metode pemabayaran',
                'kode_pemesanan' => $kodeOrder
            ] ;
        }elseif($data['transaction_status'] == 'settlement'){
            $this->_success($data,$idCart,$kodeOrder);
            return $result =[
                'alert' => 'berhasil memilih metode pemabayaran',
                'kode_pemesanan' => $kodeOrder
            ] ;
        }
    }

    private function _success($data,$idCart,$kodeOrder)
    {
        //mandiri
        if (array_key_exists('biller_code', $data)) {
            //insert tabel order
            $cartProduk = CartProduk::where('cart_id', $idCart)->get();
            foreach ($cartProduk as $produk) {
             Order::create([
                'kode_order' => $kodeOrder,
                'user_id' => 1,
                'produk_id' => $produk->produk_id,
                'jumlah' => $produk->jumlah,
                'tanggal_order' => \date('Y-m-d')
             ]);
            }
            //insert tabel transaksi
            Transaksi::create([
                'kode_order' => $kodeOrder,
                'order_id' => $data['order_id'],
                'gross_amount' => $data['gross_amount'],
                'payment_type' => 'mandiri -' . $data['bill_key'],
                'transaction_status' => $data['transaction_status'],
                'pdf' => $data['pdf_url']
            ]);;  
            //update tabel cart
            foreach ($cartProduk as $cart ) {
                $cart->update(['status' => 'paid']);
            }
        }
        //permata
        else if (\array_key_exists('permata_va_number', $data)) {
            $cartProduk = CartProduk::where('cart_id', $idCart)->get();
            foreach ($cartProduk as $produk) {
             Order::create([
                'kode_order' => $kodeOrder,
                'user_id' => 1,
                'produk_id' => $produk->produk_id,
                'jumlah' => $produk->jumlah,
                'tanggal_order' => \date('Y-m-d')
             ]);
            }
            Transaksi::create([
                'kode_order' => $kodeOrder,
                'order_id' => $data['order_id'],
                'gross_amount' => $data['gross_amount'],
                'payment_type' => 'permata -' . $data['permata_va_number'],
                'transaction_status' => $data['transaction_status'],
                'pdf' => $data['pdf_url']
            ]);
            foreach ($cartProduk as $cart ) {
                $cart->update(['status' => 'paid']);
            }
        }
        //semua bank
        else{
            $cartProduk = CartProduk::where('cart_id', $idCart)->get();
            foreach ($cartProduk as $produk) {
                Order::create([
                    'kode_order' => $kodeOrder,
                    'user_id' => 1,
                    'produk_id' => $produk->produk_id,
                    'jumlah' => $produk->jumlah,
                    'tanggal_order' => \date('Y-m-d')
                ]);
               
            }
            foreach ($cartProduk as $cart ) {
                $cart->update(['status' => 'paid']);
            }

            Transaksi::create([
                'kode_order' => $kodeOrder,
                'order_id' => $data['order_id'],
                'gross_amount' => $data['gross_amount'],
                'payment_type' => $data['va_numbers'][0]['bank'] . '-' . $data['va_numbers'][0]['va_number'],
                'transaction_status' => $data['transaction_status'],
                'pdf' => $data['pdf_url']
            ]);;
        }
    }

    private function _pending($data,$idCart,$kodeOrder){
        //mandiri
        if (array_key_exists('biller_code', $data)) {
            //insert tabel order
            $cartProduk = CartProduk::where('cart_id', $idCart)->get();
            foreach ($cartProduk as $produk) {
             Order::create([
                'kode_order' => $kodeOrder,
                'user_id' => 1,
                'produk_id' => $produk->produk_id,
                'jumlah' => $produk->jumlah,
                'tanggal_order' => \date('Y-m-d')
             ]);
            }
            //insert tabel transaksi
            Transaksi::create([
                'kode_order' => $kodeOrder,
                'order_id' => $data['order_id'],
                'gross_amount' => $data['gross_amount'],
                'payment_type' => 'mandiri -' . $data['bill_key'],
                'transaction_status' => $data['transaction_status'],
                'pdf' => $data['pdf_url']
            ]);;     
            //update tabel cart
            foreach ($cartProduk as $cart ) {
                $cart->update(['status' => 'order']);
            }
        }
        //permata
        else if (\array_key_exists('permata_va_number', $data)) {
            $cartProduk = CartProduk::where('cart_id', $idCart)->get();
            foreach ($cartProduk as $produk) {
             Order::create([
                'kode_order' => $kodeOrder,
                'user_id' => 1,
                'produk_id' => $produk->produk_id,
                'jumlah' => $produk->jumlah,
                'tanggal_order' => \date('Y-m-d')
             ]);
            }
            Transaksi::create([
                'kode_order' => $kodeOrder,
                'order_id' => $data['order_id'],
                'gross_amount' => $data['gross_amount'],
                'payment_type' => 'permata -' . $data['permata_va_number'],
                'transaction_status' => $data['transaction_status'],
                'pdf' => $data['pdf_url']
            ]);
            foreach ($cartProduk as $cart ) {
                $cart->update(['status' => 'order']);
            }
        }
        //semua bank
        else{
            $cartProduk = CartProduk::where('cart_id', $idCart)->get();
            foreach ($cartProduk as $produk) {
                Order::create([
                    'kode_order' => $kodeOrder,
                    'user_id' => 1,
                    'produk_id' => $produk->produk_id,
                    'jumlah' => $produk->jumlah,
                    'tanggal_order' => \date('Y-m-d')
                ]);
            }
            foreach ($cartProduk as $cart ) {
                $cart->update(['status' => 'order']);
            }
            Transaksi::create([
                'kode_order' => $kodeOrder,
                'order_id' => $data['order_id'],
                'gross_amount' => $data['gross_amount'],
                'payment_type' => $data['va_numbers'][0]['bank'] . '-' . $data['va_numbers'][0]['va_number'],
                'transaction_status' => $data['transaction_status'],
                'pdf' => $data['pdf_url']
            ]);;   
        }
    }
}
