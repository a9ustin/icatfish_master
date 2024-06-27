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
        Schema::create('feed', function (Blueprint $table) {
            $table->id();
            $table->string('tanggal');
            $table->enum('jenis_transaksi', ['Pemasukan', 'Pengeluaran']);
            $table->string('jenis_pakan');
            $table->decimal('jumlah_pakan', 10, 2);
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feed');
    }
};