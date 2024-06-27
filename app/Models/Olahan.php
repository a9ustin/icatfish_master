<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Olahan extends Model
{
    use HasFactory;
    protected $table = "olahan";
    protected $fillable = ['tanggal','jenis_transaksi','jenis_olahan', 'jumlah', 'total'];
}
