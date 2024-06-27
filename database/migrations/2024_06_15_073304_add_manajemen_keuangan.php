<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table("keuangans", function (Blueprint $table) {
            $table->integer("feed_id")->nullable();
            $table->integer("tool_id")->nullable();
            $table->integer("olahan_id")->nullable();
            $table->dropColumn("total");
            $table
                ->decimal("jumlah_uang", 10, 2)
                ->nullable()
                ->change();
            $table
                ->enum("jenis_transaksi", ["Pemasukan", "Pengeluaran"])
                ->nullable()
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("keuangans", function (Blueprint $table) {
            $table->dropColumn("feed_id");
            $table->dropColumn("tool_id");
            $table->dropColumn("olahan_id");
            $table->decimal("total", 10, 2);
            $table->decimal("jumlah_uang", 10, 2)->change();
            $table
                ->enum("jenis_transaksi", ["Pemasukan", "Pengeluaran"])
                ->change();
        });
    }
};
