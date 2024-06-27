<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manajemen extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'jenis', 'stock'];

    // Definisikan kolom jenis sebagai enum
    protected $enum = [
        'jenis' => ['pakan', 'olahan ikan', 'perlengkapan']
    ];
}