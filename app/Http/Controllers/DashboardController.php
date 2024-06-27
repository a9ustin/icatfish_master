<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feed;
use App\Models\Keuangan;
use App\Models\Kolam;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

setlocale(LC_TIME, "id_ID.utf8");
Carbon::setLocale("id");

class DashboardController extends Controller
{
    /**
     * Menampilkan semua pakan.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // chart 1
        $bulanTahun = $request->input("bulanKeuangan")
            ? $request->input("bulanKeuangan")
            : Carbon::now()->translatedFormat("F Y");

        $bulanMap = [
            "Januari" => "01",
            "Februari" => "02",
            "Maret" => "03",
            "April" => "04",
            "Mei" => "05",
            "Juni" => "06",
            "Juli" => "07",
            "Agustus" => "08",
            "September" => "09",
            "Oktober" => "10",
            "November" => "11",
            "Desember" => "12",
        ];

        list($namaBulan, $tahun) = explode(" ", $bulanTahun);
        $bulan = $bulanMap[$namaBulan];
        $keuangan = Keuangan::with(["olahan", "pakan", "perlengkapan"])
            ->where(DB::raw("DATE_FORMAT(tanggal, '%Y')"), $tahun)
            ->where(DB::raw("DATE_FORMAT(tanggal, '%m')"), $bulan)
            ->get();

        foreach ($keuangan as $value) {
            if ($value->olahan) {
                $value->jenis_transaksi = $value->olahan->jenis_transaksi;
                $value->jumlah_uang = $value->olahan->total;
                $value->tanggal = $value->olahan->tanggal;
            } elseif ($value->pakan) {
                $value->jenis_transaksi = $value->pakan->jenis_transaksi;
                $value->jumlah_uang = $value->pakan->total;
                $value->tanggal = $value->pakan->tanggal;
            } elseif ($value->perlengkapan) {
                $value->jenis_transaksi = $value->perlengkapan->jenis_transaksi;
                $value->jumlah_uang = $value->perlengkapan->total;
                $value->tanggal = $value->perlengkapan->tanggal;
            }
        }

        $dates = $keuangan
            ->sortBy("tanggal")
            ->pluck("tanggal")
            ->unique()
            ->values();

        $pengeluaran = [];
        $pemasukan = [];

        foreach ($dates as $i => $value) {
            $pemasukan[] = 0;
            $pengeluaran[] = 0;
            foreach ($keuangan as $value2) {
                if ($value2->tanggal == $value) {
                    if ($value2->jenis_transaksi == "Pemasukan") {
                        $pemasukan[$i] += $value2->jumlah_uang;
                    } else {
                        $pengeluaran[$i] += $value2->jumlah_uang;
                    }
                }
            }
        }

        $months = Keuangan::with(["olahan", "pakan", "perlengkapan"])->get();

        foreach ($months as $value) {
            if ($value->olahan) {
                $value->jenis_transaksi = $value->olahan->jenis_transaksi;
                $value->jumlah_uang = $value->olahan->total;
                $value->tanggal = $value->olahan->tanggal;
            } elseif ($value->pakan) {
                $value->jenis_transaksi = $value->pakan->jenis_transaksi;
                $value->jumlah_uang = $value->pakan->total;
                $value->tanggal = $value->pakan->tanggal;
            } elseif ($value->perlengkapan) {
                $value->jenis_transaksi = $value->perlengkapan->jenis_transaksi;
                $value->jumlah_uang = $value->perlengkapan->total;
                $value->tanggal = $value->perlengkapan->tanggal;
            }
        }
        $months = $months
            ->sortBy("tanggal")
            ->pluck("tanggal")
            ->unique()
            ->values();
        $months = $months
            ->sortByDesc(function ($dateString) {
                return Carbon::parse($dateString);
            })
            ->map(function ($dateString) {
                $date = Carbon::parse($dateString);
                return $date->translatedFormat("F Y");
            })
            ->unique()
            ->values();

        // chart 2
        $kolam = Kolam::get();
        $namaKolam = [];
        $ikanMati = [];
        $ikanHidup = [];

        foreach ($kolam as $i => $value) {
            $namaKolam[] = $value->nama_kolam;
            $ikanMati[] = $value->jumlah_ikan_mati;
            $ikanHidup[] = $value->jumlah_ikan_hidup;
        }

        return view(
            "dashboard",
            compact([
                "dates",
                "pemasukan",
                "pengeluaran",
                "months",
                "bulanTahun",
                "namaKolam",
                "ikanMati",
                "ikanHidup",
            ])
        );
    }

    /**
     * Menampilkan formulir untuk membuat pakan baru.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.feed.create");
    }

    /**
     * Menyimpan pakan baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "tanggal" => "required",
            "jenis_transaksi" => "required|in:Pemasukan,Pengeluaran",
            "jenis_pakan" => "required",
            "jumlah_pakan" => "required|numeric",
            "total" => "required|numeric",
        ]);

        Feed::create($validatedData);

        return redirect()
            ->route("pakan")
            ->with("success", "Transaksi Pakan Berhasil Disimpan !");
    }

    /**
     * Menampilkan detail pakan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pakan = Feed::findOrFail($id);
        return view("admin.feed.show", compact("pakan"));
    }

    public function detail(Request $request)
    {
        $data = Feed::where("id", $request->id)->first();
        return response()->json([
            "data" => $data,
        ]);
    }

    /**
     * Menampilkan formulir untuk mengedit pakan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pakan = Feed::findOrFail($id);
        return view("admin.feed.edit", compact("pakan"));
    }

    /**
     * Memperbarui pakan di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $pakan = Feed::findOrFail($request->id);

        $validatedData = $request->validate([
            "tanggal" => "required",
            "jenis_transaksi" => "required|in:Pemasukan,Pengeluaran",
            "jenis_pakan" => "required",
            "jumlah_pakan" => "required|numeric",
            "total" => "required|numeric",
            "keterangan" => "nullable|string|max:255",
        ]);

        $pakan->update($validatedData);

        return redirect()
            ->route("pakan")
            ->with("success", "Data Pakan Berhasil Diupdate !");
    }

    /**
     * Menghapus data Pakan dari database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $pakan = Feed::findOrFail($id);
            $pakan->delete();
            return redirect()
                ->route("pakan")
                ->with("success", "Transaksi pakan berhasil dihapus.");
        } catch (\Throwable $e) {
            return redirect()
                ->route("pakan")
                ->with("error", $e);
        }
    }
}
