<?php
// app/Models/PreOrder.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreOrder extends Model
{
    protected $table = 'preorder';
    protected $primaryKey = 'id_preorder';
    public $timestamps = false;
    protected $fillable = [
        'id_pengguna', 'id_produk', 'jumlah_produk', 'total_jumlah_produk',
        'tanggal_pesanan', 'status_pesanan', 'total_harga', 'bukti_pembayaran',
    ];
    protected $casts = ['tanggal_pesanan' => 'datetime'];
    
    public function pengguna() { return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna'); }
    public function produk()   { return $this->belongsTo(Produk::class, 'id_produk', 'id_produk'); }
    public function detail()   { return $this->hasMany(DetailPreOrder::class, 'id_preorder', 'id_preorder'); }
}
