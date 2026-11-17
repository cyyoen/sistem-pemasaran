<?php
// app/Models/Produk.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    public $timestamps = false;
    protected $fillable = ['jenis_melon', 'harga_produk', 'stok_jenis', 'gambar_produk'];
}