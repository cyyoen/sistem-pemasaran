<?php
// app/Models/LanggananNotifikasi.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LanggananNotifikasi extends Model
{
    protected $table = 'langganan_notifikasi';
    protected $primaryKey = 'id_langganan';
    public $timestamps = false;
    protected $fillable = ['id_pengguna', 'tanggal_langganan', 'status_langganan'];
    protected $casts = ['tanggal_langganan' => 'date'];
    
    public function pengguna() {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }
}