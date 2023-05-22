<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];
    use HasFactory;
    
    public function transaksi()
    {
        return $this->hasOne(Transaksi::class,'kode_order');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
