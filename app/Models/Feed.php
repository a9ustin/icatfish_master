<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    use HasFactory;
    protected $table = 'feed';
    protected $fillable = ['tanggal','jenis_transaksi','jenis_pakan', 'jumlah_pakan', 'total', 'keterangan'];
}
