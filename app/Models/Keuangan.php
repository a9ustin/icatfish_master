<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Keuangan extends Model
{
    use HasFactory;
    protected $fillable = [
        "jenis_transaksi",
        "jumlah_uang",
        "keterangan",
        "feed_id",
        "olahan_id",
        "tool_id",
        "tanggal",
    ];

    public function olahan(): HasOne
    {
        return $this->hasOne(Olahan::class, "id", "olahan_id");
    }

    public function pakan(): HasOne
    {
        return $this->hasOne(Feed::class, "id", "feed_id");
    }

    public function perlengkapan(): HasOne
    {
        return $this->hasOne(Tool::class, "id", "tool_id");
    }
}