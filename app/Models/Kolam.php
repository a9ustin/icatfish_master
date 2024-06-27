<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kolam extends Model
{
    use HasFactory;
    protected $table='kolam';
    protected $fillable = ['nama_kolam', 'luas', 'tanggal_dibersihkan', 'tanggal_pakan', 'tanggal_panen', 'jumlah_ikan_hidup', 'jumlah_ikan_mati'];
}
