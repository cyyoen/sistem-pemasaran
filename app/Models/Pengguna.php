<?php
// app/Models/Pengguna.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    protected $table = 'pengguna_terdaftar';
    protected $primaryKey = 'id_pengguna';
    public $timestamps = false;
    protected $rememberTokenName = '';
    protected $fillable = ['nama_pengguna', 'email', 'username', 'password', 'no_telepon'];
    protected $hidden = ['password'];
    protected function casts(): array { return ['password' => 'hashed']; }

    public function langganan() {
        return $this->hasOne(LanggananNotifikasi::class, 'id_pengguna', 'id_pengguna');
    }
}