<?php
// app/Models/DetailPreOrder.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPreOrder extends Model
{
    protected $table = 'detail_preorder';
    protected $primaryKey = 'id_detail_preorder';
    public $timestamps = false;
    protected $fillable = ['id_produk', 'id_preorder', 'jumlah_produk', 'harga_satuan', 'subtotal'];

    public function produk() { return $this->belongsTo(Produk::class, 'id_produk', 'id_produk'); }
}