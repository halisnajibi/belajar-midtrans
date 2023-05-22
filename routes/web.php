<?php

use App\Http\Controllers\CartProdukController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RiwayatController;
use App\Models\CartProduk;
use Illuminate\Support\Facades\Route;
use App\Model\CartProduk as ModelCartProduk;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[OrderController::class,'index'] );
Route::get('belanja',[OrderController::class,'belanja'] );
Route::post('checkout',[OrderController::class,'checkout']);
Route::get('invoice',[OrderController::class,'invoice'] );

Route::get('cart',[CartProdukController::class,'index'] );
Route::get('cartProduk',[CartProdukController::class,'store'] );

Route::get('/cart/count', function () {
    $count = CartProduk::where('status', 'cart')->count(); // menghitung jumlah item di dalam cart
    return response()->json(['count' => $count]);
});

Route::get('checkout/{id}',[CheckoutController::class,'checkout'] );


Route::post('checkout/notification',[CheckoutController::class,'notification']);


Route::get('/riwayat',[RiwayatController::class,'index']);
Route::get('/riwayat/{kode_pemesanan}',[RiwayatController::class,'index']);
Route::get('detailPemesanan/{kode_order}',[RiwayatController::class,'detailPemesanan'] );
