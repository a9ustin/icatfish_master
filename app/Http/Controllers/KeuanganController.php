<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;
use App\Models\Feed;
use App\Models\Tool;
use App\Models\Olahan;

class KeuanganController extends Controller
{
    /**
     * Menampilkan semua transaksi keuangan.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaksiKeuangan = Keuangan::with([
            "olahan",
            "pakan",
            "perlengkapan",
        ])->get();

        foreach ($transaksiKeuangan as $value) {
            if ($value->olahan) {
                $value->jenis_transaksi = $value->olahan->jenis_transaksi;
                $value->jumlah_uang = $value->olahan->total;
                $value->tanggal = $value->olahan->tanggal;
                $value->keterangan =
                    "Olahan ikan: " . $value->olahan->jenis_olahan;
            } elseif ($value->pakan) {
                $value->jenis_transaksi = $value->pakan->jenis_transaksi;
                $value->jumlah_uang = $value->pakan->total;
                $value->tanggal = $value->pakan->tanggal;
                $value->keterangan = "Pakan: " . $value->pakan->jenis_pakan;
            } elseif ($value->perlengkapan) {
                $value->jenis_transaksi = $value->perlengkapan->jenis_transaksi;
                $value->jumlah_uang = $value->perlengkapan->total;
                $value->tanggal = $value->perlengkapan->tanggal;
                $value->keterangan =
                    "Perlengkapan: " . $value->perlengkapan->jenis_tools;
            }
        }

        $data = $transaksiKeuangan;
        $totalUang = 0;
        foreach ($data as $value) {
            if ($value->jenis_transaksi == "Pemasukan") {
                $totalUang = $totalUang + $value->jumlah_uang;
            } else {
                $totalUang = $totalUang - $value->jumlah_uang;
            }
        }

        return view(
            "admin.keuangan.index",
            compact(["transaksiKeuangan", "totalUang"])
        );
    }

    /**
     * Menampilkan formulir untuk membuat transaksi keuangan baru.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.keuangan.create");
    }

    /**
     * Menyimpan transaksi keuangan baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "jenis_transaksi" => "required|in:Pemasukan,Pengeluaran",
            "tanggal" => "required",
            "jumlah_uang" => "required|numeric",
            "keterangan" => "nullable|string|max:255",
        ]);

        Keuangan::create($validatedData);

        return redirect()
            ->route("keuangan")
            ->with("success", "Transaksi Keuangan Berhasil Disimpan !");
    }

    /**
     * Menampilkan detail transaksi keuangan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaksiKeuangan = Keuangan::findOrFail($id);
        return view("admin.keuangan.show", compact("transaksiKeuangan"));
    }

    public function detail(Request $request)
    {
        $data = Keuangan::where("id", $request->id)
            ->with(["olahan", "pakan", "perlengkapan"])
            ->first();

        if ($data->olahan) {
            $data->jenis_transaksi = $data->olahan->jenis_transaksi;
            $data->jumlah_uang = $data->olahan->total;
            $data->tanggal = $data->olahan->tanggal;
            $data->keterangan = $data->olahan->jenis_olahan;
        } elseif ($data->pakan) {
            $data->jenis_transaksi = $data->pakan->jenis_transaksi;
            $data->jumlah_uang = $data->pakan->total;
            $data->tanggal = $data->pakan->tanggal;
            $data->keterangan = $data->pakan->jenis_pakan;
        } elseif ($data->perlengkapan) {
            $data->jenis_transaksi = $data->perlengkapan->jenis_transaksi;
            $data->jumlah_uang = $data->perlengkapan->total;
            $data->tanggal = $data->perlengkapan->tanggal;
            $data->keterangan = $data->perlengkapan->jenis_tools;
        }

        return response()->json([
            "data" => $data,
        ]);
    }

    /**
     * Menampilkan formulir untuk mengedit transaksi keuangan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transaksiKeuangan = Keuangan::findOrFail($id);
        return view("admin.keuangan.edit", compact("transaksiKeuangan"));
    }

    /**
     * Memperbarui transaksi keuangan di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $transaksiKeuangan = Keuangan::findOrFail($request->id);

        $validatedData = $request->validate([
            "jenis_transaksi" => "required|in:Pemasukan,Pengeluaran",
            "tanggal" => "required",
            "jumlah_uang" => "required|numeric",
            "keterangan" => "nullable|string|max:255",
        ]);

        if ($transaksiKeuangan->feed_id) {
            $data = Feed::findOrFail($transaksiKeuangan->feed_id);
            $data->jenis_transaksi = $validatedData["jenis_transaksi"];
            $data->tanggal = $validatedData["tanggal"];
            $data->total = $validatedData["jumlah_uang"];
            $data->jenis_pakan = $validatedData["keterangan"];
            $data->save();
        } elseif ($transaksiKeuangan->tool_id) {
            $data = Tool::findOrFail($transaksiKeuangan->tool_id);
            $data->jenis_transaksi = $validatedData["jenis_transaksi"];
            $data->tanggal = $validatedData["tanggal"];
            $data->total = $validatedData["jumlah_uang"];
            $data->jenis_tools = $validatedData["keterangan"];
            $data->save();
        } elseif ($transaksiKeuangan->olahan_id) {
            $data = Olahan::findOrFail($transaksiKeuangan->olahan_id);
            $data->jenis_transaksi = $validatedData["jenis_transaksi"];
            $data->tanggal = $validatedData["tanggal"];
            $data->total = $validatedData["jumlah_uang"];
            $data->jenis_olahan = $validatedData["keterangan"];
            $data->save();
        } else {
            $transaksiKeuangan->update($validatedData);
        }

        return redirect()
            ->route("keuangan")
            ->with("success", "Data Keuangan Berhasil Diupdate !");
    }

    /**
     * Menghapus transaksi keuangan dari database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $keuangan = Keuangan::findOrFail($id);

            if ($keuangan->feed_id) {
                $data = Feed::findOrFail($keuangan->feed_id);
                $data->delete();
            } elseif ($keuangan->olahan_id) {
                $data = Olahan::findOrFail($keuangan->olahan_id);
                $data->delete();
            } elseif ($keuangan->tool_id) {
                $data = Tool::findOrFail($keuangan->tool_id);
                $data->delete();
            }

            $keuangan->delete();
            return redirect()
                ->route("keuangan")
                ->with("success", "Transaksi keuangan berhasil dihapus.");
        } catch (\Throwable $e) {
            return redirect()
                ->route("keuangan")
                ->with("error", $e);
        }
    }
}