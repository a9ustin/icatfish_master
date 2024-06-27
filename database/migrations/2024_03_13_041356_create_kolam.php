<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kolam', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nama_kolam', 191);
            $table->decimal('luas');
            $table->date('tanggal_dibersihkan');
            $table->date('tanggal_pakan');
            $table->date('tanggal_panen');
            $table->integer('jumlah_ikan_hidup');
            $table->integer('jumlah_ikan_mati');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kolam');
    }
};