<?php

namespace App\Listeners;

use App\Events\KeuanganCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Keuangan;

class HitungTotalKeuangan
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(KeuanganCreated $event): void
    {
        $transaksi = $event->keuangan;
        $jenis_transaksi = $transaksi->jenis_transaksi;
        $jumlah_uang = $transaksi->jumlah_uang;

        // Ambil total terakhir dari tabel keuangan
        $total_sebelumnya = Keuangan::max('total');

        // Hitung ulang total berdasarkan jenis transaksi
        if ($jenis_transaksi === 'Pemasukan') {
            $total_baru = $total_sebelumnya + $jumlah_uang;
        } else if ($jenis_transaksi === 'Pengeluaran') {
            $total_baru = $total_sebelumnya - $jumlah_uang;
        }

        // Simpan total baru ke dalam tabel keuangan
        Keuangan::create([
            'jenis_transaksi' => $jenis_transaksi,
            'jumlah_uang' => $jumlah_uang,
            'total' => $total_baru,
            'keterangan' => $transaksi->keterangan
        ]);
    }
}