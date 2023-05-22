<?php

use App\Models\Cart;
use App\Models\Produk;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_produks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Cart::class);
            $table->foreignId('produk_id');
            $table->bigInteger('jumlah');
            $table->date('tanggal_masuk');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_produks');
    }
};
