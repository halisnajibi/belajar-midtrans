<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;
class CartProduk extends Model
{
   protected $guarded =['id'];
    use HasFactory;

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
