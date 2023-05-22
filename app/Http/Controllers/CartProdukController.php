<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\CartProduk;
use App\Models\Produk;

class CartProdukController extends Controller
{
    public function index()
    {
        return \view('cart.index',[
            'carts' => CartProduk::where('status','cart')->get()
        ]);
    }

    public function store(Request $request)
    {
        $cartProduk = CartProduk::where('produk_id', $request->idProduk)->first();
        if($cartProduk){
            if($cartProduk->status == 'cart'){
                $cartProduk->update(['jumlah' => $cartProduk->jumlah + $request->jumlah]);
            }else{
                CartProduk::create([
                    // cart id nya rubah jd dimanis
                    'cart_id' => 1,
                    'produk_id' => $request->idProduk,
                    'jumlah' => $request->jumlah,
                    'tanggal_masuk' => \date('Y-m-d'),
                    'status' => 'cart'
                ]);
            }
        }else{    
            CartProduk::create([
                // cart id nya rubah jd dimanis
                'cart_id' => 1,
                'produk_id' => $request->idProduk,
                'jumlah' => $request->jumlah,
                'tanggal_masuk' => \date('Y-m-d'),
                'status' => 'cart'
            ]);
        } 
        return CartProduk::where('status', 'cart')->count();
    }
}
