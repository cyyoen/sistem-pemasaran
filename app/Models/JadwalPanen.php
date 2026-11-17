<?php
// app/Models/JadwalPanen.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPanen extends Model
{
    protected $table = 'jadwal_panen';
    protected $primaryKey = 'id_panen';
    public $timestamps = false;
    protected $fillable = ['jadwal_panen'];
    protected $casts = ['jadwal_panen' => 'date'];
}
