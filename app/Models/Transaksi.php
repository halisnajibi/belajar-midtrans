<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function order()
    {
        return $this->belongsTo(Order::class,'kode_order','kode_order');
    }
}
